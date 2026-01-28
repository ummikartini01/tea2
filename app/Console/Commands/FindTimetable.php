<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class FindTimetable extends Command
{
    protected $signature = 'tea:find {title}';
    protected $description = 'Find timetable by title';

    public function handle()
    {
        $title = $this->argument('title');
        
        $timetable = TeaTimetable::where('title', $title)->first();
        
        if (!$timetable) {
            $this->error('❌ Timetable "' . $title . '" not found!');
            return 1;
        }
        
        $this->info('📋 Found timetable:');
        $this->info('🆔 ID: ' . $timetable->id);
        $this->info('🍵 Title: ' . $timetable->title);
        $this->info('📝 Description: ' . $timetable->description);
        $this->info('📅 Created: ' . $timetable->created_at->format('Y-m-d H:i:s'));
        
        if (!empty($timetable->schedule)) {
            foreach ($timetable->schedule as $daySchedule) {
                $this->info('📅 Day: ' . ucfirst($daySchedule['day']));
                foreach ($daySchedule['times'] as $timeSlot) {
                    $this->info('⏰ Time: ' . $timeSlot['time'] . ' (Tea ID: ' . $timeSlot['tea_id'] . ')');
                }
            }
        }
        
        return 0;
    }
}
