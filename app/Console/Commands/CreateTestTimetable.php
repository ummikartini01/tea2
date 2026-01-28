<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;
use App\Models\User;

class CreateTestTimetable extends Command
{
    protected $signature = 'tea:create-test {chatId=1012190593}';
    protected $description = 'Create a test tea timetable for testing notifications';

    public function handle()
    {
        $chatId = $this->argument('chatId');
        
        $this->info('🍵 Creating test tea timetable...');
        
        // Get the first user (or create one if needed)
        $user = User::first();
        if (!$user) {
            $this->error('❌ No users found in database!');
            return 1;
        }
        
        $this->info('👤 User: ' . $user->name . ' (ID: ' . $user->id . ')');
        
        // Create a test timetable
        $timetable = $user->teaTimetables()->create([
            'title' => 'Test Tea Schedule',
            'description' => 'A test timetable for debugging notifications',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(7)->format('Y-m-d'),
            'timezone' => 'Asia/Kuala_Lumpur',
            'schedule' => [
                [
                    'day' => strtolower(now()->format('l')), // Today's day
                    'times' => [
                        [
                            'time' => now()->format('H:i'), // Current time
                            'tea_id' => 1, // Assuming tea ID 1 exists
                            'notes' => 'Test tea time'
                        ]
                    ]
                ]
            ],
            'is_active' => true,
            'telegram_notifications_enabled' => true,
            'telegram_chat_id' => $chatId,
        ]);
        
        $this->info('✅ Test timetable created successfully!');
        $this->info('📋 Timetable ID: ' . $timetable->id);
        $this->info('📅 Schedule for: ' . ucfirst($timetable->schedule[0]['day']));
        $this->info('⏰ Time: ' . $timetable->schedule[0]['times'][0]['time']);
        $this->info('💬 Chat ID: ' . $timetable->telegram_chat_id);
        
        // Test if it's eligible for reminders
        $isActiveForDate = $timetable->isActiveForDate();
        $this->info('🗓️ Active for today: ' . ($isActiveForDate ? 'Yes' : 'No'));
        
        return 0;
    }
}
