@extends('layouts.app')

@section('content')

@php
$currentStatus = old('status', $pengaduan->status);

$statusKey = match($pengaduan->status) {
'Menunggu Verifikasi' => 'waiting',
'Diterima' => 'accepted',
'Sedang Diproses' => 'processing',
'Menunggu Informasi Tambahan' => 'info',
'Selesai' => 'done',
'Ditolak' => 'rejected',
default => 'other',
};

$badgeClass = match($statusKey) {
'waiting' => 'bg-amber-100 text-amber-800 border-amber-200',
'accepted' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
'info' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
'done' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
'rejected' => 'bg-rose-100 text-rose-800 border-rose-200',
default => 'bg-gray-100 text-gray-800 border-gray-200',
};
@endphp


<style>
    .detail-panel {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 24px;
        box-shadow: 0 12px 30px -4px rgba(15, 23, 42, 0.12), 0 6px 14px -4px rgba(15, 23, 42, 0.08);
    }

    .detail-info {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .detail-label {
        display: block;
        font-size: 10px;
        color: #94a3b8;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .07em;
        margin-bottom: 7px;
    }

    .detail-value {
        font-size: 14px;
        color: #1e293b;
        font-weight: 600;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .detail-input {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 12px;
        font-size: 13px;
        outline: none;
        background: white;
    }

    .detail-input:focus {
        border-color: #409da1;
        box-shadow: 0 0 0 3px rgba(64, 157, 161, .12);
    }

    .detail-section-title {
        color: #213a75;
        font-size: 17px;
        font-weight: 800;
    }
</style>


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- TOMBOL KEMBALI --}}
    <a
        href="{{ route('admin.dashboard') }}"
        class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-unsriNavy mb-6">

        <i class="fa-solid fa-arrow-left"></i>

        Kembali ke Dashboard

    </a>


    {{-- HEADER DETAIL --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

        <div>

            <span class="text-xs text-unsriTeal font-extrabold uppercase tracking-widest">
                Admin Control Center
            </span>

            <h1 class="text-2xl md:text-3xl font-extrabold text-unsriNavy mt-1">
                Detail Pengaduan
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Periksa informasi laporan dan lakukan tindak lanjut.
            </p>

        </div>

        <div class="inline-flex items-center self-start md:self-center">

            <span class="rounded-full border px-4 py-2 text-xs font-extrabold {{ $badgeClass }}">
                {{ strtoupper($pengaduan->status) }}
            </span>

        </div>

    </div>


    {{-- PESAN SUKSES --}}
    @if(session('success'))

    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 text-sm">

        <i class="fa-solid fa-circle-check mr-2"></i>

        {{ session('success') }}

    </div>

    @endif


    {{-- VALIDASI ERROR --}}
    @if($errors->any())

    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl p-4">

        <div class="font-bold text-sm mb-2">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>
            Periksa kembali data yang dimasukkan.
        </div>

        <ul class="list-disc list-inside text-xs space-y-1">

            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach

        </ul>

    </div>

    @endif


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- DETAIL INFORMASI LAPORAN --}}
        <div class="lg:col-span-2 space-y-6">

            <div class="detail-panel p-5 md:p-7">

                {{-- NOMOR TIKET --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

                    <div>

                        <span class="detail-label">
                            Nomor Tiket
                        </span>

                        <h2 class="text-xl font-extrabold text-unsriNavy tracking-wide">
                            {{ $pengaduan->nomor_tiket }}
                        </h2>

                    </div>

                    <div class="bg-blue-50 text-blue-800 px-3 py-2 rounded-xl text-xs font-bold">

                        <i class="fa-solid fa-calendar-days mr-1"></i>

                        {{ $pengaduan->created_at->format('d M Y H:i') }}

                    </div>

                </div>


                <div class="border-t border-gray-100 pt-6">

                    <span class="detail-label">
                        Judul Pengaduan
                    </span>

                    <h2 class="text-2xl font-extrabold text-gray-800 leading-snug">
                        {{ $pengaduan->judul }}
                    </h2>

                    <p class="text-sm font-bold text-unsriTeal mt-2">
                        {{ $pengaduan->kategori }}
                    </p>

                </div>


                {{-- INFORMASI UTAMA --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-7">

                    <div class="detail-info">

                        <span class="detail-label">
                            Nama Pelapor
                        </span>

                        <div class="detail-value">

                            @if($pengaduan->is_anonim)

                            <i class="fa-solid fa-user-secret mr-1"></i>
                            Anonim

                            @else

                            <i class="fa-solid fa-user mr-1"></i>
                            {{ $pengaduan->user->name ?? 'Pengguna' }}

                            @endif

                        </div>

                    </div>


                    <div class="detail-info">

                        <span class="detail-label">
                            Tingkat Urgensi
                        </span>

                        <div class="detail-value">

                            <i class="fa-solid fa-bolt text-orange-500 mr-1"></i>

                            {{ $pengaduan->urgensi }}

                        </div>

                    </div>


                    <div class="detail-info sm:col-span-2">

                        <span class="detail-label">
                            Lokasi Kejadian
                        </span>

                        <div class="detail-value">

                            <i class="fa-solid fa-location-dot text-unsriTeal mr-1"></i>

                            {{ $pengaduan->lokasi }}

                        </div>

                    </div>

                </div>


                {{-- DESKRIPSI --}}
                <div class="mt-7">

                    <h3 class="detail-section-title mb-3">
                        <i class="fa-solid fa-align-left text-unsriTeal mr-2"></i>
                        Deskripsi Pengaduan
                    </h3>

                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">

                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>

                    </div>

                </div>


                {{-- BUKTI --}}
                <div class="mt-7">

                    <h3 class="detail-section-title mb-3">
                        <i class="fa-solid fa-paperclip text-unsriTeal mr-2"></i>
                        Bukti Foto / Dokumen
                    </h3>

                    @if($pengaduan->bukti)

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm">

                                <i class="fa-solid fa-file-arrow-down text-lg"></i>

                            </div>

                            <div>

                                <p class="text-sm font-bold text-gray-700">
                                    Bukti Pengaduan
                                </p>

                                <p class="text-xs text-gray-500">
                                    Lampiran laporan mahasiswa
                                </p>

                            </div>

                        </div>

                        <a
                            href="{{ asset('storage/' . $pengaduan->bukti) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex justify-center items-center gap-2 bg-unsriNavy hover:bg-blue-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold">

                            <i class="fa-solid fa-eye"></i>

                            Lihat Bukti

                        </a>

                    </div>

                    @else

                    <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-5 text-center">

                        <i class="fa-solid fa-file-circle-xmark text-2xl text-gray-300"></i>

                        <p class="text-sm text-gray-400 mt-2">
                            Tidak ada bukti yang dilampirkan.
                        </p>

                    </div>

                    @endif

                </div>


                {{-- ALASAN DITOLAK --}}
                @if($pengaduan->status === 'Ditolak' && $pengaduan->alasan_ditolak)

                <div class="mt-7 bg-rose-50 border border-rose-200 rounded-xl p-5">

                    <h3 class="text-sm font-extrabold text-rose-700">

                        <i class="fa-solid fa-circle-exclamation mr-2"></i>

                        Alasan Penolakan

                    </h3>

                    <p class="text-sm text-rose-700 mt-2 leading-relaxed">
                        {{ $pengaduan->alasan_ditolak }}
                    </p>

                </div>

                @endif

            </div>

        </div>


        {{-- PANEL PENGELOLAAN ADMIN --}}
        <div class="space-y-5">

            <div class="detail-panel p-5 md:p-6">

                <div class="mb-6">

                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-unsriNavy flex items-center justify-center mb-3">

                        <i class="fa-solid fa-sliders text-xl"></i>

                    </div>

                    <h2 class="text-lg font-extrabold text-unsriNavy">
                        Kelola Laporan
                    </h2>

                    <p class="text-xs text-gray-500 mt-1">
                        Perbarui perkembangan dan unit penanganan pengaduan.
                    </p>

                </div>


                <form
                    action="{{ route('admin.pengaduan.status', $pengaduan->id) }}"
                    method="POST"
                    id="formStatus">

                    @csrf
                    @method('PUT')


                    {{-- STATUS --}}
                    <div class="mb-5">

                        <label class="block text-xs font-extrabold text-gray-600 uppercase mb-2">
                            Status Pengaduan
                        </label>

                        <select
                            name="status"
                            id="statusPengaduan"
                            required
                            class="detail-input">

                            @foreach([
                            'Menunggu Verifikasi',
                            'Diterima',
                            'Sedang Diproses',
                            'Menunggu Informasi Tambahan',
                            'Selesai',
                            'Ditolak'
                            ] as $status)

                            <option
                                value="{{ $status }}"
                                @selected($currentStatus===$status)>

                                {{ $status }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- UNIT PENANGANAN --}}
                    <div class="mb-5">

                        <label class="block text-xs font-extrabold text-gray-600 uppercase mb-2">
                            Unit Penanganan
                        </label>

                        <input
                            type="text"
                            name="unit_terkait"
                            value="{{ old('unit_terkait', $pengaduan->unit_terkait) }}"
                            placeholder="Contoh: ICT Center UNSRI"
                            class="detail-input">

                    </div>


                    {{-- ALASAN DITOLAK --}}
                    <div
                        id="alasanDitolakContainer"
                        class="mb-5"
                        @if($currentStatus !=='Ditolak' ) hidden @endif>

                        <label class="block text-xs font-extrabold text-rose-600 uppercase mb-2">

                            <i class="fa-solid fa-circle-exclamation mr-1"></i>

                            Alasan Penolakan

                        </label>

                        <textarea
                            name="alasan_ditolak"
                            id="alasanDitolak"
                            rows="5"
                            placeholder="Tuliskan alasan mengapa laporan ditolak..."
                            class="detail-input border-rose-300 focus:border-rose-500"
                            {{ $currentStatus === 'Ditolak' ? 'required' : 'disabled' }}>{{ old('alasan_ditolak', $pengaduan->alasan_ditolak) }}</textarea>

                        <p class="text-xs text-gray-400 mt-2">
                            Alasan wajib diisi jika status laporan adalah Ditolak.
                        </p>

                    </div>


                    {{-- SIMPAN --}}
                    <button
                        type="submit"
                        class="w-full bg-unsriNavy hover:bg-blue-900 text-white font-extrabold py-3.5 px-4 rounded-xl text-sm transition shadow-md">

                        <i class="fa-solid fa-floppy-disk mr-2"></i>

                        Simpan Perubahan

                    </button>


                </form>

            </div>


            {{-- INFORMASI UNIT --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">

                <div class="flex items-start gap-3">

                    <i class="fa-solid fa-circle-info text-unsriTeal text-lg mt-1"></i>

                    <div>

                        <h3 class="text-sm font-extrabold text-unsriNavy">
                            Informasi Pengelolaan
                        </h3>

                        <p class="text-xs text-gray-600 leading-relaxed mt-2">
                            Setiap perubahan status akan tersimpan ke database dan dapat dilihat mahasiswa pada halaman riwayat pengaduan.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- JAVASCRIPT ALASAN PENOLAKAN --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const statusSelect = document.getElementById('statusPengaduan');

        const alasanContainer = document.getElementById('alasanDitolakContainer');

        const alasanTextarea = document.getElementById('alasanDitolak');


        function updateAlasanDitolak() {

            if (statusSelect.value === 'Ditolak') {

                alasanContainer.hidden = false;

                alasanTextarea.disabled = false;

                alasanTextarea.required = true;

            } else {

                alasanContainer.hidden = true;

                alasanTextarea.disabled = true;

                alasanTextarea.required = false;

                alasanTextarea.value = '';

            }

        }


        statusSelect.addEventListener('change', updateAlasanDitolak);

        updateAlasanDitolak();

    });
</script>

@endsection