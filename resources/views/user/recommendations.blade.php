@extends('layouts.sidebar')
@section('content')

<h1 class="text-3xl font-bold mb-6">My Previous Recommendations</h1>

<!-- Chosen Preferences Section -->
@if($preferences)
    <div class="tea-card p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-bold mb-2" style="color: var(--text-dark);">
                    🎯 Your Chosen Preferences
                </h2>
                <p class="text-sm" style="color: var(--text-light);">
                    These preferences were used for your previous recommendations
                </p>
            </div>
            <a href="{{ route('find.tea') }}" class="btn-secondary">
                ✏️ Update Preferences
            </a>
        </div>
        
        <!-- Preferences Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Flavor Preference -->
            <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--cream-green);">
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                    <span class="text-white">🍃</span>
                </div>
                <div>
                    <p class="font-semibold text-sm" style="color: var(--text-dark);">Flavor</p>
                    <p class="text-sm font-medium capitalize" style="color: var(--accent-green);">
                        {{ str_replace('_', ' ', $preferences->preferred_flavor) }}
                    </p>
                </div>
            </div>
            
            <!-- Caffeine Preference -->
            <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--cream-green);">
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                    <span class="text-white">⚡</span>
                </div>
                <div>
                    <p class="font-semibold text-sm" style="color: var(--text-dark);">Caffeine</p>
                    <p class="text-sm font-medium capitalize" style="color: var(--accent-green);">
                        {{ str_replace('_', ' ', $preferences->preferred_caffeine) }}
                    </p>
                </div>
            </div>
            
            <!-- Health Goal -->
            <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--cream-green);">
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                    <span class="text-white">🌿</span>
                </div>
                <div>
                    <p class="font-semibold text-sm" style="color: var(--text-dark);">Health Goal</p>
                    <p class="text-sm font-medium capitalize" style="color: var(--accent-green);">
                        {{ str_replace('_', ' ', $preferences->health_goal) }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Weather Preferences (if enabled) -->
        @if($preferences->weather_based_recommendations)
            <div class="border-t pt-4 mt-4" style="border-color: var(--border-color);">
                <h3 class="font-semibold text-sm mb-3" style="color: var(--text-dark);">🌤️ Weather Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--pale-green);">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                            <span class="text-white text-xs">🇲🇾</span>
                        </div>
                        <div>
                            <p class="font-semibold text-xs" style="color: var(--text-dark);">City</p>
                            <p class="text-xs" style="color: var(--text-medium);">
                                {{ $preferences->city ?? 'Not set' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--pale-green);">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                            <span class="text-white text-xs">🌡️</span>
                        </div>
                        <div>
                            <p class="font-semibold text-xs" style="color: var(--text-dark);">Weather Mode</p>
                            <p class="text-xs" style="color: var(--text-medium);">
                                {{ $preferences->weather_preference ? str_replace('_', ' ', ucfirst($preferences->weather_preference)) : 'Auto' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--pale-green);">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: var(--accent-green);">
                            <span class="text-white text-xs">✅</span>
                        </div>
                        <div>
                            <p class="font-semibold text-xs" style="color: var(--text-dark);">Status</p>
                            <p class="text-xs" style="color: var(--text-medium);">
                                Weather recommendations enabled
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Preference Summary -->
        <div class="mt-4 p-3 rounded-lg" style="background: var(--light-green);">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-white">
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

@if($recommendations->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($recommendations as $recommendation)
            <div class="tea-card overflow-hidden group">
                @php
                    $fallbackImage = 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop';
                    $imgSrc = $recommendation['tea']->image
                        ? (str_starts_with($recommendation['tea']->image, 'http') ? $recommendation['tea']->image
                            : (str_starts_with($recommendation['tea']->image, '//') ? 'https:'.$recommendation['tea']->image
                            : (str_starts_with($recommendation['tea']->image, '/storage/') ? $recommendation['tea']->image : '/storage/'.$recommendation['tea']->image)))
                        : $fallbackImage;
                @endphp
                
                <!-- Image Section -->
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $imgSrc }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                         alt="{{ $recommendation['tea']->name }}">
                    
                    <!-- Overlay with score badge -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Score Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="score-badge text-sm px-3 py-1">
                            {{ round($recommendation['contextual_score']) }}/100
                        </span>
                    </div>
                    
                    <!-- Flavor Tag -->
                    <div class="absolute top-4 left-4">
                        <span class="flavor-tag">
                            {{ $recommendation['tea']->flavor }}
                        </span>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-6">
                    <!-- Tea Name -->
                    <h3 class="text-xl font-bold mb-3 group-hover:text-green-700 transition-colors" style="color: var(--text-dark);">
                        {{ $recommendation['tea']->name }}
                    </h3>

                    <!-- Tea Details -->
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between py-2 border-b" style="border-color: var(--border-color);">
                            <span class="text-sm font-medium flex items-center" style="color: var(--text-medium);">
                                <span class="mr-2">🍃</span> Flavor
                            </span>
                            <span class="text-sm font-semibold" style="color: var(--accent-green);">
                                {{ $recommendation['tea']->flavor }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b" style="border-color: var(--border-color);">
                            <span class="text-sm font-medium flex items-center" style="color: var(--text-medium);">
                                <span class="mr-2">⚡</span> Caffeine
                            </span>
                            <span class="text-sm font-semibold" style="color: var(--accent-green);">
                                {{ $recommendation['tea']->caffeine_level }}
                            </span>
                        </div>
                    </div>

                    <!-- Health Benefit -->
                    <div class="mb-4">
                        <p class="text-sm leading-relaxed line-clamp-3" style="color: var(--text-light);">
                            {{ $recommendation['tea']->health_benefit }}
                        </p>
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
                                    {{ round($recommendation['flavor_score'] * 100) }}%
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-2">
                                <div class="text-xs font-medium mb-1" style="color: var(--text-light);">Caffeine</div>
                                <div class="text-lg font-bold" style="color: var(--light-green);">
                                    {{ round($recommendation['caffeine_score'] * 100) }}%
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-2">
                                <div class="text-xs font-medium mb-1" style="color: var(--text-light);">Health</div>
                                <div class="text-lg font-bold" style="color: var(--light-green);">
                                    {{ round($recommendation['health_score'] * 100) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="text-center">
                        <a href="{{ route('find.tea') }}" class="btn-secondary w-full">
                            🔄 Get New Recommendations
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-12">
        <div class="max-w-md mx-auto">
            <div class="text-6xl mb-4">💡</div>
            <p class="text-gray-500 text-lg mb-4">No recommendations available yet.</p>
            <p class="text-gray-400 text-sm mb-6">Please set your preferences to get personalized recommendations.</p>
            <a href="{{ route('find.tea') }}" class="btn-primary">
                Set Preferences Now
            </a>
        </div>
    </div>
@endif

@endsection
