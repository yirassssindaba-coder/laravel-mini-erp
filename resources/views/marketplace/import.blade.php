@extends('layouts.app')

@section('title', 'Import Marketplace')
@section('header', 'Import Order Marketplace')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Import Mock Orders</h3>
        </div>
        <div class="p-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-800">Tentang Import Marketplace</h4>
                        <p class="mt-1 text-sm text-blue-600">
                            Fitur ini akan mengimport order dari file JSON lokal yang mensimulasikan integrasi dengan marketplace eksternal.
                            Ini adalah fitur mock untuk demonstrasi, bukan koneksi API sebenarnya.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Contoh Data Mock:</h4>
                <pre class="text-xs text-gray-600 overflow-x-auto">
{
  "orders": [
    {
      "order_number": "MKT-20260115-001",
      "customer_name": "Budi Santoso",
      "items": [...]
    }
  ]
}
                </pre>
            </div>

            <form action="{{ route('marketplace.import.process') }}" method="POST">
                @csrf
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('marketplace.index') }}" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class="fas fa-download mr-2"></i>Import Orders
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
