@extends('layouts.admin')

@section('title', 'Kelola Review Pelanggan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Review Pelanggan</h1>
        <p class="text-gray-600">Kelola dan balas review dari pelanggan</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.reviews') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <select name="product_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-48">
                <select name="rating" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                            ⭐ {{ $i }} Bintang
                        </option>
                    @endfor
                </select>
            </div>
            <div class="w-full md:w-48">
                <select name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Belum Dibalas</option>
                    <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Sudah Dibalas</option>
                </select>
            </div>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                Filter
            </button>
            @if(request()->hasAny(['product_id', 'rating', 'status']))
                <a href="{{ route('admin.reviews') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Reviews List -->
    <div class="space-y-4">
        @forelse($reviews as $review)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex gap-4">
                    <!-- Product Image (Clickable) -->
                    <a href="{{ route('product.show', $review->product->slug) }}" 
                       class="flex-shrink-0 group"
                       target="_blank">
                        <img src="{{ $review->product->image_url }}" 
                             alt="{{ $review->product->title }}" 
                             class="w-20 h-20 object-cover rounded-lg border-2 border-transparent group-hover:border-blue-500 transition-all">
                    </a>
                    
                    <div class="flex-1">
                        <!-- Product & User Info -->
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <a href="{{ route('product.show', $review->product->slug) }}" 
                                   target="_blank"
                                   class="font-semibold text-gray-800 hover:text-blue-600 transition-colors">
                                    {{ $review->product->title }}
                                </a>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-sm text-gray-600">{{ $review->user->name }}</span>
                                    <span class="text-gray-400">•</span>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <!-- Review Text -->
                        @if($review->review)
                            <p class="text-gray-700 mb-3">{{ $review->review }}</p>
                        @else
                            <p class="text-gray-400 italic mb-3">Tidak ada review tertulis</p>
                        @endif

                        <!-- Admin Reply Section -->
                        @if($review->admin_reply)
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-3">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-sm font-semibold text-blue-800">Balasan Admin</span>
                                    @if($review->replier)
                                        <span class="text-xs text-blue-600">• {{ $review->replier->name }}</span>
                                    @endif
                                    <span class="text-xs text-blue-500">• {{ $review->replied_at->format('d M Y H:i') }}</span>
                                </div>
                                <p class="text-gray-700">{{ $review->admin_reply }}</p>
                                <form method="POST" action="{{ route('admin.reviews.delete-reply', $review->id) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus balasan ini?')"
                                            class="text-xs text-red-600 hover:text-red-700 font-semibold">
                                        Hapus Balasan
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Reply Form -->
                            <form method="POST" action="{{ route('admin.reviews.reply', $review->id) }}" class="mt-3">
                                @csrf
                                <textarea name="admin_reply" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2"
                                          placeholder="Tulis balasan Anda..."
                                          required
                                          maxlength="1000"></textarea>
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        Kirim Balasan
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada review</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
        <div class="mt-8">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection
