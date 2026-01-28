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
    <title>Create Test User - Teazy</title>
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
        <h1>Create Test User</h1>
        <p class='subtitle'>Create a test user account</p>";

if ($_POST['name'] && $_POST['email'] && $_POST['password']) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'] ?? 'user';
    
    echo "<div class='status info'>";
    echo "<strong>Creating user:</strong> $name<br>";
    echo "<strong>Email:</strong> $email<br>";
    echo "<strong>Role:</strong> $role<br>";
    echo "</div>";
    
    // Check if user already exists
    $existingUser = \App\Models\User::where('email', $email)->first();
    if ($existingUser) {
        echo "<div class='status error'>❌ User with this email already exists</div>";
        echo "<div class='status info'>Existing user: {$existingUser->name} ({$existingUser->role})</div>";
    } else {
        // Create new user
        try {
            $user = \App\Models\User::create([
                'name' => $name,
                'email' => $email,
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'role' => $role,
                'email_verified_at' => now(),
            ]);
            
            echo "<div class='status success'>✅ User created successfully!</div>";
            echo "<div class='status info'>User ID: {$user->id}</div>";
            echo "<div class='status info'>Name: {$user->name}</div>";
            echo "<div class='status info'>Email: {$user->email}</div>";
            echo "<div class='status info'>Role: {$user->role}</div>";
            
            // Test login immediately
            if (\Illuminate\Support\Facades\Auth::attempt(['email' => $email, 'password' => $password])) {
                echo "<div class='status success'>✅ Login test successful!</div>";
                \Illuminate\Support\Facades\Auth::logout();
                
                // Provide appropriate link
                if ($role === 'admin') {
                    echo "<div class='status info'>";
                    echo "<a href='/tea2/test-admin-login.php' class='btn'>Test Admin Login</a>";
                    echo "</div>";
                } else {
                    echo "<div class='status info'>";
                    echo "<a href='/tea2/test-user-login.php' class='btn'>Test User Login</a>";
                    echo "</div>";
                }
            }
            
        } catch (Exception $e) {
            echo "<div class='status error'>❌ Error creating user: " . $e->getMessage() . "</div>";
        }
    }
    
    echo "<hr>";
}

echo "<h3>Create New Test User:</h3>";
echo "<form method='post'>";
echo "<p><strong>Name:</strong><br>";
echo "<input type='text' name='name' value='Test User' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'></p>";
echo "<p><strong>Email:</strong><br>";
echo "<input type='email' name='email' value='testuser@example.com' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'></p>";
echo "<p><strong>Password:</strong><br>";
echo "<input type='password' name='password' value='password' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'></p>";
echo "<p><strong>Role:</strong><br>";
echo "<select name='role' style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'>";
echo "<option value='user'>Regular User</option>";
echo "<option value='admin'>Admin User</option>";
echo "</select></p>";
echo "<button type='submit' class='btn'>Create Test User</button>";
echo "</form>";

echo "<h3>Quick Links:</h3>";
echo "<a href='/tea2/test-admin-login.php' class='btn'>Test Admin Login</a>";
echo "<a href='/tea2/test-user-login.php' class='btn'>Test User Login</a>";
echo "<a href='/tea2/login' class='btn'>Real Login Page</a>";

echo "</div></body></html>";
?>
