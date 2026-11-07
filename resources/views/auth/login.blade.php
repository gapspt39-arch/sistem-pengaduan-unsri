<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pengaduan UNSRI</title>
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

<body class="relative min-h-screen flex items-center justify-center px-4 bg-slate-900 overflow-x-hidden font-sans">

    <!-- Background Landmark UNSRI with Gradient Overlay -->
    <div class="fixed inset-0 z-0 select-none pointer-events-none">
        <img src="{{ asset('images/unsri_landmark_plg.jpg') }}" 
             alt="Landmark UNSRI" 
             class="w-full h-full object-cover object-center filter brightness-[0.70] contrast-[1.05]">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-[#1b2f5d]/40 to-black/70 backdrop-blur-[1px]"></div>
    </div>

    <!-- Login Card -->
    <div class="relative z-10 max-w-md w-full bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 border-t-4 border-unsriTeal">
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-unsri.png') }}" alt="Logo UNSRI" class="w-20 h-20 mx-auto mb-3 object-contain drop-shadow-md">
            <h1 class="text-2xl font-bold text-unsriNavy">SIPADU UNSRI</h1>
            <p class="text-xs text-gray-500 mt-1">Sistem Pengaduan Layanan & Fasilitas Kampus</p>
        </div>

        @if($errors->any())
        <div class="mb-4 bg-rose-50 border-l-4 border-rose-500 p-3 text-xs text-rose-700 rounded-r">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        </div>
        @endif

        @if(session('success'))
        <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 p-3 text-xs text-emerald-700 rounded-r">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-check mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Kampus</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full text-sm pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsriTeal focus:border-transparent outline-none transition"
                        placeholder="nama@unsri.ac.id">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                    <input type="password" name="password" required
                        class="w-full text-sm pl-9 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-unsriTeal focus:border-transparent outline-none transition"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full bg-unsriNavy hover:bg-blue-900 text-white font-semibold py-2.5 rounded-lg text-sm transition shadow-md flex items-center justify-center space-x-2">
                <span>Masuk Sistem</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </form>
    </div>

</body>

</html>