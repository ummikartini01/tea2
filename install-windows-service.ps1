# PowerShell script to install tea reminder as a Windows service
Write-Host "🔧 Installing Tea Reminder as Windows Service..." -ForegroundColor Green

# Check if running as Administrator
if (-NOT ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")) {
    Write-Host "❌ Please run this script as Administrator!" -ForegroundColor Red
    Write-Host "Right-click PowerShell and select 'Run as Administrator'" -ForegroundColor Yellow
    pause
    exit 1
}

# Service details
$serviceName = "TeaReminderService"
$displayName = "Tea Reminder Service"
$description = "Automatic tea reminder notification service"
$scriptPath = "C:\Laragon\laragon\www\tea2\start-automatic-reminders.ps1"

# Create the service script
$serviceScript = @"
# Service wrapper for tea reminders
while (`$true) {
    try {
        Set-Location "C:\Laragon\laragon\www\tea2"
        & php artisan tea:send-reminders
    } catch {
        Write-Host "Error: `$_" -ForegroundColor Red
    }
    Start-Sleep -Seconds 60
}
"@

$serviceScript | Out-File -FilePath "C:\Laragon\laragon\www\tea2\tea-reminder-service.ps1" -Encoding UTF8

# Install the service using NSSM (Non-Sucking Service Manager)
Write-Host "📦 Installing service with NSSM..." -ForegroundColor Yellow

# Check if NSSM is available
$nssmPath = "C:\nssm\nssm.exe"
if (-not (Test-Path $nssmPath)) {
    Write-Host "📥 Downloading NSSM..." -ForegroundColor Yellow
    $nssmUrl = "https://nssm.cc/release/nssm-2.24.zip"
    $nssmZip = "C:\nssm.zip"
    
    # Create directory
    New-Item -ItemType Directory -Path "C:\nssm" -Force | Out-Null
    
    # Download NSSM
    Invoke-WebRequest -Uri $nssmUrl -OutFile $nssmZip
    
    # Extract
    Expand-Archive -Path $nssmZip -DestinationPath "C:\nssm" -Force
    
    # Find the correct architecture
    if ([Environment]::Is64BitOperatingSystem) {
        $nssmPath = "C:\nssm\nssm-2.24\win64\nssm.exe"
    } else {
        $nssmPath = "C:\nssm\nssm-2.24\win32\nssm.exe"
    }
}

if (Test-Path $nssmPath) {
    # Install the service
    & $nssmPath install $serviceName powershell.exe -ExecutionPolicy Bypass -File "C:\Laragon\laragon\www\tea2\tea-reminder-service.ps1"
    
    # Set service properties
    & $nssmPath set $serviceName DisplayName $displayName
    & $nssmPath set $serviceName Description $description
    & $nssmPath set $serviceName Start SERVICE_AUTO_START
    
    Write-Host "✅ Service installed successfully!" -ForegroundColor Green
    Write-Host "🚀 Starting service..." -ForegroundColor Yellow
    
    # Start the service
    Start-Service -Name $serviceName
    
    Write-Host "✅ Tea Reminder Service is now running!" -ForegroundColor Green
    Write-Host "📱 It will automatically check and send notifications every minute" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "To manage the service:" -ForegroundColor Yellow
    Write-Host "• Stop:  Stop-Service TeaReminderService" -ForegroundColor White
    Write-Host "• Start: Start-Service TeaReminderService" -ForegroundColor White
    Write-Host "• Remove: & 'C:\nssm\nssm-2.24\win64\nssm.exe' remove TeaReminderService" -ForegroundColor White
} else {
    Write-Host "❌ Failed to install NSSM" -ForegroundColor Red
    Write-Host "🔄 Falling back to manual startup method..." -ForegroundColor Yellow
    
    # Create startup shortcut
    $shell = New-Object -ComObject WScript.Shell
    $shortcut = $shell.CreateShortcut("$env:APPDATA\Microsoft\Windows\Start Menu\Programs\Startup\Tea Reminder.lnk")
    $shortcut.TargetPath = "powershell.exe"
    $shortcut.Arguments = "-ExecutionPolicy Bypass -File `"$scriptPath`""
    $shortcut.WorkingDirectory = "C:\Laragon\laragon\www\tea2"
    $shortcut.Save()
    
    Write-Host "✅ Created startup shortcut!" -ForegroundColor Green
    Write-Host "🔄 The service will start automatically when you log in" -ForegroundColor Cyan
}

Write-Host ""
Write-Host "🎉 Installation complete!" -ForegroundColor Green
Write-Host "📱 Your tea reminders will now be sent automatically!" -ForegroundColor Cyan
pause
