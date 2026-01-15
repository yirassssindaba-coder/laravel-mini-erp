<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\MarketplacePushLog;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('orders.create', compact('products'));
    }

    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $requiredStock = [];
            foreach ($request->items as $item) {
                $productId = $item['product_id'];
                $quantity = $item['quantity'];
                if (!isset($requiredStock[$productId])) {
                    $requiredStock[$productId] = 0;
                }
                $requiredStock[$productId] += $quantity;
            }

            $products = Product::whereIn('id', array_keys($requiredStock))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($requiredStock as $productId => $totalQuantity) {
                $product = $products->get($productId);
                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan.");
                }
                if ($product->stock < $totalQuantity) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}, dibutuhkan: {$totalQuantity}");
                }
            }

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_address' => $request->customer_address,
                'status' => 'new',
                'source' => 'manual',
            ]);

            foreach ($request->items as $item) {
                $product = $products->get($item['product_id']);
                $subtotal = $product->price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ]);

                InventoryMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'notes' => 'Order: ' . $order->order_number,
                ]);
            }

            $order->calculateTotal();

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Order berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load(['items', 'marketplacePushLogs']);
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,packed,shipped,done',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        if ($order->source === 'marketplace') {
            MarketplacePushLog::create([
                'order_id' => $order->id,
                'status' => $request->status,
                'response' => json_encode([
                    'success' => true,
                    'message' => 'Status updated successfully',
                    'timestamp' => now()->toISOString(),
                ]),
                'success' => true,
            ]);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', "Status order diubah dari '{$oldStatus}' menjadi '{$request->status}'.");
    }
}
