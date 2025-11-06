@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Akun</h1>
        <p class="text-sm text-gray-600">Edit informasi akun {{ $user->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.accounts.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Profile Photo -->
                @if($user->photo)
                <div class="flex items-center gap-4 pb-4 border-b">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                         class="w-20 h-20 rounded-full border-2 border-gray-200">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Foto Profil</p>
                        <p class="text-xs text-gray-500">Foto hanya bisa diubah oleh user sendiri</p>
                    </div>
                </div>
                @endif

                <!-- Read-only Data Pribadi -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-sm font-bold text-gray-800 mb-3">📋 Data Pribadi (Read-only)</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Nama Lengkap</p>
                            <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Email</p>
                            <p class="font-semibold text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Telepon</p>
                            <p class="font-semibold text-gray-900">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Jenis Kelamin</p>
                            <p class="font-semibold text-gray-900">
                                @if($user->gender === 'male')
                                    Laki-laki
                                @elseif($user->gender === 'female')
                                    Perempuan
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600">Tanggal Lahir</p>
                            <p class="font-semibold text-gray-900">{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Kota</p>
                            <p class="font-semibold text-gray-900">{{ $user->city ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Provinsi</p>
                            <p class="font-semibold text-gray-900">{{ $user->province ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Kode Pos</p>
                            <p class="font-semibold text-gray-900">{{ $user->postal_code ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-600">Alamat Lengkap</p>
                            <p class="font-semibold text-gray-900">{{ $user->address ?? '-' }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">
                        ℹ️ Data pribadi tidak dapat diubah oleh admin. User harus mengubahnya sendiri dari halaman profile.
                    </p>
                </div>

                <hr class="my-4">

                <h3 class="text-sm font-bold text-gray-800 mb-3">✏️ Yang Dapat Diubah Admin</h3>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role *</label>
                    <select name="role" id="role" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member</option>
                        <option value="kasir" {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-4">

                <!-- Password (Optional) -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-yellow-800 mb-2">⚠️ Ubah Password (Opsional)</p>
                    <p class="text-xs text-yellow-700 mb-4">Kosongkan jika tidak ingin mengubah password</p>

                    <div class="space-y-3">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password" id="password"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-gray-700 mb-2">ℹ️ Informasi Akun</p>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p>ID: <span class="font-semibold">{{ $user->id }}</span></p>
                        <p>Terdaftar: <span class="font-semibold">{{ $user->created_at->format('d M Y H:i') }}</span></p>
                        <p>Update Terakhir: <span class="font-semibold">{{ $user->updated_at->format('d M Y H:i') }}</span></p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <a href="{{ route('admin.accounts') }}" 
                   class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-center font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
