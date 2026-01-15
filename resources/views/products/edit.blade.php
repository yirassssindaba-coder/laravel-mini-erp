@extends('layouts.app')

@section('title', 'Edit Produk')
@section('header', 'Edit Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Form Edit Produk</h3>
        </div>
        <form action="{{ route('products.update', $product) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU <span class="text-red-500">*</span></label>
                <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('sku') border-red-500 @enderror" required>
                @error('sku')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga <span class="text-red-500">*</span></label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror" required>
                @error('price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Stok saat ini: <span class="font-semibold text-gray-700">{{ $product->stock }}</span></p>
                <p class="text-xs text-gray-400 mt-1">Stok dikelola melalui menu Inventori.</p>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('products.index') }}" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
