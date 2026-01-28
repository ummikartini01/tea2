<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MalaysiaTimezonesInfo extends Command
{
    protected $signature = 'tea:malaysia-timezones-info';
    protected $description = 'Show information about Malaysia timezone system';

    public function handle()
    {
        $this->info('🇲🇾 MALAYSIA TIMEZONE SYSTEM - COMPLETE GUIDE');
        $this->info(str_repeat('=', 60));
        $this->info('');
        
        $this->info('📍 Available States & Federal Territories:');
        $this->info('');
        
        $states = [
            'Kuala Lumpur & Selangor' => 'Main federal territories',
            'Putrajaya' => 'Administrative center',
            'Johor' => 'Southern state',
            'Melaka' => 'Historical state',
            'Negeri Sembilan' => 'Western state',
            'Pahang' => 'Largest state',
            'Perak' => 'Northern state',
            'Perlis' => 'Smallest state',
            'Kedah' => 'Rice bowl state',
            'Penang' => 'Tech hub state',
            'Terengganu' => 'East coast state',
            'Kelantan' => 'Islamic state',
            'Sabah' => 'Borneo state',
            'Sarawak' => 'Largest Borneo state',
            'Labuan' => 'Federal territory',
        ];
        
        foreach ($states as $state => $description) {
            $this->info("🗺️  {$state}: {$description}");
        }
        
        $this->info('');
        $this->info('⏰ Timezone Details:');
        $this->info('🌐 All states use: Asia/Kuala_Lumpur (MYT)');
        $this->info('🕐 Time offset: UTC+8');
        $this->info('📅 No daylight saving time');
        $this->info('🔧 System automatically converts all to MYT');
        
        $this->info('');
        $this->info('🚀 How to Use:');
        $this->info('1. Visit: http://127.0.0.1:8000/tea-timetables/create');
        $this->info('2. Select your state from timezone dropdown');
        $this->info('3. System automatically uses Asia/Kuala_Lumpur');
        $this->info('4. Create tea schedules with local Malaysia time');
        $this->info('5. Receive notifications at correct local time');
        
        $this->info('');
        $this->info('✅ Benefits:');
        $this->info('🎯 State-specific selection for better UX');
        $this->info('🕐 All states use correct Malaysia time');
        $this->info('📱 Telegram notifications work perfectly');
        $this->info('🌟 No timezone confusion for Malaysian users');
        
        $this->info('');
        $this->info('📱 Test Commands:');
        $this->info('php artisan tea:show-timezones - Show all options');
        $this->info('php artisan tea:create-real-test 2 - Create test');
        $this->info('php artisan tea:send-reminders - Test notifications');
        
        return 0;
    }
}
