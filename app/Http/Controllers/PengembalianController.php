<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengembalianController extends Controller
{
    public function tampil8(Request $request)
    {
        $pengembalian = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->whereHas('peminjaman.anggota', function ($sub) use ($search) {
                        $sub->where('namalengkap', 'like', '%' . $search . '%');
                    })->orWhereHas('peminjaman.buku', function ($sub) use ($search) {
                        $sub->where('judul_buku', 'like', '%' . $search . '%');
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pengembalian.tampil8', compact('pengembalian'));
    }



    public function tambah8()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'dipinjam')
            ->get();

        return view('pengembalian.tambah8', compact('peminjaman'));
    }

    public function edit7($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])->findOrFail($id);
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'dipinjam')
            ->orWhere('id', $pengembalian->peminjaman_id)
            ->get();

        return view('pengembalian.edit7', compact('pengembalian', 'peminjaman'));
    }

    public function submit7(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'nama' => 'required|string|max:255',
            'tanggal_harus_kembali' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'keterlambatan' => 'required|in:Telat,Tepat Waktu',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($request->peminjaman_id);

        if (Pengembalian::where('peminjaman_id', $peminjaman->id)->exists()) {
            return back()->withErrors(['peminjaman_id' => 'Peminjaman ini sudah dikembalikan.'])->withInput();
        }

        $tanggal_kembali = Carbon::parse($request->tanggal_kembali);
        $tanggal_harus_kembali = Carbon::parse($request->tanggal_harus_kembali);
        $tanggal_batas_kembali = $tanggal_harus_kembali->copy()->addDay();

        if ($tanggal_kembali->lt(Carbon::parse($peminjaman->tanggal_pinjam))) {
            return back()->withErrors(['tanggal_kembali' => 'Tanggal kembali tidak boleh sebelum tanggal pinjam.'])->withInput();
        }

        if ($request->nama !== ($peminjaman->anggota->namalengkap ?? '-')) {
            return back()->withErrors(['nama' => 'Nama tidak sesuai dengan data peminjaman.'])->withInput();
        }

        if ($tanggal_harus_kembali->toDateString() !== Carbon::parse($peminjaman->tanggal_kembali)->toDateString()) {
            return back()->withErrors(['tanggal_harus_kembali' => 'Tanggal harus kembali tidak sesuai dengan data peminjaman.'])->withInput();
        }

        $jumlah_hari_telat = $tanggal_kembali->gt($tanggal_batas_kembali)
            ? $tanggal_kembali->diffInDays($tanggal_batas_kembali)
            : 0;
        $denda = min($jumlah_hari_telat * 1000, 16000);

        DB::beginTransaction();
        try {
            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'anggota_id' => $peminjaman->anggota_id,
                'buku_id' => $peminjaman->buku_id,
                'tanggal_kembali' => $tanggal_kembali->toDateString(),
                'keterlambatan' => $request->keterlambatan,
                'keterangan' => $request->keterangan ?? '',
                'jumlah_denda' => $denda,
            ]);

            $peminjaman->update(['status' => 'dikembalikan']);
            Buku::findOrFail($peminjaman->buku_id)->increment('stok');

           
            DB::commit();
            return redirect()->route('pengembalian.tampil8')->with('success', 'Pengembalian berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menambahkan pengembalian: ' . $e->getMessage()])->withInput();
        }
    }

    public function update7(Request $request, $id)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'nama' => 'required|string|max:255',
            'tanggal_harus_kembali' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'keterlambatan' => 'required|in:Telat,Tepat Waktu',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($request->peminjaman_id);

        $tanggal_kembali = Carbon::parse($request->tanggal_kembali);
        $tanggal_harus_kembali = Carbon::parse($request->tanggal_harus_kembali);
        $tanggal_batas_kembali = $tanggal_harus_kembali->copy()->addDay();

        if ($tanggal_kembali->lt(Carbon::parse($peminjaman->tanggal_pinjam))) {
            return back()->withErrors(['tanggal_kembali' => 'Tanggal kembali tidak boleh sebelum tanggal pinjam.'])->withInput();
        }

        if ($request->nama !== ($peminjaman->anggota->namalengkap ?? '-')) {
            return back()->withErrors(['nama' => 'Nama tidak sesuai dengan data peminjaman.'])->withInput();
        }

        if ($tanggal_harus_kembali->toDateString() !== Carbon::parse($peminjaman->tanggal_kembali)->toDateString()) {
            return back()->withErrors(['tanggal_harus_kembali' => 'Tanggal harus kembali tidak sesuai dengan data peminjaman.'])->withInput();
        }

        $jumlah_hari_telat = $tanggal_kembali->gt($tanggal_batas_kembali)
            ? $tanggal_kembali->diffInDays($tanggal_batas_kembali)
            : 0;
        $denda = min($jumlah_hari_telat * 1000, 16000);

        DB::beginTransaction();
        try {
            $pengembalian->update([
                'peminjaman_id' => $peminjaman->id,
                'anggota_id' => $peminjaman->anggota_id,
                'buku_id' => $peminjaman->buku_id,
                'tanggal_kembali' => $tanggal_kembali->toDateString(),
                'keterlambatan' => $request->keterlambatan,
                'keterangan' => $request->keterangan ?? '',
                'jumlah_denda' => $denda,
            ]);

            $peminjaman->update(['status' => 'dikembalikan']);

            if ($pengembalian->buku_id != $peminjaman->buku_id) {
                Buku::findOrFail($pengembalian->buku_id)->increment('stok');
                Buku::findOrFail($peminjaman->buku_id)->increment('stok');
            }

            DB::commit();
            return redirect()->route('pengembalian.tampil8')->with('success', 'Data pengembalian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal memperbarui pengembalian: ' . $e->getMessage()])->withInput();
        }
    }

    public function delete7($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $peminjaman = Peminjaman::findOrFail($pengembalian->peminjaman_id);
        $buku = Buku::findOrFail($pengembalian->buku_id);

        DB::beginTransaction();
        try {
            $peminjaman->update([
                'status' => 'dipinjam',
                // Tidak perlu set ulang tanggal_kembali!
            ]);

            if ($buku->stok > 0) {
                $buku->decrement('stok');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Stok buku tidak mencukupi.']);
            }

            $pengembalian->delete();
            DB::commit();
            return redirect()->route('pengembalian.tampil8')->with('success', 'Data pengembalian berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal menghapus pengembalian: ' . $e->getMessage()]);
        }
    }


}
