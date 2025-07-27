<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahTamu = Pengunjung::count();
        $jumlahAnggota = Anggota::count();
        $jumlahBuku = Buku::count();
        $jumlahPeminjaman = Peminjaman::whereNull('tanggal_kembali')->count();
        $jumlahPengembalian = Pengembalian::count();

        $labels = [];
        $values = [];

        for ($i = 29; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $labels[] = $tanggal->format('d M');
            $values[] = Pengunjung::whereDate('created_at', $tanggal)->count();
        }
        return view('dashboard.index', compact(
            'jumlahTamu',
            'jumlahAnggota',
            'jumlahBuku',
            'jumlahPeminjaman',
            'jumlahPengembalian',
            'labels',
            'values'
        ));
    }
}
