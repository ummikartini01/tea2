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
    <title>User Login Test - Teazy</title>
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
            max-width: 500px;
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
    </style>
</head>
<body>
    <div class='test-container'>
        <div class='tea-logo'>🍵</div>
        <h1>User Login Test</h1>
        <p class='subtitle'>Test user authentication flow</p>";

// Handle login attempt
if ($_POST['email'] && $_POST['password']) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    echo "<div class='status info'>";
    echo "<strong>Testing login for:</strong> $email<br>";
    echo "<strong>Password:</strong> $password<br>";
    echo "</div>";
    
    // Test 1: Check user exists
    $user = \App\Models\User::where('email', $email)->first();
    if (!$user) {
        echo "<div class='status error'>❌ User not found in database</div>";
    } else {
        echo "<div class='status success'>✅ User found: {$user->name}</div>";
        echo "<div class='status info'>Role: {$user->role}</div>";
        
        // Test 2: Check password
        if (\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            echo "<div class='status success'>✅ Password matches</div>";
            
            // Test 3: Test Laravel Auth
            \Illuminate\Support\Facades\Auth::logout();
            
            if (\Illuminate\Support\Facades\Auth::attempt(['email' => $email, 'password' => $password])) {
                echo "<div class='status success'>✅ Laravel Auth successful!</div>";
                
                $authUser = \Illuminate\Support\Facades\Auth::user();
                echo "<div class='status info'>Authenticated as: {$authUser->email}</div>";
                echo "<div class='status info'>Role: {$authUser->role}</div>";
                
                // Test 4: Check redirection
                if ($authUser->role === 'admin') {
                    echo "<div class='status info'>⚠️ User has admin role - should redirect to admin dashboard</div>";
                    echo "<div class='status info'>";
                    echo "<a href='/tea2/admin/dashboard' class='btn'>Go to Admin Dashboard</a>";
                    echo "</div>";
                } else {
                    echo "<div class='status success'>✅ Should redirect to: /dashboard</div>";
                    echo "<div class='status info'>";
                    echo "<a href='/tea2/dashboard' class='btn'>Go to User Dashboard</a>";
                    echo "</div>";
                }
                
                \Illuminate\Support\Facades\Auth::logout();
                
            } else {
                echo "<div class='status error'>❌ Laravel Auth failed</div>";
            }
        } else {
            echo "<div class='status error'>❌ Password does not match</div>";
        }
    }
    
    echo "<hr>";
}

// Show current regular users
echo "<h3>Available Regular Users:</h3>";
$regularUsers = \App\Models\User::where('role', 'user')->get();
if ($regularUsers->count() > 0) {
    foreach ($regularUsers as $user) {
        echo "<div class='status info'>";
        echo "<strong>{$user->email}</strong> ({$user->name})<br>";
        echo "<small>ID: {$user->id}, Role: {$user->role}</small>";
        echo "</div>";
    }
} else {
    echo "<div class='status info'>No regular users found. All users are admins.</div>";
}

echo "<h3>Create Test User:</h3>";
echo "<form method='post' action='/tea2/create-test-user.php'>";
echo "<p><strong>Name:</strong><br>";
echo "<input type='text' name='name' value='Test User' style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'></p>";
echo "<p><strong>Email:</strong><br>";
echo "<input type='email' name='email' value='testuser@example.com' style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'></p>";
echo "<p><strong>Password:</strong><br>";
echo "<input type='password' name='password' value='password' style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'></p>";
echo "<button type='submit' class='btn'>Create Test User</button>";
echo "</form>";

echo "<h3>Test User Login:</h3>";
echo "<form method='post'>";
echo "<p><strong>Email:</strong><br>";
echo "<input type='email' name='email' value='testuser@example.com' style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'></p>";
echo "<p><strong>Password:</strong><br>";
echo "<input type='password' name='password' value='password' style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'></p>";
echo "<button type='submit' class='btn'>Test User Login</button>";
echo "</form>";

echo "<hr>";
echo "<h3>Quick Links:</h3>";
echo "<a href='/tea2/login' class='btn'>Go to Real Login Page</a>";
echo "<a href='/tea2/test-admin-login.php' class='btn'>Test Admin Login</a>";
echo "<a href='/tea2/test-user-login.php' class='btn'>Refresh This Page</a>";

echo "</div></body></html>";
?>
