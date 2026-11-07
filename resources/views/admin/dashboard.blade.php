@extends('layouts.app')

@section('content')

<style>
    /* GRID KARTU */
    .uno-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 24px;
    }

    @media (min-width: 640px) {
        .uno-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1100px) {
        .uno-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    /* DASAR KARTU UNO */
    .report-card {
        --hover-bg: #64748b;
        --hover-border: #475569;
        --hover-text: #ffffff;

        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 355px;
        padding: 22px;
        overflow: hidden;

        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 28px;

        color: #1e293b;
        text-decoration: none;

        box-shadow: 0 5px 15px rgba(15, 23, 42, 0.06);

        transition:
            transform .3s ease,
            background .3s ease,
            border-color .3s ease,
            box-shadow .3s ease;
        isolation: isolate;
    }

    /* WARNA HOVER SESUAI STATUS */
    .report-card.status-waiting {
        --hover-bg: #E8AA35;
        --hover-border: #C68B20;
        --hover-text: #273449;
    }

    .report-card.status-accepted {
        --hover-bg: #299DA9;
        --hover-border: #16818D;
        --hover-text: #ffffff;
    }

    .report-card.status-processing {
        --hover-bg: #327DC7;
        --hover-border: #1E62A5;
        --hover-text: #ffffff;
    }

    .report-card.status-info {
        --hover-bg: #D4A12E;
        --hover-border: #B5821C;
        --hover-text: #273449;
    }

    .report-card.status-done {
        --hover-bg: #209B73;
        --hover-border: #137D5C;
        --hover-text: #ffffff;
    }

    .report-card.status-rejected {
        --hover-bg: #D94C60;
        --hover-border: #B72F44;
        --hover-text: #ffffff;
    }

    .report-card.status-other {
        --hover-bg: #64748b;
        --hover-border: #475569;
        --hover-text: #ffffff;
    }

    /* ANIMASI HOVER */
    .report-card:hover {
        transform: translateY(-8px) rotate(-0.7deg);
        background: var(--hover-bg);
        border-color: var(--hover-border);

        box-shadow: 0 20px 38px rgba(15, 23, 42, .20);
    }

    /* ORNAMEN OVAL UNO */
    .uno-oval {
        position: absolute;
        pointer-events: none;
        z-index: -1;

        width: 230px;
        height: 145px;

        top: 45%;
        left: 50%;

        transform: translate(-50%, -50%) rotate(-30deg);

        border: 5px solid rgba(255, 255, 255, .9);
        border-radius: 50%;

        opacity: 0;
        transition: opacity .3s ease;
    }

    .report-card:hover .uno-oval {
        opacity: .22;
    }

    /* TEKS KARTU */
    .report-ticket,
    .report-title,
    .report-category,
    .report-description,
    .report-location,
    .report-footer,
    .report-date {
        transition: color .3s ease;
    }

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

    /* BADGE STATUS TERPISAH */
    .report-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 8px 13px;
        border-radius: 999px;
        border: 1px solid;

        font-size: 10px;
        font-weight: 800;
        letter-spacing: .035em;
        line-height: 1.3;
        text-transform: uppercase;

        white-space: normal;
        text-align: center;
        max-width: 165px;

        box-shadow: 0 3px 8px rgba(0, 0, 0, .09);

        transition: transform .3s ease, box-shadow .3s ease;
    }

    .report-card:hover .report-status-badge {
        transform: scale(1.04);
        box-shadow: 0 5px 12px rgba(0, 0, 0, .15);
    }

    .badge-waiting {
        background: #FFF3D4;
        color: #895B06;
        border-color: #F2D38A;
    }

    .badge-accepted {
        background: #CFFAFE;
        color: #155E75;
        border-color: #A5F3FC;
    }

    .badge-processing {
        background: #DBEAFE;
        color: #1E40AF;
        border-color: #BFDBFE;
    }

    .badge-info {
        background: #FEF3C7;
        color: #92400E;
        border-color: #FDE68A;
    }

    .badge-done {
        background: #D1FAE5;
        color: #065F46;
        border-color: #A7F3D0;
    }

    .badge-rejected {
        background: #FFE4E6;
        color: #9F1239;
        border-color: #FECDD3;
    }

    .badge-other {
        background: #E2E8F0;
        color: #334155;
        border-color: #CBD5E1;
    }

    .report-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: #f1f5f9;
        color: #213a75;
        transition: color .3s ease, background .3s ease;
    }

    .report-card:hover .report-icon {
        background: rgba(255, 255, 255, .20);
    }

    .report-description {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 66px;

        padding: 12px;
        border-radius: 14px;
        border: 1px solid #f1f5f9;
        background: #f8fafc;

        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
    }

    .report-card:focus-visible {
        outline: 4px solid #409da1;
        outline-offset: 4px;
    }

    .report-arrow {
        transition: transform .3s ease;
    }

    .report-card:hover .report-arrow {
        transform: translateX(5px);
    }
