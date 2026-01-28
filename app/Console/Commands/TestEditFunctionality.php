<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class TestEditFunctionality extends Command
{
    protected $signature = 'tea:test-edit-functionality {id}';
    protected $description = 'Test the edit functionality for a timetable';

    public function handle()
    {
        $id = $this->argument('id');
        
        $timetable = TeaTimetable::find($id);
        
        if (!$timetable) {
            $this->error('❌ Timetable not found!');
            return 1;
        }
        
        $this->info('🔧 Testing Edit Functionality for Timetable ID: ' . $id);
        $this->info('🍵 Title: ' . $timetable->title);
        $this->info('📝 Description: ' . $timetable->description);
        $this->info('');
        
        $this->info('📅 Current Schedule:');
        if (!empty($timetable->schedule)) {
            foreach ($timetable->schedule as $daySchedule) {
                $this->info('   📅 Day: ' . ucfirst($daySchedule['day']));
                foreach ($daySchedule['times'] as $timeSlot) {
                    $this->info('   ⏰ Time: ' . $timeSlot['time'] . ' (Tea ID: ' . $timeSlot['tea_id'] . ')');
                    $this->info('   📝 Notes: ' . ($timeSlot['notes'] ?? 'None'));
                }
            }
        } else {
            $this->info('   ❌ No schedule found');
        }
        
        $this->info('');
        $this->info('🌐 Edit URL:');
        $this->info('   http://127.0.0.1:8000/tea-timetables/' . $id . '/edit');
        $this->info('');
        
        $this->info('🧪 Test Steps:');
        $this->info('1. Visit the edit URL above');
        $this->info('2. Modify the schedule (add/remove time slots)');
        $this->info('3. Click "Update Timetable"');
        $this->info('4. Check if the schedule updates correctly');
        $this->info('');
        
        $this->info('🐛 Debug Info:');
        $this->info('• Check browser console for JavaScript errors');
        $this->info('• Check storage/logs/laravel.log for update logs');
        $this->info('• Form should submit schedule data as JSON');
        $this->info('• Controller should parse and save the schedule');
        $this->info('');
        
        $this->info('📱 If issues persist, use the simple edit form:');
        $this->info('   http://127.0.0.1:8000/tea-timetables/' . $id . '/edit-simple');
        
        return 0;
    }
}
