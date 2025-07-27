<?php

namespace App\Imports;

use App\Models\Buku;
use App\Models\Jenis;
use App\Models\Kategori;
use App\Models\Penerbit;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BukuImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $jenis = Jenis::firstOrCreate(
            ['name' => $row['jenis']],
            ['kode_jenis' => 'JNS-' . strtoupper(Str::random(4))]
        );

        $kategori = Kategori::firstOrCreate(
            ['name' => $row['kategori']],
            ['kode_kategori' => 'KTG-' . strtoupper(Str::random(4))]
        );

        $penerbit = Penerbit::firstOrCreate(
            ['name' => $row['penerbit']],
            ['kode_penerbit' => 'PNB-' . strtoupper(Str::random(4))]
        );

        return new Buku([
            'kode_buku'     => $row['kode_buku'],
            'judul_buku'    => $row['judul_buku'],
            'isbn'          => $row['isbn'],
            'penulis'       => $row['penulis'],
            'stok'          => $row['stok'],
            'tahun_terbit'  => $row['tahun_terbit'],
            'jenis_id'      => $jenis->id,
            'kategori_id'   => $kategori->id,
            'penerbit_id'   => $penerbit->id,
        ]);
    }
}
