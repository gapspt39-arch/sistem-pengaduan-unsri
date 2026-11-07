<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    // ==================================================
    // DASHBOARD MAHASISWA
    // ==================================================

    public function indexMahasiswa(Request $request)
    {
        $query = Pengaduan::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('nomor_tiket', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('mahasiswa.dashboard', compact('pengaduans'));
    }


    // ==================================================
    // DASHBOARD ADMIN
    // ==================================================

    public function indexAdmin(Request $request)
    {
        $total = Pengaduan::count();

        $baru = Pengaduan::where(
            'status',
            'Menunggu Verifikasi'
        )->count();

        $proses = Pengaduan::where(
            'status',
            'Sedang Diproses'
        )->count();

        $selesai = Pengaduan::where(
            'status',
            'Selesai'
        )->count();

        $query = Pengaduan::with('user');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('nomor_tiket', 'like', '%' . $search . '%');
            });
        }

        $pengaduans = $query
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view(
            'admin.dashboard',
            compact(
                'pengaduans',
                'total',
                'baru',
                'proses',
                'selesai'
            )
        );
    }


    // ==================================================
    // DETAIL LAPORAN ADMIN
    // ==================================================

    public function showAdmin($id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id);

        return view('admin.detail', compact('pengaduan'));
    }


    // ==================================================
    // SIMPAN PENGADUAN BARU
    // ==================================================

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'lokasi' => 'required|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,mp4,pdf|max:5120',
            'urgensi' => 'required|string',
        ]);

        $path = null;

        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store(
                'bukti_pengaduan',
                'public'
            );
        }

        Pengaduan::create([
            'nomor_tiket' => 'UNSRI-' . strtoupper(Str::random(6)),
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'lokasi' => $request->lokasi,
            'bukti' => $path,
            'urgensi' => $request->urgensi,
            'is_anonim' => $request->has('is_anonim'),
            'status' => 'Menunggu Verifikasi',
            'alasan_ditolak' => null,
        ]);

        return redirect()->back()->with(
            'success',
            'Laporan pengaduan berhasil dikirim dengan nomor tiket!'
        );
    }


    // ==================================================
    // EDIT PENGADUAN MAHASISWA
    // ==================================================

    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if (
            Auth::user()->role !== 'mahasiswa' ||
            (int) $pengaduan->user_id !== (int) Auth::id()
        ) {
            abort(403, 'Anda tidak memiliki akses ke pengaduan ini.');
        }

        return view(
            'pengaduan.edit',
            compact('pengaduan')
        );
    }


    // ==================================================
    // UPDATE PENGADUAN MAHASISWA
    // ==================================================

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if (
            Auth::user()->role !== 'mahasiswa' ||
            (int) $pengaduan->user_id !== (int) Auth::id()
        ) {
            abort(403, 'Anda tidak memiliki akses ke pengaduan ini.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'lokasi' => 'required|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,mp4,pdf|max:5120',
            'urgensi' => 'required|string',
        ]);

        $pengaduan->judul = $request->judul;
        $pengaduan->deskripsi = $request->deskripsi;
        $pengaduan->kategori = $request->kategori;
        $pengaduan->lokasi = $request->lokasi;
        $pengaduan->urgensi = $request->urgensi;
        $pengaduan->is_anonim = $request->has('is_anonim');

        if ($request->hasFile('bukti')) {

            if (
                $pengaduan->bukti &&
                Storage::disk('public')->exists($pengaduan->bukti)
            ) {
                Storage::disk('public')->delete($pengaduan->bukti);
            }

            $pengaduan->bukti = $request
                ->file('bukti')
                ->store('bukti_pengaduan', 'public');
        }

        $pengaduan->save();

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }


    // ==================================================
    // HAPUS PENGADUAN MAHASISWA
    // ==================================================

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if (
            Auth::user()->role !== 'mahasiswa' ||
            (int) $pengaduan->user_id !== (int) Auth::id()
        ) {
            abort(403, 'Anda tidak memiliki akses ke pengaduan ini.');
        }

        if (
            $pengaduan->bukti &&
            Storage::disk('public')->exists($pengaduan->bukti)
        ) {
            Storage::disk('public')->delete($pengaduan->bukti);
        }

        $pengaduan->delete();

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }


    // ==================================================
    // UPDATE STATUS OLEH ADMIN
    // ==================================================

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Verifikasi,Diterima,Sedang Diproses,Menunggu Informasi Tambahan,Selesai,Ditolak',
            'alasan_ditolak' => 'required_if:status,Ditolak|nullable|string|max:1000',
            'unit_terkait' => 'nullable|string|max:255',
        ], [
            'alasan_ditolak.required_if' =>
            'Alasan wajib diisi ketika laporan ditolak.',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->status = $request->status;

        if ($request->status === 'Ditolak') {
            $pengaduan->alasan_ditolak = $request->alasan_ditolak;
        } else {
            $pengaduan->alasan_ditolak = null;
        }

        $pengaduan->unit_terkait = $request->unit_terkait;

        $pengaduan->save();

        return redirect()
            ->back()
            ->with(
                'success',
                'Status pengaduan ' .
                    $pengaduan->nomor_tiket .
                    ' berhasil diperbarui.'
            );
    }
}
