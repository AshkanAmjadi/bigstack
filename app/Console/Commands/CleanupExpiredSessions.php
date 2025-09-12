<?php

namespace App\Console\Commands;

use App\Models\LoginTracking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupExpiredSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'پاکسازی sessions منقضی شده';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCount = LoginTracking::where('expires_at', '<', Carbon::now())
            ->delete();

        $this->info("$expiredCount session منقضی شده پاکسازی شد.");

        return 0;
    }
}
