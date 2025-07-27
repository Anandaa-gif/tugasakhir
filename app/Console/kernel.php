<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Import command yang akan dijadwalkan
use App\Console\Commands\KirimNotifikasiPeminjaman;

class Kernel extends ConsoleKernel
{
    /**
     * Definisikan schedule (penjadwalan tugas artisan)
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jadwalkan notifikasi setiap hari jam 08:00 pagi (untuk H+1)
        $schedule->command(KirimNotifikasiPeminjaman::class)->dailyAt('06:00');

        // Untuk testing (hapus baris atas dan aktifkan ini)
        // $schedule->command(KirimNotifikasiPeminjaman::class)->everyMinute();
    }

    /**
     * Daftarkan folder commands artisan
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
