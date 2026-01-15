@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-box text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_products'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-shopping-cart text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Order</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Order Pending</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_orders'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Stok Rendah</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['low_stock_products'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Order Terbaru</h3>
        </div>
        <div class="p-6">
            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-800">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->customer_name }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 text-xs rounded-full {{ $order->getStatusBadgeClass() }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <p class="text-sm text-gray-500 mt-1">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada order.</p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Pergerakan Stok Terbaru</h3>
        </div>
        <div class="p-6">
            @if($recentMovements->count() > 0)
                <div class="space-y-4">
                    @foreach($recentMovements as $movement)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-800">{{ $movement->product->name ?? 'Produk Dihapus' }}</p>
                                <p class="text-sm text-gray-500">{{ $movement->notes ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 text-xs rounded-full {{ $movement->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                </span>
                                <p class="text-sm text-gray-500 mt-1">{{ $movement->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada pergerakan stok.</p>
            @endif
        </div>
    </div>
</div>
@endsection
