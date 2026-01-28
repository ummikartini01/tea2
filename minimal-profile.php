<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check authentication
if (!\Illuminate\Support\Facades\Auth::check()) {
    header('Location: /login');
    exit;
}

$user = \Illuminate\Support\Facades\Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Teazy</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f5f5; }
        .container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: white; box-shadow: 2px 0 5px rgba(0,0,0,0.1); padding: 20px; }
        .main { flex: 1; padding: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #10b981; margin-bottom: 30px; }
        .nav-item { padding: 10px; margin: 5px 0; border-radius: 5px; cursor: pointer; }
        .nav-item:hover { background: #f3f4f6; }
        .nav-item.active { background: #10b981; color: white; }
        .profile-card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .avatar { width: 80px; height: 80px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 20px; }
        .btn { background: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn:hover { background: #059669; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .info-item { padding: 15px; background: #f9fafb; border-radius: 5px; }
        .label { font-weight: bold; color: #6b7280; font-size: 12px; text-transform: uppercase; }
        .value { color: #1f2937; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">🍵 Teazy</div>
            
            <div class="nav-item">
                <strong>👤 <?= $user->name ?></strong><br>
                <small><?= $user->email ?></small>
            </div>
            
            <a href="/dashboard" class="nav-item">🏠 Dashboard</a>
            <a href="/profile" class="nav-item active">👤 My Profile</a>
            <a href="/profile/edit" class="nav-item">⚙️ Settings</a>
            <a href="/top-tea" class="nav-item">🍵 Top Tea</a>
            
            <form method="POST" action="/logout" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="btn" style="width: 100%; background: #ef4444;">🚪 Logout</button>
            </form>
        </div>
        
        <!-- Main Content -->
        <div class="main">
            <div class="profile-card">
                <div class="avatar">👤</div>
                <h1 style="text-align: center; color: #1f2937; margin-bottom: 10px;"><?= $user->name ?></h1>
                <p style="text-align: center; color: #6b7280; margin-bottom: 30px;"><?= $user->email ?></p>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="label">Phone Number</div>
                        <div class="value"><?= $user->phone ?? 'Not provided' ?></div>
                    </div>
                    <div class="info-item">
                        <div class="label">Member Since</div>
                        <div class="value"><?= $user->created_at->format('M d, Y') ?></div>
                    </div>
                    <div class="info-item">
                        <div class="label">Favorite Tea</div>
                        <div class="value"><?= $user->favorite_tea_type ?? 'Not specified' ?></div>
                    </div>
                    <div class="info-item">
                        <div class="label">Caffeine Preference</div>
                        <div class="value"><?= $user->caffeine_preference ? ucfirst($user->caffeine_preference) : 'Not specified' ?></div>
                    </div>
                </div>
                
                <?php if ($user->bio): ?>
                <div style="margin-top: 20px;">
                    <div class="label">Bio</div>
                    <div style="background: #f9fafb; padding: 15px; border-radius: 5px; margin-top: 5px;">
                        <?= $user->bio ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div style="text-align: center; margin-top: 30px;">
                    <a href="/profile/edit" class="btn">✏️ Edit Profile</a>
                    <a href="/profile/change-password" class="btn">🔐 Change Password</a>
                </div>
            </div>
            
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 20px;">
                <h3 style="color: #1f2937;">🔧 Debug Info</h3>
                <p style="color: #6b7280; font-size: 14px;">
                    This is a minimal profile page to test if the profile functionality works.<br>
                    If this page works, the issue is with the Laravel Blade views.<br>
                    If this page doesn't work, there's a deeper routing or authentication issue.
                </p>
                <div style="margin-top: 15px;">
                    <a href="/emergency-profile-debug.php" class="btn">🔍 Run Full Debug</a>
                    <a href="/dashboard" class="btn">🏠 Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
