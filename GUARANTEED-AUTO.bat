@echo off
title GUARANTEED Tea Reminder Service
color 0A
echo.
echo  ╔══════════════════════════════════════════════════════════════╗
echo  ║              🍵 GUARANTEED AUTOMATIC SERVICE                 ║
echo  ║                                                              ║
echo  ║  This version is GUARANTEED to work or shows why not        ║
echo  ║                                                              ║
echo  ║  Press Ctrl+C to stop the service                           ║
echo  ╚══════════════════════════════════════════════════════════════╝
echo.

echo [%time%] 🔧 Starting GUARANTEED automatic service...
echo [%time%] 📍 Changing to project directory...
cd /d "C:\Laragon\laragon\www\tea2"
if %errorlevel% neq 0 (
    echo [%time%] ❌ ERROR: Cannot change to project directory!
    echo [%time%] 📍 Current directory: %CD%
    echo [%time%] 💡 Make sure C:\Laragon\laragon\www\tea2 exists
    pause
    exit /b 1
)
echo [%time%] ✅ Directory changed successfully: %CD%

echo [%time%] 🧪 Testing PHP availability...
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [%time%] ❌ ERROR: PHP not found in PATH!
    echo [%time%] 💡 Try using full PHP path or add PHP to Windows PATH
    echo [%time%] 🔍 Common PHP locations:
    echo [%time%]    - C:\php\php.exe
    echo [%time%]    - C:\Laragon\bin\php\php.exe
    echo [%time%]    - C:\xampp\php\php.exe
    pause
    exit /b 1
)
echo [%time%] ✅ PHP is available

echo [%time%] 🧪 Testing Laravel...
php artisan --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [%time%] ❌ ERROR: Laravel not working!
    echo [%time%] 💡 Check if you're in the correct Laravel project directory
    pause
    exit /b 1
)
echo [%time%] ✅ Laravel is working

echo [%time%] 🚀 Starting automatic tea reminder checks...
echo [%time%] 📱 This will run every 60 seconds and show ALL results
echo.

:loop
echo [%time%] 🍵 CHECKING FOR TEA REMINDERS...
echo [%time%] 🔧 Running: php artisan tea:send-reminders
php artisan tea:send-reminders
set result=%errorlevel%
echo [%time%] 📊 Command completed with exit code: %result%

if %result% equ 0 (
    echo [%time%] ✅ SUCCESS: Tea reminder check completed
) else (
    echo [%time%] ❌ ERROR: Tea reminder check failed (exit code %result%)
    echo [%time%] 💡 This might indicate a system issue
)

echo [%time%] ⏰ Waiting 60 seconds before next check...
echo [%time%] 📅 Next check at: 
timeout /t 60 /nobreak >nul
echo.
goto loop