</style>


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

        <div>
            <span class="text-xs font-bold text-unsriTeal uppercase tracking-widest">
                Admin Control Center
            </span>

            <h1 class="text-2xl md:text-3xl font-extrabold text-unsriNavy mt-1">
                Dashboard Pengaduan
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Pilih kartu laporan untuk melihat detail dan mengelola pengaduan.
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 shadow-sm">

            <div class="flex items-center text-sm text-gray-600">
                <i class="fa-solid fa-calendar-days mr-2 text-unsriTeal"></i>
                {{ now()->translatedFormat('d F Y') }}
            </div>

        </div>

    </div>


    {{-- NOTIFIKASI --}}
    @if(session('success'))

    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 text-sm">

        <i class="fa-solid fa-circle-check mr-2"></i>

        {{ session('success') }}

    </div>

    @endif


    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase">
                    Total Laporan
                </span>
                <i class="fa-solid fa-layer-group text-unsriNavy"></i>
            </div>

            <div class="text-3xl font-extrabold text-unsriNavy mt-3">
                {{ $total }}
            </div>
        </div>


        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase">
                    Menunggu
                </span>
                <i class="fa-solid fa-clock text-orange-500"></i>
            </div>

            <div class="text-3xl font-extrabold text-orange-500 mt-3">
                {{ $baru }}
            </div>
        </div>


        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase">
                    Diproses
                </span>
                <i class="fa-solid fa-spinner text-blue-500"></i>
            </div>

            <div class="text-3xl font-extrabold text-blue-500 mt-3">
                {{ $proses }}
            </div>
        </div>


        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase">
                    Selesai
                </span>
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
            </div>

            <div class="text-3xl font-extrabold text-emerald-500 mt-3">
                {{ $selesai }}
            </div>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-8">

        <div class="flex items-center gap-2 mb-4">
            <i class="fa-solid fa-sliders text-unsriTeal"></i>

            <h2 class="font-bold text-unsriNavy">
                Cari dan Filter Laporan
            </h2>
        </div>

        <form
            action="{{ route('admin.dashboard') }}"
            method="GET"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">

            {{-- PENCARIAN --}}
            <div>

                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">
                    Tiket / Judul
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nomor tiket atau judul..."
                    class="w-full border border-gray-300 rounded-xl px-3 py-3 text-sm focus:ring-2 focus:ring-unsriTeal focus:outline-none">

            </div>


            {{-- KATEGORI --}}
            <div>

                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">
                    Kategori
                </label>

                <select
                    name="kategori"
                    class="w-full border border-gray-300 rounded-xl px-3 py-3 text-sm focus:ring-2 focus:ring-unsriTeal focus:outline-none">

                    <option value="">Semua Kategori</option>

                    <option value="Sarana dan Prasarana"
                        @selected(request('kategori')=='Sarana dan Prasarana' )>
                        Sarana dan Prasarana
                    </option>

                    <option value="Akademik"
                        @selected(request('kategori')=='Akademik' )>
                        Akademik
                    </option>

                    <option value="Keuangan"
                        @selected(request('kategori')=='Keuangan' )>
                        Keuangan
                    </option>

                    <option value="Kemahasiswaan"
                        @selected(request('kategori')=='Kemahasiswaan' )>
                        Kemahasiswaan
                    </option>

                </select>

            </div>


            {{-- STATUS --}}
            <div>

                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border border-gray-300 rounded-xl px-3 py-3 text-sm focus:ring-2 focus:ring-unsriTeal focus:outline-none">

                    <option value="">Semua Status</option>

                    @foreach([
                    'Menunggu Verifikasi',
                    'Diterima',
                    'Sedang Diproses',
                    'Menunggu Informasi Tambahan',
                    'Selesai',
                    'Ditolak'
                    ] as $status)

                    <option value="{{ $status }}"
                        @selected(request('status')==$status)>
                        {{ $status }}
                    </option>

                    @endforeach

                </select>

            </div>


            {{-- BUTTON --}}
            <div class="flex gap-2">

                <button
                    type="submit"
                    class="flex-1 bg-unsriNavy hover:bg-blue-900 text-white font-bold rounded-xl px-4 py-3 text-sm transition">

                    <i class="fa-solid fa-magnifying-glass mr-1"></i>
                    Cari

                </button>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl px-4 py-3 transition"
                    title="Reset filter">

                    <i class="fa-solid fa-rotate-left"></i>

                </a>

            </div>

        </form>

    </div>


    {{-- JUDUL DAFTAR KARTU --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-5">

        <div>
            <h2 class="text-xl font-extrabold text-unsriNavy">
                Kartu Laporan Pengaduan
            </h2>

            <p class="text-xs text-gray-500 mt-1">
                Klik salah satu kartu untuk membuka halaman pengelolaan laporan.
            </p>
        </div>

        <div class="text-xs font-semibold text-gray-500 bg-white border border-gray-200 px-3 py-2 rounded-full">
            {{ $pengaduans->total() }} laporan ditemukan
        </div>

    </div>


    {{-- GRID KARTU UNO --}}
    @if($pengaduans->count() > 0)

    <div class="uno-grid">

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

        {{-- KARTU LAPORAN --}}
        <a
            href="{{ route('admin.pengaduan.show', $item->id) }}"
            class="report-card status-{{ $statusKey }}"
            aria-label="Buka detail laporan {{ $item->nomor_tiket }}">

            <div class="uno-oval"></div>

            {{-- BAGIAN ATAS KARTU --}}
            <div class="flex justify-between items-start gap-3 relative z-10">

                <div class="report-icon">
                    <i class="fa-solid fa-file-lines text-lg"></i>
                </div>

                {{-- BADGE STATUS TERPISAH --}}
                <span class="report-status-badge {{ $badgeClass }}">
                    {{ $item->status }}
                </span>

            </div>


            {{-- BAGIAN ISI KARTU --}}
            <div class="relative z-10 mt-5">

                <p class="report-ticket text-xs font-extrabold tracking-wider text-unsriNavy">
                    {{ $item->nomor_tiket }}
                </p>

                <h3 class="report-title text-xl font-extrabold text-gray-900 leading-snug mt-2">
                    {{ $item->judul }}
                </h3>

                <p class="report-category text-xs font-bold text-unsriTeal mt-2">
                    {{ $item->kategori }}
                </p>

                <div class="report-description mt-4">
                    {{ $item->deskripsi }}
                </div>


                {{-- LOKASI --}}
                <div class="report-location flex items-start gap-2 mt-4 text-sm text-gray-600">

                    <i class="fa-solid fa-location-dot text-unsriTeal mt-1"></i>

                    <span class="leading-snug">
                        {{ $item->lokasi }}
                    </span>

                </div>


                {{-- URGENSI --}}
                <div class="mt-3">

                    <span class="inline-flex bg-gray-100 text-gray-700 rounded-full px-3 py-1.5 text-xs font-bold">

                        <i class="fa-solid fa-bolt mr-1 mt-0.5"></i>

                        Urgensi {{ $item->urgensi }}

                    </span>

                </div>

            </div>


            {{-- FOOTER KARTU --}}
            <div class="report-footer relative z-10 border-t border-gray-200 pt-4 mt-5 flex items-center justify-between text-xs text-gray-500">

                <div>

                    <div class="font-bold">
                        @if($item->is_anonim)
                        <i class="fa-solid fa-user-secret mr-1"></i>
                        Anonim
                        @else
                        <i class="fa-solid fa-user mr-1"></i>
                        {{ $item->user->name ?? 'Pengguna' }}
                        @endif
                    </div>

                    <div class="report-date mt-1 text-gray-400">
                        {{ $item->created_at->format('d M Y') }}
                    </div>

                </div>

                <div class="flex items-center gap-2 font-extrabold">

                    Kelola

                    <i class="fa-solid fa-arrow-right report-arrow"></i>

                </div>

            </div>

        </a>

        @endforeach

    </div>


    {{-- PAGINATION --}}
    @if($pengaduans->hasPages())

    <div class="mt-8 bg-white rounded-xl border border-gray-100 p-4">

        {{ $pengaduans->links() }}

    </div>

    @endif

    @else

    {{-- KOSONG --}}
    <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-12 text-center">

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

@endsection