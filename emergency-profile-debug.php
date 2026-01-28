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
    <title>Emergency Profile Debug - Teazy</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #10b981; background: #d1fae5; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .error { color: #ef4444; background: #fee2e2; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .info { color: #3b82f6; background: #dbeafe; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .warning { color: #f59e0b; background: #fef3c7; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .btn { background: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 4px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn:hover { background: #059669; }
        .btn-danger { background: #ef4444; }
        .btn-danger:hover { background: #dc2626; }
        pre { background: #f3f4f6; padding: 10px; border-radius: 4px; overflow-x: auto; font-size: 12px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .section { border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🚨 Emergency Profile Debug</h1>";

// Step 1: Check Authentication
echo "<div class='section'>";
echo "<h2>Step 1: Authentication Check</h2>";

if (\Illuminate\Support\Facades\Auth::check()) {
    $user = \Illuminate\Support\Facades\Auth::user();
    echo "<div class='success'>✅ User is authenticated</div>";
    echo "<pre>";
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "Created: {$user->created_at}\n";
    echo "</pre>";
} else {
    echo "<div class='error'>❌ User is NOT authenticated</div>";
    echo "<div class='warning'>Please login first: <a href='/login' class='btn'>Login</a></div>";
    echo "</div>";
    exit;
}
echo "</div>";

// Step 2: Check Routes
echo "<div class='section'>";
echo "<h2>Step 2: Route Registration</h2>";

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
echo "</div>";

// Step 3: Check Controller
echo "<div class='section'>";
echo "<h2>Step 3: Controller Test</h3>";

$controllerClass = 'App\Http\Controllers\User\ProfileController';

if (class_exists($controllerClass)) {
    echo "<div class='success'>✅ ProfileController class exists</div>";
    
    $controller = new $controllerClass();
    $methods = get_class_methods($controller);
    
    echo "<h4>Available Methods:</h4>";
    echo "<pre>" . implode(', ', $methods) . "</pre>";
    
    if (method_exists($controller, 'show')) {
        echo "<div class='success'>✅ show method exists</div>";
        
        // Test the show method
        try {
            $request = new \Illuminate\Http\Request();
            $response = $controller->show($request);
            
            if ($response instanceof \Illuminate\View\View) {
                echo "<div class='success'>✅ show() returns View object</div>";
                echo "<pre>";
                echo "View Name: " . $response->getName() . "\n";
                echo "Data Keys: " . implode(', ', array_keys($response->getData())) . "\n";
                echo "</pre>";
            } else {
                echo "<div class='error'>❌ show() does not return View</div>";
                echo "<pre>Type: " . gettype($response) . "</pre>";
            }
        } catch (Exception $e) {
            echo "<div class='error'>❌ show() method error</div>";
            echo "<pre>" . $e->getMessage() . "\nFile: " . $e->getFile() . ":" . $e->getLine() . "</pre>";
        }
    } else {
        echo "<div class='error'>❌ show method missing</div>";
    }
} else {
    echo "<div class='error'>❌ ProfileController class missing</div>";
}
echo "</div>";

// Step 4: Check Views
echo "<div class='section'>";
echo "<h2>Step 4: View Files Check</h2>";

$views = [
    'user.profile.show' => 'resources/views/user/profile/show.blade.php',
    'user.profile.edit' => 'resources/views/user/profile/edit.blade.php',
    'user.profile.change-password' => 'resources/views/user/profile/change-password.blade.php',
    'layouts.user-sidebar' => 'resources/views/layouts/user-sidebar.blade.php'
];

foreach ($views as $viewName => $viewPath) {
    $fullPath = __DIR__ . '/' . $viewPath;
    if (view()->exists($viewName)) {
        echo "<div class='success'>✅ View exists: {$viewName}</div>";
        if (file_exists($fullPath)) {
            echo "<pre>File: {$viewPath} (" . number_format(filesize($fullPath)) . " bytes)</pre>";
        }
    } else {
        echo "<div class='error'>❌ View missing: {$viewName}</div>";
        echo "<pre>Expected: {$viewPath}</pre>";
    }
}
echo "</div>";

// Step 5: Check User Model
echo "<div class='section'>";
echo "<h2>Step 5: User Model Check</h2>";

$user = \Illuminate\Support\Facades\Auth::user();
echo "<h4>User Properties:</h4>";
echo "<pre>";
foreach ($user->getAttributes() as $key => $value) {
    echo "{$key}: " . (is_null($value) ? 'NULL' : $value) . "\n";
}
echo "</pre>";

echo "<h4>Relationships:</h4>";
$relationships = ['ratings', 'preference', 'recommendations'];
foreach ($relationships as $rel) {
    if (method_exists($user, $rel)) {
        echo "<div class='success'>✅ {$rel}() method exists</div>";
        try {
            $count = $user->$rel()->count();
            echo "<pre>{$rel}: {$count} records</pre>";
        } catch (Exception $e) {
            echo "<div class='error'>❌ {$rel} relationship error: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='error'>❌ {$rel}() method missing</div>";
    }
}
echo "</div>";

// Step 6: Test URL Generation
echo "<div class='section'>";
echo "<h2>Step 6: URL Generation Test</h2>";

$urls = [
    'user.profile.show' => 'Profile Show',
    'user.profile.edit' => 'Profile Edit',
    'user.profile.change-password' => 'Change Password',
    'user.dashboard' => 'Dashboard'
];

foreach ($urls as $routeName => $description) {
    try {
        $url = route($routeName);
        $fullUrl = url($url);
        echo "<div class='success'>✅ {$description}</div>";
        echo "<pre>Route: {$routeName} → {$url} → {$fullUrl}</pre>";
    } catch (Exception $e) {
        echo "<div class='error'>❌ {$description}</div>";
        echo "<pre>Error: " . $e->getMessage() . "</pre>";
    }
}
echo "</div>";

// Step 7: Manual Profile Test
echo "<div class='section'>";
echo "<h2>Step 7: Manual Profile Rendering Test</h2>";

try {
    $user = \Illuminate\Support\Facades\Auth::user();
    
    // Simulate what the controller does
    $teaRecommendations = collect();
    $totalRecommendations = 0;
    
    try {
        $teaRecommendations = $user->recommendations()->with('tea')->latest()->take(5)->get();
        $totalRecommendations = $user->recommendations()->count();
    } catch (Exception $e) {
        // Fallback
    }
    
    echo "<div class='success'>✅ Data preparation successful</div>";
    echo "<pre>";
    echo "User: " . $user->name . "\n";
    echo "Recommendations: " . $totalRecommendations . "\n";
    echo "Data keys ready for view: user, teaRecommendations, totalRecommendations\n";
    echo "</pre>";
    
    // Try to render the view
    if (view()->exists('user.profile.show')) {
        echo "<div class='success'>✅ Attempting to render view...</div>";
        
        try {
            $rendered = view('user.profile.show', compact('user', 'teaRecommendations', 'totalRecommendations'))->render();
            echo "<div class='success'>✅ View rendered successfully!</div>";
            echo "<pre>Rendered length: " . strlen($rendered) . " characters</pre>";
        } catch (Exception $e) {
            echo "<div class='error'>❌ View rendering failed</div>";
            echo "<pre>" . $e->getMessage() . "\nFile: " . $e->getFile() . ":" . $e->getLine() . "</pre>";
        }
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Manual test failed</div>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
echo "</div>";

// Step 8: Test Links
echo "<div class='section'>";
echo "<h2>Step 8: Test Links</h2>";

echo "<div class='info'>";
echo "<a href='" . route('user.profile.show') . "' class='btn'>👤 Profile Page</a>";
echo "<a href='/dashboard' class='btn'>🏠 Dashboard</a>";
echo "<a href='/emergency-profile-debug.php' class='btn'>🔄 Refresh Debug</a>";
echo "</div>";

echo "<div class='warning'>";
echo "<strong>If profile still doesn't work:</strong><br>";
echo "1. Check browser console (F12) for JavaScript errors<br>";
echo "2. Check Laravel logs: storage/logs/laravel.log<br>";
echo "3. Try direct URL: " . route('user.profile.show') . "<br>";
echo "4. Make sure you're logged in as a user (not admin)<br>";
echo "</div>";

echo "</div>";

echo "</div></body></html>";
?>
