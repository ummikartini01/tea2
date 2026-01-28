<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeaController;
use App\Http\Controllers\User\RecommendationController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\FindTeaController;
use App\Http\Controllers\User\TopTeaController;
use App\Http\Controllers\User\RatedTeaController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Simple admin test route (no middleware)
Route::get('/simple-admin', function() {
    $user = \App\Models\User::where('email', 'ummikartini2004@gmail.com')->first();
    if ($user) {
        \Illuminate\Support\Facades\Auth::login($user);
        return 'Simple admin test worked! Logged in as: ' . $user->email;
    }
    return 'User not found';
});

// Emergency admin dashboard route (no middleware)
Route::get('/emergency-admin', function() {
    $user = \App\Models\User::where('email', 'ummikartini2004@gmail.com')->first();
    if ($user) {
        \Illuminate\Support\Facades\Auth::login($user);
        
        // Simple dashboard content
        $teaCount = \App\Models\Tea::count();
        $userCount = \App\Models\User::where('role', 'user')->count();
        $ratingCount = \App\Models\Rating::count();
        
        return "
        <h1>Emergency Admin Dashboard</h1>
        <p>Logged in as: {$user->email}</p>
        <p>Role: {$user->role}</p>
        <hr>
        <h2>Statistics:</h2>
        <p>Total Teas: {$teaCount}</p>
        <p>Total Users: {$userCount}</p>
        <p>Total Ratings: {$ratingCount}</p>
        <hr>
        <p><a href='/tea2/admin/teas'>Manage Teas</a></p>
        <p><a href='/tea2/admin/api-usage'>API Usage</a></p>
        ";
    }
    return 'Admin user not found';
});

// Debug authentication status
Route::get('/debug-auth', function() {
    $html = "<h1>Authentication Debug</h1>";
    
    // Check if user is authenticated
    if (auth()->check()) {
        $user = auth()->user();
        $html .= "<p style='color: green;'>✅ User is authenticated</p>";
        $html .= "<p>Email: {$user->email}</p>";
        $html .= "<p>Role: {$user->role}</p>";
        $html .= "<p>ID: {$user->id}</p>";
        
        if ($user->role === 'admin') {
            $html .= "<p style='color: green;'>✅ User has admin role</p>";
            $html .= "<p><a href='/tea2/admin/dashboard'>Try Admin Dashboard</a></p>";
        } else {
            $html .= "<p style='color: red;'>❌ User does NOT have admin role</p>";
        }
    } else {
        $html .= "<p style='color: red;'>❌ User is NOT authenticated</p>";
        
        // Try to find admin user
        $adminUser = \App\Models\User::where('email', 'ummikartini2004@gmail.com')->first();
        if ($adminUser) {
            $html .= "<p>Admin user exists: {$adminUser->email}</p>";
            $html .= "<p>Admin role: {$adminUser->role}</p>";
            $html .= "<button onclick='loginAdmin()'>Login as Admin</button>";
            $html .= "<script>
                function loginAdmin() {
                    fetch('/tea2/emergency-admin').then(() => window.location.reload());
                }
            </script>";
        } else {
            $html .= "<p style='color: red;'>❌ Admin user not found</p>";
        }
    }
    
    return $html;
});

