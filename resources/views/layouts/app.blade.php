<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan Layanan & Fasilitas UNSRI</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        unsriNavy: '#213a75',
                        unsriTeal: '#409da1',
                    }
                }
            }
        }
    </script>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-unsri.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="relative bg-slate-100/70 font-sans antialiased flex flex-col min-h-screen">

    <!-- Watermark Background Logo UNSRI Transparan -->
    <div class="fixed inset-0 pointer-events-none select-none flex items-center justify-center z-0 overflow-hidden" aria-hidden="true">
        <div class="absolute w-[600px] h-[600px] sm:w-[800px] sm:h-[800px] bg-gradient-to-tr from-blue-100/30 via-teal-50/20 to-transparent rounded-full blur-3xl"></div>
        <img src="{{ asset('images/logo-unsri.png') }}" 
             alt="Logo UNSRI Watermark" 
             class="w-[450px] sm:w-[580px] md:w-[680px] max-w-[85vw] max-h-[80vh] object-contain select-none pointer-events-none drop-shadow-sm"
             style="opacity: 0.12;">
    </div>

    <!-- NAVBAR UTAMA -->
    <nav class="bg-unsriNavy text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo & Brand -->
                <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/dashboard')) : url('/') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-unsri.png') }}" alt="Logo UNSRI" class="w-10 h-10 object-contain drop-shadow">
                    <div>
                        <span class="font-bold text-base sm:text-lg tracking-wide block leading-tight">SIPADU UNSRI</span>
                        <span class="text-xs text-unsriTeal font-medium">Layanan Pengaduan Mahasiswa & Kampus</span>
                    </div>
                </a>

                <!-- Menu & Profile User yang Login -->
                @auth
                <div class="flex items-center space-x-3 sm:space-x-6">
                    <div class="flex items-center space-x-2 bg-blue-900/50 py-1.5 px-3 rounded-full border border-blue-800">
                        <i class="fa-solid fa-user-circle text-unsriTeal text-base sm:text-lg"></i>
                        <span class="text-xs sm:text-sm font-medium">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] sm:text-xs bg-unsriTeal text-white px-2 py-0.5 rounded-full uppercase tracking-wider font-bold">
                            {{ Auth::user()->role }}
                        </span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-white transition flex items-center space-x-1 text-xs sm:text-sm font-medium bg-red-600/80 hover:bg-red-600 px-3 py-1.5 rounded-lg shadow">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="flex-grow relative z-10">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-unsriNavy text-white text-center py-4 text-xs sm:text-sm mt-auto border-t border-blue-900 relative z-20">
        <p>&copy; {{ date('Y') }} Universitas Sriwijaya. Unit Layanan Terpadu & ICT Center UNSRI.</p>
    </footer>

</body>

</html>
