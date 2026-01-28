@echo off
echo Starting Tea Reminder Service...
echo Press Ctrl+C to stop
echo.

:loop
cd /d C:\Laragon\laragon\www\tea2
echo [%time%] Checking for tea reminders...
php artisan tea:send-reminders
timeout /t 60 /nobreak > nul
goto loop
