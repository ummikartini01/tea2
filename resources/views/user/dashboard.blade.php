@extends('layouts.sidebar')

@section('content')

<!-- Welcome Section -->
<div class="mb-8">
    <div class="text-center mb-8">
        <h1 class="text-5xl font-bold mb-4" style="color: var(--primary-green);">
            Welcome to Teazy
        </h1>
        <p class="text-xl" style="color: var(--text-light);">
            Discover your perfect tea match with our smart recommendation system
        </p>
    </div>
</div>

<!-- Search Section -->
<div class="max-w-4xl mx-auto mb-12">
    <div class="card p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold mb-2" style="color: var(--text-dark);">
                🍃 Search Your Favorite Tea
            </h2>
            <p class="text-medium" style="color: var(--text-light);">
                Find teas by name, flavor, or health benefits
            </p>
        </div>
        
        <form method="GET" action="{{ route('tea.search') }}" class="relative">
            @csrf
            <div class="relative max-w-2xl mx-auto">
                <input 
                    type="text" 
                    name="query" 
                    placeholder="Search for green tea, chamomile, stress relief..."
                    class="search-bar pr-12"
                    value="{{ request('query') }}"
                >
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 rounded-full hover:bg-green-100 transition-colors">
                    <svg class="w-5 h-5" style="color: var(--accent-green);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>
        
        @if(request('query'))
            <div class="mt-4 text-center">
                <p class="text-sm" style="color: var(--text-light);">
                    Showing results for: <span class="font-semibold" style="color: var(--accent-green);">{{ request('query') }}</span>
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="tea-card p-6 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: var(--pale-green);">
            <span class="text-2xl">🔍</span>
        </div>
        <h3 class="text-xl font-bold mb-2" style="color: var(--text-dark);">Find Tea</h3>
        <p class="text-medium mb-4" style="color: var(--text-light);">Get personalized recommendations based on your preferences</p>
        <a href="{{ route('find.tea') }}" class="btn-secondary">
            Explore Now
        </a>
    </div>

    <div class="tea-card p-6 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: var(--pale-green);">
            <span class="text-2xl">⭐</span>
        </div>
        <h3 class="text-xl font-bold mb-2" style="color: var(--text-dark);">Top Rated</h3>
        <p class="text-medium mb-4" style="color: var(--text-light);">Discover the most loved teas by our community</p>
        <a href="{{ route('top.tea') }}" class="btn-secondary">
            View Top Teas
        </a>
    </div>

    <div class="tea-card p-6 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: var(--pale-green);">
            <span class="text-2xl">💡</span>
        </div>
        <h3 class="text-xl font-bold mb-2" style="color: var(--text-dark);">Your History</h3>
        <p class="text-medium mb-4" style="color: var(--text-light);">View your previous recommendations and ratings</p>
        <a href="{{ route('recommendations') }}" class="btn-secondary">
            My Recommendations
        </a>
    </div>
</div>

<!-- Recent Activity -->
@if(auth()->user()->ratings()->count() > 0)
<div class="max-w-6xl mx-auto">
    <div class="card p-8">
        <h2 class="text-2xl font-bold mb-6" style="color: var(--text-dark);">🌿 Your Recent Activity</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $recentRatings = auth()->user()->ratings()->with('tea')->latest()->take(6)->get();
            @endphp
            
            @forelse($recentRatings as $rating)
                <div class="flex items-center space-x-3 p-3 rounded-lg" style="background: var(--cream-green);">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--light-green);">
                            <span class="text-white font-bold text-sm">{{ $rating->rating }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium truncate" style="color: var(--text-dark);">{{ $rating->tea->name }}</p>
                        <p class="text-sm" style="color: var(--text-light);">{{ $rating->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p style="color: var(--text-light);">No recent activity. Start exploring teas!</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('rated.tea') }}" class="btn-secondary">
                View All Rated Teas
            </a>
        </div>
    </div>
</div>
@endif

@endsection
