<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// Tambahan
use App\Exports\PengunjungExport;
use Maatwebsite\Excel\Facades\Excel;

class PengunjungController extends Controller
{
    public function tampil7()
    {
        $pengunjung = Pengunjung::orderBy('created_at', 'desc')->paginate(10);
        return view('pengunjung.tampil7', compact('pengunjung'));
    }

    public function tambah7(Request $request)
    {
        $type = $request->query('type'); // ?type=siswa/guru/tamu
        return view('pengunjung.tambah7', compact('type'));
    }

    public function qrCode()
    {
        $urlTambah = route('pengunjung.tambah7');
        $qrCode = QrCode::size(250)->generate($urlTambah);
        return view('pengunjung.qr', compact('qrCode'));
    }

    public function submit6(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'type'          => 'required|in:siswa,guru,tamu',
            'tujuan'        => 'required|string|max:255',
            'waktu_kunjung' => 'required|date',
            'kelas'         => 'required_if:type,siswa|nullable|string|max:10',
            'alamat'        => 'required_if:type,tamu|nullable|string|max:255',
            'kesan_pesan'   => 'nullable|string'
        ]);

        Pengunjung::create($validated);

        return redirect()->route('pengunjung.success')->with('success', 'Data pengunjung berhasil disimpan!');
    }

    public function success()
    {
        return view('pengunjung.success');
    }

    public function edit6($id)
    {
        $kunjungan = Pengunjung::findOrFail($id);
        return view('pengunjung.edit6', compact('kunjungan'));
    }

    public function update6(Request $request, $id)
    {
        $request->validate([
            'nama'             => 'required|string|max:255',
            'tipe'             => 'required|in:siswa,guru,tamu',
            'tujuan_kunjungan' => 'required|string|max:255',
            'waktu_kunjungan'  => 'required|date',
            'kelas'            => 'nullable|string|max:10',
            'alamat'           => 'nullable|string|max:255',
            'kesan_pesan'      => 'nullable|string',
        ]);

        $pengunjung = Pengunjung::findOrFail($id);
        $pengunjung->name         = $request->nama;
        $pengunjung->type         = $request->tipe;
        $pengunjung->tujuan       = $request->tujuan_kunjungan;
        $pengunjung->waktu_kunjung = $request->waktu_kunjungan;
        $pengunjung->kelas        = $request->tipe === 'siswa' ? $request->kelas : null;
        $pengunjung->alamat       = $request->tipe === 'tamu' ? $request->alamat : null;
        $pengunjung->kesan_pesan  = $request->tipe === 'tamu' ? $request->kesan_pesan : null;
        $pengunjung->save();

        return redirect()->route('pengunjung.tampil7')->with('success', 'Data pengunjung berhasil diperbarui.');
    }

    public function delete6($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        $pengunjung->delete();

        return redirect()->route('pengunjung.tampil7')->with('success', 'Data pengunjung berhasil dihapus.');
    }

    // ✅ Tambahan: Export Data Berdasarkan Bulan
    public function exportPerBulan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
        ]);

        $bulan = $request->bulan;

        return Excel::download(new PengunjungExport($bulan), 'pengunjung_bulan_' . $bulan . '.xlsx');
    }
}
