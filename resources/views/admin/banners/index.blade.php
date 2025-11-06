@extends('layouts.admin')

@section('title', 'Manajemen Banner Promosi')

@section('content')
<div class="container mx-auto px-4 py-6" x-data="{ activeTab: '{{ request('position', 'home') }}' }">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Banner Promosi</h1>
            <p class="text-gray-600 mt-1">Kelola banner di katalog dan layar customer</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">Tambah Banner</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-1 inline-flex gap-1 mb-6">
        <a href="{{ route('admin.banners.index', ['position' => 'home']) }}" @click="activeTab = 'home'" :class="activeTab === 'home' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100'" class="px-6 py-2.5 rounded-md font-medium text-sm transition">Banner Katalog</a>
        <a href="{{ route('admin.banners.index', ['position' => 'customer_display']) }}" @click="activeTab = 'customer_display'" :class="activeTab === 'customer_display' ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-gray-100'" class="px-6 py-2.5 rounded-md font-medium text-sm transition">Banner Customer Display</a>
    </div>

    @php
        $position = request('position', 'home');
        $filteredBanners = $banners->where('position', $position)->sortBy('display_order');
    @endphp

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if($filteredBanners->count() > 0)
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left">Urutan</th>
                    <th class="px-6 py-4 text-left">Preview</th>
                    <th class="px-6 py-4 text-left">Judul</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filteredBanners as $banner)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4">
                        @if(!$loop->first)
                        <form action="{{ route('admin.banners.reorder', $banner) }}" method="POST" class="inline">@csrf @method('PUT')<input type="hidden" name="direction" value="up"><button type="submit">↑</button></form>
                        @endif
                        @if(!$loop->last)
                        <form action="{{ route('admin.banners.reorder', $banner) }}" method="POST" class="inline">@csrf @method('PUT')<input type="hidden" name="direction" value="down"><button type="submit">↓</button></form>
                        @endif
                    </td>
                    <td class="px-6 py-4"><img src="{{ asset('storage/' . $banner->image_path) }}" class="h-20 w-40 object-cover rounded"></td>
                    <td class="px-6 py-4">
                        <div>{{ $banner->title }}</div>
                        <span class="text-xs px-2 py-1 rounded {{ $position === 'home' ? 'bg-blue-100' : 'bg-green-100' }}">{{ $position === 'home' ? 'Katalog' : 'Customer Display' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST">@csrf @method('PUT')<button type="submit" class="px-3 py-1 rounded {{ $banner->is_active ? 'bg-green-100' : 'bg-gray-100' }}">{{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}</button></form>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button></form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-12">
            <h3 class="text-lg font-medium">Belum ada banner {{ $position === 'home' ? 'katalog' : 'customer display' }}</h3>
            <a href="{{ route('admin.banners.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded">Tambah Banner</a>
        </div>
        @endif
    </div>
</div>
@endsection