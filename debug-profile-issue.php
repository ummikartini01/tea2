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
    <title>Profile Issue Debug - Teazy</title>
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
            max-width: 800px;
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
        pre { background: #f3f4f6; padding: 10px; border-radius: 4px; overflow-x: auto; font-size: 12px; }
    </style>
</head>
<body>
    <div class='test-container'>
        <div class='tea-logo'>🍵</div>
        <h1>Profile Issue Debug</h1>
        <p class='subtitle'>Diagnose profile link not working</p>";

echo "<h3>🔍 Current Request Info:</h3>";
echo "<div class='status info'>";
echo "<strong>Current URL:</strong> " . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'Not set') . "<br>";
echo "<strong>HTTP Host:</strong> " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'Not set') . "<br>";
echo "<strong>Server Name:</strong> " . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'Not set') . "<br>";
echo "<strong>Port:</strong> " . (isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : 'Not set') . "<br>";
echo "<strong>Request Method:</strong> " . (isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'Not set') . "<br>";
echo "</div>";

echo "<h3>🔍 Authentication Status:</h3>";

if (\Illuminate\Support\Facades\Auth::check()) {
    $user = \Illuminate\Support\Facades\Auth::user();
    echo "<div class='status success'>";
    echo "✅ User is authenticated<br>";
    echo "ID: {$user->id}<br>";
    echo "Name: {$user->name}<br>";
    echo "Email: {$user->email}<br>";
    echo "Role: {$user->role}<br>";
    echo "</div>";
} else {
    echo "<div class='status error'>❌ User is NOT authenticated</div>";
    echo "<div class='status warning'>You need to login first</div>";
    echo "<div class='status info'>";
    echo "<a href='/login' class='btn'>Login Now</a>";
    echo "</div>";
}

echo "<h3>🔍 Route Registration Check:</h3>";

$routes = \Illuminate\Support\Facades\Route::getRoutes();
$profileRoutes = [];

foreach ($routes as $route) {
    if (strpos($route->getName(), 'profile') !== false) {
        $profileRoutes[] = $route;
    }
}

if (!empty($profileRoutes)) {
    echo "<div class='status success'>";
    echo "✅ Found " . count($profileRoutes) . " profile routes:<br>";
    foreach ($profileRoutes as $route) {
        echo "- " . $route->getName() . " (" . $route->uri() . ")<br>";
    }
    echo "</div>";
} else {
    echo "<div class='status error'>❌ No profile routes found</div>";
}

echo "<h3>🔍 Specific Profile Route Check:</h3>";

$profileRoute = null;
foreach ($routes as $route) {
    if ($route->getName() === 'user.profile.show') {
        $profileRoute = $route;
        break;
    }
}

if ($profileRoute) {
    echo "<div class='status success'>";
    echo "✅ user.profile.show route found<br>";
    echo "URI: " . $profileRoute->uri() . "<br>";
    echo "Name: " . $profileRoute->getName() . "<br>";
    echo "Methods: " . implode(', ', $profileRoute->methods()) . "<br>";
    echo "Action: " . $profileRoute->getAction('uses') . "<br>";
    echo "Generated URL: " . route('user.profile.show') . "<br>";
    echo "</div>";
} else {
    echo "<div class='status error'>❌ user.profile.show route NOT found</div>";
}

echo "<h3>🔍 Controller and View Check:</h3>";

$controllerClass = 'App\Http\Controllers\User\ProfileController';
$viewName = 'user.profile.show';

echo "<div class='status info'>";

// Controller check
if (class_exists($controllerClass)) {
    echo "✅ ProfileController exists<br>";
    if (method_exists($controllerClass, 'show')) {
        echo "✅ show method exists<br>";
    } else {
        echo "❌ show method missing<br>";
    }
} else {
    echo "❌ ProfileController missing<br>";
}

// View check
if (view()->exists($viewName)) {
    echo "✅ Profile view exists<br>";
} else {
    echo "❌ Profile view missing<br>";
    echo "Looking for: resources/views/user/profile/show.blade.php<br>";
}

echo "</div>";

echo "<h3>🔍 Test Profile Controller Directly:</h3>";

try {
    $controller = new \App\Http\Controllers\User\ProfileController();
    
    // Mock request
    $request = new \Illuminate\Http\Request();
    
    echo "<div class='status info'>";
    echo "Testing ProfileController::show()...<br>";
    
    if (\Illuminate\Support\Facades\Auth::check()) {
        // Try to call the show method
        $response = $controller->show($request);
        
        if ($response instanceof \Illuminate\View\View) {
            echo "✅ Controller returns View object<br>";
            echo "View name: " . $response->getName() . "<br>";
            echo "Data keys: " . implode(', ', array_keys($response->getData())) . "<br>";
        } else {
            echo "❌ Controller does not return View<br>";
            echo "Response type: " . gettype($response) . "<br>";
        }
    } else {
        echo "❌ Cannot test controller - user not authenticated<br>";
    }
    echo "</div>";
    
} catch (\Exception $e) {
    echo "<div class='status error'>";
    echo "❌ Controller error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    echo "</div>";
}

echo "<h3>🔍 Sidebar Link Test:</h3>";
echo "<div class='status info'>";
echo "Sidebar link should point to: " . route('user.profile.show') . "<br>";
echo "Full URL: " . url(route('user.profile.show')) . "<br>";
echo "</div>";

echo "<h3>🚀 Test Links:</h3>";
echo "<div class='status info'>";

if (\Illuminate\Support\Facades\Auth::check()) {
    echo "<a href='" . route('user.profile.show') . "' class='btn'>Try Profile Page</a>";
    echo "<a href='/dashboard' class='btn'>Dashboard</a>";
    echo "<a href='/debug-profile-issue.php' class='btn'>Refresh Debug</a>";
} else {
    echo "<a href='/login' class='btn'>Login First</a>";
}

echo "</div>";

echo "<h3>🔧 Possible Solutions:</h3>";
echo "<div class='status warning'>";
echo "<strong>If profile link shows blank page:</strong><br>";
echo "1. Check browser console for JavaScript errors<br>";
echo "2. Check Laravel logs (storage/logs/laravel.log)<br>";
echo "3. Try accessing profile directly via URL<br>";
echo "4. Check if view file exists and has correct syntax<br>";
echo "5. Verify all required data is passed to view<br>";
echo "</div>";

echo "</div></body></html>";
?>
