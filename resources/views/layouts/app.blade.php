<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sistem Pengaduan Layanan & Fasilitas UNSRI</title>
    <!-- Google Fonts: Geist (Judul) & Plus Jakarta Sans (Isi) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        unsriNavy: '#213a75',
                        unsriTeal: '#409da1',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        heading: ['"Geist"', '"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        geist: ['"Geist"', 'sans-serif'],
                        jakarta: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    screens: {
                        'xs': '480px',
                    }
                }
            }
        }
    </script>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-unsri.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1, h2, h3, h4, h5, h6,
        .font-heading,
        .font-geist {
            font-family: 'Geist', 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.015em;
        }

        @keyframes pageContentFadeIn {
            0% {
                opacity: 0;
                transform: translateY(14px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-content {
            animation: pageContentFadeIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .fade-out-page {
            opacity: 0 !important;
            transform: translateY(8px) !important;
            transition: opacity 0.2s ease-out, transform 0.2s ease-out !important;
        }

        /* Mobile hamburger menu */
        .mobile-menu-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .mobile-menu-panel {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .mobile-menu-panel.active {
            transform: translateX(0);
        }
    </style>
</head>

<body class="relative bg-slate-100/70 font-sans antialiased flex flex-col min-h-screen overflow-x-hidden">

    <!-- Watermark Background Logo UNSRI Transparan -->
    <div class="fixed inset-0 pointer-events-none select-none flex items-center justify-center z-0 overflow-hidden" aria-hidden="true">
        <div class="absolute w-[400px] h-[400px] sm:w-[600px] sm:h-[600px] md:w-[800px] md:h-[800px] bg-gradient-to-tr from-blue-100/30 via-teal-50/20 to-transparent rounded-full blur-3xl"></div>
        <img src="{{ asset('images/logo-unsri.png') }}" 
             alt="Logo UNSRI Watermark" 
             class="w-[280px] sm:w-[450px] md:w-[580px] lg:w-[680px] max-w-[85vw] max-h-[80vh] object-contain select-none pointer-events-none drop-shadow-sm"
             style="opacity: 0.12;">
    </div>

    <!-- NAVBAR UTAMA -->
    <nav class="bg-unsriNavy text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14 sm:h-16 items-center">
                <!-- Logo & Brand -->
                <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/dashboard')) : url('/') }}" class="flex items-center space-x-2 sm:space-x-3 min-w-0">
                    <img src="{{ asset('images/logo-unsri.png') }}" alt="Logo UNSRI" class="w-8 h-8 sm:w-10 sm:h-10 object-contain drop-shadow flex-shrink-0">
                    <div class="min-w-0">
                        <span class="font-bold text-sm sm:text-base md:text-lg tracking-wide block leading-tight truncate">SIPADU UNSRI</span>
                        <span class="text-[10px] sm:text-xs text-unsriTeal font-medium hidden xs:block">Layanan Pengaduan Mahasiswa & Kampus</span>
                    </div>
                </a>

                <!-- Desktop Menu & Profile -->
                @auth
                <div class="hidden md:flex items-center space-x-3 lg:space-x-6">
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
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>

                <!-- Mobile Hamburger Button -->
                <button id="mobileMenuBtn" type="button" class="md:hidden flex items-center justify-center w-9 h-9 rounded-lg bg-blue-900/50 border border-blue-800 text-white focus:outline-none active:bg-blue-800 transition">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay & Panel -->
    @auth
    <div id="mobileMenuOverlay" class="mobile-menu-overlay fixed inset-0 bg-black/50 z-[60] md:hidden">
        <div id="mobileMenuPanel" class="mobile-menu-panel absolute right-0 top-0 h-full w-72 bg-unsriNavy shadow-2xl flex flex-col">
            <!-- Mobile Menu Header -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-blue-800/60">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo-unsri.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                    <span class="font-bold text-sm text-white">SIPADU UNSRI</span>
                </div>
                <button id="mobileMenuClose" type="button" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 hover:text-white hover:bg-blue-800 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Mobile User Info -->
            <div class="px-5 py-4 border-b border-blue-800/40">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-unsriTeal/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user-circle text-unsriTeal text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <span class="text-[10px] bg-unsriTeal text-white px-2 py-0.5 rounded-full uppercase tracking-wider font-bold inline-block mt-1">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Links -->
            <div class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
                <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/dashboard') }}"
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm text-gray-200 hover:bg-blue-800/60 hover:text-white transition">
                    <i class="fa-solid fa-gauge-high w-5 text-center text-unsriTeal"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Mobile Logout -->
            <div class="px-4 py-4 border-t border-blue-800/40">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 bg-red-600/80 hover:bg-red-600 text-white font-medium py-2.5 rounded-xl text-sm transition">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar dari Akun</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endauth

    <!-- KONTEN UTAMA -->
    <main id="mainContent" class="flex-grow relative z-10 animate-fade-in-content">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-unsriNavy text-white text-center py-3 sm:py-4 px-4 text-[10px] sm:text-xs md:text-sm mt-auto border-t border-blue-900 relative z-20">
        <p>&copy; {{ date('Y') }} Universitas Sriwijaya. Unit Layanan Terpadu & ICT Center UNSRI.</p>
    </footer>

    <script>
        // Trigger animasi fade in setiap kali halaman ditampilkan (termasuk saat user menekan tombol Back di browser)
        window.addEventListener('pageshow', function (event) {
            const mainContent = document.getElementById('mainContent') || document.querySelector('main');
            if (mainContent) {
                mainContent.classList.remove('fade-out-page');
                mainContent.classList.remove('animate-fade-in-content');
                void mainContent.offsetWidth; // Memicu reflow browser agar animasi terulang
                mainContent.classList.add('animate-fade-in-content');
            }
        });

        // Transisi fade out halus saat menekan tombol atau link kembali ke dashboard
        document.addEventListener('DOMContentLoaded', function () {
            const backLinks = document.querySelectorAll('.btn-back-transition, a[href*="dashboard"]');
            backLinks.forEach(link => {
                // Kecualikan navbar brand link atau footer
                if (link.closest('nav') || link.closest('footer')) return;

                link.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (!href || href === '#' || href.startsWith('javascript:') || this.target === '_blank') return;
                    if (e.ctrlKey || e.metaKey || e.shiftKey) return;

                    const mainContent = document.getElementById('mainContent') || document.querySelector('main');
                    if (mainContent) {
                        e.preventDefault();
                        mainContent.classList.add('fade-out-page');
                        setTimeout(() => {
                            window.location.href = href;
                        }, 200);
                    }
                });
            });

            // Mobile menu toggle
            const menuBtn = document.getElementById('mobileMenuBtn');
            const menuOverlay = document.getElementById('mobileMenuOverlay');
            const menuPanel = document.getElementById('mobileMenuPanel');
            const menuClose = document.getElementById('mobileMenuClose');

            function openMenu() {
                if (menuOverlay && menuPanel) {
                    menuOverlay.classList.add('active');
                    menuPanel.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeMenu() {
                if (menuOverlay && menuPanel) {
                    menuPanel.classList.remove('active');
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            if (menuBtn) menuBtn.addEventListener('click', openMenu);
            if (menuClose) menuClose.addEventListener('click', closeMenu);
            if (menuOverlay) {
                menuOverlay.addEventListener('click', function(e) {
                    if (e.target === menuOverlay) closeMenu();
                });
            }
        });
    </script>

</body>

</html>
