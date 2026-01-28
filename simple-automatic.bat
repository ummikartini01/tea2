@echo off
title Tea Reminder Service
color 0A
echo.
echo  ╔══════════════════════════════════════════════════════════════╗
echo  ║                🍵 AUTOMATIC TEA REMINDER SERVICE              ║
echo  ║                                                              ║
echo  ║  This service will automatically check and send tea         ║
echo  ║  reminders every minute. No manual intervention needed!     ║
echo  ║                                                              ║
echo  ║  Press Ctrl+C to stop the service                           ║
echo  ╚══════════════════════════════════════════════════════════════╝
echo.

:loop
echo [%time%] 🍵 Checking for tea reminders...
cd /d "C:\Laragon\laragon\www\tea2"
php artisan tea:send-reminders >nul 2>&1
if %errorlevel% equ 0 (
    echo [%time%] ✅ Check completed
) else (
    echo [%time%] ❌ Error occurred
)
echo.
timeout /t 60 /nobreak >nul
goto loop
