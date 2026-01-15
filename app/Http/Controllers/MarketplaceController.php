<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\MarketplacePushLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MarketplaceController extends Controller
{
    public function index()
    {
        $logs = MarketplacePushLog::with('order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('marketplace.index', compact('logs'));
    }

    public function importForm()
    {
        return view('marketplace.import');
    }

    public function import(Request $request)
    {
        $jsonPath = storage_path('app/mock/marketplace_orders.json');

        if (!File::exists($jsonPath)) {
            return back()->with('error', 'File mock orders tidak ditemukan.');
        }

        try {
            $jsonData = File::get($jsonPath);
            $mockOrders = json_decode($jsonData, true);

            if (!$mockOrders || !isset($mockOrders['orders'])) {
                return back()->with('error', 'Format JSON tidak valid.');
            }

            $imported = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($mockOrders['orders'] as $mockOrder) {
                $existingOrder = Order::where('order_number', $mockOrder['order_number'])->first();
                if ($existingOrder) {
                    $errors[] = "Order {$mockOrder['order_number']} sudah ada.";
                    continue;
                }

                $order = Order::create([
                    'order_number' => $mockOrder['order_number'],
                    'customer_name' => $mockOrder['customer_name'],
                    'customer_email' => $mockOrder['customer_email'] ?? null,
                    'customer_address' => $mockOrder['customer_address'] ?? null,
                    'status' => 'new',
                    'source' => 'marketplace',
                ]);

                foreach ($mockOrder['items'] as $item) {
                    $product = Product::where('sku', $item['sku'])->first();

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product?->id,
                        'product_name' => $item['name'],
                        'product_sku' => $item['sku'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['price'] * $item['quantity'],
                    ]);
                }

                $order->calculateTotal();

                MarketplacePushLog::create([
                    'order_id' => $order->id,
                    'status' => 'imported',
                    'response' => json_encode([
                        'success' => true,
                        'message' => 'Order imported from marketplace',
                        'timestamp' => now()->toISOString(),
                    ]),
                    'success' => true,
                ]);

                $imported++;
            }

            DB::commit();

            $message = "Berhasil mengimport {$imported} order.";
            if (count($errors) > 0) {
                $message .= ' ' . implode(' ', $errors);
            }

            return redirect()->route('orders.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengimport: ' . $e->getMessage());
        }
    }
}
