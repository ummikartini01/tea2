@echo off
title Tea Reminder Debug Service
color 0C
echo.
echo  ╔══════════════════════════════════════════════════════════════╗
echo  ║                🍵 DEBUG TEA REMINDER SERVICE                ║
echo  ║                                                              ║
echo  ║  This will show ALL output and errors to help debug          ║
echo  ║  why notifications aren't working automatically.             ║
echo  ║                                                              ║
echo  ║  Press Ctrl+C to stop the service                           ║
echo  ╚══════════════════════════════════════════════════════════════╝
echo.

:loop
echo [%time%] 🍵 DEBUG: Checking for tea reminders...
cd /d "C:\Laragon\laragon\www\tea2"
echo [%time%] 📍 Current directory: %CD%
echo [%time%] 🔧 Running: php artisan tea:send-reminders
php artisan tea:send-reminders
echo [%time%] 📊 Exit code: %errorlevel%
echo.
timeout /t 60 /nobreak >nul
goto loop
