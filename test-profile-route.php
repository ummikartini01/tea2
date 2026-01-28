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
    <title>Profile Route Test - Teazy</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #10b981; background: #d1fae5; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .error { color: #ef4444; background: #fee2e2; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .info { color: #3b82f6; background: #dbeafe; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .btn { background: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 4px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn:hover { background: #059669; }
        pre { background: #f3f4f6; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🍵 Profile Route Test</h1>";

echo "<h2>🔍 Route Registration Check:</h2>";

$routes = \Illuminate\Support\Facades\Route::getRoutes();
$profileRoutes = [];

foreach ($routes as $route) {
    if (strpos($route->getName(), 'profile') !== false) {
        $profileRoutes[] = $route;
    }
}

if (!empty($profileRoutes)) {
    echo "<div class='success'>✅ Found " . count($profileRoutes) . " profile routes</div>";
    echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
    echo "<tr><th>Name</th><th>URI</th><th>Methods</th><th>Action</th></tr>";
    foreach ($profileRoutes as $route) {
        echo "<tr>";
        echo "<td>" . $route->getName() . "</td>";
        echo "<td>" . $route->uri() . "</td>";
        echo "<td>" . implode(', ', $route->methods()) . "</td>";
        echo "<td>" . $route->getAction('uses') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div class='error'>❌ No profile routes found</div>";
}

echo "<h2>🔍 Route Generation Test:</h2>";

$testRoutes = [
    'profile' => 'Profile Show',
    'profile.edit' => 'Profile Edit',
    'profile.change-password' => 'Change Password',
    'user.profile.show' => 'User Profile Show (alias)',
    'user.profile.edit' => 'User Profile Edit (alias)'
];

foreach ($testRoutes as $routeName => $description) {
    try {
        $url = route($routeName);
        echo "<div class='success'>✅ {$description}: {$routeName} → {$url}</div>";
    } catch (Exception $e) {
        echo "<div class='error'>❌ {$description}: {$routeName} → " . $e->getMessage() . "</div>";
    }
}

echo "<h2>🔍 Authentication Check:</h2>";

if (\Illuminate\Support\Facades\Auth::check()) {
    $user = \Illuminate\Support\Facades\Auth::user();
    echo "<div class='success'>✅ Logged in as: {$user->name} ({$user->email})</div>";
    
    echo "<h2>🚀 Test Links:</h2>";
    echo "<div class='info'>";
    echo "<a href='" . route('profile') . "' class='btn'>👤 Profile (route)</a>";
    echo "<a href='/dashboard' class='btn'>🏠 Dashboard</a>";
    echo "<a href='/test-profile-route.php' class='btn'>🔄 Refresh Test</a>";
    echo "</div>";
    
} else {
    echo "<div class='error'>❌ Not logged in</div>";
    echo "<div class='info'>";
    echo "<a href='/login' class='btn'>🔐 Login First</a>";
    echo "</div>";
}

echo "<h2>🔧 Debug Info:</h2>";
echo "<pre>";
echo "Current URL: " . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'Not set') . "\n";
echo "HTTP Host: " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'Not set') . "\n";
echo "Base URL: " . url('') . "\n";
echo "App URL: " . config('app.url') . "\n";
echo "</pre>";

echo "</div></body></html>";
?>
