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
    <title>Login Route Test - Teazy</title>
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
        <h1>Login Route Test</h1>
        <p class='subtitle'>Check if login routes are working</p>";

echo "<h3>🔍 Route Registration Check:</h3>";

// Check if routes are registered
$routes = \Illuminate\Support\Facades\Route::getRoutes();
$loginRoute = null;
$adminLoginRoute = null;

foreach ($routes as $route) {
    if ($route->uri() === 'login') {
        $loginRoute = $route;
    }
    if ($route->uri() === 'admin/login') {
        $adminLoginRoute = $route;
    }
}

if ($loginRoute) {
    echo "<div class='status success'>";
    echo "✅ User login route found<br>";
    echo "URI: " . $loginRoute->uri() . "<br>";
    echo "Name: " . $loginRoute->getName() . "<br>";
    echo "Methods: " . implode(', ', $loginRoute->methods()) . "<br>";
    echo "Action: " . $loginRoute->getAction('uses') . "<br>";
    echo "</div>";
} else {
    echo "<div class='status error'>❌ User login route NOT found</div>";
}

if ($adminLoginRoute) {
    echo "<div class='status success'>";
    echo "✅ Admin login route found<br>";
    echo "URI: " . $adminLoginRoute->uri() . "<br>";
    echo "Name: " . $adminLoginRoute->getName() . "<br>";
    echo "Methods: " . implode(', ', $adminLoginRoute->methods()) . "<br>";
    echo "Action: " . $adminLoginRoute->getAction('uses') . "<br>";
    echo "</div>";
} else {
    echo "<div class='status error'>❌ Admin login route NOT found</div>";
}

echo "<h3>🔧 Controller Check:</h3>";

// Check if controllers exist
$userLoginController = 'App\Http\Controllers\Auth\AuthenticatedSessionController';
$adminLoginController = 'App\Http\Controllers\Auth\AdminLoginController';

if (class_exists($userLoginController)) {
    echo "<div class='status success'>✅ User login controller exists</div>";
    if (method_exists($userLoginController, 'create')) {
        echo "<div class='status success'>✅ create method exists</div>";
    } else {
        echo "<div class='status error'>❌ create method missing</div>";
    }
} else {
    echo "<div class='status error'>❌ User login controller missing</div>";
}

if (class_exists($adminLoginController)) {
    echo "<div class='status success'>✅ Admin login controller exists</div>";
    if (method_exists($adminLoginController, 'create')) {
        echo "<div class='status success'>✅ create method exists</div>";
    } else {
        echo "<div class='status error'>❌ create method missing</div>";
    }
} else {
    echo "<div class='status error'>❌ Admin login controller missing</div>";
}

echo "<h3>🔧 View Check:</h3>";

// Check if views exist
$userLoginView = 'auth.login';
$adminLoginView = 'auth.admin-login';

if (view()->exists($userLoginView)) {
    echo "<div class='status success'>✅ User login view exists</div>";
} else {
    echo "<div class='status error'>❌ User login view missing</div>";
}

if (view()->exists($adminLoginView)) {
    echo "<div class='status success'>✅ Admin login view exists</div>";
} else {
    echo "<div class='status error'>❌ Admin login view missing</div>";
}

echo "<h3>🚀 Test Links:</h3>";
echo "<div class='status info'>";

echo "<a href='/tea2/login' class='btn'>Try User Login</a>";
echo "<a href='/tea2/admin/login' class='btn'>Try Admin Login</a>";
echo "<a href='/tea2/register' class='btn'>Try Register</a>";
echo "<a href='/tea2/test-login-route.php' class='btn'>Refresh Test</a>";

echo "</div>";

echo "<h3>🔧 Debug Info:</h3>";
echo "<div class='status info'>";
echo "Base URL: " . url('/') . "<br>";
echo "Current URL: " . url()->current() . "<br>";
echo "Laravel Version: " . app()->version() . "<br>";
echo "Environment: " . app()->environment() . "<br>";
echo "</div>";

echo "<h3>🔧 Possible Solutions:</h3>";
echo "<div class='status warning'>";
echo "<strong>If login route shows 404:</strong><br>";
echo "1. Check .htaccess file exists and is correct<br>";
echo "2. Try accessing with index.php: /tea2/index.php/login<br>";
echo "3. Clear browser cache and try incognito mode<br>";
echo "4. Check if mod_rewrite is enabled<br>";
echo "5. Verify virtual host configuration<br>";
echo "</div>";

echo "</div></body></html>";
?>
