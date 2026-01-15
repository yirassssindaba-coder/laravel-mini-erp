@extends('layouts.app')

@section('title', 'Detail Order')
@section('header', 'Detail Order')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">{{ $order->order_number }}</h3>
                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <span class="px-3 py-1 text-sm rounded-full {{ $order->getStatusBadgeClass() }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Pelanggan</p>
                    <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                    @if($order->customer_email)
                        <p class="text-sm text-gray-600">{{ $order->customer_email }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500">Alamat</p>
                    <p class="text-gray-900">{{ $order->customer_address ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Sumber</p>
                    <span class="px-2 py-1 text-xs rounded-full {{ $order->source === 'marketplace' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($order->source) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="border-t pt-6">
                <h4 class="text-md font-semibold text-gray-800 mb-4">Item Order</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $item->product_name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500">{{ $item->product_sku }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 text-right">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-900 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($order->status !== 'done')
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b">
            <h4 class="text-md font-semibold text-gray-800">Update Status</h4>
        </div>
        <div class="p-6">
            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="flex flex-wrap gap-2">
                @csrf
                @method('PATCH')
                @php
                    $nextStatuses = match($order->status) {
                        'new' => ['packed' => 'Packed'],
                        'packed' => ['shipped' => 'Shipped'],
                        'shipped' => ['done' => 'Done'],
                        default => [],
                    };
                @endphp

                @foreach($nextStatuses as $value => $label)
                    <button type="submit" name="status" value="{{ $value }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        <i class="fas fa-arrow-right mr-1"></i> Update ke {{ $label }}
                    </button>
                @endforeach
            </form>
        </div>
    </div>
    @endif

    @if($order->marketplacePushLogs->count() > 0)
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b">
            <h4 class="text-md font-semibold text-gray-800">Log Marketplace</h4>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @foreach($order->marketplacePushLogs as $log)
                    <div class="flex items-start gap-4 p-3 bg-gray-50 rounded-lg">
                        <span class="px-2 py-1 text-xs rounded-full {{ $log->success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $log->success ? 'Success' : 'Failed' }}
                        </span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">Status: {{ ucfirst($log->status) }}</p>
                            <p class="text-xs text-gray-500">{{ $log->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('orders.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Order
        </a>
    </div>
</div>
@endsection
