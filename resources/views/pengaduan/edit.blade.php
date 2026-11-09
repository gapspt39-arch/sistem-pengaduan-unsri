@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <a href="{{ Auth::user()->role === 'admin'
            ? route('admin.dashboard')
            : route('mahasiswa.dashboard') }}"
            class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-unsriNavy btn-back-transition group transition">
            <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r shadow-sm text-rose-800">
        <div class="flex items-center mb-1">
            <i class="fa-solid fa-triangle-exclamation mr-2 text-rose-600"></i>
            <span class="font-semibold">
                Mohon perbaiki kesalahan berikut:
            </span>
        </div>

        <ul class="list-disc list-inside text-xs space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl p-6 border-t-4 border-unsriTeal border border-gray-100">

        <div class="mb-6">
            <h1 class="text-xl font-bold text-unsriNavy">
                <i class="fa-solid fa-pen-to-square mr-2 text-unsriTeal"></i>
                Edit Pengaduan
            </h1>

            <p class="text-xs text-gray-500 mt-1">
                Tiket:
                <strong>{{ $pengaduan->nomor_tiket }}</strong>
            </p>
        </div>

        <form
            action="{{ Auth::user()->role === 'admin'
                ? route('admin.pengaduan.update', $pengaduan->id)
                : route('pengaduan.update', $pengaduan->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-5">

            @csrf
            @method('PUT')

            <!-- JUDUL -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                    Judul Pengaduan
                    <span class="text-rose-500">*</span>
                </label>

                <input
                    type="text"
                    name="judul"
                    value="{{ old('judul', $pengaduan->judul) }}"
                    required
                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border">
            </div>

            <!-- KATEGORI -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                    Kategori
                    <span class="text-rose-500">*</span>
                </label>

                <select
                    name="kategori"
                    required
                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border">

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    <option value="Sarana dan Prasarana"
                        @selected(old('kategori', $pengaduan->kategori) == 'Sarana dan Prasarana')>
                        Sarana & Prasarana
                    </option>

                    <option value="Akademik"
                        @selected(old('kategori', $pengaduan->kategori) == 'Akademik')>
                        Akademik & Layanan Mahasiswa
                    </option>

                    <option value="Keuangan"
                        @selected(old('kategori', $pengaduan->kategori) == 'Keuangan')>
                        Keuangan & UKT
                    </option>

                    <option value="Kemahasiswaan"
                        @selected(old('kategori', $pengaduan->kategori) == 'Kemahasiswaan')>
                        Kemahasiswaan & Ormawa
                    </option>
                </select>
            </div>

            <!-- LOKASI -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                    Lokasi Kejadian
                    <span class="text-rose-500">*</span>
                </label>

                <input
                    type="text"
                    name="lokasi"
                    value="{{ old('lokasi', $pengaduan->lokasi) }}"
                    required
                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border">
            </div>

            <!-- DESKRIPSI -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                    Deskripsi Detail
                    <span class="text-rose-500">*</span>
                </label>

                <textarea
                    name="deskripsi"
                    rows="5"
                    required
                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border">{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
            </div>

            <!-- URGENSI -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                    Tingkat Urgensi
                </label>

                <select
                    name="urgensi"
                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border">

                    <option value="Rendah"
                        @selected(old('urgensi', $pengaduan->urgensi) == 'Rendah')>
                        Rendah
                    </option>

                    <option value="Sedang"
                        @selected(old('urgensi', $pengaduan->urgensi) == 'Sedang')>
                        Sedang
                    </option>

                    <option value="Tinggi"
                        @selected(old('urgensi', $pengaduan->urgensi) == 'Tinggi')>
                        Tinggi
                    </option>

                    <option value="Darurat"
                        @selected(old('urgensi', $pengaduan->urgensi) == 'Darurat')>
                        Darurat
                    </option>
                </select>
            </div>

            <!-- BUKTI -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                    Bukti Foto / Dokumen
                </label>

                @if($pengaduan->bukti)
                <div class="mb-2 p-3 bg-gray-50 rounded-lg border border-gray-200">

                    <p class="text-xs text-gray-600 mb-2">
                        Bukti saat ini:
                    </p>

                    <a
                        href="{{ asset('storage/' . $pengaduan->bukti) }}"
                        target="_blank"
                        class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 font-medium">

                        <i class="fa-solid fa-paperclip mr-1"></i>
                        Lihat Bukti Lama
                    </a>
                </div>
                @endif

                <input
                    type="file"
                    name="bukti"
                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-unsriTeal file:text-white">

                <p class="text-[10px] text-gray-400 mt-1">
                    Kosongkan jika tidak ingin mengganti bukti.
                    Maksimal 5MB.
                </p>
            </div>

            <!-- ANONIM -->
            <div class="flex items-center space-x-2">
                <input
                    type="checkbox"
                    name="is_anonim"
                    id="is_anonim"
                    value="1"
                    @checked(old('is_anonim', $pengaduan->is_anonim))
                class="rounded text-unsriTeal focus:ring-unsriTeal">

                <label
                    for="is_anonim"
                    class="text-xs text-gray-600 font-medium">
                    Kirim sebagai Anonim
                </label>
            </div>

            @if(Auth::user()->role === 'admin')

            <div class="border-t border-gray-200 pt-5 mt-5">

                <h2 class="font-bold text-unsriNavy mb-4">
                    Pengaturan Admin
                </h2>

                <!-- STATUS -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="w-full text-sm border-gray-300 rounded-lg p-2.5 border">

                        <option value="Menunggu Verifikasi"
                            @selected($pengaduan->status == 'Menunggu Verifikasi')>
                            Menunggu Verifikasi
                        </option>

                        <option value="Diterima"
                            @selected($pengaduan->status == 'Diterima')>
                            Diterima
                        </option>

                        <option value="Sedang Diproses"
                            @selected($pengaduan->status == 'Sedang Diproses')>
                            Sedang Diproses
                        </option>

                        <option value="Menunggu Informasi Tambahan"
                            @selected($pengaduan->status == 'Menunggu Informasi Tambahan')>
                            Menunggu Informasi Tambahan
                        </option>

                        <option value="Selesai"
                            @selected($pengaduan->status == 'Selesai')>
                            Selesai
                        </option>

                        <option value="Ditolak"
                            @selected($pengaduan->status == 'Ditolak')>
                            Ditolak
                        </option>
                    </select>
                </div>

                <!-- UNIT -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                        Unit Penanganan
                    </label>

                    <input
                        type="text"
                        name="unit_terkait"
                        value="{{ old('unit_terkait', $pengaduan->unit_terkait) }}"
                        placeholder="Contoh: ICT Center / Perlengkapan"
                        class="w-full text-sm border-gray-300 rounded-lg p-2.5 border">
                </div>

                <!-- ALASAN DITOLAK -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                        Alasan Penolakan
                    </label>

                    <textarea
                        name="alasan_ditolak"
                        rows="3"
                        placeholder="Isi jika pengaduan ditolak..."
                        class="w-full text-sm border-gray-300 rounded-lg p-2.5 border">{{ old('alasan_ditolak', $pengaduan->alasan_ditolak) }}</textarea>
                </div>

            </div>

            @endif

            <!-- BUTTON -->
            <div class="flex gap-3 pt-4">

                <a
                    href="{{ Auth::user()->role === 'admin'
                        ? route('admin.dashboard')
                        : route('mahasiswa.dashboard') }}"
                    class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2.5 px-4 rounded-lg text-sm">

                    Batal
                </a>

                <button
                    type="submit"
                    class="flex-1 bg-unsriNavy hover:bg-blue-900 text-white font-medium py-2.5 px-4 rounded-lg text-sm shadow">

                    <i class="fa-solid fa-floppy-disk mr-1"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>
</div>
@endsection