# PowerShell script for automatic tea reminders
Write-Host "🍵 Starting Automatic Tea Reminder Service..." -ForegroundColor Green
Write-Host "This will run continuously and check for tea times every minute" -ForegroundColor Yellow
Write-Host "Press Ctrl+C to stop the service" -ForegroundColor Red
Write-Host ""

while ($true) {
    Write-Host "[$(Get-Date -Format 'HH:mm:ss')] Checking for tea reminders..." -ForegroundColor Cyan
    
    Set-Location "C:\Laragon\laragon\www\tea2"
    & php artisan tea:send-reminders
    
    Write-Host ""
    Start-Sleep -Seconds 60
}
