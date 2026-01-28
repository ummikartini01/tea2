@echo off
echo 🍵 Starting Automatic Tea Reminder Service...
echo.
echo This will run continuously and check for tea times every minute
echo Press Ctrl+C to stop the service
echo.

:loop
echo [%time%] Checking for tea reminders...
cd /d "C:\Laragon\laragon\www\tea2"
php artisan tea:send-reminders
echo.
timeout /t 60 /nobreak >nul
goto loop
