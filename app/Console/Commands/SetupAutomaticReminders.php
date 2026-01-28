<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupAutomaticReminders extends Command
{
    protected $signature = 'tea:setup-automatic';
    protected $description = 'Setup automatic tea reminder service';

    public function handle()
    {
        $this->info('🚀 SETTING UP AUTOMATIC TEA REMINDERS');
        $this->info(str_repeat('=', 50));
        $this->info('');
        
        $this->info('🤔 Problem: You have to manually run php artisan tea:send-reminders');
        $this->info('🎯 Solution: Automatic service that runs every minute');
        $this->info('');
        
        $this->info('🔧 Available Options:');
        $this->info('');
        
        $this->info('1️⃣  EASIEST - Simple Batch File (Recommended for testing):');
        $this->info('   📁 File: simple-automatic.bat');
        $this->info('   🚀 How: Double-click the file to start');
        $this->info('   ⏰ Runs: Every 60 seconds automatically');
        $this->info('   🛑 Stop: Close the window or press Ctrl+C');
        $this->info('');
        
        $this->info('2️⃣  BETTER - PowerShell Script:');
        $this->info('   📁 File: start-automatic-reminders.ps1');
        $this->info('   🚀 How: Right-click → Run with PowerShell');
        $this->info('   ⏰ Runs: Every 60 seconds automatically');
        $this->info('   🛑 Stop: Close the window or press Ctrl+C');
        $this->info('');
        
        $this->info('3️⃣  BEST - Windows Service (Runs on startup):');
        $this->info('   📁 File: install-windows-service.ps1');
        $this->info('   🚀 How: Run as Administrator');
        $this->info('   ⏰ Runs: 24/7, starts automatically with Windows');
        $this->info('   🛑 Stop: Stop-Service TeaReminderService');
        $this->info('');
        
        $this->info('🎯 QUICK START - EASIEST METHOD:');
        $this->info('1. Navigate to: C:\Laragon\laragon\www\tea2');
        $this->info('2. Double-click: simple-automatic.bat');
        $this->info('3. Keep the window open');
        $this->info('4. Your tea reminders will now be automatic!');
        $this->info('');
        
        $this->info('📱 What Happens Next:');
        $this->info('✅ Service checks every minute for scheduled tea times');
        $this->info('✅ Automatically sends Telegram notifications');
        $this->info('✅ No more manual intervention needed');
        $this->info('✅ Works with all your timetables');
        $this->info('');
        
        $this->info('🔍 How to Verify It\'s Working:');
        $this->info('• Create a new timetable with current time + 2 minutes');
        $this->info('• Wait 2-3 minutes');
        $this->info('• Check Telegram for notification');
        $this->info('• Should arrive automatically without manual commands');
        $this->info('');
        
        $this->info('⚠️  Important Notes:');
        $this->info('• Keep the command window open for the service to run');
        $this->info('• The service uses minimal system resources');
        $this->info('• It will check all your timetables automatically');
        $this->info('• Works with the 5-minute notification window');
        $this->info('');
        
        $this->info('🎉 RESULT:');
        $this->info('🎊 NO MORE MANUAL COMMANDS NEEDED! 🎊');
        $this->info('');
        $this->info('Your tea reminders will now be completely automatic!');
        $this->info('Just start the service and forget about it!');
        
        return 0;
    }
}
