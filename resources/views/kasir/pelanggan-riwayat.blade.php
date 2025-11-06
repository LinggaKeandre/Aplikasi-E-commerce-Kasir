@extends('layouts.kasir')

@section('title', 'Riwayat Pelanggan')

@section('content')
<div class="py-6">
    <div class="mb-6">
        <a href="{{ route('kasir.pelanggan') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            ← Kembali ke Daftar Pelanggan
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Pembelian</h1>
        <p class="text-gray-600">{{ $customer->name }} - {{ $customer->email }}</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $order->order_number }}</td>
                    <td class="px-6 py-4 text-sm">{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($order->shipping_method === 'kasir')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                Offline (Kasir)
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Online
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($order->status == 'delivered' || $order->status == 'completed')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                        @elseif($order->status == 'pending')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $order->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Pelanggan ini belum pernah melakukan pembelian
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>

    @if($orders->count() > 0)
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <p class="text-gray-500 text-sm">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $orders->total() }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Transaksi Online</p>
                <p class="text-2xl font-bold text-blue-600">{{ $orders->where('shipping_method', '!=', 'kasir')->count() }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Transaksi Offline</p>
                <p class="text-2xl font-bold text-purple-600">{{ $orders->where('shipping_method', 'kasir')->count() }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Pembelanjaan</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($orders->whereIn('status', ['delivered', 'completed'])->sum('total'), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
