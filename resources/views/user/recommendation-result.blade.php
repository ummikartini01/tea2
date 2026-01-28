@extends('layouts.sidebar')
@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold mb-6" style="color: var(--text-dark);">
        🍃 Recommended Teas for You
    </h1>
    
    @if($preferences)
        <!-- Enhanced User Preferences Display -->
        <div class="tea-card p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold mb-2" style="color: var(--text-dark);">
                        🎯 Your Personalized Tea Profile
                    </h2>
                    <p class="text-sm" style="color: var(--text-light);">
                        These preferences were used to generate your recommendations
                    </p>
                </div>
                <a href="{{ route('find.tea') }}" class="btn-secondary">
                    ✏️ Update Preferences
                </a>
            </div>
            
            <!-- Main Preferences Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Flavor Preference -->
                <div class="relative overflow-hidden rounded-lg border-2" style="border-color: var(--accent-green); background: var(--cream-green);">
                    <div class="absolute top-2 right-2 w-8 h-8 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                        <span class="text-white text-sm font-bold">1</span>
                    </div>
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: var(--light-green);">
                            <span class="text-2xl text-white">🍃</span>
                        </div>
                        <h3 class="font-bold text-lg mb-2" style="color: var(--text-dark);">Flavor Profile</h3>
                        <p class="text-xl font-bold capitalize mb-2" style="color: var(--accent-green);">
                            {{ str_replace('_', ' ', $preferences->preferred_flavor) }}
                        </p>
                        <div class="text-xs px-3 py-1 rounded-full inline-block" style="background: var(--light-green);">
                            Taste Preference
                        </div>
                    </div>
                </div>
                
                <!-- Caffeine Preference -->
                <div class="relative overflow-hidden rounded-lg border-2" style="border-color: var(--accent-green); background: var(--cream-green);">
                    <div class="absolute top-2 right-2 w-8 h-8 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                        <span class="text-white text-sm font-bold">2</span>
                    </div>
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: var(--light-green);">
                            <span class="text-2xl text-white">⚡</span>
                        </div>
                        <h3 class="font-bold text-lg mb-2" style="color: var(--text-dark);">Caffeine Level</h3>
                        <p class="text-xl font-bold capitalize mb-2" style="color: var(--accent-green);">
                            {{ str_replace('_', ' ', $preferences->preferred_caffeine) }}
                        </p>
                        <div class="text-xs px-3 py-1 rounded-full inline-block" style="background: var(--light-green);">
                            Caffeine Preference
                        </div>
                    </div>
                </div>
                
                <!-- Health Goal -->
                <div class="relative overflow-hidden rounded-lg border-2" style="border-color: var(--accent-green); background: var(--cream-green);">
                    <div class="absolute top-2 right-2 w-8 h-8 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                        <span class="text-white text-sm font-bold">3</span>
                    </div>
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: var(--light-green);">
                            <span class="text-2xl text-white">🌿</span>
                        </div>
                        <h3 class="font-bold text-lg mb-2" style="color: var(--text-dark);">Wellness Goal</h3>
                        <p class="text-xl font-bold capitalize mb-2" style="color: var(--accent-green);">
                            {{ str_replace('_', ' ', $preferences->health_goal) }}
                        </p>
                        <div class="text-xs px-3 py-1 rounded-full inline-block" style="background: var(--light-green);">
                            Health Focus
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Weather Preferences (if enabled) -->
            @if($preferences->weather_based_recommendations)
                <div class="border-t pt-6" style="border-color: var(--border-color);">
                    <h3 class="font-bold text-lg mb-4" style="color: var(--text-dark);">
                        🌤️ Weather-Based Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--pale-green);">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                                <span class="text-white">📍</span>
                            </div>
                            <div>
                                <p class="font-semibold" style="color: var(--text-dark);">Location</p>
                                <p class="text-sm" style="color: var(--text-medium);">
                                    🇲🇾 {{ $preferences->city ?? 'Not set' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--pale-green);">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                                <span class="text-white">🌡️</span>
                            </div>
                            <div>
                                <p class="font-semibold" style="color: var(--text-dark);">Weather Mode</p>
                                <p class="text-sm" style="color: var(--text-medium);">
                                    {{ $preferences->weather_preference ? str_replace('_', ' ', ucfirst($preferences->weather_preference)) : 'Auto' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--pale-green);">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                                <span class="text-white">✅</span>
                            </div>
                            <div>
                                <p class="font-semibold" style="color: var(--text-dark);">Status</p>
                                <p class="text-sm" style="color: var(--text-medium);">
                                    Weather recommendations enabled
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Preference Summary -->
            <div class="mt-6 p-4 rounded-lg" style="background: var(--light-green);">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-white">
                            🎯 <strong>Your Profile:</strong> 
                            {{ str_replace('_', ' ', $preferences->preferred_flavor) }} • 
                            {{ str_replace('_', ' ', $preferences->preferred_caffeine) }} • 
                            {{ str_replace('_', ' ', $preferences->health_goal) }}
                            @if($preferences->weather_based_recommendations && $preferences->city)
                                • 🇲🇾 {{ $preferences->city }}
                            @endif
                        </p>
                    </div>
                    <div class="text-xs text-white">
                        Last updated: {{ $preferences->updated_at->format('M j, Y g:i A') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Weather Information -->
    @if($preferences && $preferences->weather_based_recommendations && $preferences->city)
        @php
            $currentWeather = \App\Models\Weather::forCity($preferences->city);
            $weeklyForecast = \App\Models\Weather::weeklyForecast($preferences->city);
        @endphp
        
        @if($currentWeather)
            <div class="tea-card p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold" style="color: var(--text-dark);">
                        🌤️ Weather-Based Recommendations
                    </h2>
                    <span class="text-sm" style="color: var(--text-light);">
                        {{ $currentWeather->city }}, {{ $currentWeather->country }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Current Weather -->
                    <div class="text-center p-4 rounded-lg" style="background: var(--cream-green);">
                        <div class="flex items-center justify-center mb-3">
                            @if($currentWeather->icon_code)
                                <img src="{{ \App\Services\WeatherService::getWeatherIconUrl($currentWeather->icon_code) }}" 
                                     alt="{{ $currentWeather->description }}" 
                                     class="w-16 h-16">
                            @else
                                <span class="text-4xl">🌤️</span>
                            @endif
                        </div>
                        <h3 class="font-semibold mb-1" style="color: var(--text-dark);">Current Weather</h3>
                        <p class="text-2xl font-bold" style="color: var(--accent-green);">
                            {{ round($currentWeather->temperature) }}°C
                        </p>
                        <p class="text-sm capitalize" style="color: var(--text-medium);">
                            {{ $currentWeather->description }}
                        </p>
                        <p class="text-xs mt-2" style="color: var(--text-light);">
                            Feels like {{ round($currentWeather->feels_like) }}°C
                        </p>
                    </div>
                    
                    <!-- Tea Recommendation -->
                    <div class="text-center p-4 rounded-lg" style="background: var(--cream-green);">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-full flex items-center justify-center" style="background: var(--light-green);">
                            <span class="text-xl text-white">🍵</span>
                        </div>
                        <h3 class="font-semibold mb-1" style="color: var(--text-dark);">Recommended For</h3>
                        <p class="text-lg font-bold capitalize" style="color: var(--accent-green);">
                            {{ $currentWeather->getTeaCategory() }} Weather
                        </p>
                        <p class="text-sm" style="color: var(--text-medium);">
                            @if($currentWeather->isHot())
                                ☀️ Cooling teas recommended
                            @elseif($currentWeather->isCold())
                                ❄️ Warming teas recommended
                            @elseif($currentWeather->isRainy())
                                🌧️ Comforting teas recommended
                            @else
                                🌤️ Perfect for any tea
                            @endif
                        </p>
                    </div>
                </div>
                
                <!-- Weekly Forecast Preview -->
                @if($weeklyForecast && $weeklyForecast->count() > 1)
                    <div class="mt-6 pt-6 border-t" style="border-color: var(--border-color);">
                        <h3 class="text-lg font-semibold mb-4" style="color: var(--text-dark);">
                            📅 This Week's Tea Forecast
                        </h3>
                        <div class="grid grid-cols-3 md:grid-cols-7 gap-2">
                            @foreach($weeklyForecast->take(7) as $day)
                                <div class="text-center p-2 rounded" style="background: var(--pale-green);">
                                    <p class="text-xs font-medium" style="color: var(--text-medium);">
                                        {{ \Carbon\Carbon::parse($day->date)->format('D') }}
                                    </p>
                                    <p class="text-lg font-bold" style="color: var(--accent-green);">
                                        {{ round($day->temperature) }}°
                                    </p>
                                    <p class="text-xs" style="color: var(--text-light);">
                                        {{ $day->getTeaCategory() }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($recommendations as $item)
        <div class="tea-card overflow-hidden group">
            @php
                $fallbackImage = 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop';
                $imgSrc = $item['tea']->image
                    ? (str_starts_with($item['tea']->image, 'http') ? $item['tea']->image
                        : (str_starts_with($item['tea']->image, '//') ? 'https:'.$item['tea']->image
                        : (str_starts_with($item['tea']->image, '/storage/') ? $item['tea']->image : '/storage/'.$item['tea']->image)))
                    : $fallbackImage;
            @endphp
            
            <!-- Image Section -->
            <div class="relative h-56 overflow-hidden">
                <img src="{{ $imgSrc }}" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                     alt="{{ $item['tea']->name }}">
                
                <!-- Overlay with score badge -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <!-- Score Badge -->
                <div class="absolute top-4 right-4">
                    <span class="score-badge text-sm px-3 py-1">
                        {{ round($item['contextual_score']) }}/100
                    </span>
                </div>
                
                <!-- Flavor Tag -->
                <div class="absolute top-4 left-4">
                    <span class="flavor-tag">
                        {{ $item['tea']->flavor }}
                    </span>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6">
                <!-- Tea Name -->
                <div class="mb-3">
                    <h3 class="text-xl font-bold group-hover:text-green-700 transition-colors" style="color: var(--text-dark);">
                        {{ $item['tea']->name }}
                    </h3>
                </div>

                <!-- Preference Matching Indicators -->
                @if($preferences)
                    @php
                        $flavorMatch = str_contains(strtolower($item['tea']->flavor), str_replace('_', ' ', strtolower($preferences->preferred_flavor)));
                        $caffeineMatch = str_contains(strtolower($item['tea']->caffeine), str_replace('_', ' ', strtolower($preferences->preferred_caffeine)));
                        $healthMatch = str_contains(strtolower($item['tea']->health_benefit), str_replace('_', ' ', strtolower($preferences->health_goal)));
                    @endphp
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($flavorMatch)
                            <span class="text-xs px-2 py-1 rounded-full" style="background: var(--light-green);">
                                <span class="text-white">🍃 Flavor Match</span>
                            </span>
                        @endif
                        @if($caffeineMatch)
                            <span class="text-xs px-2 py-1 rounded-full" style="background: var(--light-green);">
                                <span class="text-white">⚡ Caffeine Match</span>
                            </span>
                        @endif
                        @if($healthMatch)
                            <span class="text-xs px-2 py-1 rounded-full" style="background: var(--light-green);">
                                <span class="text-white">🌿 Health Match</span>
                            </span>
                        @endif
                    </div>
                @endif

                <!-- Tea Details -->
                <div class="space-y-3 mb-4">
                    <div class="flex items-center justify-between py-2 border-b" style="border-color: var(--border-color);">
                        <span class="text-sm font-medium flex items-center" style="color: var(--text-medium);">
                            <span class="mr-2">🍃</span> Flavor
                        </span>
                        <span class="text-sm font-semibold {{ $flavorMatch ?? false ? 'text-green-600' : '' }}" style="color: var(--accent-green);">
                            {{ $item['tea']->flavor }}
                            @if($preferences && $flavorMatch)
                                <span class="text-xs ml-1">✓</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b" style="border-color: var(--border-color);">
                        <span class="text-sm font-medium flex items-center" style="color: var(--text-medium);">
                            <span class="mr-2">⚡</span> Caffeine
                        </span>
                        <span class="text-sm font-semibold {{ $caffeineMatch ?? false ? 'text-green-600' : '' }}" style="color: var(--accent-green);">
                            {{ $item['tea']->caffeine_level }}
                            @if($preferences && $caffeineMatch)
                                <span class="text-xs ml-1">✓</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b" style="border-color: var(--border-color);">
                        <span class="text-sm font-medium flex items-center" style="color: var(--text-medium);">
                            <span class="mr-2">🌿</span> Health
                        </span>
                        <span class="text-sm font-semibold {{ $healthMatch ?? false ? 'text-green-600' : '' }}" style="color: var(--accent-green);">
                            {{ $item['tea']->health_benefit }}
                            @if($preferences && $healthMatch)
                                <span class="text-xs ml-1">✓</span>
                            @endif
                        </span>
                    </div>
                </div>

                
            <!-- Match Score Breakdown -->
                <div class="mb-6 p-4 rounded-lg" style="background: var(--cream-green);">
                    <div class="text-center mb-3">
                        <span class="text-sm font-medium" style="color: var(--text-dark);">
                            Match Score Breakdown
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="bg-white rounded-lg p-2">
                            <div class="text-xs font-medium mb-1" style="color: var(--text-light);">Flavor</div>
                            <div class="text-lg font-bold" style="color: var(--light-green);">
                                {{ round($item['flavor_score'] * 100) }}%
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-2">
                            <div class="text-xs font-medium mb-1" style="color: var(--text-light);">Caffeine</div>
                            <div class="text-lg font-bold" style="color: var(--light-green);">
                                {{ round($item['caffeine_score'] * 100) }}%
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-2">
                            <div class="text-xs font-medium mb-1" style="color: var(--text-light);">Health</div>
                            <div class="text-lg font-bold" style="color: var(--light-green);">
                                {{ round($item['health_score'] * 100) }}%
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rating Section -->
                <div class="pt-4 border-t" style="border-color: var(--border-color);">
                    @php
                        $userRating = $item['tea']->userRating(auth()->id());
                        $avgRating = $item['tea']->averageRating();
                        $totalRatings = $item['tea']->totalRatings();
                    @endphp
                    
                    <!-- Average Rating Display -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium" style="color: var(--text-medium);">
                                Community Rating
                            </span>
                            <div class="flex items-center">
                                <span class="text-sm font-bold" style="color: var(--accent-green);">
                                    {{ number_format($avgRating, 1) }}
                                </span>
                                <span class="text-yellow-500 ml-1">⭐</span>
                                <span class="text-xs" style="color: var(--text-light);">
                                    ({{ $totalRatings }})
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- User Rating Form -->
                    @if($userRating)
                        <div class="text-center mb-3 p-2 rounded-lg" style="background: var(--pale-green);">
                            <span class="text-sm font-medium" style="color: var(--primary-green);">
                                Your Rating: {{ $userRating->rating }} ⭐
                            </span>
                        </div>
                    @endif

                    <form action="{{ route('ratings.store') }}" method="POST" class="rating-form" data-tea-id="{{ $item['tea']->id }}">
                        @csrf
                        <input type="hidden" name="tea_id" value="{{ $item['tea']->id }}">
                        
                        <div class="flex items-center justify-between mb-3">
                            <label class="text-sm font-medium" style="color: var(--text-medium);">Rate this tea:</label>
                            <select name="rating" class="search-bar text-sm py-2 px-3" style="max-width: 150px;">
                                <option value="">Select rating</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $userRating && $userRating->rating == $i ? 'selected' : '' }}>
                                        {{ $i }} ⭐ @if($i == 1) Poor @elseif($i == 2) Fair @elseif($i == 3) Good @elseif($i == 4) Very Good @else Excellent @endif
                                    </option>
                                @endfor
                            </select>
                        </div>
                        
                        <button type="submit" class="btn-primary w-full text-sm">
                            {{ $userRating ? '🔄 Update Rating' : '⭐ Submit Rating' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>No recommendation available.</p>
    @endforelse
</div>

@endsection

