@extends('layouts.kasir')

@section('title', 'Pelanggan')

@section('content')
<div class="py-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Data Pelanggan</h1>
            <p class="text-gray-600">Daftar pelanggan dan riwayat pembelian</p>
        </div>
        <a href="{{ route('kasir.member.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Member
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Pesanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bergabung</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($paginatedCustomers as $customer)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($customer->photo)
                                <img src="{{ asset('storage/' . $customer->photo) }}" class="w-10 h-10 rounded-full mr-3">
                            @else
                                <div class="w-10 h-10 bg-gray-300 rounded-full mr-3 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="font-medium">{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $customer->email }}</td>
                    <td class="px-6 py-4 text-sm">{{ $customer->orders_count }} pesanan</td>
                    <td class="px-6 py-4 text-sm">{{ $customer->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('kasir.pelanggan.riwayat', $customer->id) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            Lihat Riwayat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada pelanggan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $paginatedCustomers->links() }}
    </div>
</div>
@endsection
