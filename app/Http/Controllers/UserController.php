<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $anggota = Anggota::where('nis', $user->email)->first();
        $bukus = Buku::latest()->get();
        $peminjamans = $anggota
            ? Peminjaman::with(['buku', 'anggota'])
            ->where('anggota_id', $anggota->id)
            ->whereDoesntHave('pengembalian')
            ->orderByDesc('tanggal_pinjam')
            ->get()
            : collect();

        $pengembalians = $anggota
            ? Pengembalian::with(['peminjaman.buku', 'peminjaman.anggota'])
            ->whereHas('peminjaman', function ($query) use ($anggota) {
                $query->where('anggota_id', $anggota->id);
            })
            ->orderByDesc('tanggal_kembali')
            ->get()
            : collect();
        $riwayat_peminjaman = $anggota
            ? Peminjaman::with(['buku', 'pengembalian'])
            ->where('anggota_id', $anggota->id)
            ->whereHas('pengembalian')
            ->orderByDesc('tanggal_pinjam')
            ->get()
            : collect();

        return view('user_dashboard.index', compact(
            'bukus',
            'peminjamans',
            'pengembalians',
            'riwayat_peminjaman',
            'anggota'
        ));
    }


    public function simpanPeminjaman(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|array|min:1|max:2',
            'buku_id.*' => 'required|distinct|exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $user = Auth::user();
        $anggota = Anggota::where('nis', $user->email)->first();

        if (!$anggota) {
            return redirect()->route('user_dashboard.index')->with('error', 'Anda belum terdaftar sebagai anggota.');
        }

        $buku_ids = array_filter($request->buku_id);

        // Hitung jumlah buku yang sedang dipinjam oleh anggota (status = dipinjam)
        $dipinjamSekarang = Peminjaman::where('anggota_id', $anggota->id)
            ->where('status', 'dipinjam')
            ->count();

        if ($dipinjamSekarang + count($buku_ids) > 2) {
            return redirect()->route('user_dashboard.index', '#peminjaman')
                ->with('error', 'Anda hanya boleh meminjam maksimal 2 buku dalam satu waktu.');
        }

        // Validasi stok dulu untuk semua buku
        foreach ($buku_ids as $id_buku) {
            $buku = Buku::find($id_buku);
            if (!$buku || $buku->stok < 1) {
                return redirect()->route('user_dashboard.index', '#peminjaman')
                    ->with('error', "Stok buku '{$buku->judul_buku}' tidak mencukupi.");
            }
        }

        DB::beginTransaction();
        try {
            foreach ($buku_ids as $id_buku) {
                Peminjaman::create([
                    'anggota_id' => $anggota->id,
                    'buku_id' => $id_buku,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => 'dipinjam', // status wajib
                ]);

                Buku::find($id_buku)->decrement('stok');
            }

            DB::commit();
            return redirect(route('user_dashboard.index') . '#peminjaman')
                ->with('success', 'Peminjaman berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user_dashboard.index', '#peminjaman')
                ->with('error', 'Gagal menyimpan peminjaman: ' . $e->getMessage());
        }
    }
}
