<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AnggotaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validasi minimal: nis dan nama wajib
        if (empty($row['nis']) || empty($row['namalengkap'])) {
            return null;
        }

        // Cegah duplikat berdasarkan NIS
        if (Anggota::where('nis', $row['nis'])->exists()) {
            return null;
        }

        // Generate nomor anggota otomatis
        $last = Anggota::pluck('nomor_anggota')
            ->map(fn($n) => (int) preg_replace('/\D/', '', $n))
            ->max() ?? 0;

        $nomor_anggota = str_pad($last + 1, 4, '0', STR_PAD_LEFT);

        // Buat data anggota
        $anggota = new Anggota([
            'nis'            => $row['nis'],
            'namalengkap'    => $row['namalengkap'],
            'nomor_anggota'  => $nomor_anggota,
            'jenis'          => ucfirst(strtolower($row['jenis'])),
            'kelas'          => strtolower($row['jenis']) === 'siswa' ? $row['kelas'] : null,
            'alamat'         => $row['alamat'] ?? null,
            'no_hp'          => $row['no_hp'] ?? null,
        ]);

        // Buat akun user jika belum ada
        if (!User::where('email', $row['nis'])->exists()) {
            User::create([
                'name'     => $row['namalengkap'],
                'email'    => $row['nis'], // login tetap pakai NIS, tapi disimpan di kolom email
                'password' => Hash::make($row['nis']),
                'role'     => 'anggota',
            ]);
        }


        return $anggota;
    }
}
