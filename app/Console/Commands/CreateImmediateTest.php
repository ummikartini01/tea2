<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;
use App\Models\Tea;

class CreateImmediateTest extends Command
{
    protected $signature = 'tea:create-immediate-test';
    protected $description = 'Create a timetable that will send notification immediately (within 5-minute window)';

    public function handle()
    {
        $this->info('🕐 CREATING IMMEDIATE TEST TIMETABLE');
        $this->info(str_repeat('=', 50));
        $this->info('');
        
        // Get current time and create a time within the 5-minute window
        $currentTime = now('Asia/Kuala_Lumpur');
        $testTime = $currentTime->copy()->addMinutes(2); // 2 minutes from now
        $timeString = $testTime->format('H:i');
        
        $this->info('⏰ Current time: ' . $currentTime->format('H:i'));
        $this->info('⏰ Test time: ' . $timeString . ' (in 2 minutes)');
        $this->info('📅 Day: ' . $testTime->format('l'));
        $this->info('');
        
        // Get user
        $user = \App\Models\User::find(2);
        if (!$user) {
            $this->error('❌ User not found!');
            return 1;
        }
        
        // Create the timetable
        $timetable = TeaTimetable::create([
            'user_id' => $user->id,
            'title' => 'Immediate Test - ' . $timeString,
            'description' => 'Test timetable for immediate notification',
            'start_date' => $testTime->format('Y-m-d'),
            'end_date' => $testTime->copy()->addDays(7)->format('Y-m-d'),
            'timezone' => 'Asia/Kuala_Lumpur_Melaka',
            'schedule' => [
                [
                    'day' => strtolower($testTime->format('l')),
                    'times' => [
                        [
                            'time' => $timeString,
                            'tea_id' => 2,
                            'notes' => 'Immediate test notification'
                        ]
                    ]
                ]
            ],
            'is_active' => true,
            'telegram_notifications_enabled' => true,
            'telegram_chat_id' => '1012190593',
        ]);
        
        $this->info('✅ Immediate test timetable created successfully!');
        $this->info('📋 Timetable ID: ' . $timetable->id);
        $this->info('🍵 Title: ' . $timetable->title);
        $this->info('📅 Schedule: ' . json_encode($timetable->schedule, JSON_PRETTY_PRINT));
        $this->info('');
        
        // Test immediately
        $this->info('🧪 Testing notification system immediately...');
        
        // Check if it should send notification
        $actualTimezone = $timetable->getActualTimezone();
        $current = now($actualTimezone);
        $scheduled = $current->copy()->setTimeFromTimeString($timeString);
        $diffInMinutes = abs($current->diffInMinutes($scheduled));
        $shouldSend = $diffInMinutes <= 5;
        
        $this->info('⏰ Current time: ' . $current->format('H:i'));
        $this->info('⏰ Scheduled time: ' . $scheduled->format('H:i'));
        $this->info('⏰ Time difference: ' . $diffInMinutes . ' minutes');
        $this->info('🔔 Should send: ' . ($shouldSend ? 'YES' : 'NO'));
        $this->info('');
        
        if ($shouldSend) {
            $this->info('🎉 PERFECT! This timetable will send notification immediately!');
            $this->info('📱 Run: php artisan tea:send-reminders');
        } else {
            $this->info('⚠️  This timetable is outside the 5-minute window');
        }
        
        return 0;
    }
}
