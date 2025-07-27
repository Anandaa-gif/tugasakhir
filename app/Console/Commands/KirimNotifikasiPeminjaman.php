<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Peminjaman;

class KirimNotifikasiPeminjaman extends Command
{
    protected $signature = 'notifikasi:kirim';
    protected $description = 'Kirim notifikasi WhatsApp H-1 dan H+1 peminjaman buku menggunakan Fonnte';

    public function handle(): void
    {
        $besok = Carbon::tomorrow()->toDateString();
        $kemarin = Carbon::yesterday()->toDateString();

        // Notifikasi H-1: Pengingat pengembalian besok
        $pengingat = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', $besok)
            ->get();

        foreach ($pengingat as $pinjam) {
            if ($pinjam->anggota && $pinjam->anggota->no_hp) {
                $this->kirimWA(
                    $pinjam->anggota->no_hp,
                    "📚 Hai {$pinjam->anggota->namalengkap},\nBesok adalah batas pengembalian buku \"{$pinjam->buku->judul}\".\nJangan lupa dikembalikan ya!"
                );
            }
        }

        // Notifikasi H+1: Telat mengembalikan
        $terlambat = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', $kemarin)
            ->get();

        foreach ($terlambat as $pinjam) {
            if ($pinjam->anggota && $pinjam->anggota->no_hp) {
                $this->kirimWA(
                    $pinjam->anggota->no_hp,
                    "⚠️ Hai {$pinjam->anggota->namalengkap},\nAnda TELAT mengembalikan buku \"{$pinjam->buku->judul}\" kemarin ({$kemarin}).\nSegera kembalikan untuk menghindari denda ya!"
                );
            }
        }

        $this->info("Notifikasi berhasil dikirim.");
    }

    private function kirimWA($nomor, $pesan): void
    {
        $token = env('FONNTE_TOKEN'); // Letakkan token di .env

        Http::withHeaders([
            'Authorization' => $token
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $nomor,
            'message' => $pesan,
            'countryCode' => '62'
        ]);
    }
}
