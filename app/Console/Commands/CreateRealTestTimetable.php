<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;
use App\Models\User;

class CreateRealTestTimetable extends Command
{
    protected $signature = 'tea:create-real-test {minutes=2}';
    protected $description = 'Create a test tea timetable with real tea for notification testing';

    public function handle()
    {
        $minutes = (int) $this->argument('minutes');
        
        $this->info('🍵 Creating real test tea timetable...');
        
        // Get the first user
        $user = User::first();
        if (!$user) {
            $this->error('❌ No users found in database!');
            return 1;
        }
        
        $this->info('👤 User: ' . $user->name . ' (ID: ' . $user->id . ')');
        
        // Create a timetable with future time and real tea
        $futureTime = now()->addMinutes($minutes)->format('H:i');
        $this->info('⏰ Setting tea time for: ' . $futureTime . ' (in ' . $minutes . ' minutes)');
        
        // Create a test timetable with real tea
        $timetable = $user->teaTimetables()->create([
            'title' => 'Real Test Schedule - ' . $futureTime,
            'description' => 'Test timetable with real tea for notification testing',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(7)->format('Y-m-d'),
            'timezone' => 'Asia/Kuala_Lumpur',
            'schedule' => [
                [
                    'day' => strtolower(now()->format('l')), // Today's day
                    'times' => [
                        [
                            'time' => $futureTime, // Future time
                            'tea_id' => 2, // Green Tea (real tea ID)
                            'notes' => 'Real test notification - Green Tea at ' . $futureTime . '!'
                        ]
                    ]
                ]
            ],
            'is_active' => true,
            'telegram_notifications_enabled' => true,
            'telegram_chat_id' => '1012190593',
        ]);
        
        $this->info('✅ Real test timetable created successfully!');
        $this->info('📋 Timetable ID: ' . $timetable->id);
        $this->info('🍵 Tea: Green Tea (ID: 2)');
        $this->info('📅 Schedule for: ' . ucfirst($timetable->schedule[0]['day']));
        $this->info('⏰ Time: ' . $timetable->schedule[0]['times'][0]['time']);
        $this->info('💬 Chat ID: ' . $timetable->telegram_chat_id);
        
        // Test if it's eligible for reminders
        $isActiveForDate = $timetable->isActiveForDate();
        $this->info('🗓️ Active for today: ' . ($isActiveForDate ? 'Yes' : 'No'));
        
        $this->info('🧪 Run this command in ' . $minutes . ' minutes to test notifications:');
        $this->info('   php artisan tea:send-reminders');
        
        return 0;
    }
}
