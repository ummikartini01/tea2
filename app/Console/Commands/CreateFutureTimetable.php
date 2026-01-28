<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;
use App\Models\User;

class CreateFutureTimetable extends Command
{
    protected $signature = 'tea:create-future {chatId=1012190593}';
    protected $description = 'Create a test tea timetable with future time for testing notifications';

    public function handle()
    {
        $chatId = $this->argument('chatId');
        
        $this->info('🍵 Creating future tea timetable...');
        
        // Get the first user
        $user = User::first();
        if (!$user) {
            $this->error('❌ No users found in database!');
            return 1;
        }
        
        $this->info('👤 User: ' . $user->name . ' (ID: ' . $user->id . ')');
        
        // Create a future time (2 minutes from now)
        $futureTime = now()->addMinutes(2)->format('H:i');
        $this->info('⏰ Setting tea time for: ' . $futureTime);
        
        // Create a test timetable with future time
        $timetable = $user->teaTimetables()->create([
            'title' => 'Future Tea Schedule',
            'description' => 'Test timetable with future time for notifications',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(7)->format('Y-m-d'),
            'timezone' => 'Asia/Kuala_Lumpur',
            'schedule' => [
                [
                    'day' => strtolower(now()->format('l')), // Today's day
                    'times' => [
                        [
                            'time' => $futureTime, // 2 minutes from now
                            'tea_id' => 1, // Assuming tea ID 1 exists
                            'notes' => 'Future test tea time'
                        ]
                    ]
                ]
            ],
            'is_active' => true,
            'telegram_notifications_enabled' => true,
            'telegram_chat_id' => $chatId,
        ]);
        
        $this->info('✅ Future timetable created successfully!');
        $this->info('📋 Timetable ID: ' . $timetable->id);
        $this->info('📅 Schedule for: ' . ucfirst($timetable->schedule[0]['day']));
        $this->info('⏰ Time: ' . $timetable->schedule[0]['times'][0]['time']);
        $this->info('💬 Chat ID: ' . $timetable->telegram_chat_id);
        
        // Test if it's eligible for reminders
        $isActiveForDate = $timetable->isActiveForDate();
        $this->info('🗓️ Active for today: ' . ($isActiveForDate ? 'Yes' : 'No'));
        
        $this->info('🧪 Run this command in 2 minutes to test notifications:');
        $this->info('   php artisan tea:send-reminders --test');
        
        return 0;
    }
}
