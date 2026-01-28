<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;
use App\Services\TelegramBotService;
use Illuminate\Support\Facades\Log;

class SendTeaReminders extends Command
{
    protected $signature = 'tea:send-reminders {--test : Run in test mode}';
    protected $description = 'Send automated tea reminders via Telegram';

    private TelegramBotService $telegramService;

    public function __construct(TelegramBotService $telegramService)
    {
        parent::__construct();
        $this->telegramService = $telegramService;
    }

    public function handle()
    {
        $this->info('Starting tea reminder service...');
        
        $testMode = $this->option('test');
        
        if ($testMode) {
            $this->info('Running in TEST mode');
        }

        // Get all active timetables with Telegram enabled
        $timetables = TeaTimetable::where('is_active', true)
            ->where('telegram_notifications_enabled', true)
            ->whereNotNull('telegram_chat_id')
            ->get();

        $sentCount = 0;
        $failedCount = 0;

        foreach ($timetables as $timetable) {
            if (!$timetable->isActiveForDate()) {
                continue;
            }

            $todaySchedule = $timetable->getTodaySchedule();
            
            if (empty($todaySchedule['times'])) {
                continue;
            }

            foreach ($todaySchedule['times'] as $timeSlot) {
                if ($this->shouldSendReminder($timetable, $timeSlot)) {
                    $success = $testMode 
                        ? $this->testSend($timetable, $timeSlot)
                        : $this->telegramService->sendTeaReminder($timetable, $timeSlot);

                    if ($success) {
                        $sentCount++;
                        $this->info("✅ Sent reminder to {$timetable->user->name} for {$timeSlot['time']}");
                    } else {
                        $failedCount++;
                        $this->error("❌ Failed to send reminder to {$timetable->user->name}");
                    }
                }
            }
        }

        $this->info("Reminder service completed. Sent: {$sentCount}, Failed: {$failedCount}");
        
        return self::SUCCESS;
    }

    private function shouldSendReminder(TeaTimetable $timetable, array $timeSlot): bool
    {
        $actualTimezone = $timetable->getActualTimezone();
        $currentTime = now($actualTimezone);
        $scheduledTime = $currentTime->copy()->setTimeFromTimeString($timeSlot['time']);
        
        // Check if we're within 5 minutes of the scheduled time (before or after)
        $diffInMinutes = abs($currentTime->diffInMinutes($scheduledTime));
        
        return $diffInMinutes <= 5;
    }

    private function testSend(TeaTimetable $timetable, array $timeSlot): bool
    {
        $tea = \App\Models\Tea::find($timeSlot['tea_id']);
        $this->info("🧪 TEST: Would send reminder to {$timetable->telegram_chat_id}");
        $this->info("   Tea: " . ($tea ? $tea->name : 'Tea ID ' . $timeSlot['tea_id']) . " at {$timeSlot['time']}");
        $this->info("   User: {$timetable->user->name}");

        return true; // Simulate success
    }
}
