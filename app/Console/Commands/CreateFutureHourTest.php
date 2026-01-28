<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;
use App\Models\User;

class CreateFutureHourTest extends Command
{
    protected $signature = 'tea:create-hour-test {hours=2}';
    protected $description = 'Create a test tea timetable hours from now';

    public function handle()
    {
        $hours = (int) $this->argument('hours');
        
        $this->info('🍵 Creating future hour test tea timetable...');
        
        // Get the first user
        $user = User::first();
        if (!$user) {
            $this->error('❌ No users found in database!');
            return 1;
        }
        
        $this->info('👤 User: ' . $user->name . ' (ID: ' . $user->id . ')');
        
        // Create a timetable with future time
        $futureTime = now()->addHours($hours)->format('H:i');
        $futureDate = now()->addHours($hours)->format('Y-m-d');
        $futureDay = strtolower(now()->addHours($hours)->format('l'));
        
        $this->info('⏰ Setting tea time for: ' . $futureTime . ' (in ' . $hours . ' hours)');
        $this->info('📅 Future date: ' . $futureDate);
        $this->info('📅 Future day: ' . ucfirst($futureDay));
        
        // Create a test timetable with future time
        $timetable = $user->teaTimetables()->create([
            'title' => 'Future Hour Test - ' . $hours . ' hours',
            'description' => 'Test timetable ' . $hours . ' hours from now',
            'start_date' => $futureDate,
            'end_date' => now()->addDays(7)->format('Y-m-d'),
            'timezone' => 'Asia/Kuala_Lumpur',
            'schedule' => [
                [
                    'day' => $futureDay,
                    'times' => [
                        [
                            'time' => $futureTime,
                            'tea_id' => 2, // Green Tea
                            'notes' => 'Future test - ' . $hours . ' hours from now at ' . $futureTime
                        ]
                    ]
                ]
            ],
            'is_active' => true,
            'telegram_notifications_enabled' => true,
            'telegram_chat_id' => '1012190593',
        ]);
        
        $this->info('✅ Future hour test timetable created successfully!');
        $this->info('📋 Timetable ID: ' . $timetable->id);
        $this->info('🍵 Tea: Green Tea (ID: 2)');
        $this->info('📅 Schedule for: ' . ucfirst($futureDay));
        $this->info('⏰ Time: ' . $futureTime);
        $this->info('📅 Date: ' . $futureDate);
        $this->info('💬 Chat ID: ' . $timetable->telegram_chat_id);
        
        // Test if it's eligible for reminders
        $isActiveForDate = $timetable->isActiveForDate();
        $this->info('🗓️ Active for today: ' . ($isActiveForDate ? 'Yes' : 'No'));
        
        $this->info('🧪 Run this command in ' . $hours . ' hours to test notifications:');
        $this->info('   php artisan tea:send-reminders');
        
        $this->info('⚠️  Or run with --test to simulate:');
        $this->info('   php artisan tea:send-reminders --test');
        
        return 0;
    }
}
