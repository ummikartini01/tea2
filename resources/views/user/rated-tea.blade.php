@extends('layouts.sidebar')
@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2" style="color: var(--text-dark);">
        ⭐ My Rated Teas
    </h1>
    <p class="text-lg" style="color: var(--text-light);">
        Manage your tea ratings and personal notes
    </p>
</div>

@if(session('success'))
    <div class="mb-6 p-4 rounded-lg border-l-4" style="background: var(--cream-green); border-color: var(--light-green);">
        <div class="flex items-center">
            <span class="text-2xl mr-3">✅</span>
            <p class="font-medium" style="color: var(--primary-green);">
                {{ session('success') }}
            </p>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($ratings as $rating)
        <div class="tea-card overflow-hidden group">
            <!-- Image Section -->
            <div class="relative h-48 overflow-hidden">
                @php
                    $fallbackImage = 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop';
                    $imgSrc = $rating->tea->image
                        ? (str_starts_with($rating->tea->image, 'http') ? $rating->tea->image
                            : (str_starts_with($rating->tea->image, '//') ? 'https:'.$rating->tea->image
                            : (str_starts_with($rating->tea->image, '/storage/') ? $rating->tea->image : '/storage/'.$rating->tea->image)))
                        : $fallbackImage;
                @endphp
                
                <img src="{{ $imgSrc }}" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                     alt="{{ $rating->tea->name }}">
                
                <!-- Rating Badge -->
                <div class="absolute top-4 right-4">
                    <span class="score-badge">
                        ⭐ {{ $rating->rating }}/5
                    </span>
                </div>
                
                <!-- Flavor Tag -->
                <div class="absolute top-4 left-4">
                    <span class="flavor-tag">
                        {{ $rating->tea->flavor }}
                    </span>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6">
                <!-- Tea Name -->
                <h3 class="text-xl font-bold mb-3 group-hover:text-green-700 transition-colors" style="color: var(--text-dark);">
                    {{ $rating->tea->name }}
                </h3>

                <!-- Tea Details -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center justify-between py-2 border-b" style="border-color: var(--border-color);">
                        <span class="text-sm font-medium flex items-center" style="color: var(--text-medium);">
                            <span class="mr-2">🍃</span> Flavor
                        </span>
                        <span class="text-sm font-semibold" style="color: var(--accent-green);">
                            {{ $rating->tea->flavor }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b" style="border-color: var(--border-color);">
                        <span class="text-sm font-medium flex items-center" style="color: var(--text-medium);">
                            <span class="mr-2">⚡</span> Caffeine
                        </span>
                        <span class="text-sm font-semibold" style="color: var(--accent-green);">
                            {{ $rating->tea->caffeine_level }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b" style="border-color: var(--border-color);">
                        <span class="text-sm font-medium flex items-center" style="color: var(--text-medium);">
                            <span class="mr-2">🌿</span> Health Benefit
                        </span>
                        <span class="text-sm font-semibold" style="color: var(--accent-green);">
                            {{ $rating->tea->health_benefit }}
                        </span>
                    </div>
                </div>

                <!-- User Notes -->
                @if($rating->description)
                    <div class="mb-4 p-3 rounded-lg" style="background: var(--cream-green);">
                        <div class="flex items-start">
                            <span class="text-lg mr-2 mt-1">📝</span>
                            <div class="flex-1">
                                <p class="text-sm leading-relaxed" style="color: var(--text-medium);">
                                    {{ Str::limit($rating->description, 100) }}
                                    @if(strlen($rating->description) > 100)
                                        <span class="text-xs" style="color: var(--text-light);">...</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-4 p-3 rounded-lg border-2 border-dashed" style="border-color: var(--pale-green);">
                        <div class="text-center">
                            <span class="text-2xl mb-2 block">📝</span>
                            <p class="text-sm" style="color: var(--text-light);">
                                No notes added yet
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Rating Info -->
                <div class="mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium" style="color: var(--text-medium);">
                            Rated: {{ $rating->rating }}/5
                        </span>
                        <span class="text-xs" style="color: var(--text-light);">
                            {{ $rating->updated_at->format('M j, Y') }}
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between space-x-2">
                    <a href="{{ route('rated.tea.edit', $rating->id) }}" 
                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg border transition-colors duration-200 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1"
                       style="background: white; border-color: var(--accent-green); color: var(--accent-green);">
                        ✏️ Edit
                    </a>
                    
                    <form action="{{ route('rated.tea.destroy', $rating->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this rating?')" 
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg border transition-colors duration-200 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1"
                                style="background: white; border-color: #ef4444; color: #ef4444;">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--cream-green);">
                        <span class="text-4xl">⭐</span>
                    </div>
                    
                    <h3 class="text-2xl font-bold mb-4" style="color: var(--text-dark);">
                        No Rated Teas Yet
                    </h3>
                    
                    <p class="text-lg mb-6" style="color: var(--text-light);">
                        Start exploring and rating teas to build your personal collection!
                    </p>
                    
                    <div class="space-y-3">
                        <a href="{{ route('find.tea') }}" class="btn-primary block">
                            🔍 Find Teas to Rate
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="btn-secondary block">
                            🏠 Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
</div>

@endsection
