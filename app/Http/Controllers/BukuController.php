<?php

namespace App\Http\Controllers;

use App\Imports\BukuImport;
use App\Models\Buku;
use App\Models\Jenis;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class BukuController extends Controller
{
    public function tampil5(Request $request)
    {
        $query = Buku::with(['penerbit', 'jenis', 'kategori']);

        if ($request->filled('search')) {
            $query->where('judul_buku', 'like', '%' . $request->search . '%')
                ->orWhere('kode_buku', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $kategoriList = Kategori::orderBy('name')->get();

        $buku = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('buku.tampil5', compact('buku', 'kategoriList'));
    }






    public function tambah5()
    {
        $penerbit = Penerbit::all();
        $jenis = Jenis::all();
        $kategori = Kategori::all();

        return view('buku.tambah5', compact('penerbit', 'jenis', 'kategori'));
    }

    public function submit4(Request $request)
    {
        $request->validate([
            'kode_buku'    => 'required|unique:buku,kode_buku',
            'judul_buku'   => 'required',
            'isbn'         => 'required',
            'penulis'      => 'required',
            'tahun_terbit' => 'required',
            'penerbit_id'  => 'required|exists:penerbit,id',
            'jenis_id'     => 'required|exists:jenis,id',
            'kategori_id'  => 'required|exists:kategori,id',
            'stok'         => 'required|integer|min:0',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $buku = new Buku($request->except('foto'));

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $path = $foto->store('foto_buku', 'public');
            $buku->foto = $path;
        }

        $buku->save();

        return redirect()->route('buku.tampil5')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit4($id)
    {
        $buku = Buku::findOrFail($id);
        $penerbit = Penerbit::all();
        $jenis = Jenis::all();
        $kategori = Kategori::all();

        return view('buku.edit4', compact('buku', 'penerbit', 'jenis', 'kategori'));
    }

    public function update4(Request $request, $id)
    {
        $request->validate([
            'kode_buku'    => 'required|unique:buku,kode_buku,' . $id,
            'judul_buku'   => 'required',
            'isbn'         => 'required',
            'penulis'      => 'required',
            'tahun_terbit' => 'required',
            'penerbit_id'  => 'required|exists:penerbit,id',
            'jenis_id'     => 'required|exists:jenis,id',
            'kategori_id'  => 'required|exists:kategori,id',
            'stok'         => 'required|integer|min:0',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->fill($request->except('foto'));

        if ($request->hasFile('foto')) {
            if ($buku->foto && Storage::disk('public')->exists($buku->foto)) {
                Storage::disk('public')->delete($buku->foto);
            }

            $path = $request->file('foto')->store('foto_buku', 'public');
            $buku->foto = $path;
        }

        $buku->save();

        return redirect()->route('buku.tampil5')->with('success', 'Buku berhasil diperbarui.');
    }

    public function delete4($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->foto && Storage::disk('public')->exists($buku->foto)) {
            Storage::disk('public')->delete($buku->foto);
        }

        $buku->delete();

        return redirect()->route('buku.tampil5')->with('success', 'Buku berhasil dihapus.');
    }

    public function printqr($id)
    {
        $buku = Buku::with(['penerbit', 'jenis', 'kategori'])->findOrFail($id);
        $url = route('buku.detail', $buku->id); // QR code mengarah ke halaman detail
        $qrCode = QrCode::size(200)->generate($url);

        return view('buku.qr_code', compact('buku', 'qrCode'));
    }

    public function showDetail($id)
    {
        $buku = Buku::with([
            'penerbit',
            'jenis',
            'kategori',
            'peminjaman.anggota' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        $peminjamanAktif = $buku->peminjaman()
            ->where('status', 'dipinjam')
            ->first();

        $riwayatPeminjaman = $buku->peminjaman()
            ->with('anggota')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('buku.detail', compact('buku', 'peminjamanAktif', 'riwayatPeminjaman'));
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new BukuImport, $request->file('file'));

        return redirect()->route('buku.tampil5')->with('success', 'Import data buku berhasil!');
    }
    public function qrcode($id)
    {
        $buku = Buku::findOrFail($id);
        $url = route('buku.detail', $buku->id); // Tujuan QR code
        $qrCode = QrCode::size(250)->generate($url); // Pastikan Anda sudah import use QrCode

        return view('buku.qr_code', compact('buku', 'qrCode'));
    }
}
