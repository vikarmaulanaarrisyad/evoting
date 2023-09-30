<?php

namespace App\Console;

use App\Jobs\ProcessUpdateData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $tanggalTertentu = '2023-09-30'; // Tanggal yang diinginkan
        $tanggalSekarang = now()->toDateString();

        if ($tanggalSekarang === $tanggalTertentu) {
            // Jadwalkan tugas pembaruan pada tanggal tertentu
            $schedule->job(new ProcessUpdateData)->daily(); // Ubah jadwal sesuai kebutuhan
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
