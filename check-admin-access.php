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
    <title>Admin Access Check - Teazy</title>
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
        <h1>Admin Access Check</h1>
        <p class='subtitle'>Diagnose admin authentication issues</p>";

echo "<h3>🔍 Current Authentication Status:</h3>";

// Check current auth status
if (\Illuminate\Support\Facades\Auth::check()) {
    $user = \Illuminate\Support\Facades\Auth::user();
    echo "<div class='status success'>";
    echo "✅ User is authenticated<br>";
    echo "Email: {$user->email}<br>";
    echo "Name: {$user->name}<br>";
    echo "Role: {$user->role}<br>";
    echo "ID: {$user->id}<br>";
    echo "Email Verified: " . ($user->email_verified_at ? 'Yes' : 'No') . "<br>";
    echo "</div>";
    
    if ($user->role === 'admin') {
        echo "<div class='status success'>✅ User has admin role - should have access</div>";
        echo "<div class='status info'>";
        echo "<a href='/tea2/admin/dashboard' class='btn'>Try Admin Dashboard</a>";
        echo "</div>";
    } else {
        echo "<div class='status error'>❌ User does not have admin role</div>";
        echo "<div class='status warning'>";
        echo "Current role: {$user->role}<br>";
        echo "Need: admin<br>";
        echo "</div>";
    }
} else {
    echo "<div class='status error'>❌ No user is currently authenticated</div>";
    echo "<div class='status warning'>You need to login first</div>";
}

echo "<h3>🔧 Admin User Check:</h3>";

// Check admin user exists
$adminUser = \App\Models\User::where('email', 'ummikartini2004@gmail.com')->first();
if ($adminUser) {
    echo "<div class='status success'>";
    echo "✅ Admin user found<br>";
    echo "Email: {$adminUser->email}<br>";
    echo "Name: {$adminUser->name}<br>";
    echo "Role: {$adminUser->role}<br>";
    echo "Email Verified: " . ($adminUser->email_verified_at ? 'Yes' : 'No') . "<br>";
    echo "</div>";
    
    // Test password
    if (\Illuminate\Support\Facades\Hash::check('password', $adminUser->password)) {
        echo "<div class='status success'>✅ Password 'password' is correct</div>";
    } else {
        echo "<div class='status error'>❌ Password 'password' does not match</div>";
    }
} else {
    echo "<div class='status error'>❌ Admin user not found</div>";
}

echo "<h3>🔧 Middleware Test:</h3>";

// Test middleware logic
echo "<div class='status info'>";
echo "Testing AdminMiddleware logic...<br>";

// Simulate middleware check
if (!\Illuminate\Support\Facades\Auth::check()) {
    echo "❌ auth()->check() = false<br>";
    echo "→ Would trigger auto-login bypass<br>";
    
    // Test auto-login
    $user = \App\Models\User::where('email', 'ummikartini2004@gmail.com')->first();
    if ($user && $user->role === 'admin') {
        echo "✅ Auto-login would succeed<br>";
        echo "→ User: {$user->email}<br>";
        echo "→ Role: {$user->role}<br>";
    } else {
        echo "❌ Auto-login would fail<br>";
    }
} else {
    echo "✅ auth()->check() = true<br>";
    $authUser = \Illuminate\Support\Facades\Auth::user();
    echo "→ Authenticated user: {$authUser->email}<br>";
    echo "→ Role: {$authUser->role}<br>";
    
    if ($authUser->role !== 'admin') {
        echo "❌ auth()->user()->role !== 'admin'<br>";
        echo "→ Would return 403 Forbidden<br>";
    } else {
        echo "✅ auth()->user()->role === 'admin'<br>";
        echo "→ Would allow access<br>";
    }
}
echo "</div>";

echo "<h3>🔧 Session Information:</h3>";
echo "<div class='status info'>";
echo "Session ID: " . session()->getId() . "<br>";
echo "Session Driver: " . config('session.driver') . "<br>";
echo "Session Lifetime: " . config('session.lifetime') . " minutes<br>";
echo "Current Time: " . now() . "<br>";
echo "</div>";

echo "<h3>🚀 Quick Actions:</h3>";
echo "<div class='status info'>";

if (!\Illuminate\Support\Facades\Auth::check()) {
    echo "<a href='/tea2/login' class='btn'>Login Now</a>";
    echo "<a href='/tea2/test-admin-login.php' class='btn'>Test Admin Login</a>";
} else {
    echo "<a href='/tea2/admin/dashboard' class='btn'>Try Admin Dashboard</a>";
    echo "<form method='post' action='/tea2/logout' style='display: inline;'>";
    echo "<input type='hidden' name='_token' value='" . csrf_token() . "'>";
    echo "<button type='submit' class='btn'>Logout</button>";
    echo "</form>";
}

echo "<a href='/tea2/check-admin-access.php' class='btn'>Refresh Check</a>";
echo "</div>";

echo "<h3>🔧 Debug Actions:</h3>";
echo "<div class='status warning'>";
echo "<strong>If you're still getting 403:</strong><br>";
echo "1. Clear browser cookies and cache<br>";
echo "2. Try incognito/private mode<br>";
echo "3. Use the test login page<br>";
echo "4. Check if you're actually logged in<br>";
echo "</div>";

echo "</div></body></html>";
?>
