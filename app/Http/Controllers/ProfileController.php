<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user dan riwayat peminjaman
     */
    public function index()
    {
        // Ambil data anggota berdasarkan email user (diasumsikan NIS == email)
        $anggota = Anggota::where('nis', Auth::user()->email)->first();

        // Jika belum menjadi anggota, arahkan ke form pendaftaran
        if (!$anggota) {
            return redirect()->route('anggota.formulir')
                ->with('warning', 'Silakan lengkapi data anggota terlebih dahulu.');
        }

        // Ambil data peminjaman dengan relasi buku dan pengembalian
        $riwayat_peminjaman = Peminjaman::with(['buku', 'pengembalian'])
            ->where('anggota_id', $anggota->id)
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view('user_dashboard.tabs.profil', compact('anggota', 'riwayat_peminjaman'));
    }

    /**
     * Menghandle proses reset password
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        // Validasi input password
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Pastikan password lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withInput()->with('error', 'Password lama tidak sesuai.');
        }

        // Pastikan objek user adalah model Eloquent (punya method save)
        if (!method_exists($user, 'save')) {
            return back()->with('error', 'Gagal menyimpan password. User model tidak valid.');
        }

        // Simpan password baru
        $user->password = Hash::make($request->new_password);
        
        return back()->with('success', 'Password berhasil diubah.');
    }
}

        $user->save();