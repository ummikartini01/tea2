@extends('layouts.admin-sidebar')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h1 class="text-3xl font-bold mb-2">Scraped Teas</h1>
            <p class="text-gray-600">Manage and edit scraped tea data</p>
        </div>
        <div class="space-x-4">
            <form action="{{ route('admin.scrape.teas') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    🕷️ Scrap Tea Data
                </button>
            </form>
            <a href="{{ route('admin.teas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block">
                ➕ Add New Tea
            </a>
        </div>
    </div>
    
    <!-- Flavor Filter -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.teas.scraped') }}" class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <label for="flavor" class="text-sm font-medium text-gray-700">
                    🍃 Filter by Flavor:
                </label>
                <select name="flavor" id="flavor" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all" {{ $flavorFilter === 'all' ? 'selected' : '' }}>
                        All Flavors ({{ $teas->count() }})
                    </option>
                    @foreach($availableFlavors as $flavor)
                        @php
                            $count = \App\Models\Tea::where('source', 'scraped')->where('flavor', $flavor)->count();
                        @endphp
                        <option value="{{ $flavor }}" {{ $flavorFilter === $flavor ? 'selected' : '' }}>
                            {{ ucfirst($flavor) }} ({{ $count }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover:bg-gray-700">
                🔍 Apply Filter
            </button>
            
            @if($flavorFilter !== 'all')
                <a href="{{ route('admin.teas.scraped') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300 inline-block">
                    ✖️ Clear Filter
                </a>
            @endif
        </form>
        
        @if($flavorFilter !== 'all')
            <div class="mt-3 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Showing <span class="font-semibold text-blue-600">{{ $teas->count() }}</span> teas with flavor: 
                    <span class="font-semibold text-blue-600">{{ ucfirst($flavorFilter) }}</span>
                </div>
                <div class="text-xs text-gray-500">
                    Total scraped teas: {{ \App\Models\Tea::where('source', 'scraped')->count() }}
                </div>
            </div>
        @else
            <div class="mt-3 text-xs text-gray-500 text-right">
                Total scraped teas: {{ \App\Models\Tea::where('source', 'scraped')->count() }}
            </div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($teas as $tea)
        <div class="bg-white rounded shadow overflow-hidden">
            @php
                $fallbackImage = 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=600&h=400&fit=crop';
                $imgSrc = $tea->image
                    ? (str_starts_with($tea->image, 'http') ? $tea->image
                        : (str_starts_with($tea->image, '//') ? 'https:'.$tea->image
                        : (str_starts_with($tea->image, '/storage/') ? $tea->image : '/storage/'.$tea->image)))
                    : $fallbackImage;
            @endphp
            <img src="{{ $imgSrc }}" alt="{{ $tea->name }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="text-lg font-semibold text-gray-900 leading-tight">{{ $tea->name }}</h2>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('admin.teas.edit', $tea->id) }}" class="text-blue-600 hover:text-blue-900">
                            ✏️
                        </a>
                        <form action="{{ route('admin.teas.destroy', $tea->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-3 space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-700">Flavor:</span>
                        @if($flavorFilter !== 'all' && $tea->flavor === $flavorFilter)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                🍃 {{ $tea->flavor }}
                            </span>
                        @else
                            <span class="text-gray-600">{{ $tea->flavor }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-700">Caffeine:</span>
                        <span class="text-gray-600">{{ $tea->caffeine_level }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 block mb-1">Benefit:</span>
                        <span class="text-gray-600 text-xs leading-relaxed">{{ Str::limit($tea->health_benefit, 80) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded shadow p-6 text-center text-gray-500">
            No scraped teas found. Use the "Scrape Tea Data" button to get started.
        </div>
    @endforelse
</div>

@endsection
