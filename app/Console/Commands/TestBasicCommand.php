<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestBasicCommand extends Command
{
    protected $signature = 'tea:test-basic';
    protected $description = 'Test basic PHP and Laravel functionality';

    public function handle()
    {
        $this->info('🧪 BASIC SYSTEM TEST');
        $this->info('==================');
        $this->info('');
        
        $this->info('✅ PHP Version: ' . phpversion());
        $this->info('✅ Laravel Version: ' . app()->version());
        $this->info('✅ Current Time: ' . now()->format('Y-m-d H:i:s'));
        $this->info('✅ Timezone: ' . config('app.timezone'));
        $this->info('✅ Project Path: ' . base_path());
        $this->info('');
        
        $this->info('🔧 Testing Database Connection:');
        try {
            $timetables = \App\Models\TeaTimetable::count();
            $this->info('✅ Database connected: ' . $timetables . ' timetables found');
        } catch (\Exception $e) {
            $this->error('❌ Database error: ' . $e->getMessage());
        }
        
        $this->info('');
        $this->info('📱 Testing Telegram Service:');
        try {
            $telegramService = app(\App\Services\TelegramBotService::class);
            $this->info('✅ Telegram service loaded');
        } catch (\Exception $e) {
            $this->error('❌ Telegram service error: ' . $e->getMessage());
        }
        
        $this->info('');
        $this->info('🎯 Testing tea11 specifically:');
        $tea11 = \App\Models\TeaTimetable::where('title', 'tea11')->first();
        if ($tea11) {
            $this->info('✅ tea11 found: ID ' . $tea11->id);
            $this->info('✅ Scheduled: ' . $tea11->schedule[0]['times'][0]['time']);
            $this->info('✅ Telegram enabled: ' . ($tea11->telegram_notifications_enabled ? 'Yes' : 'No'));
            $this->info('✅ Chat ID: ' . $tea11->telegram_chat_id);
        } else {
            $this->error('❌ tea11 not found');
        }
        
        $this->info('');
        $this->info('🎉 BASIC TEST COMPLETE');
        
        return 0;
    }
}