/*
|--------------------------------------------------------------------------
| ADMIN AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'create'])
        ->name('login');
    
    Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'store'])
        ->name('login.submit');
    
    Route::post('/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'destroy'])
        ->name('logout');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (ONLY ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->group(function () {

    Route::get('/admin/test', function() {
        return 'Admin middleware working! User: ' . auth()->guard('admin')->user()->email;
    });

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/teas', [TeaController::class, 'index'])
        ->name('admin.teas.index');

    Route::get('/admin/teas/scraped', [TeaController::class, 'scraped'])
        ->name('admin.teas.scraped');

    Route::get('/admin/teas/manual', [TeaController::class, 'manual'])
        ->name('admin.teas.manual');

    Route::get('/admin/teas/create', [TeaController::class, 'create'])
        ->name('admin.teas.create');

    Route::post('/admin/teas', [TeaController::class, 'store'])
        ->name('admin.teas.store');

    Route::get('/admin/teas/{id}/edit', [TeaController::class, 'edit'])
        ->name('admin.teas.edit');

    Route::put('/admin/teas/{id}', [TeaController::class, 'update'])
        ->name('admin.teas.update');

    Route::post('/admin/scrape-teas', [TeaController::class, 'scrape'])
        ->name('admin.scrape.teas');

    Route::delete('/admin/teas/{id}', [TeaController::class, 'destroy'])
        ->name('admin.teas.destroy');

    // User Management Routes
    Route::get('/admin/users', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])
        ->name('admin.users.index');
    
    Route::get('/admin/users/create', [App\Http\Controllers\Admin\UserManagementController::class, 'create'])
        ->name('admin.users.create');
    
    Route::post('/admin/users', [App\Http\Controllers\Admin\UserManagementController::class, 'store'])
        ->name('admin.users.store');
    
    Route::get('/admin/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'show'])
        ->name('admin.users.show');
    
    Route::get('/admin/users/{id}/edit', [App\Http\Controllers\Admin\UserManagementController::class, 'edit'])
        ->name('admin.users.edit');
    
    Route::put('/admin/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'update'])
        ->name('admin.users.update');
    
    Route::delete('/admin/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])
        ->name('admin.users.destroy');

    // Rating Management Routes
    Route::get('/admin/ratings', [App\Http\Controllers\Admin\RatingManagementController::class, 'index'])
        ->name('admin.ratings.index');
    
    Route::get('/admin/ratings/{id}', [App\Http\Controllers\Admin\RatingManagementController::class, 'show'])
        ->name('admin.ratings.show');
    
    Route::get('/admin/ratings/{id}/edit', [App\Http\Controllers\Admin\RatingManagementController::class, 'edit'])
        ->name('admin.ratings.edit');
    
    Route::put('/admin/ratings/{id}', [App\Http\Controllers\Admin\RatingManagementController::class, 'update'])
        ->name('admin.ratings.update');
    
    Route::delete('/admin/ratings/{id}', [App\Http\Controllers\Admin\RatingManagementController::class, 'destroy'])
        ->name('admin.ratings.destroy');
    
    Route::get('/admin/ratings/user/{userId}', [App\Http\Controllers\Admin\RatingManagementController::class, 'byUser'])
        ->name('admin.ratings.byUser');
    
    Route::get('/admin/ratings/tea/{teaId}', [App\Http\Controllers\Admin\RatingManagementController::class, 'byTea'])
        ->name('admin.ratings.byTea');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    // User Profile Routes
    Route::prefix('profile')->name('user.profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\ProfileController::class, 'show'])
            ->name('show');
        Route::get('/edit', [App\Http\Controllers\User\ProfileController::class, 'edit'])
            ->name('edit');
        Route::put('/', [App\Http\Controllers\User\ProfileController::class, 'update'])
            ->name('update');
        Route::delete('/', [App\Http\Controllers\User\ProfileController::class, 'destroy'])
            ->name('destroy');
    });

    Route::get('/recommendations', [RecommendationController::class, 'index'])
        ->name('recommendations');

    Route::get('/search', [FindTeaController::class, 'search'])
        ->name('tea.search');

    Route::get('/find-tea', [FindTeaController::class, 'create'])
        ->name('find.tea');

    Route::post('/find-tea', [FindTeaController::class, 'store'])
        ->name('find.tea.store');

    Route::get('/top-tea', [TopTeaController::class, 'index'])
        ->name('top.tea');

    Route::get('/rated-tea', [RatedTeaController::class, 'index'])
        ->name('rated.tea');

    Route::get('/rated-tea/{id}/edit', [RatedTeaController::class, 'edit'])
        ->name('rated.tea.edit');

    Route::put('/rated-tea/{id}', [RatedTeaController::class, 'update'])
        ->name('rated.tea.update');

    Route::delete('/rated-tea/{id}', [RatedTeaController::class, 'destroy'])
        ->name('rated.tea.destroy');

    // Rating routes
    Route::post('/ratings', [RatingController::class, 'store'])
        ->name('ratings.store');

    Route::get('/top-rated', [RatingController::class, 'topRated'])
        ->name('top.rated');

    // Tea Timetable Routes
    Route::prefix('tea-timetables')->name('user.tea-timetables.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\TeaTimetableController::class, 'index'])
            ->name('index');
        Route::get('/create', [App\Http\Controllers\User\TeaTimetableController::class, 'create'])
            ->name('create');
        Route::post('/', [App\Http\Controllers\User\TeaTimetableController::class, 'store'])
            ->name('store');
        Route::get('/{teaTimetable}', [App\Http\Controllers\User\TeaTimetableController::class, 'show'])
            ->name('show');
        Route::get('/{teaTimetable}/edit', [App\Http\Controllers\User\TeaTimetableController::class, 'edit'])
            ->name('edit');
        Route::get('/{teaTimetable}/edit-simple', [App\Http\Controllers\User\TeaTimetableController::class, 'edit'])
            ->name('edit-simple');
        Route::put('/{teaTimetable}', [App\Http\Controllers\User\TeaTimetableController::class, 'update'])
            ->name('update');
        Route::delete('/{teaTimetable}', [App\Http\Controllers\User\TeaTimetableController::class, 'destroy'])
            ->name('destroy');
        Route::get('/{teaTimetable}/pdf', [App\Http\Controllers\User\TeaTimetableController::class, 'generatePDF'])
            ->name('pdf');
        Route::post('/{teaTimetable}/toggle-telegram', [App\Http\Controllers\User\TeaTimetableController::class, 'toggleTelegramNotifications'])
            ->name('toggle-telegram');
    });

    // Health check endpoint for Railway
Route::get('/health', [App\Http\Controllers\HealthController::class, 'index']);

// Admin API Usage routes
    Route::get('/admin/api-usage', [App\Http\Controllers\Admin\ApiUsageController::class, 'index'])
        ->name('admin.api-usage');
    
    Route::post('/admin/api-usage/clear-cache', [App\Http\Controllers\Admin\ApiUsageController::class, 'clearCache'])
        ->name('admin.api-usage.clear-cache');
});

// Test route to verify routing works
Route::get('/test-login', function() {
    return "Login route test works! Time: " . now();
});

require __DIR__.'/auth.php';
