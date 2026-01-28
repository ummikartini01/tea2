<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestTelegramToken extends Command
{
    protected $signature = 'telegram:test-token';
    protected $description = 'Test Telegram bot token validity';

    public function handle()
    {
        $botToken = config('services.telegram.bot_token');
        
        if (!$botToken) {
            $this->error('❌ No Telegram bot token found in config/services.php');
            return 1;
        }

        $this->info('🔍 Testing Telegram bot token...');
        $this->info('Token: ' . substr($botToken, 0, 10) . '...');
        
        try {
            $response = Http::get("https://api.telegram.org/bot{$botToken}/getMe");
            
            if ($response->successful()) {
                $botInfo = $response->json();
                $this->info('✅ Bot token is valid!');
                $this->info('🤖 Bot Name: ' . $botInfo['result']['first_name']);
                $this->info('🆔 Bot Username: @' . $botInfo['result']['username']);
                $this->info('🆔 Bot ID: ' . $botInfo['result']['id']);
                return 0;
            } else {
                $this->error('❌ Bot token is invalid!');
                $this->error('Response: ' . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Error testing bot token: ' . $e->getMessage());
            Log::error('Telegram token test failed: ' . $e->getMessage());
            return 1;
        }
    }
}
