@extends('layouts.sidebar')
@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2" style="color: var(--text-dark);">
        🇲🇾 Top Tea This Week - Malaysia Focus
    </h1>
    <p class="text-lg" style="color: var(--text-light);">
        Weather-based tea recommendations optimized for Malaysian climate patterns
    </p>
    @if($weeklyWeatherTeas && $weeklyWeatherTeas->isNotEmpty() && isset($weeklyWeatherTeas[0]['weather_details']['is_hot']) && $weeklyWeatherTeas[0]['weather_details']['is_hot'])
        <div class="mt-2 p-2 rounded" style="background: var(--light-green);">
            <p class="text-sm text-white">
                🌡️ <strong>Hot Weather Alert:</strong> Staying cool with refreshing Malaysian tea recommendations
            </p>
        </div>
    @endif
</div>

<!-- Weather-Based Weekly Recommendations -->
@if($weeklyWeatherTeas && $weeklyWeatherTeas->isNotEmpty())
    <div class="tea-card p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold" style="color: var(--text-dark);">
                📅 Your Weekly Tea Forecast
            </h2>
            <div class="text-right">
                <p class="text-sm font-medium" style="color: var(--text-medium);">
                    🇲🇾 {{ $weatherInfo['city'] }}
                </p>
                @if($weatherInfo['current'])
                    <p class="text-xs" style="color: var(--text-light);">
                        Currently {{ round($weatherInfo['current']->temperature) }}°C, {{ $weatherInfo['current']->description }}
                    </p>
                    <p class="text-xs" style="color: var(--text-light);">
                        🕐 {{ \App\Services\WeatherService::formatMalaysianTime(now()) }} (MYT)
                    </p>
                @endif
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($weeklyWeatherTeas as $dayRecommendation)
                <div class="tea-card overflow-hidden group flex flex-col h-full">
                    <!-- Day Header Section -->
                    <div class="relative" style="background: linear-gradient(135deg, var(--accent-green), var(--primary-green));">
                        <!-- Top Section with Day Info -->
                        <div class="p-4 pb-2">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold bg-white bg-opacity-20 backdrop-blur-sm">
                                        {{ $dayRecommendation['day_number'] }}
                                    </div>
                                    <div class="text-white">
                                        <p class="text-sm font-semibold">{{ $dayRecommendation['day_name'] }}</p>
                                        <p class="text-xs opacity-90">{{ $dayRecommendation['short_date'] }}</p>
                                    </div>
                                </div>
                                
                                <!-- Weather Icon and Temp -->
                                <div class="text-right text-white">
                                    @if($dayRecommendation['weather_details']['icon_code'])
                                        <img src="{{ \App\Services\WeatherService::getWeatherIconUrl($dayRecommendation['weather_details']['icon_code']) }}" 
                                             alt="{{ $dayRecommendation['weather_details']['description'] }}" 
                                             class="w-10 h-10 mb-1">
                                    @else
                                        <span class="text-3xl block mb-1">{{ $dayRecommendation['weather_details']['tea_emoji'] }}</span>
                                    @endif
                                    <p class="text-lg font-bold">{{ $dayRecommendation['weather_details']['temperature'] }}°C</p>
                                    <p class="text-xs opacity-90 capitalize">{{ $dayRecommendation['weather_details']['description'] }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Weather Details Bar -->
                        <div class="px-4 pb-4">
                            @if(isset($dayRecommendation['weather_details']))
                                <div class="grid grid-cols-4 gap-2 text-white">
                                    <div class="text-center">
                                        <div class="text-sm font-bold mb-1">{{ $dayRecommendation['weather_details']['feels_like'] ?? 'N/A' }}°</div>
                                        <div class="text-xs font-bold tracking-wide">Feels</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm font-bold mb-1">{{ $dayRecommendation['weather_details']['humidity'] ?? 'N/A' }}%</div>
                                        <div class="text-xs font-bold tracking-wide">Humidity</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm font-bold mb-1">{{ $dayRecommendation['weather_details']['wind_speed'] ?? 'N/A' }}</div>
                                        <div class="text-xs font-bold tracking-wide">Wind</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm font-bold mb-1">{{ isset($dayRecommendation['weather_details']['comfort_level']['emoji']) ? $dayRecommendation['weather_details']['comfort_level']['emoji'] : '😐' }}</div>
                                        <div class="text-xs font-bold tracking-wide">Comfort</div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-white text-xs">
                                    <p>Weather details not available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Tea Recommendation Section -->
                    <div class="p-4 flex flex-col flex-1">
                        @foreach($dayRecommendation['teas'] as $tea)
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 border-2" style="border-color: var(--accent-green);">
                                    @php
                                        $fallbackImage = 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop';
                                        $imgSrc = $tea->image
                                            ? (str_starts_with($tea->image, 'http') ? $tea->image
                                                : (str_starts_with($tea->image, '//') ? 'https:'.$tea->image
                                                : (str_starts_with($tea->image, '/storage/') ? $tea->image : '/storage/'.$tea->image)))
                                            : $fallbackImage;
                                    @endphp
                                    
                                    <img src="{{ $imgSrc }}" 
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" 
                                         alt="{{ $tea->name }}">
                                </div>
                                 
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base font-bold mb-1 truncate group-hover:text-green-700 transition-colors" style="color: var(--text-dark);">
                                        {{ $tea->name }}
                                    </h4>
                                    <p class="text-sm leading-relaxed mb-2" style="color: var(--text-medium);">
                                        {{ $tea->health_benefit }}
                                    </p>
                                    <div class="flex items-center flex-wrap gap-1">
                                        <span class="text-xs font-medium px-2 py-1 rounded" style="background: var(--cream-green); color: var(--accent-green);">
                                            ⭐ {{ $tea->averageRating() ? number_format($tea->averageRating(), 1) : 'N/A' }}
                                        </span>
                                        @if(isset($tea->weather_score) && $tea->weather_score !== null)
                                            <span class="text-xs px-2 py-1 rounded text-white" style="background: var(--accent-green);">
                                                {{ round($tea->weather_score * 100) }}%
                                            </span>
                                        @else
                                            <span class="text-xs px-2 py-1 rounded" style="background: var(--light-green); color: var(--text-medium);">
                                                Weather Match: N/A
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Recommendation Reason -->
                        <div class="p-3 rounded-lg text-sm mt-auto" style="background: var(--cream-green); border-left: 3px solid var(--accent-green);">
                            <div class="flex items-start space-x-2">
                                <span class="text-lg flex-shrink-0">💡</span>
                                <p class="leading-relaxed" style="color: var(--text-medium);">
                                    {{ $dayRecommendation['recommendation_reason'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif


<!-- Regular Top Teas (Fallback or Additional) -->
<div class="mb-8">
    <h2 class="text-2xl font-bold mb-6" style="color: var(--text-dark);">
        🏆 Top 5 Rated Teas
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($topTeas as $tea)
            <div class="tea-card overflow-hidden group">
                <div class="relative h-48 overflow-hidden">
                    @php
                        $fallbackImage = 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop';
                        $imgSrc = $tea->image
                            ? (str_starts_with($tea->image, 'http') ? $tea->image
                                : (str_starts_with($tea->image, '//') ? 'https:'.$tea->image
                                : (str_starts_with($tea->image, '/storage/') ? $tea->image : '/storage/'.$tea->image)))
                            : $fallbackImage;
                    @endphp
                    
                    <img src="{{ $imgSrc }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                         alt="{{ $tea->name }}">
                    
                    <!-- Rating Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="score-badge">
                            {{ $tea->averageRating() ? number_format($tea->averageRating(), 1) : 'N/A' }}
                        </span>
                    </div>
                    
                    <!-- Flavor Tag -->
                    <div class="absolute top-4 left-4">
                        <span class="flavor-tag">
                            {{ $tea->flavor }}
                        </span>
                    </div>
                </div>

                <div class="p-4">
                    <h3 class="text-lg font-bold mb-2 group-hover:text-green-700 transition-colors" style="color: var(--text-dark);">
                        {{ $tea->name }}
                    </h3>

                    <div class="space-y-1 mb-3">
                        <div class="flex items-center justify-between py-1 border-b" style="border-color: var(--border-color);">
                            <span class="text-xs font-medium flex items-center" style="color: var(--text-medium);">
                                <span class="mr-2">🍃</span> Flavor
                            </span>
                            <span class="text-xs font-semibold" style="color: var(--accent-green);">
                                {{ $tea->flavor }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-1 border-b" style="border-color: var(--border-color);">
                            <span class="text-xs font-medium flex items-center" style="color: var(--text-medium);">
                                <span class="mr-2">⚡</span> Caffeine
                            </span>
                            <span class="text-xs font-semibold" style="color: var(--accent-green);">
                                {{ $tea->caffeine_level }}
                            </span>
                        </div>
                    </div>

                    <p class="text-xs mb-3 line-clamp-2" style="color: var(--text-light);">
                        {{ $tea->health_benefit }}
                    </p>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-1">
                            <span class="text-sm font-medium" style="color: var(--accent-green);">
                                {{ $tea->averageRating() ? number_format($tea->averageRating(), 1) : 'N/A' }}
                            </span>
                        </div>
                        <span class="text-xs" style="color: var(--text-light);">
                            {{ $tea->ratings_count }} ratings
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Debug Information (Remove in production) -->
@if(auth()->user() && auth()->user()->preference)
    @php
        $weatherService = app(\App\Services\WeatherService::class);
        $apiStats = $weatherService->getApiUsageStats();
    @endphp
    
    <div class="mb-4 p-4 rounded border" style="background: var(--cream-green); border-color: var(--accent-green);">
        <h4 class="font-bold mb-2" style="color: var(--text-dark);">🔍 System Information:</h4>
        
        <!-- Weather Status -->
        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
            <div>
                <p style="color: var(--text-medium);">
                    <strong>Weather Enabled:</strong> 
                    <span class="{{ auth()->user()->preference->weather_based_recommendations ? 'text-green-600' : 'text-red-600' }}">
                        {{ auth()->user()->preference->weather_based_recommendations ? '✅ Yes' : '❌ No' }}
                    </span>
                </p>
                <p style="color: var(--text-medium);">
                    <strong>City:</strong> 
                    <span class="{{ auth()->user()->preference->city ? 'text-green-600' : 'text-red-600' }}">
                        {{ auth()->user()->preference->city ?: '❌ Not set' }}
                    </span>
                </p>
                <p style="color: var(--text-medium);">
                    <strong>Weather Preference:</strong> 
                    <span class="{{ auth()->user()->preference->weather_preference ? 'text-green-600' : 'text-orange-600' }}">
                        {{ auth()->user()->preference->weather_preference ?: '⚠️ Not set (defaults to auto)' }}
                    </span>
                </p>
            </div>
            <div>
                <p style="color: var(--text-medium);">
                    <strong>Weekly Weather Data:</strong> 
                    <span class="{{ $weeklyWeatherTeas && $weeklyWeatherTeas->isNotEmpty() ? 'text-green-600' : 'text-red-600' }}">
                        {{ $weeklyWeatherTeas ? '✅ ' . $weeklyWeatherTeas->count() . ' days' : '❌ None' }}
                    </span>
                </p>
                <p style="color: var(--text-medium);">
                    <strong>API Key Status:</strong> 
                    <span class="{{ config('services.openweather.api_key') ? 'text-green-600' : 'text-red-600' }}">
                        {{ config('services.openweather.api_key') ? '✅ Set' : '❌ Missing' }}
                    </span>
                </p>
                <p style="color: var(--text-medium);">
                    <strong>Weather Info:</strong> 
                    <span class="{{ $weatherInfo ? 'text-green-600' : 'text-red-600' }}">
                        {{ $weatherInfo ? '✅ Available' : '❌ Not available' }}
                    </span>
                </p>
            </div>
        </div>
        
        <!-- API Usage Status -->
        <div class="border-t pt-3" style="border-color: var(--border-color);">
            <h5 class="font-semibold mb-2" style="color: var(--text-dark);">📊 API Usage Until Jan 29:</h5>
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div class="text-center p-2 rounded" style="background: var(--pale-green);">
                    <div class="font-bold" style="color: {{ $apiStats['daily_percentage'] >= 90 ? 'var(--danger-red)' : 'var(--accent-green)' }};">
                        {{ $apiStats['daily_calls'] }}/{{ $apiStats['daily_limit'] }}
                    </div>
                    <p class="text-xs" style="color: var(--text-light);">Today's Calls</p>
                </div>
                <div class="text-center p-2 rounded" style="background: var(--pale-green);">
                    <div class="font-bold" style="color: {{ $apiStats['days_until_jan29'] <= 3 ? 'var(--danger-red)' : 'var(--accent-green)' }};">
                        {{ $apiStats['days_until_jan29'] }} days
                    </div>
                    <p class="text-xs" style="color: var(--text-light);">Until Deadline</p>
                </div>
                <div class="text-center p-2 rounded" style="background: var(--pale-green);">
                    <div class="font-bold" style="color: var(--accent-green);">
                        {{ $apiStats['cache_duration_minutes'] }} min
                    </div>
                    <p class="text-xs" style="color: var(--text-light);">Cache Duration</p>
                </div>
            </div>
            <div class="mt-2 p-2 rounded text-xs" 
                 style="background: {{ $apiStats['days_until_jan29'] <= 1 ? 'var(--danger-red)' : 
                               ($apiStats['days_until_jan29'] <= 3 ? 'var(--warning-orange)' : 'var(--light-green)') }};">
                <p style="color: black;">
                    📋 <strong>Status:</strong> {{ $apiStats['recommendation'] }}
                </p>
            </div>
        </div>
        
        @if(!auth()->user()->preference->weather_based_recommendations)
            <div class="mt-3 p-2 rounded" style="background: var(--light-green);">
                <p class="text-xs text-white">
                    💡 <strong>Solution:</strong> Go to <a href="{{ route('find.tea') }}" class="underline">Find Tea</a> and enable weather-based recommendations
                </p>
            </div>
        @elseif(!auth()->user()->preference->city)
            <div class="mt-3 p-2 rounded" style="background: var(--light-green);">
                <p class="text-xs text-white">
                    💡 <strong>Solution:</strong> Go to <a href="{{ route('find.tea') }}" class="underline">Find Tea</a> and enter your city
                </p>
            </div>
        @elseif(!config('services.openweather.api_key'))
            <div class="mt-3 p-2 rounded" style="background: var(--warning-orange);">
                <p class="text-xs text-white">
                    ⚠️ <strong>Action Required:</strong> Add OpenWeatherMap API key to your .env file
                </p>
            </div>
        @elseif(!$weeklyWeatherTeas || $weeklyWeatherTeas->isEmpty())
            <div class="mt-3 p-2 rounded" style="background: var(--warning-orange);">
                <p class="text-xs text-white">
                    ⚠️ <strong>Issue:</strong> Weather data not found. The system will try to fetch it automatically.
                </p>
            </div>
        @endif
    </div>
@endif

<!-- Enable Weather Recommendations CTA -->
@if(!$weeklyWeatherTeas || $weeklyWeatherTeas->isEmpty())
    <div class="text-center py-8">
        <div class="max-w-md mx-auto">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: var(--cream-green);">
                <span class="text-3xl">🌤️</span>
            </div>
            
            <h3 class="text-xl font-bold mb-3" style="color: var(--text-dark);">
                Get Weather-Based Tea Recommendations!
            </h3>
            
            <p class="text-sm mb-4" style="color: var(--text-light);">
                Enable weather-based recommendations to get personalized tea suggestions for each day of the week based on your local weather forecast.
            </p>
            
            <a href="{{ route('find.tea') }}" class="btn-primary">
                🌤️ Set Up Weather Preferences
            </a>
        </div>
    </div>
@endif

@endsection
