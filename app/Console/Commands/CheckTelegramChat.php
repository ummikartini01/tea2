<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTelegramChat extends Command
{
    protected $signature = 'telegram:check-chat {chatId}';
    protected $description = 'Check if chat ID is valid for Telegram bot';

    public function handle()
    {
        $chatId = $this->argument('chatId');
        $botToken = config('services.telegram.bot_token');
        
        if (!$botToken) {
            $this->error('❌ No Telegram bot token found in config/services.php');
            return 1;
        }

        $this->info('🔍 Checking chat ID: ' . $chatId);
        $this->info('🤖 Bot: @teazy_reminder_bot');
        
        try {
            // First, try to get chat info
            $response = Http::get("https://api.telegram.org/bot{$botToken}/getChat", [
                'chat_id' => $chatId
            ]);
            
            if ($response->successful()) {
                $chatInfo = $response->json();
                $this->info('✅ Chat ID is valid!');
                $this->info('👤 Chat Type: ' . $chatInfo['result']['type']);
                
                if (isset($chatInfo['result']['first_name'])) {
                    $this->info('👤 Name: ' . $chatInfo['result']['first_name']);
                }
                if (isset($chatInfo['result']['username'])) {
                    $this->info('🆔 Username: @' . $chatInfo['result']['username']);
                }
                
                // Now try to send a simple message
                $this->info('📤 Sending test message...');
                $messageResponse = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => '🍵 Hello from Tea Reminder Bot! Your chat ID is working correctly.',
                ]);
                
                if ($messageResponse->successful()) {
                    $this->info('✅ Test message sent successfully!');
                    $this->info('📱 Check your Telegram app for the message.');
                    return 0;
                } else {
                    $this->error('❌ Failed to send message:');
                    $this->error('Response: ' . $messageResponse->body());
                    return 1;
                }
            } else {
                $this->error('❌ Chat ID is invalid or bot cannot access this chat');
                $this->error('Response: ' . $response->body());
                $this->info('💡 Make sure you have:');
                $this->info('   1. Started a chat with @teazy_reminder_bot');
                $this->info('   2. Sent at least one message to the bot');
                $this->info('   3. Not blocked the bot');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Error checking chat: ' . $e->getMessage());
            Log::error('Telegram chat check failed: ' . $e->getMessage());
            return 1;
        }
    }
}
