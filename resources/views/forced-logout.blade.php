<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Berubah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Background Page (Blurred) -->
    <div class="min-h-screen p-6 filter blur-sm pointer-events-none">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="h-8 bg-gray-200 rounded w-1/4 mb-4"></div>
                <div class="space-y-3">
                    <div class="h-4 bg-gray-200 rounded w-full"></div>
                    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                    <div class="h-4 bg-gray-200 rounded w-4/6"></div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="h-24 bg-gray-200 rounded mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="h-24 bg-gray-200 rounded mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="h-24 bg-gray-200 rounded mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
            <!-- Header -->
            <div class="border-b px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Role Akun Telah Diubah</h2>
            </div>

            <!-- Content -->
            <div class="px-6 py-5 space-y-4">
                <!-- Alert -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                    <p class="text-sm text-gray-700">
                        Administrator telah mengubah role akun Anda. Silakan logout dan login kembali untuk melanjutkan.
                    </p>
                </div>

                <!-- Role Change -->
                <div class="flex items-center justify-center gap-3 py-2">
                    <span class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded text-sm font-medium">
                        {{ ucfirst($oldRole) }}
                    </span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                    <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded text-sm font-medium">
                        {{ ucfirst($newRole) }}
                    </span>
                </div>

                <!-- Info -->
                <div class="bg-gray-50 rounded-md p-3">
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Perubahan role memerlukan sesi login baru. Setelah logout, login kembali dengan username dan password Anda untuk melihat tampilan yang sesuai dengan role baru.
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t px-6 py-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-md hover:bg-blue-700 font-medium text-sm transition">
                        Logout Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Prevent back button
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</body>
</html>
