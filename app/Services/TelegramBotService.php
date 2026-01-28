<?php

namespace App\Services;

use App\Models\TeaTimetable;
use App\Models\Tea;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramBotService
{
    private ?string $botToken;
    private string $apiUrl;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        if ($this->botToken) {
            $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
        } else {
            $this->apiUrl = '';
        }
    }

    public function sendMessage(string $chatId, string $message, array $keyboard = null): bool
    {
        if (!$this->botToken) {
            Log::error('Telegram bot token not configured');
            return false;
        }

        try {
            $payload = [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];

            if ($keyboard) {
                $payload['reply_markup'] = json_encode([
                    'inline_keyboard' => $keyboard
                ]);
            }

            $response = Http::post("{$this->apiUrl}/sendMessage", $payload);
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Telegram send message failed: ' . $e->getMessage());
            return false;
        }
    }

    public function sendTeaReminder(TeaTimetable $timetable, array $timeSlot): bool
    {
        if (!$timetable->telegram_notifications_enabled || !$timetable->telegram_chat_id) {
            return false;
        }

        $tea = Tea::find($timeSlot['tea_id']);
        if (!$tea) {
            return false;
        }

        $time = date('g:i A', strtotime($timeSlot['time']));
        $teaName = $tea->name;
        $teaFlavor = $tea->flavor;
        $caffeineLevel = $tea->caffeine_level;
        
        $message = "🍵 *Tea Time Reminder!*\n\n";
        $message .= "⏰ *Time:* {$time}\n";
        $message .= "🍃 *Tea:* {$teaName}\n";
        $message .= "⚡ *Caffeine Level:* {$caffeineLevel}\n";
        $message .= "🌿 *Flavor:* {$teaFlavor}\n";
        
        if (!empty($timeSlot['notes'])) {
            $message .= "📝 *Notes:* {$timeSlot['notes']}\n";
        }
        
        $message .= "\nEnjoy your tea! 🌟";
        
        $keyboard = [
            [
                ['text' => "☕ I had my tea!", 'callback_data' => "tea_had_{$timetable->id}_{$timeSlot['tea_id']}"],
                ['text' => "⏰ Remind me in 10 mins", 'callback_data' => "remind_{$timetable->id}_{$timeSlot['tea_id']}_10"]
            ],
            [
                ['text' => "📋 View My Schedule", 'callback_data' => "view_schedule_{$timetable->id}"]
            ]
        ];

        return $this->sendMessage($timetable->telegram_chat_id, $message, $keyboard);
    }

    public function sendDailySummary(TeaTimetable $timetable): bool
    {
        if (!$timetable->telegram_notifications_enabled || !$timetable->telegram_chat_id) {
            return false;
        }

        $todaySchedule = $timetable->getTodaySchedule();
        
        if (empty($todaySchedule['times'])) {
            return false;
        }

        $message = $this->formatDailySummary($timetable, $todaySchedule);
        
        return $this->sendMessage($timetable->telegram_chat_id, $message);
    }

    public function sendWeeklySummary(TeaTimetable $timetable): bool
    {
        if (!$timetable->telegram_notifications_enabled || !$timetable->telegram_chat_id) {
            return false;
        }

        $message = $this->formatWeeklySummary($timetable);
        
        return $this->sendMessage($timetable->telegram_chat_id, $message);
    }

    private function formatTeaReminder(Tea $tea, array $timeSlot, TeaTimetable $timetable): string
    {
        $emoji = $this->getTeaEmoji($tea->flavor);
        $time = date('g:i A', strtotime($timeSlot['time']));
        
        $message = "<b>🍵 Tea Time Reminder!</b>\n\n";
        $message .= "{$emoji} <b>{$tea->name}</b>\n";
        $message .= "⏰ Scheduled for: {$time}\n";
        $message .= "🍃 Flavor: {$tea->flavor}\n";
        $message .= "⚡ Caffeine: {$tea->caffeine_level}\n";
        
        if (!empty($timeSlot['notes'])) {
            $message .= "📝 Notes: {$timeSlot['notes']}\n";
        }
        
        if (!empty($tea->health_benefit)) {
            $message .= "🌿 Benefit: " . substr($tea->health_benefit, 0, 100) . "...\n";
        }
        
        $message .= "\n<i>Enjoy your tea moment! ☕</i>";
        
        return $message;
    }

    private function formatDailySummary(TeaTimetable $timetable, array $todaySchedule): string
    {
        $dayName = now($timetable->timezone)->format('l');
        $message = "<b>☕ Today's Tea Schedule - {$dayName}</b>\n\n";
        
        foreach ($todaySchedule['times'] as $index => $timeSlot) {
            $tea = Tea::find($timeSlot['tea_id']);
            if (!$tea) continue;
            
            $time = date('g:i A', strtotime($timeSlot['time']));
            $teaName = $tea->name;
            $teaFlavor = $tea->flavor;
            $caffeineLevel = $tea->caffeine_level;
            $emoji = $this->getTeaEmoji($tea->flavor);
            
            $message .= "{$emoji} <b>{$time}</b> - {$teaName}\n";
            
            if (!empty($timeSlot['notes'])) {
                $message .= "   📝 {$timeSlot['notes']}\n";
            }
            
            $message .= "\n";
        }
        
        $message .= "<i>Have a wonderful tea-filled day! 🍵</i>";
        
        return $message;
    }

    private function formatWeeklySummary(TeaTimetable $timetable): string
    {
        $message = "<b>📅 Weekly Tea Schedule Summary</b>\n\n";
        $message .= "<i>Timetable: {$timetable->title}</i>\n\n";
        
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        foreach ($days as $index => $day) {
            $schedule = $timetable->getScheduleForDay($day);
            
            if (!empty($schedule['times'])) {
                $message .= "<b>{$dayNames[$index]}:</b>\n";
                
                foreach ($schedule['times'] as $timeSlot) {
                    $tea = Tea::find($timeSlot['tea_id']);
                    if (!$tea) continue;
                    
                    $time = date('g:i A', strtotime($timeSlot['time']));
                    $teaName = $tea->name;
                    $teaFlavor = $tea->flavor;
                    $caffeineLevel = $tea->caffeine_level;
                    $emoji = $this->getTeaEmoji($tea->flavor);
                    
                    $message .= "  {$emoji} {$time} - {$teaName}\n";
                }
                
                $message .= "\n";
            }
        }
        
        $message .= "<i>Stay hydrated and enjoy your tea journey! 🍵✨</i>";
        
        return $message;
    }

    private function getTeaEmoji(string $flavor): string
    {
        $emojis = [
            'herbal' => '🌿',
            'bitter' => '🍃',
            'sweet' => '🍯',
            'fruity' => '🍓',
            'spicy' => '🌶️',
            'minty' => '🌱',
            'various' => '🎨',
            'n/a' => '☕',
        ];

        return $emojis[strtolower($flavor)] ?? '☕';
    }

    public function handleCallback(array $callback): bool
    {
        $chatId = $callback['message']['chat']['id'];
        $data = $callback['data'];

        // Parse callback data
        $parts = explode('_', $data);
        $action = $parts[0];

        switch ($action) {
            case 'tea_had':
                return $this->handleTeaHad($chatId, $parts[1], $parts[2]);
            
            case 'remind':
                return $this->handleRemind($chatId, $parts[1], $parts[2], $parts[3]);
            
            case 'view_schedule':
                return $this->handleViewSchedule($chatId, $parts[1]);
            
            default:
                return false;
        }
    }

    private function handleTeaHad(string $chatId, string $timetableId, string $teaId): bool
    {
        $message = "🎉 Great job! You've had your tea!\n\n";
        $message .= "Keep up with your tea routine for better health and wellness. 🍵✨";
        
        return $this->sendMessage($chatId, $message);
    }

    private function handleRemind(string $chatId, string $timetableId, string $teaId, string $minutes): bool
    {
        // This would typically queue a delayed reminder
        $message = "⏰ I'll remind you again in {$minutes} minutes!";
        
        return $this->sendMessage($chatId, $message);
    }

    private function handleViewSchedule(string $chatId, string $timetableId): bool
    {
        $timetable = TeaTimetable::find($timetableId);
        if (!$timetable) return false;

        return $this->sendDailySummary($timetable);
    }
}
