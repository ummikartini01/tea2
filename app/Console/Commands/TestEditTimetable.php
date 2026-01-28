<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class TestEditTimetable extends Command
{
    protected $signature = 'tea:test-edit {id}';
    protected $description = 'Test editing a timetable to check schedule updates';

    public function handle()
    {
        $id = $this->argument('id');
        
        $timetable = TeaTimetable::find($id);
        
        if (!$timetable) {
            $this->error('❌ Timetable not found!');
            return 1;
        }
        
        $this->info('🔧 Testing Edit for Timetable ID: ' . $id);
        $this->info('🍵 Title: ' . $timetable->title);
        $this->info('📝 Description: ' . $timetable->description);
        $this->info('📅 Current Schedule:');
        
        if (!empty($timetable->schedule)) {
            foreach ($timetable->schedule as $daySchedule) {
                $this->info('   📅 Day: ' . ucfirst($daySchedule['day']));
                foreach ($daySchedule['times'] as $timeSlot) {
                    $this->info('   ⏰ Time: ' . $timeSlot['time'] . ' (Tea ID: ' . $timeSlot['tea_id'] . ')');
                    $this->info('   📝 Notes: ' . ($timeSlot['notes'] ?? 'None'));
                }
            }
        }
        
        // Test updating the schedule
        $newSchedule = [
            [
                'day' => 'friday',
                'times' => [
                    [
                        'time' => '14:00',
                        'tea_id' => 2,
                        'notes' => 'Updated schedule - Friday afternoon tea'
                    ]
                ]
            ]
        ];
        
        $this->info('');
        $this->info('🔄 Updating schedule to:');
        $this->info('   📅 Day: Friday');
        $this->info('   ⏰ Time: 14:00');
        $this->info('   🍵 Tea: Green Tea (ID: 2)');
        $this->info('   📝 Notes: Updated schedule - Friday afternoon tea');
        
        $timetable->schedule = $newSchedule;
        $timetable->save();
        
        $this->info('');
        $this->info('✅ Schedule updated successfully!');
        $this->info('🔄 Refreshing timetable data...');
        
        // Refresh and show updated data
        $timetable->refresh();
        
        $this->info('📅 Updated Schedule:');
        if (!empty($timetable->schedule)) {
            foreach ($timetable->schedule as $daySchedule) {
                $this->info('   📅 Day: ' . ucfirst($daySchedule['day']));
                foreach ($daySchedule['times'] as $timeSlot) {
                    $this->info('   ⏰ Time: ' . $timeSlot['time'] . ' (Tea ID: ' . $timeSlot['tea_id'] . ')');
                    $this->info('   📝 Notes: ' . ($timeSlot['notes'] ?? 'None'));
                }
            }
        }
        
        $this->info('');
        $this->info('📱 Visit the edit page to test web interface:');
        $this->info('   http://127.0.0.1:8000/tea-timetables/' . $id . '/edit');
        
        return 0;
    }
}
