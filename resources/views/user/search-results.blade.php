@extends('layouts.sidebar')
@section('content')

<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold mb-2" style="color: var(--text-dark);">
                🍃 Search Results
            </h1>
            <p class="text-lg" style="color: var(--text-light);">
                Found {{ $teas->count() }} teas for "<span style="color: var(--accent-green);">{{ $query }}</span>"
            </p>
        </div>
        
        <a href="{{ route('user.dashboard') }}" class="btn-secondary">
            ← Back to Dashboard
        </a>
    </div>
</div>

@if($teas->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($teas as $tea)
            <div class="tea-card overflow-hidden">
                @php
                    $fallbackImage = 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop';
                    $imgSrc = $tea->image
                        ? (str_starts_with($tea->image, 'http') ? $tea->image
                            : (str_starts_with($tea->image, '//') ? 'https:'.$tea->image
                            : (str_starts_with($tea->image, '/storage/') ? $tea->image : '/storage/'.$tea->image)))
                        : $fallbackImage;
                @endphp
                
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $imgSrc }}" 
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" 
                         alt="{{ $tea->name }}">
                    
                    <div class="absolute top-3 right-3">
                        <span class="flavor-tag">
                            {{ $tea->flavor }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2" style="color: var(--text-dark);">
                        {{ $tea->name }}
                    </h3>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium" style="color: var(--text-medium);">Flavor</span>
                            <span class="text-sm" style="color: var(--text-light);">{{ $tea->flavor }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium" style="color: var(--text-medium);">Caffeine</span>
                            <span class="text-sm" style="color: var(--text-light);">{{ $tea->caffeine_level }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-sm line-clamp-2" style="color: var(--text-light);">
                            {{ $tea->health_benefit }}
                        </p>
                    </div>

                    <!-- Rating Section -->
                    <div class="pt-4 border-t" style="border-color: var(--border-color);">
                        <!-- Average Rating Display -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium" style="color: var(--text-medium);">
                                    {{ number_format($tea->average_rating, 1) }}
                                </span>
                                <span class="text-yellow-500">⭐</span>
                                <span class="text-xs" style="color: var(--text-light);">
                                    ({{ $tea->total_ratings }} reviews)
                                </span>
                            </div>
                        </div>

                        <!-- User Rating Form -->
                        <form action="{{ route('ratings.store') }}" method="POST" class="rating-form" data-tea-id="{{ $tea->id }}">
                            @csrf
                            <input type="hidden" name="tea_id" value="{{ $tea->id }}">
                            
                            @if($tea->user_rating)
                                <div class="text-sm text-green-600 mb-2">
                                    You rated: {{ $tea->user_rating->rating }} ⭐
                                </div>
                            @endif

                            <div class="flex items-center space-x-2">
                                <label class="text-sm" style="color: var(--text-medium);">Rate:</label>
                                <select name="rating" class="border rounded px-2 py-1 text-sm" style="border-color: var(--border-color);">
                                    <option value="">Select rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ $tea->user_rating && $tea->user_rating->rating == $i ? 'selected' : '' }}>
                                            {{ $i }} - @if($i == 1) Poor @elseif($i == 2) Fair @elseif($i == 3) Good @elseif($i == 4) Very Good @else Excellent @endif
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            
                            <button type="submit" class="mt-2 btn-primary text-sm px-3 py-1">
                                {{ $tea->user_rating ? 'Update' : 'Submit' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-16">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--cream-green);">
                <span class="text-4xl">🔍</span>
            </div>
            
            <h3 class="text-2xl font-bold mb-4" style="color: var(--text-dark);">
                No teas found
            </h3>
            
            <p class="text-lg mb-6" style="color: var(--text-light);">
                We couldn't find any teas matching "<span style="color: var(--accent-green);">{{ $query }}</span>"
            </p>
            
            <div class="space-y-3">
                <a href="{{ route('find.tea') }}" class="btn-primary block">
                    Try Personalized Recommendations
                </a>
                <a href="{{ route('user.dashboard') }}" class="btn-secondary block">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
@endif

@endsection
