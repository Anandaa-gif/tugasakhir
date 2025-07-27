<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RiwayatExport implements FromCollection, WithHeadings
{
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($awal, $akhir)
    {
        $this->tanggal_awal = $awal;
        $this->tanggal_akhir = $akhir;
    }

    public function collection()
    {
        return Peminjaman::with(['anggota', 'buku', 'pengembalian'])
            ->whereBetween('tanggal_pinjam', [$this->tanggal_awal, $this->tanggal_akhir])
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->anggota->namalengkap ?? '-',
                    'Judul Buku' => $item->buku->judul_buku ?? '-',
                    'Tgl Pinjam' => $item->tanggal_pinjam,
                    'Tgl Harus Kembali' => $item->tanggal_kembali,
                    'Tgl Kembali' => $item->pengembalian->tanggal_kembali ?? '-',
                    'Status' => ucfirst($item->status),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama', 'Judul Buku', 'Tgl Pinjam', 'Tgl Harus Kembali', 'Tgl Kembali', 'Status'];
    }
}
