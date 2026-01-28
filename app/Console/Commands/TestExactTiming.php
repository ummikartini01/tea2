<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class TestExactTiming extends Command
{
    protected $signature = 'tea:test-exact-timing {id}';
    protected $description = 'Test exact timing calculations for a timetable';

    public function handle()
    {
        $id = $this->argument('id');
        
        $timetable = TeaTimetable::find($id);
        
        if (!$timetable) {
            $this->error('❌ Timetable not found!');
            return 1;
        }
        
        $this->info('🕐 EXACT TIMING TEST for Timetable ID: ' . $id);
        $this->info('🍵 Title: ' . $timetable->title);
        $this->info('');
        
        $actualTimezone = $timetable->getActualTimezone();
        $currentTime = now($actualTimezone);
        
        foreach ($timetable->schedule as $daySchedule) {
            foreach ($daySchedule['times'] as $timeSlot) {
                $scheduledTime = $currentTime->copy()->setTimeFromTimeString($timeSlot['time']);
                $diffInMinutes = abs($currentTime->diffInMinutes($scheduledTime));
                $shouldSend = $diffInMinutes <= 5;
                
                $this->info('⏰ Current time: ' . $currentTime->format('H:i:s'));
                $this->info('⏰ Scheduled time: ' . $scheduledTime->format('H:i:s'));
                $this->info('⏰ Time difference: ' . $diffInMinutes . ' minutes');
                $this->info('🔔 Should send: ' . ($shouldSend ? 'YES' : 'NO'));
                $this->info('📊 Condition: ' . $diffInMinutes . ' <= 5 = ' . ($diffInMinutes <= 5 ? 'TRUE' : 'FALSE'));
                
                // Test edge cases
                $this->info('');
                $this->info('🧪 Edge Case Tests:');
                
                for ($i = 1; $i <= 10; $i++) {
                    $testTime = $currentTime->copy()->addMinutes($i);
                    $testDiff = abs($currentTime->diffInMinutes($testTime));
                    $testShouldSend = $testDiff <= 5;
                    
                    $this->info(sprintf(
                        '   +%d min: %d <= 5 = %s',
                        $i,
                        $testDiff,
                        $testShouldSend ? 'YES' : 'NO'
                    ));
                }
                
                $this->info('');
                $this->info('🎯 Current Status:');
                if ($shouldSend) {
                    $this->info('✅ SHOULD SEND NOTIFICATION');
                    $this->info('📱 If no notification received, check:');
                    $this->info('   • Telegram app for messages');
                    $this->info('   • Teazy Bot chat');
                    $this->info('   • Network connectivity');
                    $this->info('   • Bot token validity');
                } else {
                    $this->info('❌ OUTSIDE NOTIFICATION WINDOW');
                    $this->info('📅 Next opportunity: Update timetable time');
                }
            }
        }
        
        return 0;
    }
}
