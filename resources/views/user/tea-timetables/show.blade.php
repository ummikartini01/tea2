@extends('layouts.sidebar')

@section('content')
<div class="max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $teaTimetable->title }}</h1>
                <p class="text-gray-600">{{ $teaTimetable->description }}</p>
            </div>
            <div class="flex items-center space-x-2">
                @if($teaTimetable->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Inactive
                    </span>
                @endif
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex items-center space-x-4">
            <a href="https://t.me/teazy_reminder_bot" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.56l-1.68 7.92c-.12.57-.46.71-.91.44l-2.49-1.85-1.2 1.16c-.14.14-.26.26-.52.26l.18-2.77 4.63-4.19c.2-.18-.05-.28-.31-.1l-5.72 3.6-2.47-.77c-.53-.17-.54-.53.11-.78l9.63-3.71c.44-.16.82.11.68.78z"/>
                </svg>
                <span>📱 Chat with Teazy Bot</span>
            </a>
            <a href="{{ route('user.tea-timetables.edit', $teaTimetable) }}" class="btn-secondary">
                ✏️ Edit
            </a>
            <a href="{{ route('user.tea-timetables.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Timetables
            </a>
        </div>
    </div>

    <!-- Timetable Details -->
    <div class="tea-card p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">📅 Schedule Details</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="font-medium text-gray-900 mb-3">Basic Information</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-medium">{{ $teaTimetable->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Start Date:</span>
                        <span class="font-medium">{{ $teaTimetable->start_date->format('F j, Y') }}</span>
                    </div>
                    @if($teaTimetable->end_date)
                        <div class="flex justify-between">
                            <span class="text-gray-600">End Date:</span>
                            <span class="font-medium">{{ $teaTimetable->end_date->format('F j, Y') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Timezone:</span>
                        <span class="font-medium">{{ $teaTimetable->timezone }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium">{{ $teaTimetable->created_at->format('F j, Y g:i A') }}</span>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="font-medium text-gray-900 mb-3">Telegram Notifications</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-medium">{{ $teaTimetable->telegram_notifications_enabled ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                    @if($teaTimetable->telegram_notifications_enabled && $teaTimetable->telegram_chat_id)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Chat ID:</span>
                            <span class="font-medium">{{ $teaTimetable->telegram_chat_id }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Schedule -->
    <div class="tea-card p-6">
        <h2 class="text-xl font-semibold mb-4">🍵 Weekly Tea Schedule</h2>
        
        @php
            $days = [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday', 
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday'
            ];
            
            $teaEmojis = [
                'herbal' => '🌿',
                'bitter' => '🍃',
                'sweet' => '🍯',
                'fruity' => '🍓',
                'spicy' => '🌶️',
                'minty' => '🌱',
                'various' => '🎨',
                'n/a' => '☕',
            ];
        @endphp
        
        <div class="space-y-4">
            @foreach($days as $dayKey => $dayName)
                @php
                    $daySchedule = collect($teaTimetable->schedule)->firstWhere('day', $dayKey);
                    $timeSlots = $daySchedule['times'] ?? [];
                @endphp
                
                @if(!empty($timeSlots))
                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="font-semibold text-lg mb-3">{{ $dayName }}</h3>
                        <div class="space-y-2">
                            @foreach($timeSlots as $timeSlot)
                                @php
                                    $tea = \App\Models\Tea::find($timeSlot['tea_id']);
                                    $emoji = $teaEmojis[strtolower($tea->flavor ?? '')] ?? '☕';
                                @endphp
                                
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-lg">{{ $emoji }}</span>
                                        <div>
                                            <div class="font-medium">{{ date('g:i A', strtotime($timeSlot['time'])) }}</div>
                                            <div class="text-sm text-gray-600">{{ $tea->name }}</div>
                                            @if(!empty($timeSlot['notes']))
                                                <div class="text-xs text-gray-500 italic">📝 {{ $timeSlot['notes'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">{{ $tea->flavor }}</div>
                                        <div class="text-xs text-gray-500">{{ $tea->caffeine_level }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="border-l-4 border-gray-300 pl-4 opacity-50">
                        <h3 class="font-semibold text-lg mb-3 text-gray-500">{{ $dayName }}</h3>
                        <p class="text-gray-400 italic">No tea scheduled</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
