# Tea Reminder PowerShell Script
# Run this every minute to send tea notifications

Set-Location -Path "C:\Laragon\laragon\www\tea2"
php artisan tea:send-reminders
