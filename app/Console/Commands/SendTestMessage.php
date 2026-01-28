<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TelegramBotService;

class SendTestMessage extends Command
{
    protected $signature = 'telegram:test-message {chatId=1012190593}';
    protected $description = 'Send a direct test message to Telegram';

    public function handle(TelegramBotService $telegramService)
    {
        $chatId = $this->argument('chatId');
        
        $this->info('📱 Sending test message to ' . $chatId);
        
        $message = "🍵 *Test Message*\n\n";
        $message .= "This is a direct test to verify your Telegram notifications are working!\n\n";
        $message .= "✅ Bot is connected\n";
        $message .= "✅ Chat ID is valid\n";
        $message .= "✅ Message delivery successful\n\n";
        $message .= "You should now receive tea time reminders when scheduled! 🌟";
        
        $success = $telegramService->sendMessage($chatId, $message);
        
        if ($success) {
            $this->info('✅ Test message sent successfully!');
            $this->info('📱 Check your Telegram bot @teazy_reminder_bot');
        } else {
            $this->error('❌ Failed to send test message');
        }
        
        return $success ? 0 : 1;
    }
}
