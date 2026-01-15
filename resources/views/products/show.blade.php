@extends('layouts.app')

@section('title', 'Detail Produk')
@section('header', 'Detail Produk')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
            <div class="space-x-2">
                <a href="{{ route('products.edit', $product) }}" class="text-yellow-600 hover:text-yellow-800">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">SKU</p>
                    <p class="font-medium text-gray-900">{{ $product->sku }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Harga</p>
                    <p class="font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Stok</p>
                    <span class="px-3 py-1 text-sm rounded-full {{ $product->stock < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $product->stock }} unit
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dibuat</p>
                    <p class="font-medium text-gray-900">{{ $product->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            @if($product->description)
                <div class="mt-6">
                    <p class="text-sm text-gray-500">Deskripsi</p>
                    <p class="text-gray-900 mt-1">{{ $product->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Riwayat Pergerakan Stok</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($product->inventoryMovements->sortByDesc('created_at') as $movement)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $movement->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $movement->type === 'in' ? 'Stock In' : 'Stock Out' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $movement->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $movement->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat pergerakan stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Produk
        </a>
    </div>
</div>
@endsection
