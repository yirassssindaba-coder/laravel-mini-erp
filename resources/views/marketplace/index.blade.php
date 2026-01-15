@extends('layouts.app')

@section('title', 'Marketplace')
@section('header', 'Log Marketplace')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Riwayat Sync Marketplace</h3>
        <a href="{{ route('marketplace.import') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-download mr-2"></i>Import Orders
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hasil</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($log->order)
                                <a href="{{ route('orders.show', $log->order) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $log->order->order_number }}
                                </a>
                            @else
                                <span class="text-gray-400">Order Dihapus</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($log->status) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full {{ $log->success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $log->success ? 'Success' : 'Failed' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-store text-4xl mb-2"></i>
                            <p>Belum ada log marketplace.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
