<?php

namespace App\Console\Commands;

use App\Models\LoginTracking;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CleanupExpiredLogins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login-security:cleanup {--days=7 : Number of days to keep expired logins}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired login tracking records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $keepDays = $this->option('days') ?: config('login-security.cleanup.keep_expired_for_days', 7);
        $threshold = Carbon::now()->subDays($keepDays);
        
        // حذف لاگین‌های منقضی شده قدیمی
        $expiredCount = LoginTracking::where('expires_at', '<', $threshold)
            ->orWhere(function($query) use ($threshold) {
                $query->whereNull('last_activity_at')
                      ->where('created_at', '<', $threshold);
            })
            ->delete();
            
        $this->info("Deleted {$expiredCount} expired login records.");
        
        // پاکسازی لاگین‌های مشکوک قدیمی
        $suspiciousCount = LoginTracking::where('is_suspicious', true)
            ->where('created_at', '<', Carbon::now()->subDays($keepDays))
            ->delete();
            
        if ($suspiciousCount > 0) {
            $this->info("Deleted {$suspiciousCount} suspicious login records.");
        }
        
        return Command::SUCCESS;
    }
} 