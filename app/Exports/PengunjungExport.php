<?php

namespace App\Exports;

use App\Models\Pengunjung;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengunjungExport implements FromCollection, WithHeadings
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function collection()
    {
        return Pengunjung::whereMonth('created_at', $this->bulan)->get([
            'name',
            'type',
            'tujuan',
            'waktu_kunjung',
            'kelas',
            'alamat',
            'kesan_pesan'
        ]);
    }

    public function headings(): array
    {
        return ['Nama', 'Tipe', 'Tujuan', 'Waktu Kunjung', 'Kelas', 'Alamat', 'Kesan dan Pesan'];
    }
}
