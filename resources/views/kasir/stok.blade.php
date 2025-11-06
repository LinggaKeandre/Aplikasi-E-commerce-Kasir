@extends('layouts.kasir')

@section('title', 'Stok Produk')

@section('content')
<div class="py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Stok Produk</h1>
        <p class="text-gray-600">Lihat dan update stok produk</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <img src="{{ $product->image_url }}" class="w-12 h-12 rounded object-cover mr-3">
                            <span class="font-medium">{{ $product->title }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">Rp {{ number_format($product->price - $product->discount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded {{ $product->stock < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $product->stock }} unit
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="updateStok({{ $product->id }}, {{ $product->stock }})" 
                                class="text-blue-600 hover:text-blue-800 text-sm">
                            Update Stok
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>

<script>
function updateStok(productId, currentStock) {
    const newStock = prompt('Masukkan stok baru:', currentStock);
    if (newStock !== null && newStock >= 0) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/kasir/stok/${productId}/update`;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'PATCH';
        form.appendChild(method);
        
        const stock = document.createElement('input');
        stock.type = 'hidden';
        stock.name = 'stock';
        stock.value = newStock;
        form.appendChild(stock);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
