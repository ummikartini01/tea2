<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DiagnoseAutomaticService extends Command
{
    protected $signature = 'tea:diagnose-automatic';
    protected $description = 'Diagnose why automatic service isn\'t working';

    public function handle()
    {
        $this->info('🔍 DIAGNOSING AUTOMATIC SERVICE ISSUE');
        $this->info(str_repeat('=', 50));
        $this->info('');
        
        $this->info('🤔 User Problem: "still the same, for timetable tea11"');
        $this->info('📊 tea11 Status: Scheduled 01:45, Current 01:45, Should send');
        $this->info('❌ Issue: No automatic notification received');
        $this->info('');
        
        $this->info('🔍 POSSIBLE CAUSES:');
        $this->info('');
        
        $this->info('1️⃣  AUTOMATIC SERVICE NOT RUNNING:');
        $this->info('   ❌ User hasn\'t started simple-automatic.bat');
        $this->info('   ❌ Service window was closed');
        $this->info('   ❌ Computer was restarted');
        $this->info('');
        
        $this->info('2️⃣  AUTOMATIC SERVICE RUNNING BUT NOT WORKING:');
        $this->info('   ❌ PHP path issue in the batch file');
        $this->info('   ❌ Laravel project path issue');
        $this->info('   ❌ Permission issues');
        $this->info('   ❌ Command output being suppressed');
        $this->info('');
        
        $this->info('3️⃣  TELEGRAM ISSUES:');
        $this->info('   ❌ Bot token invalid');
        $this->info('   ❌ Chat ID wrong');
        $this->info('   ❌ Network connectivity');
        $this->info('   ❌ Telegram API issues');
        $this->info('');
        
        $this->info('🚀 IMMEDIATE TROUBLESHOOTING:');
        $this->info('');
        
        $this->info('STEP 1: Verify automatic service is running');
        $this->info('• Look for black window with "🍵 Checking for tea reminders..."');
        $this->info('• If not found, double-click simple-automatic.bat');
        $this->info('• Keep the window open');
        $this->info('');
        
        $this->info('STEP 2: Test manual command (to verify system works)');
        $this->info('• Run: php artisan tea:send-reminders');
        $this->info('• If this works, system is OK, issue is with automation');
        $this->info('• If this doesn\'t work, deeper system issue');
        $this->info('');
        
        $this->info('STEP 3: Check the automatic service output');
        $this->info('• The service should show: "[time] 🍵 Checking for tea reminders..."');
        $this->info('• Then: "[time] ✅ Check completed"');
        $this->info('• If showing "❌ Error occurred", there\'s a problem');
        $this->info('');
        
        $this->info('🔧 QUICK FIXES:');
        $this->info('');
        
        $this->info('FIX 1: Restart the automatic service');
        $this->info('1. Close the current service window (if open)');
        $this->info('2. Double-click simple-automatic.bat again');
        $this->info('3. Watch it for 2-3 minutes');
        $this->info('4. Check if it sends notifications');
        $this->info('');
        
        $this->info('FIX 2: Test with visible output');
        $this->info('1. Open Command Prompt manually');
        $this->info('2. Navigate to: C:\\Laragon\\laragon\\www\\tea2');
        $this->info('3. Run: php artisan tea:send-reminders');
        $this->info('4. See what messages appear');
        $this->info('');
        
        $this->info('FIX 3: Check Telegram connectivity');
        $this->info('1. Run: php artisan tea:send-test-message');
        $this->info('2. See if Telegram message is sent');
        $this->info('3. If not, Telegram connection issue');
        $this->info('');
        
        $this->info('🎯 MOST LIKELY ISSUE:');
        $this->info('❌ The automatic service is not actually running');
        $this->info('👉 User thinks it\'s running but it\'s not');
        $this->info('🔧 Solution: Start it properly and keep it open');
        $this->info('');
        
        $this->info('📱 WHAT TO DO RIGHT NOW:');
        $this->info('1. Go to: C:\\Laragon\\laragon\\www\\tea2');
        $this->info('2. Double-click: simple-automatic.bat');
        $this->info('3. Keep the window open and visible');
        $this->info('4. Wait 2-3 minutes');
        $this->info('5. See if tea11 notification appears');
        $this->info('');
        
        $this->info('🎉 IF STILL NOT WORKING:');
        $this->info('• The issue is deeper than just the service');
        $this->info('• Could be PHP path, Laravel setup, or Telegram API');
        $this->info('• Need to check error logs and system configuration');
        
        return 0;
    }
}
