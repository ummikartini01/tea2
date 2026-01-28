<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ContinuousReminders extends Command
{
    protected $signature = 'tea:continuous-reminders';
    protected $description = 'Run continuous tea reminders (alternative to batch file)';

    public function handle()
    {
        $this->info('🚀 CONTINUOUS TEA REMINDER SERVICE');
        $this->info('================================');
        $this->info('Press Ctrl+C to stop');
        $this->info('');

        while (true) {
            $this->info('[' . now()->format('H:i:s') . '] 🍵 Checking for tea reminders...');
            
            try {
                $this->call('tea:send-reminders');
                $this->info('[' . now()->format('H:i:s') . '] ✅ Check completed successfully');
            } catch (\Exception $e) {
                $this->error('[' . now()->format('H:i:s') . '] ❌ Error: ' . $e->getMessage());
            }
            
            $this->info('[' . now()->format('H:i:s') . '] ⏰ Waiting 60 seconds...');
            $this->info('');
            
            // Sleep for 60 seconds
            sleep(60);
        }
        
        return 0;
    }
}
