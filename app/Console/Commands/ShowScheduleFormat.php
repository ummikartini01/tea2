<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class ShowScheduleFormat extends Command
{
    protected $signature = 'tea:show-schedule-format {id}';
    protected $description = 'Show the current schedule format for a timetable';

    public function handle()
    {
        $id = $this->argument('id');
        
        $timetable = TeaTimetable::find($id);
        
        if (!$timetable) {
            $this->error('❌ Timetable not found!');
            return 1;
        }
        
        $this->info('📋 Schedule Format for Timetable ID: ' . $id);
        $this->info('🍵 Title: ' . $timetable->title);
        $this->info('');
        
        $this->info('📝 Current Schedule (JSON format):');
        $this->info(json_encode($timetable->schedule, JSON_PRETTY_PRINT));
        $this->info('');
        
        $this->info('📝 Example Formats:');
        $this->info('');
        
        $this->info('🌅 Single day, single time:');
        $this->info(json_encode([
            [
                'day' => 'monday',
                'times' => [
                    [
                        'time' => '09:00',
                        'tea_id' => 2,
                        'notes' => 'Morning green tea'
                    ]
                ]
            ]
        ], JSON_PRETTY_PRINT));
        $this->info('');
        
        $this->info('🌅 Single day, multiple times:');
        $this->info(json_encode([
            [
                'day' => 'monday',
                'times' => [
                    [
                        'time' => '09:00',
                        'tea_id' => 2,
                        'notes' => 'Morning green tea'
                    ],
                    [
                        'time' => '15:00',
                        'tea_id' => 1,
                        'notes' => 'Afternoon black tea'
                    ]
                ]
            ]
        ], JSON_PRETTY_PRINT));
        $this->info('');
        
        $this->info('📅 Multiple days:');
        $this->info(json_encode([
            [
                'day' => 'monday',
                'times' => [
                    [
                        'time' => '09:00',
                        'tea_id' => 2,
                        'notes' => 'Morning green tea'
                    ]
                ]
            ],
            [
                'day' => 'wednesday',
                'times' => [
                    [
                        'time' => '14:00',
                        'tea_id' => 3,
                        'notes' => 'Afternoon tea'
                    ]
                ]
            ]
        ], JSON_PRETTY_PRINT));
        $this->info('');
        
        $this->info('📱 Edit URL:');
        $this->info('http://127.0.0.1:8000/tea-timetables/' . $id . '/edit');
        $this->info('');
        $this->info('💡 Copy the JSON format above and paste it into the Schedule Data field');
        
        return 0;
    }
}
