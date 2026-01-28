<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TelegramButtonsInfo extends Command
{
    protected $signature = 'tea:telegram-buttons-info';
    protected $description = 'Show information about the new Telegram buttons';

    public function handle()
    {
        $this->info('📱 TELEGRAM BUTTONS - ADDED SUCCESSFULLY!');
        $this->info(str_repeat('=', 50));
        $this->info('');
        
        $this->info('🎯 New Telegram Buttons Added:');
        $this->info('');
        
        $this->info('1️⃣  My Tea Timetables Page (Top):');
        $this->info('   📍 Location: Top right of the page');
        $this->info('   🎨 Style: Blue button with Telegram icon');
        $this->info('   📱 Text: "📱 Teazy Bot"');
        $this->info('   🔗 Link: https://t.me/teazy_reminder_bot');
        $this->info('   🚀 Action: Opens Teazy Bot in new tab');
        $this->info('');
        
        $this->info('2️⃣  My Tea Timetables Page (Each Card):');
        $this->info('   📍 Location: Next to View/Edit/Delete buttons');
        $this->info('   🎨 Style: Blue text link with Telegram icon');
        $this->info('   📱 Text: "Bot"');
        $this->info('   🔗 Link: https://t.me/teazy_reminder_bot');
        $this->info('   🚀 Action: Opens Teazy Bot in new tab');
        $this->info('');
        
        $this->info('3️⃣  Individual Timetable Page:');
        $this->info('   📍 Location: Top action buttons area');
        $this->info('   🎨 Style: Blue button with Telegram icon');
        $this->info('   📱 Text: "📱 Chat with Teazy Bot"');
        $this->info('   🔗 Link: https://t.me/teazy_reminder_bot');
        $this->info('   🚀 Action: Opens Teazy Bot in new tab');
        $this->info('');
        
        $this->info('🌟 Benefits:');
        $this->info('✅ Easy access to Teazy Bot from any page');
        $this->info('✅ No need to search for bot manually');
        $this->info('✅ Quick chat access for support');
        $this->info('✅ Professional user experience');
        $this->info('✅ Opens in new tab (doesn\'t lose your place)');
        $this->info('');
        
        $this->info('📱 Visit Your Pages:');
        $this->info('🏠 Main: http://127.0.0.1:8000/tea-timetables');
        $this->info('📋 Individual: http://127.0.0.1:8000/tea-timetables/[id]');
        $this->info('');
        
        $this->info('🎉 Users can now easily access Teazy Bot anytime!');
        
        return 0;
    }
}
