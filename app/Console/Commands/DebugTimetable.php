<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class DebugTimetable extends Command
{
    protected $signature = 'tea:debug {id=1}';
    protected $description = 'Debug timetable activation and reminder logic';

    public function handle()
    {
        $id = $this->argument('id');
        $timetable = TeaTimetable::find($id);
        
        if (!$timetable) {
            $this->error('❌ Timetable not found!');
            return 1;
        }
        
        $this->info('🔍 Debugging Timetable ID: ' . $id);
        $this->info('🍵 Title: ' . $timetable->title);
        
        // Check dates
        $today = now($timetable->getActualTimezone())->format('Y-m-d');
        $this->info('📅 Today: ' . $today);
        $this->info('📅 Start Date: ' . $timetable->start_date->format('Y-m-d'));
        $this->info('📅 End Date: ' . ($timetable->end_date ? $timetable->end_date->format('Y-m-d') : 'No end date'));
        
        // Check active status
        $this->info('✅ Is Active: ' . ($timetable->is_active ? 'Yes' : 'No'));
        $this->info('🗓️ Active for today: ' . ($timetable->isActiveForDate() ? 'Yes' : 'No'));
        
        // Check today's schedule
        $todaySchedule = $timetable->getTodaySchedule();
        $this->info('📅 Today day: ' . strtolower(now($timetable->getActualTimezone())->format('l')));
        $this->info('📋 Schedule days: ' . implode(', ', array_column($timetable->schedule, 'day')));
        
        if (!empty($todaySchedule['times'])) {
            $this->info('⏰ Today\'s tea times:');
            foreach ($todaySchedule['times'] as $timeSlot) {
                $this->info('   - ' . $timeSlot['time'] . ' (Tea ID: ' . $timeSlot['tea_id'] . ')');
            }
        } else {
            $this->info('⏰ No tea times scheduled for today');
        }
        
        // Check time comparison
        $actualTimezone = $timetable->getActualTimezone();
        $currentTime = now($actualTimezone)->format('H:i');
        $this->info('⏰ Current time: ' . $currentTime);
        
        if (!empty($todaySchedule['times'])) {
            foreach ($todaySchedule['times'] as $timeSlot) {
                $scheduledTime = $timeSlot['time'];
                $this->info('⏰ Scheduled time: ' . $scheduledTime);
                
                // Check if within 5 minutes
                $current = now($actualTimezone);
                $scheduled = $current->copy()->setTimeFromTimeString($scheduledTime);
                $diffInMinutes = abs($current->diffInMinutes($scheduled));
                
                $this->info('⏰ Time difference: ' . $diffInMinutes . ' minutes');
                $this->info('🔔 Should send reminder: ' . ($diffInMinutes <= 5 ? 'Yes' : 'No'));
            }
        }
        
        // Check Telegram settings
        $this->info('📱 Telegram Enabled: ' . ($timetable->telegram_notifications_enabled ? 'Yes' : 'No'));
        $this->info('💬 Chat ID: ' . ($timetable->telegram_chat_id ?: 'Not set'));
        
        // Check overall eligibility
        $eligible = $timetable->is_active 
            && $timetable->telegram_notifications_enabled 
            && $timetable->telegram_chat_id 
            && $timetable->isActiveForDate();
            
        $this->info('🔔 Eligible for reminders: ' . ($eligible ? 'Yes' : 'No'));
        
        return 0;
    }
}
