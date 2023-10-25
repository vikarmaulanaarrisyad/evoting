<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CronTes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron-tes';

    protected $Domainesia = 'cron:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memastikan command jalan dengan pembuatan log';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("Cron is working fine!");
    }
}
