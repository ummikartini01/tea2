@echo off
echo Testing basic functionality...
echo Current directory: %CD%
echo.

echo Testing PHP...
php --version
echo.

echo Testing Laravel...
php artisan --version
echo.

echo Testing tea reminders...
php artisan tea:send-reminders
echo.

echo Test complete!
pause
