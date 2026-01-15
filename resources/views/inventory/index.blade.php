@extends('layouts.app')

@section('title', 'Inventori')
@section('header', 'Manajemen Inventori')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <form action="{{ route('inventory.index') }}" method="GET" class="flex flex-wrap gap-2">
            <select name="type" class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Tipe</option>
                <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>Stock In</option>
                <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Stock Out</option>
            </select>
            <select name="product_id" class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Produk</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
        </form>
        <a href="{{ route('inventory.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-center">
            <i class="fas fa-plus mr-2"></i>Tambah Pergerakan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($movements as $movement)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($movement->product)
                                <a href="{{ route('products.show', $movement->product) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $movement->product->name }}
                                </a>
                            @else
                                <span class="text-gray-400">Produk Dihapus</span>
                            @endif
                        </td>
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-warehouse text-4xl mb-2"></i>
                            <p>Belum ada pergerakan stok.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($movements->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $movements->links() }}
        </div>
    @endif
</div>
@endsection
