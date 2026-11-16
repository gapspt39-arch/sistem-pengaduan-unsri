@extends('layouts.app')

@section('content')

<style>
    /* ============================================================
       CONTAINER TATA LETAK KARTU
       ============================================================ */
    .uno-container {
        transition: all 0.3s ease;
        width: 100%;
    }

    /* 1. TATA LETAK HORIZONTAL SCROLL */
    .uno-container.layout-horizontal {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        gap: 14px;
        padding: 4px 2px 16px 2px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #94a3b8 #f1f5f9;
        width: 100%;
    }

    .uno-container.layout-horizontal::-webkit-scrollbar { height: 6px; }
    .uno-container.layout-horizontal::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 999px; }
    .uno-container.layout-horizontal::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 999px; }

    .uno-container.layout-horizontal .report-card {
        min-width: 260px;
        max-width: 285px;
        width: 275px;
        min-height: 245px;
        padding: 14px 16px;
        flex-shrink: 0;
        scroll-snap-align: start;
        border-radius: 20px;
    }

    @media (min-width: 640px) {
        .uno-container.layout-horizontal .report-card {
            min-width: 290px;
            max-width: 310px;
            width: 300px;
            min-height: 260px;
            padding: 16px 18px;
            border-radius: 22px;
        }
    }

    /* 2. TATA LETAK GRID - MOBILE 1 KOLOM RAPI, TABLET 2 KOLOM, DESKTOP 3 KOLOM */
    .uno-container.layout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        width: 100%;
    }

    @media (min-width: 640px) {
        .uno-container.layout-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
    }

    @media (min-width: 1024px) {
        .uno-container.layout-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }
    }

    /* KARTU DI DALAM MODE GRID - MOBILE: KOMPAK & RAPI */
    .uno-container.layout-grid .report-card {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        min-height: auto;
        padding: 12px 14px;
        border-radius: 16px;
    }

    @media (min-width: 640px) {
        .uno-container.layout-grid .report-card {
            min-height: 270px;
            padding: 18px 20px;
            border-radius: 22px;
        }
    }

    /* ============================================================
       DASAR KARTU UNO
       ============================================================ */
    .report-card {
        --hover-bg: #64748b;
        --hover-border: #475569;
        --hover-text: #ffffff;
        --status-color: #64748b;

        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: auto;
        padding: 14px 15px;
        overflow: hidden;

        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;

        color: #1e293b;
        text-decoration: none;

        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04);

        transition:
            transform .25s ease,
            background .25s ease,
            border-color .25s ease,
            box-shadow .25s ease;
        isolation: isolate;
    }

    @media (min-width: 640px) {
        .report-card {
            border-radius: 22px;
            box-shadow: 0 10px 25px -4px rgba(15, 23, 42, 0.10), 0 4px 10px -2px rgba(15, 23, 42, 0.05);
        }
    }

    /* WARNA STATUS: border-left + variabel untuk aksen */
    .report-card.status-waiting {
        --hover-bg: #E8AA35; --hover-border: #C68B20; --hover-text: #273449; --status-color: #F59E0B;
        border-left: 4px solid #F59E0B;
    }
    .report-card.status-accepted {
        --hover-bg: #299DA9; --hover-border: #16818D; --hover-text: #ffffff; --status-color: #06B6D4;
        border-left: 4px solid #06B6D4;
    }
    .report-card.status-processing {
        --hover-bg: #327DC7; --hover-border: #1E62A5; --hover-text: #ffffff; --status-color: #3B82F6;
        border-left: 4px solid #3B82F6;
    }
    .report-card.status-info {
        --hover-bg: #D4A12E; --hover-border: #B5821C; --hover-text: #273449; --status-color: #EAB308;
        border-left: 4px solid #EAB308;
    }
    .report-card.status-done {
        --hover-bg: #209B73; --hover-border: #137D5C; --hover-text: #ffffff; --status-color: #10B981;
        border-left: 4px solid #10B981;
    }
    .report-card.status-rejected {
        --hover-bg: #D94C60; --hover-border: #B72F44; --hover-text: #ffffff; --status-color: #F43F5E;
        border-left: 4px solid #F43F5E;
    }
    .report-card.status-other {
        --hover-bg: #64748b; --hover-border: #475569; --hover-text: #ffffff; --status-color: #64748b;
        border-left: 4px solid #64748b;
    }

    /* ANIMASI HOVER - hanya untuk non-touch (desktop) */
    @media (hover: hover) {
        .report-card:hover {
            transform: translateY(-5px) rotate(-0.5deg);
            background: var(--hover-bg);
            border-color: var(--hover-border);
            box-shadow: 0 16px 30px -4px rgba(15, 23, 42, 0.22), 0 6px 12px -3px rgba(15, 23, 42, 0.12);
        }
    }

    /* Active state untuk sentuhan mobile */
    .report-card:active {
        transform: scale(0.98);
        box-shadow: 0 2px 8px -2px rgba(15, 23, 42, 0.12);
    }

    /* ORNAMEN OVAL UNO */
    .uno-oval {
        position: absolute;
        pointer-events: none;
        z-index: -1;
        width: 170px;
        height: 110px;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-30deg);
        border: 4px solid rgba(255, 255, 255, .9);
        border-radius: 50%;
        opacity: 0;
        transition: opacity .3s ease;
    }

    @media (hover: hover) {
        .report-card:hover .uno-oval { opacity: .22; }
    }

    /* ============================================================
       TIPOGRAFI KARTU
       ============================================================ */
    .report-title,
    .report-ticket,
    .report-status-badge {
        font-family: 'Geist', sans-serif;
    }

    .report-description,
    .report-category,
    .report-location,
    .report-footer {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Transisi warna teks saat hover */
    .report-ticket, .report-title, .report-category,
    .report-description, .report-location, .report-footer,
    .report-date { transition: color .3s ease; }

    @media (hover: hover) {
        .report-card:hover .report-ticket,
        .report-card:hover .report-title,
        .report-card:hover .report-category,
        .report-card:hover .report-description,
        .report-card:hover .report-location,
        .report-card:hover .report-footer,
        .report-card:hover .report-date,
        .report-card:hover .report-icon {
            color: var(--hover-text);
        }
        .report-card:hover .report-description {
            background: rgba(255, 255, 255, .14);
            border-color: rgba(255, 255, 255, .2);
        }
    }

    /* ============================================================
       BADGE STATUS
       ============================================================ */
    .report-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 3px 7px;
        border-radius: 999px;
        border: 1px solid;
        font-size: 8px;
        font-weight: 800;
        letter-spacing: .03em;
        line-height: 1.3;
        text-transform: uppercase;
        white-space: normal;
        text-align: center;
        max-width: 120px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .07);
        transition: transform .3s ease, box-shadow .3s ease;
    }

    @media (min-width: 640px) {
        .report-status-badge {
            padding: 5px 10px;
            font-size: 9px;
            max-width: 155px;
        }
    }

    @media (hover: hover) {
        .report-card:hover .report-status-badge {
            transform: scale(1.03);
            box-shadow: 0 4px 10px rgba(0, 0, 0, .12);
        }
    }

    .badge-waiting    { background: #FFF3D4; color: #895B06; border-color: #F2D38A; }
    .badge-accepted   { background: #CFFAFE; color: #155E75; border-color: #A5F3FC; }
    .badge-processing { background: #DBEAFE; color: #1E40AF; border-color: #BFDBFE; }
    .badge-info       { background: #FEF3C7; color: #92400E; border-color: #FDE68A; }
    .badge-done       { background: #D1FAE5; color: #065F46; border-color: #A7F3D0; }
    .badge-rejected   { background: #FFE4E6; color: #9F1239; border-color: #FECDD3; }
    .badge-other      { background: #E2E8F0; color: #334155; border-color: #CBD5E1; }

    /* ============================================================
       IKON DOKUMEN
       ============================================================ */
    .report-icon {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f1f5f9;
        color: #213a75;
        font-size: 12px;
        transition: color .3s ease, background .3s ease;
    }

    @media (min-width: 640px) {
        .report-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            font-size: 14px;
        }
    }

    @media (hover: hover) {
        .report-card:hover .report-icon {
            background: rgba(255, 255, 255, .20);
        }
    }

    /* ============================================================
       KOTAK DESKRIPSI
       ============================================================ */
    .report-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: auto;
        max-height: 40px;
        padding: 5px 8px;
        border-radius: 8px;
        border: 1px solid #f1f5f9;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        line-height: 1.45;
    }

    @media (min-width: 640px) {
        .report-description {
            max-height: 52px;
            -webkit-line-clamp: 3;
            padding: 8px 12px;
            border-radius: 12px;
            font-size: 12px;
            line-height: 1.55;
        }
    }

    /* ============================================================
       FOKUS & ARROW
       ============================================================ */
    .report-card:focus-visible {
        outline: 3px solid #409da1;
        outline-offset: 3px;
    }

    .report-arrow {
        transition: transform .3s ease;
    }

    @media (hover: hover) {
        .report-card:hover .report-arrow {
            transform: translateX(5px);
        }
    }

    /* ============================================================
       MOBILE GRID: LAYOUT KHUSUS KOMPAK 
       Kartu di mobile Grid ditampilkan sebagai baris horizontal mini
       agar hemat ruang dan mudah di-scroll secara vertikal
       ============================================================ */

    /* Default: strip tersembunyi, content wrapper biasa */
    .mobile-status-strip {
        display: none;
    }

    .mobile-card-content {
        display: contents;
    }

    @media (max-width: 639px) {
        .uno-container.layout-grid .report-card {
            display: grid;
            grid-template-columns: 5px 1fr;
            grid-template-rows: auto;
            gap: 0;
            padding: 0;
            border-left: none !important;
            border-radius: 14px;
            overflow: hidden;
            min-height: auto;
        }

        /* Strip warna status di sisi kiri kartu */
        .uno-container.layout-grid .mobile-status-strip {
            display: block;
            background: var(--status-color);
            border-radius: 14px 0 0 14px;
            min-height: 100%;
        }

        /* Konten utama di sisi kanan strip */
        .uno-container.layout-grid .mobile-card-content {
            display: flex;
            flex-direction: column;
            padding: 10px 12px;
            gap: 0;
        }

        /* Sembunyikan oval di mobile grid */
        .uno-container.layout-grid .uno-oval {
            display: none;
        }

        /* Header kartu mobile: ikon + tiket + badge status sebaris */
        .uno-container.layout-grid .card-top-section {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .uno-container.layout-grid .report-icon {
            width: 24px;
            height: 24px;
            font-size: 10px;
            border-radius: 6px;
        }

        .uno-container.layout-grid .report-status-badge {
            margin-left: auto;
            padding: 2px 6px;
            font-size: 7.5px;
            max-width: 110px;
        }

        /* Body kartu mobile: judul + kategori + deskripsi KOMPAK */
        .uno-container.layout-grid .card-body-section {
            margin-top: 5px !important;
        }

        .uno-container.layout-grid .report-title {
            font-size: 13.5px;
            line-height: 1.3;
        }

        .uno-container.layout-grid .report-category {
            font-size: 10px;
        }

        .uno-container.layout-grid .report-description {
            margin-top: 5px !important;
            padding: 4px 7px;
            font-size: 10.5px;
            max-height: 32px;
            border-radius: 6px;
        }

        /* Meta: lokasi & urgensi sebaris */
        .uno-container.layout-grid .report-meta-section {
            margin-top: 5px !important;
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px !important;
        }

        .uno-container.layout-grid .report-meta-section > * {
            margin: 0 !important;
        }

        .uno-container.layout-grid .report-location {
            font-size: 10.5px;
            flex: 1;
            min-width: 0;
        }

        .uno-container.layout-grid .report-meta-section .inline-flex {
            font-size: 9.5px;
            flex-shrink: 0;
        }

        /* Footer kartu mobile: user + kelola sebaris KOMPAK */
        .uno-container.layout-grid .report-footer {
            margin-top: 6px !important;
            padding-top: 6px !important;
            border-top: 1px solid #f1f5f9;
        }
    }
</style>


<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-5 sm:mb-7">

        <div>
            <span class="text-[10px] sm:text-xs font-bold text-unsriTeal uppercase tracking-widest">
                Admin Control Center
            </span>

            <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-unsriNavy mt-1">
                Dashboard Pengaduan
            </h1>

            <p class="text-xs sm:text-sm text-gray-500 mt-1 sm:mt-2">
                Pilih kartu laporan untuk melihat detail dan mengelola pengaduan.
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl px-3 py-2 sm:px-4 sm:py-3 shadow-md self-start sm:self-auto">

            <div class="flex items-center text-xs sm:text-sm text-gray-600">
                <i class="fa-solid fa-calendar-days mr-2 text-unsriTeal"></i>
                {{ now()->translatedFormat('d F Y') }}
            </div>

        </div>

    </div>


    {{-- NOTIFIKASI --}}
    @if(session('success'))

    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 text-sm shadow-md">

        <i class="fa-solid fa-circle-check mr-2"></i>

        {{ session('success') }}

    </div>

    @endif


    {{-- STATISTIK (KOMPAK, RAPI & HEMAT RUANG - IDENTIK DENGAN DESAIN KETUA) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3.5 mb-3.5 sm:mb-5">

        <div class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider block font-heading">
                    Total Laporan
                </span>
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-blue-50 text-unsriNavy flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-layer-group text-xs"></i>
                </div>
            </div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-black text-unsriNavy font-heading leading-tight mt-1.5 sm:mt-2">
                {{ $total }}
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider block font-heading">
                    Menunggu
                </span>
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-clock text-xs"></i>
                </div>
            </div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-black text-orange-500 font-heading leading-tight mt-1.5 sm:mt-2">
                {{ $baru }}
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider block font-heading">
                    Diproses
                </span>
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-spinner text-xs"></i>
                </div>
            </div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-black text-blue-600 font-heading leading-tight mt-1.5 sm:mt-2">
                {{ $proses }}
            </div>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider block font-heading">
                    Selesai
                </span>
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-xs"></i>
                </div>
            </div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-black text-emerald-600 font-heading leading-tight mt-1.5 sm:mt-2">
                {{ $selesai }}
            </div>
        </div>

    </div>


    {{-- FILTER (KOMPAK, RAPI, SESUAI DESKTOP KETUA & MOBILE HEMAT RUANG) --}}
    <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm p-3 sm:p-4 mb-4 sm:mb-5">

        <div class="flex items-center justify-between mb-2 sm:mb-2.5">
            <div class="flex items-center gap-1.5">
                <i class="fa-solid fa-sliders text-unsriTeal text-xs"></i>
                <h2 class="font-bold text-unsriNavy text-xs sm:text-sm font-heading">
                    Cari dan Filter Laporan
                </h2>
            </div>

            @if(request('search') || request('kategori') || request('status'))
            <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-bold text-rose-600 hover:text-rose-700 bg-rose-50 px-2.5 py-0.5 rounded-full flex items-center gap-1 transition">
                <i class="fa-solid fa-xmark"></i>
                <span>Reset Filter</span>
            </a>
            @endif
        </div>

        <form
            action="{{ route('admin.dashboard') }}"
            method="GET">

            {{-- TAMPILAN DESKTOP: 1 BARIS HORIZONTAL RAPI | TAMPILAN MOBILE: 2 BARIS KOMPAK --}}
            <div class="flex flex-col lg:flex-row lg:items-center gap-2">

                {{-- BARIS 1 DI MOBILE: INPUT PENCARIAN + TOMBOL CARI + RESET --}}
                <div class="flex items-center gap-1.5 flex-1 min-w-0">
                    <div class="relative flex-1 min-w-0">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-gray-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nomor tiket atau judul..."
                            class="w-full border border-gray-300 rounded-lg pl-8 pr-3 py-1.5 sm:py-2 text-xs focus:ring-2 focus:ring-unsriTeal focus:border-transparent focus:outline-none transition bg-slate-50/50">
                    </div>

                    <button
                        type="submit"
                        class="lg:hidden bg-unsriNavy hover:bg-blue-900 text-white font-bold rounded-lg px-3.5 py-1.5 text-xs transition flex items-center gap-1.5 flex-shrink-0 shadow-sm">
                        <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                        <span>Cari</span>
                    </button>

                    @if(request('search') || request('kategori') || request('status'))
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="lg:hidden bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg p-1.5 text-xs transition flex items-center justify-center flex-shrink-0 w-7 h-7"
                        title="Reset Filter">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                    </a>
                    @endif
                </div>

                {{-- BARIS 2 DI MOBILE (2 KOLOM) / INLINE DI DESKTOP: DROPDOWN KATEGORI & STATUS --}}
                <div class="grid grid-cols-2 lg:flex lg:items-center gap-2">
                    <div class="lg:w-48">
                        <select
                            name="kategori"
                            onchange="this.form.submit()"
                            class="w-full border border-gray-300 rounded-lg px-2.5 py-1.5 sm:py-2 text-xs focus:ring-2 focus:ring-unsriTeal focus:outline-none bg-slate-50/50 text-gray-700">

                            <option value="">Semua Kategori</option>
                            <option value="Sarana dan Prasarana" @selected(request('kategori')=='Sarana dan Prasarana')>Sarana & Prasarana</option>
                            <option value="Akademik" @selected(request('kategori')=='Akademik')>Akademik</option>
                            <option value="Keuangan" @selected(request('kategori')=='Keuangan')>Keuangan</option>
                            <option value="Kemahasiswaan" @selected(request('kategori')=='Kemahasiswaan')>Kemahasiswaan</option>
                        </select>
                    </div>

                    <div class="lg:w-44">
                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="w-full border border-gray-300 rounded-lg px-2.5 py-1.5 sm:py-2 text-xs focus:ring-2 focus:ring-unsriTeal focus:outline-none bg-slate-50/50 text-gray-700">

                            <option value="">Semua Status</option>
                            @foreach([
                            'Menunggu Verifikasi',
                            'Diterima',
                            'Sedang Diproses',
                            'Menunggu Informasi Tambahan',
                            'Selesai',
                            'Ditolak'
                            ] as $status)
                            <option value="{{ $status }}" @selected(request('status')==$status)>
                                {{ $status }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- TOMBOL CARI & RESET FILTER KHUSUS DESKTOP --}}
                <div class="hidden lg:flex items-center gap-1.5">
                    <button
                        type="submit"
                        class="bg-unsriNavy hover:bg-blue-900 text-white font-bold rounded-lg px-4 py-2 text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                        <span>Cari</span>
                    </button>

                    @if(request('search') || request('kategori') || request('status'))
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg p-2 text-xs transition flex items-center justify-center flex-shrink-0 w-8 h-8"
                        title="Reset Filter">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                    </a>
                    @endif
                </div>

            </div>

        </form>

    </div>


    {{-- JUDUL DAFTAR KARTU & KONTROL TATA LETAK --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">

        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-lg sm:text-xl font-extrabold text-unsriNavy font-heading">
                    Kartu Laporan Pengaduan
                </h2>
                <span class="text-[11px] font-bold text-gray-500 bg-white border border-gray-200 px-2.5 py-0.5 rounded-full shadow-sm">
                    {{ $pengaduans->total() }} laporan ditemukan
                </span>
            </div>

            <p class="text-xs text-gray-500 mt-0.5">
                Pilih salah satu kartu untuk membuka halaman pengelolaan laporan.
            </p>
        </div>

        {{-- KONTROL MODE TAMPILAN: GRID (DEFAULT) & HORIZONTAL SCROLL --}}
        <div class="flex items-center gap-2 self-start sm:self-auto">

            {{-- TOMBOL NAVIGASI SCROLL HORIZONTAL (MUNCUL JIKA MODE HORIZONTAL DIAKTIFKAN) --}}
            <div id="horizontalScrollNav" style="display: none;" class="items-center gap-1 bg-white border border-gray-200 p-1 rounded-xl shadow-sm">
                <button type="button" id="btnScrollLeft" class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-slate-100 text-gray-600 transition" title="Geser ke Kiri">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button type="button" id="btnScrollRight" class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-slate-100 text-gray-600 transition" title="Geser ke Kanan">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>

            {{-- TOGGLE LAYOUT BUTTONS --}}
            <div class="inline-flex bg-gray-200/80 p-1 rounded-xl text-xs font-semibold">
                <button type="button" id="btnLayoutGrid" class="layout-toggle-btn active flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-unsriNavy bg-white shadow-sm transition">
                    <i class="fa-solid fa-table-cells-large"></i>
                    <span>Grid</span>
                </button>
                <button type="button" id="btnLayoutHorizontal" class="layout-toggle-btn flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-gray-600 hover:text-unsriNavy transition">
                    <i class="fa-solid fa-arrows-left-right text-unsriTeal"></i>
                    <span>Horizontal</span>
                </button>
            </div>

        </div>

    </div>

    {{-- PETUNJUK GESER HORIZONTAL (HANYA AKTIF DI MODE HORIZONTAL) --}}
    <div id="horizontalScrollHint" style="display: none;" class="items-center gap-1.5 text-[11px] text-gray-500 mb-2 px-1">
        <i class="fa-solid fa-hand-point-right text-unsriTeal animate-pulse"></i>
        <span>Geser ke samping (swipe horizontal) atau gunakan tombol panah untuk melihat kartu lainnya</span>
    </div>


    {{-- KONTAINER KARTU UNO --}}
    @if($pengaduans->count() > 0)

    <div id="cardContainer" class="uno-container layout-grid">

        @foreach($pengaduans as $item)

        @php
        $statusKey = match($item->status) {
        'Menunggu Verifikasi' => 'waiting',
        'Diterima' => 'accepted',
        'Sedang Diproses' => 'processing',
        'Menunggu Informasi Tambahan' => 'info',
        'Selesai' => 'done',
        'Ditolak' => 'rejected',
        default => 'other',
        };

        $badgeClass = match($statusKey) {
        'waiting' => 'badge-waiting',
        'accepted' => 'badge-accepted',
        'processing' => 'badge-processing',
        'info' => 'badge-info',
        'done' => 'badge-done',
        'rejected' => 'badge-rejected',
        default => 'badge-other',
        };
        @endphp

        {{-- KARTU LAPORAN UNO --}}
        <a
            href="{{ route('admin.pengaduan.show', $item->id) }}"
            class="report-card status-{{ $statusKey }}"
            aria-label="Buka detail laporan {{ $item->nomor_tiket }}">

            {{-- Strip warna status kiri (mobile grid only, CSS handles visibility) --}}
            <div class="mobile-status-strip"></div>

            {{-- Wrapper konten (mobile grid: kolom ke-2 dari CSS grid) --}}
            <div class="mobile-card-content">

                <div class="uno-oval"></div>

                {{-- BAGIAN ATAS KARTU: IKON + TIKET + BADGE STATUS --}}
                <div class="card-top-section flex justify-between items-center gap-2 relative z-10">

                    <div class="flex items-center gap-2 min-w-0">
                        <div class="report-icon flex-shrink-0">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <span class="report-ticket text-[10px] sm:text-xs font-black tracking-wider text-unsriNavy font-heading truncate">
                            {{ $item->nomor_tiket }}
                        </span>
                    </div>

                    <span class="report-status-badge {{ $badgeClass }} flex-shrink-0">
                        {{ $item->status }}
                    </span>

                </div>

                {{-- BAGIAN ISI KARTU --}}
                <div class="card-body-section relative z-10 mt-2 sm:mt-4">

                    <h3 class="report-title text-[15px] sm:text-lg font-black text-gray-900 leading-snug line-clamp-2">
                        {{ $item->judul }}
                    </h3>

                    <p class="report-category text-[10px] sm:text-xs font-bold text-unsriTeal mt-0.5 sm:mt-1">
                        {{ $item->kategori }}
                    </p>

                    <div class="report-description mt-1.5 sm:mt-2.5">
                        {{ $item->deskripsi }}
                    </div>

                    {{-- LOKASI & URGENSI --}}
                    <div class="report-meta-section mt-2 sm:mt-3 space-y-1.5 sm:space-y-2">

                        <div class="report-location flex items-center gap-1.5 text-[11px] sm:text-xs text-gray-600 min-w-0">
                            <i class="fa-solid fa-location-dot text-unsriTeal flex-shrink-0 text-[10px] sm:text-xs"></i>
                            <span class="truncate">{{ $item->lokasi }}</span>
                        </div>

                        <div>
                            <span class="inline-flex items-center bg-gray-100 text-gray-700 rounded-full px-2 sm:px-2.5 py-0.5 text-[9px] sm:text-[11px] font-bold">
                                <i class="fa-solid fa-bolt mr-1 text-orange-500"></i>
                                Urgensi {{ $item->urgensi }}
                            </span>
                        </div>

                    </div>

                </div>

                {{-- FOOTER KARTU --}}
                <div class="report-footer relative z-10 border-t border-gray-100 pt-2 sm:pt-2.5 mt-2 sm:mt-4 flex items-center justify-between text-xs text-gray-500">

                    <div class="min-w-0 flex items-center gap-1.5 sm:gap-2">

                        <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0 text-[9px] sm:text-[10px]">
                            @if($item->is_anonim)
                            <i class="fa-solid fa-user-secret"></i>
                            @else
                            <i class="fa-solid fa-user"></i>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <div class="font-bold text-gray-700 text-[11px] sm:text-xs truncate max-w-[100px] sm:max-w-[160px]">
                                @if($item->is_anonim)
                                Anonim
                                @else
                                {{ $item->user->name ?? 'Pengguna' }}
                                @endif
                            </div>

                            <div class="report-date text-[9px] sm:text-[10px] text-gray-400">
                                {{ $item->created_at->format('d M Y') }}
                            </div>
                        </div>

                    </div>

                    <div class="inline-flex items-center gap-1 font-bold text-[11px] sm:text-xs text-unsriNavy bg-blue-50 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-lg transition">
                        <span>Kelola</span>
                        <i class="fa-solid fa-arrow-right report-arrow text-[9px] sm:text-[10px]"></i>
                    </div>

                </div>

            </div>

        </a>

        @endforeach

    </div>


    {{-- PAGINATION --}}
    @if($pengaduans->hasPages())

    <div class="mt-8 bg-white rounded-xl border border-gray-100 p-4 shadow-md">

        {{ $pengaduans->links() }}

    </div>

    @endif

    @else

    {{-- KOSONG --}}
    <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-12 text-center shadow-md">

        <div class="w-20 h-20 mx-auto rounded-3xl bg-gray-100 flex items-center justify-center">

            <i class="fa-solid fa-inbox text-3xl text-gray-400"></i>

        </div>

        <h3 class="font-extrabold text-gray-700 mt-5">
            Belum Ada Laporan
        </h3>

        <p class="text-sm text-gray-400 mt-2">
            Tidak ada laporan yang sesuai dengan pencarian atau filter.
        </p>

        <a
            href="{{ route('admin.dashboard') }}"
            class="inline-flex mt-5 bg-unsriNavy text-white px-5 py-2.5 rounded-xl text-sm font-bold">

            Tampilkan Semua Laporan

        </a>

    </div>

    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('cardContainer');
        const scrollNav = document.getElementById('horizontalScrollNav');
        const scrollHint = document.getElementById('horizontalScrollHint');
        const btnScrollLeft = document.getElementById('btnScrollLeft');
        const btnScrollRight = document.getElementById('btnScrollRight');

        const btnLayoutHorizontal = document.getElementById('btnLayoutHorizontal');
        const btnLayoutGrid = document.getElementById('btnLayoutGrid');

        if (!container) return;

        function setLayout(mode) {
            container.classList.remove('layout-horizontal', 'layout-grid');
            container.classList.add('layout-' + mode);

            [btnLayoutHorizontal, btnLayoutGrid].forEach(btn => {
                if (!btn) return;
                btn.classList.remove('active', 'bg-white', 'text-unsriNavy', 'shadow-sm');
                btn.classList.add('text-gray-600');
            });

            if (mode === 'horizontal') {
                if (btnLayoutHorizontal) {
                    btnLayoutHorizontal.classList.add('active', 'bg-white', 'text-unsriNavy', 'shadow-sm');
                    btnLayoutHorizontal.classList.remove('text-gray-600');
                }
                if (scrollNav) scrollNav.style.display = 'flex';
                if (scrollHint) scrollHint.style.display = 'flex';
            } else if (mode === 'grid') {
                if (btnLayoutGrid) {
                    btnLayoutGrid.classList.add('active', 'bg-white', 'text-unsriNavy', 'shadow-sm');
                    btnLayoutGrid.classList.remove('text-gray-600');
                }
                if (scrollNav) scrollNav.style.display = 'none';
                if (scrollHint) scrollHint.style.display = 'none';
            }

            localStorage.setItem('sipadu_admin_card_layout', mode);
        }

        if (btnLayoutHorizontal) btnLayoutHorizontal.addEventListener('click', () => setLayout('horizontal'));
        if (btnLayoutGrid) btnLayoutGrid.addEventListener('click', () => setLayout('grid'));

        if (btnScrollLeft) {
            btnScrollLeft.addEventListener('click', () => {
                container.scrollBy({ left: -280, behavior: 'smooth' });
            });
        }
        if (btnScrollRight) {
            btnScrollRight.addEventListener('click', () => {
                container.scrollBy({ left: 280, behavior: 'smooth' });
            });
        }

        // Default layout: Grid responsif penuh (desktop 3 kolom, tablet 2 kolom, mobile 1 kolom rapi)
        const savedLayout = localStorage.getItem('sipadu_admin_card_layout') || 'grid';
        setLayout(savedLayout);
    });
</script>

@endsection