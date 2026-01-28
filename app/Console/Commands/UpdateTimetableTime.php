<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class UpdateTimetableTime extends Command
{
    protected $signature = 'tea:update-time {id} {minutes=2}';
    protected $description = 'Update timetable tea time to future time';

    public function handle()
    {
        $id = (int) $this->argument('id');
        $minutes = (int) $this->argument('minutes');
        
        $timetable = TeaTimetable::find($id);
        
        if (!$timetable) {
            $this->error('❌ Timetable not found!');
            return 1;
        }
        
        $this->info('🔧 Updating timetable ID: ' . $id);
        $this->info('🍵 Title: ' . $timetable->title);
        
        // Update the schedule with future time
        $futureTime = now()->addMinutes($minutes)->format('H:i');
        
        $schedule = $timetable->schedule;
        if (!empty($schedule)) {
            $schedule[0]['times'][0]['time'] = $futureTime;
            $schedule[0]['times'][0]['notes'] = 'Updated time - ' . $futureTime;
        }
        
        $timetable->schedule = $schedule;
        $timetable->save();
        
        $this->info('✅ Updated tea time to: ' . $futureTime);
        $this->info('🧪 Run this in ' . $minutes . ' minutes:');
        $this->info('   php artisan tea:send-reminders');
        
        return 0;
    }
}
