@extends('layouts.app')

@section('title', 'Buat Order')
@section('header', 'Buat Order Baru')

@section('content')
<div class="max-w-4xl mx-auto" x-data="orderForm()">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Form Order Baru</h3>
        </div>
        <form action="{{ route('orders.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label for="customer_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="customer_address" id="customer_address" rows="2" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('customer_address') }}</textarea>
            </div>

            <div>
                <div class="flex items-center justify-between mb-4">
                    <label class="block text-sm font-medium text-gray-700">Item Order <span class="text-red-500">*</span></label>
                    <button type="button" @click="addItem()" class="text-indigo-600 hover:text-indigo-800 text-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Item
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex flex-col sm:flex-row gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <select :name="'items[' + index + '][product_id]'" x-model="item.product_id" @change="updatePrice(index)" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                            {{ $product->name }} (Stok: {{ $product->stock }}) - Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full sm:w-32">
                                <input type="number" :name="'items[' + index + '][quantity]'" x-model="item.quantity" min="1" placeholder="Qty" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                            <div class="w-full sm:w-40 flex items-center">
                                <span class="text-sm text-gray-500" x-text="'Rp ' + formatNumber(item.subtotal)"></span>
                            </div>
                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>

                <div class="mt-4 p-4 bg-indigo-50 rounded-lg flex justify-between items-center">
                    <span class="font-medium text-gray-700">Total:</span>
                    <span class="text-xl font-bold text-indigo-600" x-text="'Rp ' + formatNumber(calculateTotal())"></span>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('orders.index') }}" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan Order</button>
            </div>
        </form>
    </div>
</div>

<script>
function orderForm() {
    const productsData = @json($products->keyBy('id')->map(fn($p) => ['price' => $p->price, 'stock' => $p->stock]));

    return {
        items: [{ product_id: '', quantity: 1, subtotal: 0 }],

        addItem() {
            this.items.push({ product_id: '', quantity: 1, subtotal: 0 });
        },

        removeItem(index) {
            this.items.splice(index, 1);
        },

        updatePrice(index) {
            const item = this.items[index];
            const product = productsData[item.product_id];
            if (product) {
                item.subtotal = product.price * item.quantity;
            } else {
                item.subtotal = 0;
            }
        },

        calculateTotal() {
            let total = 0;
            this.items.forEach((item, index) => {
                const product = productsData[item.product_id];
                if (product) {
                    item.subtotal = product.price * item.quantity;
                    total += item.subtotal;
                }
            });
            return total;
        },

        formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    }
}
</script>
@endsection
