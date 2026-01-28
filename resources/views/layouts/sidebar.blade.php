<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teazy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <div class="w-64 sidebar p-6">
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-2" style="color: var(--primary-green);">
                🍃 Teazy
            </h1>
            <p class="text-sm" style="color: var(--text-light);">Discover Your Perfect Tea</p>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-green-50 group">
                <span class="text-lg group-hover:scale-110 transition-transform">🏠</span>
                <span style="color: var(--text-medium);" class="font-medium">Home</span>
            </a>

            <a href="{{ route('find.tea') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-green-50 group">
                <span class="text-lg group-hover:scale-110 transition-transform">🔍</span>
                <span style="color: var(--text-medium);" class="font-medium">Find Tea</span>
            </a>

            <a href="{{ route('top.tea') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-green-50 group">
                <span class="text-lg group-hover:scale-110 transition-transform">🏆</span>
                <span style="color: var(--text-medium);" class="font-medium">Top Tea</span>
            </a>

            <a href="{{ route('rated.tea') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-green-50 group">
                <span class="text-lg group-hover:scale-110 transition-transform">⭐</span>
                <span style="color: var(--text-medium);" class="font-medium">Rated Tea</span>
            </a>

            <a href="{{ route('recommendations') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-green-50 group">
                <span class="text-lg group-hover:scale-110 transition-transform">💡</span>
                <span style="color: var(--text-medium);" class="font-medium">Recommendations</span>
            </a>

            <a href="{{ route('user.tea-timetables.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-green-50 group {{ request()->routeIs('user.tea-timetables.*') ? 'bg-green-50' : '' }}">
                <span class="text-lg group-hover:scale-110 transition-transform">📅</span>
                <span style="color: var(--text-medium);" class="font-medium">Tea Timetables</span>
            </a>

            <div class="pt-4 mt-4 border-t" style="border-color: var(--border-color);">
                <a href="{{ route('user.profile.show') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-green-50 group {{ request()->routeIs('user.profile.*') ? 'bg-green-50' : '' }}">
                    <span class="text-lg group-hover:scale-110 transition-transform">👤</span>
                    <span style="color: var(--text-medium);" class="font-medium">Profile</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-red-50 group w-full text-left">
                        <span class="text-lg group-hover:scale-110 transition-transform">🚪</span>
                        <span class="font-medium text-red-500">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 p-8">
        @yield('content')
    </div>

</div>

</body>
</html>
