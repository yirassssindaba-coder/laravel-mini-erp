@extends('layouts.app')

@section('title', 'Tambah Pergerakan Stok')
@section('header', 'Tambah Pergerakan Stok')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Form Pergerakan Stok</h3>
        </div>
        <form action="{{ route('inventory.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Produk <span class="text-red-500">*</span></label>
                <select name="product_id" id="product_id" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('product_id') border-red-500 @enderror" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (SKU: {{ $product->sku }}) - Stok: {{ $product->stock }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Pergerakan <span class="text-red-500">*</span></label>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="in" class="form-radio text-indigo-600" {{ old('type', 'in') === 'in' ? 'checked' : '' }}>
                        <span class="ml-2 text-green-600 font-medium"><i class="fas fa-arrow-down mr-1"></i> Stock In</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="out" class="form-radio text-indigo-600" {{ old('type') === 'out' ? 'checked' : '' }}>
                        <span class="ml-2 text-red-600 font-medium"><i class="fas fa-arrow-up mr-1"></i> Stock Out</span>
                    </label>
                </div>
                @error('type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('quantity') border-red-500 @enderror" required>
                @error('quantity')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('inventory.index') }}" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
