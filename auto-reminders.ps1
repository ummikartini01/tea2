# PowerShell Automatic Tea Reminders
Write-Host "🍵 AUTOMATIC TEA REMINDER SERVICE (PowerShell)" -ForegroundColor Green
Write-Host "==============================================" -ForegroundColor Yellow
Write-Host "Press Ctrl+C to stop" -ForegroundColor Red
Write-Host ""

# Test if we're in the right directory
if (-not (Test-Path "artisan")) {
    Write-Host "❌ ERROR: Not in Laravel project directory!" -ForegroundColor Red
    Write-Host "💡 Please navigate to C:\Laragon\laragon\www\tea2 first" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host "✅ Laravel project detected" -ForegroundColor Green

# Test PHP
try {
    $phpVersion = & php --version 2>$null
    Write-Host "✅ PHP working: $phpVersion" -ForegroundColor Green
} catch {
    Write-Host "❌ ERROR: PHP not working!" -ForegroundColor Red
    Write-Host "💡 Make sure PHP is in your PATH" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host "🚀 Starting automatic reminders..." -ForegroundColor Cyan
Write-Host ""

while ($true) {
    Write-Host "[$(Get-Date -Format 'HH:mm:ss')] 🍵 Checking for tea reminders..." -ForegroundColor Cyan
    
    try {
        Set-Location "C:\Laragon\laragon\www\tea2"
        & php artisan tea:send-reminders
        Write-Host "[$(Get-Date -Format 'HH:mm:ss')] ✅ Check completed" -ForegroundColor Green
    } catch {
        Write-Host "[$(Get-Date -Format 'HH:mm:ss')] ❌ Error: $_" -ForegroundColor Red
    }
    
    Write-Host "[$(Get-Date -Format 'HH:mm:ss')] ⏰ Waiting 60 seconds..." -ForegroundColor Yellow
    Write-Host ""
    
    Start-Sleep -Seconds 60
}
