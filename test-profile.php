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
    <title>Profile Debug - Teazy</title>
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
            max-width: 700px;
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
        <h1>Profile Debug</h1>
        <p class='subtitle'>Diagnose profile page issues</p>";

echo "<h3>🔍 Authentication Check:</h3>";

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
    exit;
}

echo "<h3>🔧 Controller Check:</h3>";

$controllerClass = 'App\Http\Controllers\User\ProfileController';
if (class_exists($controllerClass)) {
    echo "<div class='status success'>✅ ProfileController exists</div>";
    
    if (method_exists($controllerClass, 'show')) {
        echo "<div class='status success'>✅ show method exists</div>";
    } else {
        echo "<div class='status error'>❌ show method missing</div>";
    }
} else {
    echo "<div class='status error'>❌ ProfileController missing</div>";
}

echo "<h3>🔧 View Check:</h3>";

$viewName = 'user.profile.show';
if (view()->exists($viewName)) {
    echo "<div class='status success'>✅ Profile view exists</div>";
} else {
    echo "<div class='status error'>❌ Profile view missing</div>";
    echo "<div class='status info'>Looking for: resources/views/user/profile/show.blade.php</div>";
}

echo "<h3>🔧 Route Check:</h3>";

$routes = \Illuminate\Support\Facades\Route::getRoutes();
$profileRoute = null;

foreach ($routes as $route) {
    if ($route->getName() === 'user.profile.show') {
        $profileRoute = $route;
        break;
    }
}

if ($profileRoute) {
    echo "<div class='status success'>";
    echo "✅ Profile route found<br>";
    echo "URI: " . $profileRoute->uri() . "<br>";
    echo "Name: " . $profileRoute->getName() . "<br>";
    echo "Methods: " . implode(', ', $profileRoute->methods()) . "<br>";
    echo "Action: " . $profileRoute->getAction('uses') . "<br>";
    echo "</div>";
} else {
    echo "<div class='status error'>❌ Profile route NOT found</div>";
}

echo "<h3>🔧 Model Relationship Check:</h3>";

try {
    $user = \Illuminate\Support\Facades\Auth::user();
    echo "<div class='status info'>";
    echo "Testing recommendations relationship...<br>";
    
    // Check if recommendations method exists
    if (method_exists($user, 'recommendations')) {
        echo "✅ recommendations method exists<br>";
        
        // Try to get recommendations
        try {
            $recommendations = $user->recommendations;
            echo "✅ recommendations relationship works<br>";
            echo "Count: " . $recommendations->count() . "<br>";
        } catch (Exception $e) {
            echo "❌ recommendations relationship error: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ recommendations method missing<br>";
    }
    echo "</div>";
} catch (Exception $e) {
    echo "<div class='status error'>❌ Model error: " . $e->getMessage() . "</div>";
}

echo "<h3>🔧 Test Profile Data:</h3>";

try {
    $user = \Illuminate\Support\Facades\Auth::user();
    echo "<div class='status info'>";
    echo "User data:<br>";
    echo "Name: " . $user->name . "<br>";
    echo "Email: " . $user->email . "<br>";
    echo "Phone: " . ($user->phone ?? 'Not set') . "<br>";
    echo "Bio: " . ($user->bio ?? 'Not set') . "<br>";
    echo "Favorite Tea: " . ($user->favorite_tea_type ?? 'Not set') . "<br>";
    echo "Caffeine: " . ($user->caffeine_preference ?? 'Not set') . "<br>";
    echo "Created: " . $user->created_at->format('M d, Y') . "<br>";
    echo "</div>";
} catch (Exception $e) {
    echo "<div class='status error'>❌ Data error: " . $e->getMessage() . "</div>";
}

echo "<h3>🚀 Test Links:</h3>";
echo "<div class='status info'>";
echo "<a href='/profile' class='btn'>Try Profile Page</a>";
echo "<a href='/dashboard' class='btn'>Dashboard</a>";
echo "<a href='/test-profile.php' class='btn'>Refresh Test</a>";
echo "</div>";

echo "<h3>🔧 Debug Info:</h3>";
echo "<div class='status info'>";
echo "Current URL: " . url()->current() . "<br>";
echo "Base URL: " . url('') . "<br>";
echo "Profile URL: " . url('/profile') . "<br>";
echo "Route Profile: " . route('user.profile.show') . "<br>";
echo "</div>";

echo "</div></body></html>";
?>
