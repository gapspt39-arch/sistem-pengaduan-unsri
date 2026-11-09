@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-sm text-emerald-800 flex items-center">
        <i class="fa-solid fa-circle-check mr-2 text-emerald-600"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r shadow-sm text-rose-800">
        <div class="flex items-center mb-1">
            <i class="fa-solid fa-triangle-exclamation mr-2 text-rose-600"></i>
            <span class="font-semibold">Mohon perbaiki kesalahan berikut:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- KOLOM KIRI: FORM PENGADUAN BARU -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border-t-4 border-unsriTeal border-x border-b border-gray-100 h-fit">
            <h2 class="text-lg font-bold text-unsriNavy mb-4 flex items-center">
                <i class="fa-solid fa-pen-to-square mr-2 text-unsriTeal"></i> Buat Pengaduan Baru
            </h2>
            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Judul Pengaduan <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border" placeholder="Contoh: AC Rusak di Ruang Kuliah Fasilkom">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori <span class="text-rose-500">*</span></label>
                    <select name="kategori" required class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Sarana dan Prasarana" @selected(old('kategori')=='Sarana dan Prasarana' )>Sarana & Prasarana</option>
                        <option value="Akademik" @selected(old('kategori')=='Akademik' )>Akademik & Layanan Mahasiswa</option>
                        <option value="Keuangan" @selected(old('kategori')=='Keuangan' )>Keuangan & UKT</option>
                        <option value="Kemahasiswaan" @selected(old('kategori')=='Kemahasiswaan' )>Kemahasiswaan & Ormawa</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Lokasi Kejadian <span class="text-rose-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border" placeholder="Gedung / Ruangan / Fakultas">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Deskripsi Detail <span class="text-rose-500">*</span></label>
                    <textarea name="deskripsi" rows="3" required class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border" placeholder="Jelaskan kronologi atau detail masalah...">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tingkat Urgensi</label>
                    <select name="urgensi" class="w-full text-sm border-gray-300 rounded-lg focus:ring-unsriTeal focus:border-unsriTeal p-2.5 border">
                        <option value="Rendah" @selected(old('urgensi')=='Rendah' )>Rendah</option>
                        <option value="Sedang" @selected(old('urgensi', 'Sedang' )=='Sedang' )>Sedang</option>
                        <option value="Tinggi" @selected(old('urgensi')=='Tinggi' )>Tinggi</option>
                        <option value="Darurat" @selected(old('urgensi')=='Darurat' )>Darurat</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Bukti Foto / Dokumen (Opsional)</label>
                    <input type="file" name="bukti" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-unsriTeal file:text-white hover:file:bg-teal-700">
                    <p class="text-[10px] text-gray-400 mt-1">Maksimal 5MB (Format: JPG, PNG, PDF, MP4)</p>
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" name="is_anonim" id="is_anonim" value="1" @checked(old('is_anonim')) class="rounded text-unsriTeal focus:ring-unsriTeal">
                    <label for="is_anonim" class="text-xs text-gray-600 font-medium">Kirim sebagai Anonim (Nama dirahasiakan)</label>
                </div>

                <button type="submit" class="w-full bg-unsriNavy hover:bg-blue-900 text-white font-medium py-2.5 px-4 rounded-lg text-sm transition shadow flex items-center justify-center space-x-1">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Kirim Laporan</span>
                </button>
            </form>
        </div>

        <!-- KOLOM KANAN: RIWAYAT & TRACKING -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <h2 class="text-lg font-bold text-unsriNavy flex items-center">
                        <i class="fa-solid fa-clock-rotate-left mr-2 text-unsriTeal"></i> Riwayat & Tracking Pengaduan
                    </h2>

                    <!-- Search & Filter -->
                    <form method="GET" action="{{ route('mahasiswa.dashboard') }}" class="flex items-center space-x-2 w-full sm:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tiket/judul..."
                            class="text-xs border border-gray-300 rounded-lg px-3 py-2 w-full sm:w-48 focus:ring-unsriTeal">
                        <button type="submit" class="bg-unsriTeal text-white px-3 py-2 rounded-lg text-xs hover:bg-teal-700 transition">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('mahasiswa.dashboard') }}" class="bg-gray-200 text-gray-600 px-2 py-2 rounded-lg text-xs hover:bg-gray-300 transition">
                            Reset
                        </a>
                        @endif
                    </form>
                </div>

                <div class="space-y-4">
                    @forelse($pengaduans as $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 hover:border-unsriTeal transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="text-xs font-bold bg-blue-100 text-unsriNavy px-2.5 py-1 rounded-md">{{ $item->nomor_tiket }}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $item->created_at->format('d M Y H:i') }}</span>
                                @if($item->is_anonim)
                                <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full ml-1">Anonim</span>
                                @endif
                            </div>
                            <span class="text-xs px-2.5 py-1 rounded-full font-semibold
                                    @if($item->status == 'Selesai') bg-emerald-100 text-emerald-800
                                    @elseif($item->status == 'Ditolak') bg-rose-100 text-rose-800
                                    @elseif($item->status == 'Sedang Diproses') bg-amber-100 text-amber-800
                                    @else bg-blue-100 text-unsriNavy @endif">
                                {{ $item->status }}
                            </span>
                        </div>

                        <h3 class="font-bold text-gray-800 text-base mb-1">{{ $item->judul }}</h3>
                        <p class="text-xs text-gray-600 mb-2">
                            <i class="fa-solid fa-location-dot text-unsriTeal mr-1"></i> {{ $item->lokasi }} | Kategori: <strong>{{ $item->kategori }}</strong> | Urgensi: <span class="font-semibold">{{ $item->urgensi }}</span>
                        </p>
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-md mb-2 border border-gray-100">{{ $item->deskripsi }}</p>

                        @if($item->bukti)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank"
                                class="inline-flex items-center space-x-1 text-xs text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fa-solid fa-paperclip"></i>
                                <span>Lihat Bukti Lampiran</span>
                            </a>
                        </div>
                        @endif

                        @if($item->unit_terkait)
                        <p class="text-xs text-gray-600 mb-1">
                            <i class="fa-solid fa-building-user text-unsriTeal mr-1"></i> <strong>Unit Penanganan:</strong> {{ $item->unit_terkait }}
                        </p>
                        @endif

                        @if($item->status == 'Ditolak' && $item->alasan_ditolak)
                        <div class="bg-rose-50 text-rose-700 text-xs p-2.5 rounded border border-rose-200 mt-2">
                            <strong>Alasan Ditolak:</strong> {{ $item->alasan_ditolak }}
                        </div>
                        @endif
                        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">

                            {{-- EDIT --}}
                            <a
                                href="{{ route('pengaduan.edit', $item->id) }}"
                                class="inline-flex items-center bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium px-3 py-2 rounded-lg transition">

                                <i class="fa-solid fa-pen-to-square mr-1"></i>
                                Edit
                            </a>

                            {{-- HAPUS --}}
                            <form
                                action="{{ route('pengaduan.destroy', $item->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus pengaduan ini? Data yang dihapus tidak dapat dikembalikan.')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex items-center bg-rose-500 hover:bg-rose-600 text-white text-xs font-medium px-3 py-2 rounded-lg transition">

                                    <i class="fa-solid fa-trash mr-1"></i>
                                    Hapus
                                </button>

                            </form>

                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-400 text-sm">
                        <i class="fa-regular fa-folder-open text-3xl mb-2"></i>
                        <p>Belum ada laporan pengaduan yang dibuat.</p>
                    </div>
                    @endforelse

                    <div class="mt-4">
                        {{ $pengaduans->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection