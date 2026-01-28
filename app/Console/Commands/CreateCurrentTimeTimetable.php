<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;
use App\Models\User;

class CreateCurrentTimeTimetable extends Command
{
    protected $signature = 'tea:create-current {chatId=1012190593}';
    protected $description = 'Create a test tea timetable with current time for immediate notification testing';

    public function handle()
    {
        $chatId = $this->argument('chatId');
        
        $this->info('🍵 Creating current time tea timetable...');
        
        // Get the first user
        $user = User::first();
        if (!$user) {
            $this->error('❌ No users found in database!');
            return 1;
        }
        
        $this->info('👤 User: ' . $user->name . ' (ID: ' . $user->id . ')');
        
        // Create a timetable with current time
        $currentTime = now('Asia/Kuala_Lumpur')->format('H:i');
        $this->info('⏰ Setting tea time for: ' . $currentTime);
        
        // Create a test timetable with current time
        $timetable = $user->teaTimetables()->create([
            'title' => 'Current Time Test Schedule',
            'description' => 'Test timetable with current time for immediate notifications',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(7)->format('Y-m-d'),
            'timezone' => 'Asia/Kuala_Lumpur',
            'schedule' => [
                [
                    'day' => strtolower(now()->format('l')), // Today's day
                    'times' => [
                        [
                            'time' => $currentTime, // Current time
                            'tea_id' => 1, // Assuming tea ID 1 exists
                            'notes' => 'Current time test tea'
                        ]
                    ]
                ]
            ],
            'is_active' => true,
            'telegram_notifications_enabled' => true,
            'telegram_chat_id' => $chatId,
        ]);
        
        $this->info('✅ Current time timetable created successfully!');
        $this->info('📋 Timetable ID: ' . $timetable->id);
        $this->info('📅 Schedule for: ' . ucfirst($timetable->schedule[0]['day']));
        $this->info('⏰ Time: ' . $timetable->schedule[0]['times'][0]['time']);
        $this->info('💬 Chat ID: ' . $timetable->telegram_chat_id);
        
        // Test if it's eligible for reminders
        $isActiveForDate = $timetable->isActiveForDate();
        $this->info('🗓️ Active for today: ' . ($isActiveForDate ? 'Yes' : 'No'));
        
        $this->info('🧪 Run this command NOW to test notifications:');
        $this->info('   php artisan tea:send-reminders --test');
        
        return 0;
    }
}
