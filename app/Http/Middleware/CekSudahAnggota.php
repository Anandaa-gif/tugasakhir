<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;

class CekSudahAnggota
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Cek apakah user login dan apakah sudah terdaftar sebagai anggota (berdasarkan nis)
        $anggota = Anggota::where('nis', $user->email)->first();

        if (!$user || !$anggota) {
            return redirect()->route('user_dashboard.index')
                ->with('error', 'Anda harus mendaftar sebagai anggota terlebih dahulu.');
        }

        return $next($request);
    }
}

