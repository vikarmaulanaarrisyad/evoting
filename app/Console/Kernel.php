<?php

namespace App\Console;

use App\Models\Pemilihan;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule)
    {
        $now = Carbon::now();
        $tanggalSekarang = $now->format('Y-m-d');

        $schedule->call(function () use ($tanggalSekarang) {
            $pemilihan = Pemilihan::where('status_pemilihan', 'Belum Dimulai')
                ->where('tanggal_mulai_pemilihan', $tanggalSekarang)
                ->first();

            if ($pemilihan) {
                $pemilihan->update([
                    'status_pemilihan' => 'Sedang Berlangsung'
                ]);
            }
        })->dailyAt('06:30');

        $schedule->call(function () use ($tanggalSekarang) {
            $pemilihan = Pemilihan::where('status_pemilihan', 'Sedang Berlangsung')
                ->where('tanggal_selesai_pemilihan', $tanggalSekarang)
                ->first();

            if ($pemilihan) {
                $pemilihan->update([
                    'status_pemilihan' => 'Selesai'
                ]);
            }
        })->dailyAt('23:59');

    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
