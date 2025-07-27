<?php

namespace App\Http\Controllers;

use App\Exports\RiwayatExport;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class PeminjamanController extends Controller
{
    public function tampil9(Request $request)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->whereHas('anggota', function ($sub) use ($search) {
                        $sub->where('namalengkap', 'like', '%' . $search . '%');
                    })->orWhereHas('buku', function ($sub) use ($search) {
                        $sub->where('judul_buku', 'like', '%' . $search . '%');
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('peminjaman.tampil9', compact('peminjaman'));
    }



    public function tambah9()
    {
        $anggota = Anggota::all();
        $buku = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.tambah9', compact('anggota', 'buku'));
    }

    public function submit8(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|array|min:1|max:2',
            'buku_id.*' => 'exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        $anggota_id = $request->anggota_id;

        $jumlahDipinjam = Peminjaman::where('anggota_id', $anggota_id)
            ->where('status', 'dipinjam')
            ->count();

        $jumlahAkanDipinjam = count($request->buku_id);
        if ($jumlahDipinjam + $jumlahAkanDipinjam > 2) {
            return redirect()->back()->withErrors([
                'buku_id' => 'Total buku yang dipinjam melebihi batas maksimal 2 buku per anggota.'
            ])->withInput();
        }

        DB::beginTransaction();
        try {
            foreach ($request->buku_id as $bukuId) {
                $buku = Buku::findOrFail($bukuId);

                if ($request->status === 'dipinjam' && $buku->stok <= 0) {
                    DB::rollback();
                    return redirect()->back()->withErrors([
                        'buku_id' => 'Stok buku "' . $buku->judul_buku . '" tidak cukup untuk dipinjam.'
                    ])->withInput();
                }

                Peminjaman::create([
                    'anggota_id' => $anggota_id,
                    'buku_id' => $bukuId,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => $request->status,
                ]);

                if ($request->status === 'dipinjam') {
                    $buku->decrement('stok');
                }
            }

            DB::commit();
            return redirect()->route('peminjaman.tampil9')->with('success', 'Peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors([
                'error' => 'Gagal menambahkan peminjaman: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function edit8($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $anggota = Anggota::all();
        $buku = Buku::where('stok', '>', 0)->get();
        $selectedBukuIds = [$peminjaman->buku_id];

        return view('peminjaman.edit8', compact('peminjaman', 'anggota', 'buku', 'selectedBukuIds'));
    }

    public function update8(Request $request, $id)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|array|min:1|max:2',
            'buku_id.*' => 'exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        $peminjamanLama = Peminjaman::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($peminjamanLama->status === 'dipinjam') {
                Buku::find($peminjamanLama->buku_id)?->increment('stok');
            }

            $peminjamanLama->delete();

            foreach ($request->buku_id as $bukuId) {
                $buku = Buku::findOrFail($bukuId);

                if ($request->status === 'dipinjam' && $buku->stok <= 0) {
                    DB::rollback();
                    return back()->withErrors(['buku_id' => 'Stok buku "' . $buku->judul_buku . '" tidak cukup'])->withInput();
                }

                Peminjaman::create([
                    'anggota_id' => $request->anggota_id,
                    'buku_id' => $bukuId,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => $request->status,
                ]);

                if ($request->status === 'dipinjam') {
                    $buku->decrement('stok');
                }
            }

            DB::commit();
            return redirect()->route('peminjaman.tampil9')->with('success', 'Peminjaman berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal update: ' . $e->getMessage()])->withInput();
        }
    }

    public function delete8($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $buku = Buku::findOrFail($peminjaman->buku_id);

        DB::beginTransaction();
        try {
            if ($peminjaman->status === 'dipinjam') {
                $buku->increment('stok');
            }

            $peminjaman->delete();

            DB::commit();
            return redirect()->route('peminjaman.tampil9')->with('success', 'Peminjaman berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors([
                'error' => 'Gagal menghapus peminjaman: ' . $e->getMessage()
            ]);
        }
    }

    public function riwayat()
    {
        $riwayat = Peminjaman::with(['anggota', 'buku', 'pengembalian'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('peminjaman.riwayat', compact('riwayat'));
    }

    public function simpanUser(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'buku_id' => 'required|array|min:1|max:2',
            'buku_id.*' => 'nullable|exists:buku,id',
        ]);

        $user = Auth::user();
        $anggota = Anggota::where('nis', $user->email)->first();

        if (!$anggota) {
            return redirect()->route('user_dashboard.index')->with('error', 'Anda belum terdaftar sebagai anggota.');
        }

        $bukuIds = array_filter($request->buku_id);

        foreach ($bukuIds as $bukuId) {
            $buku = Buku::find($bukuId);

            if (!$buku || $buku->stok < 1) {
                return redirect()->back()->with('error', "Stok buku '{$buku->judul_buku}' habis atau buku tidak ditemukan.");
            }

            Peminjaman::create([
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuId,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'dipinjam',
            ]);

            $buku->decrement('stok');
        }

        return redirect()->route('user_dashboard.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }
    public function export(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $tanggal_awal = \Carbon\Carbon::create($tahun, $bulan, 1)->startOfMonth()->toDateString();
        $tanggal_akhir = \Carbon\Carbon::create($tahun, $bulan, 1)->endOfMonth()->toDateString();

        return Excel::download(new RiwayatExport($tanggal_awal, $tanggal_akhir), "riwayat_{$bulan}_{$tahun}.xlsx");
    }
}
