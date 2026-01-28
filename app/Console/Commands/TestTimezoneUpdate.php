<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class TestTimezoneUpdate extends Command
{
    protected $signature = 'tea:test-timezone-update {id} {timezone}';
    protected $description = 'Test timezone update for a timetable';

    public function handle()
    {
        $id = $this->argument('id');
        $timezone = $this->argument('timezone');
        
        $timetable = TeaTimetable::find($id);
        
        if (!$timetable) {
            $this->error('❌ Timetable not found!');
            return 1;
        }
        
        $this->info('🕐 Testing Timezone Update for Timetable ID: ' . $id);
        $this->info('🍵 Title: ' . $timetable->title);
        $this->info('🌐 Current Timezone: ' . $timetable->timezone);
        $this->info('🔄 Updating to: ' . $timezone);
        
        $timetable->timezone = $timezone;
        $timetable->save();
        
        $this->info('✅ Updated successfully!');
        $this->info('🌐 New Stored Timezone: ' . $timetable->timezone);
        $this->info('🎯 Actual Timezone: ' . $timetable->getActualTimezone());
        
        // Test the timezone functionality
        $this->info('');
        $this->info('🧪 Testing timezone functionality:');
        $this->info('📅 Today: ' . now()->format('Y-m-d'));
        $this->info('🗓️ Active for today: ' . ($timetable->isActiveForDate() ? 'Yes' : 'No'));
        
        return 0;
    }
}
