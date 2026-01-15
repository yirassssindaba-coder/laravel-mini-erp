<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement;
use App\Http\Requests\InventoryMovementRequest;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryMovement::with('product');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $movements = $query->orderBy('created_at', 'desc')->paginate(15);
        $products = Product::orderBy('name')->get();

        return view('inventory.index', compact('movements', 'products'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('inventory.create', compact('products'));
    }

    public function store(InventoryMovementRequest $request)
    {
        InventoryMovement::create($request->validated());

        $typeLabel = $request->type === 'in' ? 'Stock In' : 'Stock Out';

        return redirect()->route('inventory.index')
            ->with('success', $typeLabel . ' berhasil dicatat.');
    }
}
