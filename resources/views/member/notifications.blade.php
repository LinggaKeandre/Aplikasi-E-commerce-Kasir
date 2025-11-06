@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Notifikasi</h1>
        @if($unreadCount > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Tandai semua sudah dibaca
                </button>
            </form>
        @endif
    </div>

    @if($notifications->count() > 0)
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="bg-white rounded-lg shadow {{ $notification->is_read ? 'opacity-60' : 'border-l-4 border-blue-500' }} p-6 hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <!-- Icon & Title -->
                            <div class="flex items-center gap-3 mb-2">
                                @if($notification->type === 'verification_request')
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $notification->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Message -->
                            @if($notification->message)
                                <p class="text-gray-600 mb-3 ml-13">{{ $notification->message }}</p>
                            @endif

                            <!-- Verification Codes (if type is verification_request) -->
                            @if($notification->type === 'verification_request' && !$notification->is_read)
                                <div class="ml-13 bg-gray-50 rounded-lg p-4 border border-gray-200" x-data="{ selectedCode: '', loading: false, success: false, message: '', pointsEarned: 0, totalPoints: 0 }">
                                    <p class="text-sm text-gray-600 mb-3">
                                        <strong>Kasir:</strong> {{ $notification->data['kasir_name'] ?? 'Kasir' }}
                                    </p>
                                    <p class="text-sm font-medium text-gray-700 mb-3">Pilih kode yang disebutkan kasir:</p>
                                    
                                    <div x-show="!success">
                                        <div class="grid grid-cols-3 gap-3 mb-4">
                                            @foreach($notification->data['codes'] as $code)
                                                <button @click="selectedCode = '{{ $code }}'"
                                                        :class="selectedCode === '{{ $code }}' ? 'bg-blue-600 text-white ring-2 ring-blue-600' : 'bg-white text-gray-800 hover:bg-gray-100'"
                                                        class="py-3 rounded-lg font-bold text-xl border border-gray-300 transition transform hover:scale-105">
                                                    {{ $code }}
                                                </button>
                                            @endforeach
                                        </div>

                                        <button @click="
                                            if (!selectedCode) {
                                                alert('Pilih kode terlebih dahulu!');
                                                return;
                                            }
                                            loading = true;
                                            fetch('{{ route('notifications.verify', $notification->id) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({ code: selectedCode })
                                            })
                                            .then(res => {
                                                console.log('Response status:', res.status);
                                                if (!res.ok) {
                                                    throw new Error('HTTP error! status: ' + res.status);
                                                }
                                                return res.json();
                                            })
                                            .then(data => {
                                                console.log('Response data:', data);
                                                loading = false;
                                                if (data.success) {
                                                    success = true;
                                                    pointsEarned = data.points_earned;
                                                    totalPoints = data.total_points;
                                                    message = data.message;
                                                    // Auto refresh after 2 seconds
                                                    setTimeout(() => window.location.reload(), 2000);
                                                } else {
                                                    alert(data.message || 'Kode salah!');
                                                    // Auto refresh to remove expired notification
                                                    setTimeout(() => window.location.reload(), 1500);
                                                }
                                            })
                                            .catch(err => {
                                                loading = false;
                                                console.error('Error details:', err);
                                                alert('Terjadi kesalahan: ' + err.message + '. Cek console untuk detail.');
                                            });
                                        "
                                                :disabled="!selectedCode || loading"
                                                class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition">
                                            <span x-show="!loading">Verifikasi</span>
                                            <span x-show="loading">Loading...</span>
                                        </button>
                                    </div>

                                    <!-- Success Message -->
                                    <div x-show="success" class="text-center py-4">
                                        <svg class="w-16 h-16 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <h4 class="text-xl font-bold text-green-800 mb-2">Berhasil!</h4>
                                        <p class="text-gray-700 mb-2">
                                            Anda mendapatkan <strong x-text="pointsEarned"></strong> poin!
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Total poin: <strong x-text="totalPoints"></strong>
                                        </p>
                                        <button @click="window.location.reload()" 
                                                class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            @elseif($notification->is_read && $notification->type === 'verification_request')
                                <div class="ml-13 bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center gap-2 text-green-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="font-medium">Verifikasi berhasil</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Mark as Read Button (for non-verification notifications) -->
                        @if(!$notification->is_read && $notification->type !== 'verification_request')
                            <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium whitespace-nowrap">
                                    Tandai sudah dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada notifikasi</h3>
            <p class="text-gray-500">Notifikasi akan muncul di sini</p>
        </div>
    @endif
</div>
@endsection
