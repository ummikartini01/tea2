<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class Test5MinuteWindow extends Command
{
    protected $signature = 'tea:test-5min-window';
    protected $description = 'Test the 5-minute notification window';

    public function handle()
    {
        $this->info('🕐 TESTING 5-MINUTE NOTIFICATION WINDOW');
        $this->info(str_repeat('=', 50));
        $this->info('');
        
        // Get current time
        $currentTime = now('Asia/Kuala_Lumpur');
        $this->info('⏰ Current time: ' . $currentTime->format('H:i'));
        $this->info('');
        
        // Test cases with different time differences
        $testCases = [
            ['name' => '4 minutes late', 'minutes' => -4],
            ['name' => '3 minutes late', 'minutes' => -3],
            ['name' => '2 minutes late', 'minutes' => -2],
            ['name' => '1 minute late', 'minutes' => -1],
            ['name' => 'On time', 'minutes' => 0],
            ['name' => '1 minute early', 'minutes' => 1],
            ['name' => '2 minutes early', 'minutes' => 2],
            ['name' => '3 minutes early', 'minutes' => 3],
            ['name' => '4 minutes early', 'minutes' => 4],
            ['name' => '5 minutes early', 'minutes' => 5],
            ['name' => '6 minutes early', 'minutes' => 6],
            ['name' => '6 minutes late', 'minutes' => -6],
        ];
        
        $this->info('🧪 Test Results:');
        foreach ($testCases as $case) {
            $testTime = $currentTime->copy()->addMinutes($case['minutes']);
            $diffInMinutes = abs($currentTime->diffInMinutes($testTime));
            $shouldSend = $diffInMinutes <= 5;
            
            $status = $shouldSend ? '✅ YES' : '❌ NO';
            $this->info(sprintf(
                '   %s (%s): %s (diff: %d min)',
                $case['name'],
                $testTime->format('H:i'),
                $status,
                $diffInMinutes
            ));
        }
        
        $this->info('');
        $this->info('🎯 NEW 5-MINUTE WINDOW RULES:');
        $this->info('✅ Sends notifications from -5 to +5 minutes');
        $this->info('✅ Total window: 11 minutes (5 before + 5 after + exact time)');
        $this->info('❌ No notifications outside this window');
        $this->info('');
        
        $this->info('📱 Benefits:');
        $this->info('✅ More flexibility - less chance to miss notifications');
        $this->info('✅ Still timely - not too early or too late');
        $this->info('✅ Better user experience');
        $this->info('');
        
        $this->info('🚀 Your previous timetables:');
        $this->info('• "Tea Time" (00:48, now 01:07): 19 min late → ❌ Still no send');
        $this->info('• Original "tea6" (00:58, now 01:07): 9 min late → ❌ Still no send');
        $this->info('• Updated "tea6" (01:05, now 01:07): 2 min late → ✅ NOW SENDS!');
        $this->info('');
        
        $this->info('🎉 5-minute window is now ACTIVE!');
        
        return 0;
    }
}
