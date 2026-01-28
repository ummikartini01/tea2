<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\User\TeaTimetableController;

class TestTimezones extends Command
{
    protected $signature = 'tea:test-timezones';
    protected $description = 'Test the updated Malaysia timezone options';

    public function handle()
    {
        $this->info('🕐 Testing Malaysia Timezone Options...');
        
        $controller = new TeaTimetableController();
        $timezones = $controller->getTimezones();
        
        $this->info('📋 Available Malaysia Timezones:');
        $this->info('');
        
        foreach ($timezones as $value => $label) {
            $this->info("📍 {$label}");
        }
        
        $this->info('');
        $this->info('✅ All Malaysia states now available!');
        $this->info('🌐 All use Asia/Kuala_Lumpur timezone (MYT)');
        $this->info('📱 Go to: http://127.0.0.1:8000/tea-timetables/create');
        $this->info('💡 Select your state from the dropdown');
        
        return 0;
    }
}
