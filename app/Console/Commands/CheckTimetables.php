<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class CheckTimetables extends Command
{
    protected $signature = 'tea:check-timetables';
    protected $description = 'Check all tea timetables and their status';

    public function handle()
    {
        $this->info('🔍 Checking all tea timetables...');
        
        $timetables = TeaTimetable::all();
        
        if ($timetables->isEmpty()) {
            $this->error('❌ No timetables found in database!');
            return 1;
        }
        
        $this->info('📊 Found ' . $timetables->count() . ' timetables:');
        
        foreach ($timetables as $timetable) {
            $this->info("\n" . str_repeat('=', 50));
            $this->info("🍵 Timetable: " . $timetable->title);
            $this->info("📝 Description: " . ($timetable->description ?: 'None'));
            $this->info("📅 Start Date: " . $timetable->start_date->format('Y-m-d'));
            $this->info("📅 End Date: " . ($timetable->end_date ? $timetable->end_date->format('Y-m-d') : 'No end date'));
            $this->info("⏰ Timezone: " . $timetable->timezone);
            $this->info("✅ Active: " . ($timetable->is_active ? 'Yes' : 'No'));
            $this->info("📱 Telegram Enabled: " . ($timetable->telegram_notifications_enabled ? 'Yes' : 'No'));
            $this->info("💬 Chat ID: " . ($timetable->telegram_chat_id ?: 'Not set'));
            $this->info("📅 Created: " . $timetable->created_at->format('Y-m-d H:i:s'));
            
            // Check if active for today
            $isActiveForDate = $timetable->isActiveForDate();
            $this->info("🗓️ Active for today: " . ($isActiveForDate ? 'Yes' : 'No'));
            
            // Get today's schedule
            $todaySchedule = $timetable->getTodaySchedule();
            if (!empty($todaySchedule['times'])) {
                $this->info("⏰ Today's tea times:");
                foreach ($todaySchedule['times'] as $timeSlot) {
                    $this->info("   - " . $timeSlot['time'] . " (Tea ID: " . $timeSlot['tea_id'] . ")");
                }
            } else {
                $this->info("⏰ No tea times scheduled for today");
            }
            
            // Check if eligible for reminders
            $eligibleForReminders = $timetable->is_active 
                && $timetable->telegram_notifications_enabled 
                && $timetable->telegram_chat_id 
                && $isActiveForDate;
                
            $this->info("🔔 Eligible for reminders: " . ($eligibleForReminders ? 'Yes' : 'No'));
        }
        
        return 0;
    }
}
