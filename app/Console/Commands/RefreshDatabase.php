<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RefreshDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback and re-run migrations, then seed the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Log::info('Fut');
        // Run migrations
        $this->call('migrate:fresh', ['--force' => true]);

        // Seed the database
       $this->call('db:seed', ['--force' => true]);
    }
}
