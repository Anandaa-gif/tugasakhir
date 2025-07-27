<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Menampilkan halaman profil admin.
     */
    public function index()
    {
        $admin = Auth::user(); // diasumsikan sudah login

        // Validasi role (jika perlu)
        if ($admin->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('admin_dashboard.profil', compact('admin'));
    }

    /**
     * Mengubah password admin.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $oldEmail = $user->email;

        // Simpan email baru
        $user->email = $request->email;
        $user->save();

        // Sinkronkan ke tabel anggota (nis = email)
        $anggota = \App\Models\Anggota::where('nis', $oldEmail)->first();
        if ($anggota) {
            $anggota->nis = $request->email;
            $anggota->save();
        }

        return back()->with('success_email', 'Email / NIS berhasil diubah.');
    }
}
