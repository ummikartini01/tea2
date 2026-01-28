<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class UpdateTea6Timetable extends Command
{
    protected $signature = 'tea:update-tea6';
    protected $description = 'Update tea6 timetable to current time + 2 minutes';

    public function handle()
    {
        $timetable = TeaTimetable::where('title', 'tea6')->first();
        
        if (!$timetable) {
            $this->error('❌ tea6 timetable not found!');
            return 1;
        }
        
        $this->info('🔄 Updating tea6 timetable...');
        $this->info('🍵 Title: ' . $timetable->title);
        $this->info('📅 Current schedule: ' . json_encode($timetable->schedule, JSON_PRETTY_PRINT));
        
        // Get current time in Malaysia timezone and add 2 minutes
        $currentTime = now('Asia/Kuala_Lumpur');
        $futureTime = $currentTime->copy()->addMinutes(2);
        $newTime = $futureTime->format('H:i');
        
        $this->info('⏰ Current time: ' . $currentTime->format('H:i'));
        $this->info('⏰ New scheduled time: ' . $newTime);
        
        // Update the schedule
        $newSchedule = [
            [
                'day' => 'thursday',
                'times' => [
                    [
                        'time' => $newTime,
                        'tea_id' => 8,
                        'notes' => 'Updated tea6 schedule - ' . $newTime
                    ]
                ]
            ]
        ];
        
        $timetable->schedule = $newSchedule;
        $timetable->save();
        
        $this->info('✅ tea6 timetable updated successfully!');
        $this->info('📅 New schedule: ' . json_encode($timetable->schedule, JSON_PRETTY_PRINT));
        $this->info('');
        $this->info('🧪 Test in 2 minutes:');
        $this->info('   php artisan tea:send-reminders');
        $this->info('');
        $this->info('📱 You should receive a Telegram notification at ' . $newTime);
        
        return 0;
    }
}
