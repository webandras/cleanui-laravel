<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \Modules\Clean\Console\Commands\RefreshDatabase::class,
    ];


    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
       $schedule->command('db:refresh-seed')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        $this->load(__DIR__.'/../../modules/Clean/Console/Commands');

        require base_path('routes/console.php');
    }
}
