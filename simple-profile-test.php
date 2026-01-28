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
    <title>Simple Profile Test - Teazy</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #10b981; }
        .error { color: #ef4444; }
        .info { color: #3b82f6; }
        .btn { background: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 4px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn:hover { background: #059669; }
        pre { background: #f3f4f6; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🍵 Simple Profile Test</h1>";

// Test authentication
if (\Illuminate\Support\Facades\Auth::check()) {
    $user = \Illuminate\Support\Facades\Auth::user();
    echo "<div class='success'>✅ Authenticated as: {$user->name} ({$user->email})</div>";
    
    // Test route generation
    try {
        $profileUrl = route('user.profile.show');
        echo "<div class='info'>📍 Profile route: {$profileUrl}</div>";
        
        // Test if view exists
        if (view()->exists('user.profile.show')) {
            echo "<div class='success'>✅ Profile view exists</div>";
            
            // Try to render a simple version
            try {
                echo "<h2>📋 Profile Data:</h2>";
                echo "<pre>";
                echo "Name: " . $user->name . "\n";
                echo "Email: " . $user->email . "\n";
                echo "Phone: " . ($user->phone ?? 'Not set') . "\n";
                echo "Bio: " . ($user->bio ?? 'Not set') . "\n";
                echo "Favorite Tea: " . ($user->favorite_tea_type ?? 'Not set') . "\n";
                echo "Caffeine: " . ($user->caffeine_preference ?? 'Not set') . "\n";
                echo "Member Since: " . $user->created_at->format('M d, Y') . "\n";
                echo "</pre>";
                
                echo "<h2>🔗 Test Links:</h2>";
                echo "<a href='{$profileUrl}' class='btn'>Go to Profile Page</a>";
                echo "<a href='/dashboard' class='btn'>Back to Dashboard</a>";
                echo "<a href='/simple-profile-test.php' class='btn'>Refresh Test</a>";
                
            } catch (Exception $e) {
                echo "<div class='error'>❌ Error rendering profile: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='error'>❌ Profile view does not exist</div>";
        }
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ Route error: " . $e->getMessage() . "</div>";
    }
    
} else {
    echo "<div class='error'>❌ Not authenticated</div>";
    echo "<a href='/login' class='btn'>Login First</a>";
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
