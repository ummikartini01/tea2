<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>URL Configuration Check - Teazy</title>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .test-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .tea-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }
        h1 { color: #1f2937; text-align: center; margin-bottom: 10px; }
        .subtitle { color: #6b7280; text-align: center; margin-bottom: 30px; }
        .btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        .status {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .success { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        .error { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        .info { background: #dbeafe; color: #1e40af; border: 1px solid #3b82f6; }
        .warning { background: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
    </style>
</head>
<body>
    <div class='test-container'>
        <div class='tea-logo'>🍵</div>
        <h1>URL Configuration Check</h1>
        <p class='subtitle'>Diagnose URL and routing issues</p>";

echo "<h3>🔍 Current Configuration:</h3>";
echo "<div class='status info'>";
echo "<strong>APP_URL:</strong> " . config('app.url') . "<br>";
echo "<strong>Current URL:</strong> " . url('/') . "<br>";
echo "<strong>Request URL:</strong> " . request()->url() . "<br>";
echo "<strong>Base URL:</strong> " . url('') . "<br>";
echo "<strong>Asset URL:</strong> " . asset('') . "<br>";
echo "</div>";

echo "<h3>🔧 Environment Settings:</h3>";
echo "<div class='status info'>";
echo "<strong>App Environment:</strong> " . app()->environment() . "<br>";
echo "<strong>Debug Mode:</strong> " . (config('app.debug') ? 'Enabled' : 'Disabled') . "<br>";
echo "<strong>URL Generation:</strong> " . url('/dashboard') . "<br>";
echo "<strong>Route 'dashboard':</strong> " . route('dashboard') . "<br>";
echo "</div>";

echo "<h3>🔍 Route Check:</h3>";
$routes = \Illuminate\Support\Facades\Route::getRoutes();
$dashboardRoute = null;

foreach ($routes as $route) {
    if ($route->getName() === 'dashboard') {
        $dashboardRoute = $route;
        break;
    }
}

if ($dashboardRoute) {
    echo "<div class='status success'>";
    echo "✅ Dashboard route found<br>";
    echo "URI: " . $dashboardRoute->uri() . "<br>";
    echo "Name: " . $dashboardRoute->getName() . "<br>";
    echo "Methods: " . implode(', ', $dashboardRoute->methods()) . "<br>";
    echo "Action: " . $dashboardRoute->getAction('uses') . "<br>";
    echo "</div>";
} else {
    echo "<div class='status error'>❌ Dashboard route NOT found</div>";
}

echo "<h3>🌐 Access URLs:</h3>";
echo "<div class='status info'>";
echo "<strong>Localhost:</strong> <a href='http://localhost/tea2/dashboard' class='btn'>http://localhost/tea2/dashboard</a><br>";
echo "<strong>Tea2.test:</strong> <a href='http://tea2.test/dashboard' class='btn'>http://tea2.test/dashboard</a><br>";
echo "<strong>Current:</strong> " . request()->getHost() . "<br>";
echo "</div>";

echo "<h3>🔧 Possible Solutions:</h3>";
echo "<div class='status warning'>";
echo "<strong>If tea2.test doesn't work:</strong><br>";
echo "1. Check your hosts file (C:\\Windows\\System32\\drivers\\etc\\hosts)<br>";
echo "2. Add: 127.0.0.1 tea2.test<br>";
echo "3. Configure your web server (Apache/Nginx) for tea2.test<br>";
echo "4. Or use: http://localhost/tea2/dashboard<br>";
echo "</div>";

echo "<h3>🚀 Quick Test:</h3>";
echo "<div class='status info'>";
echo "<a href='/dashboard' class='btn'>Try /dashboard</a>";
echo "<a href='/tea2/dashboard' class='btn'>Try /tea2/dashboard</a>";
echo "<a href='/check-url-config.php' class='btn'>Refresh Check</a>";
echo "</div>";

echo "<h3>🔧 Virtual Host Check:</h3>";
echo "<div class='status info'>";
echo "<strong>Server Name:</strong> " . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'Not set') . "<br>";
echo "<strong>HTTP Host:</strong> " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'Not set') . "<br>";
echo "<strong>Request URI:</strong> " . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'Not set') . "<br>";
echo "</div>";

echo "</div></body></html>";
?>
