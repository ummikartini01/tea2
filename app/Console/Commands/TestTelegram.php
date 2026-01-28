<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TelegramBotService;

class TestTelegram extends Command
{
    protected $signature = 'telegram:test {chat_id}';
    protected $description = 'Test Telegram bot connection';

    public function handle(TelegramBotService $telegramService)
    {
        $chatId = $this->argument('chat_id');
        
        $this->info("Testing Telegram connection to chat ID: {$chatId}");
        
        $message = "🍵 *Test Message from Smart Tea System*\n\n";
        $message .= "✅ Bot is working correctly!\n";
        $message .= "⏰ Time: " . now()->format('Y-m-d H:i:s') . "\n";
        $message .= "🚀 Your tea timetable system is ready!";
        
        $success = $telegramService->sendMessage($chatId, $message);
        
        if ($success) {
            $this->info("✅ Test message sent successfully!");
        } else {
            $this->error("❌ Failed to send test message");
            $this->line("Check your bot token and chat ID");
        }
        
        return $success ? self::SUCCESS : self::FAILURE;
    }
}
