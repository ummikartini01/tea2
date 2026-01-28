@extends('layouts.sidebar')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2">🍵 My Tea Timetables</h1>
            <p class="text-gray-600">Create and manage your personalized tea schedules</p>
        </div>
        <div class="flex space-x-3">
            <a href="https://t.me/teazy_reminder_bot" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.56l-1.68 7.92c-.12.57-.46.71-.91.44l-2.49-1.85-1.2 1.16c-.14.14-.26.26-.52.26l.18-2.77 4.63-4.19c.2-.18-.05-.28-.31-.1l-5.72 3.6-2.47-.77c-.53-.17-.54-.53.11-.78l9.63-3.71c.44-.16.82.11.68.78z"/>
                </svg>
                <span>📱 Teazy Bot</span>
            </a>
            <a href="{{ route('user.tea-timetables.create') }}" class="btn-primary">
                ➕ Create New Timetable
            </a>
        </div>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($timetables as $timetable)
        <div class="tea-card">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $timetable->title }}</h3>
                        <p class="text-gray-600 text-sm">{{ $timetable->description }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($timetable->is_active)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inactive
                            </span>
                        @endif
                        @if($timetable->telegram_notifications_enabled)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                📱 Telegram
                            </span>
                        @endif
                    </div>
                </div>

                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <div class="flex justify-between">
                        <span>Start Date:</span>
                        <span class="font-medium">{{ $timetable->start_date->format('M j, Y') }}</span>
                    </div>
                    @if($timetable->end_date)
                        <div class="flex justify-between">
                            <span>End Date:</span>
                            <span class="font-medium">{{ $timetable->end_date->format('M j, Y') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span>Timezone:</span>
                        <span class="font-medium">{{ $timetable->timezone }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Schedule Days:</span>
                        <span class="font-medium">{{ count($timetable->schedule) }} days</span>
                    </div>
                    @if(!empty($timetable->schedule))
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Schedule Preview:</h4>
                            @php
                                $totalTimeSlots = 0;
                                $daysWithSchedule = [];
                            @endphp
                            @foreach($timetable->schedule as $daySchedule)
                                @php
                                    $dayName = ucfirst($daySchedule['day'] ?? '');
                                    $timeSlots = $daySchedule['times'] ?? [];
                                    $totalTimeSlots += count($timeSlots);
                                    if(!empty($timeSlots)) {
                                        $daysWithSchedule[] = $dayName;
                                    }
                                @endphp
                            @endforeach
                            <div class="text-xs text-gray-600">
                                <div>📅 Days: {{ implode(', ', $daysWithSchedule) }}</div>
                                <div>⏰ Total Time Slots: {{ $totalTimeSlots }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="border-t pt-4">
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-500">
                            Created {{ $timetable->created_at->format('M j, Y') }}
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('user.tea-timetables.show', $timetable) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                View
                            </a>
                            <a href="{{ route('user.tea-timetables.edit', $timetable) }}" 
                               class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                Edit
                            </a>
                            <a href="https://t.me/teazy_reminder_bot" target="_blank" 
                               class="text-blue-500 hover:text-blue-700 text-sm font-medium flex items-center space-x-1"
                               title="Chat with Teazy Bot">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.56l-1.68 7.92c-.12.57-.46.71-.91.44l-2.49-1.85-1.2 1.16c-.14.14-.26.26-.52.26l.18-2.77 4.63-4.19c.2-.18-.05-.28-.31-.1l-5.72 3.6-2.47-.77c-.53-.17-.54-.53.11-.78l9.63-3.71c.44-.16.82.11.68.78z"/>
                                </svg>
                                <span>Bot</span>
                            </a>
                            <form action="{{ route('user.tea-timetables.destroy', $timetable) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium"
                                        onclick="return confirm('Are you sure you want to delete this timetable?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <div class="text-6xl mb-4">🍵</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No tea timetables yet</h3>
                <p class="text-gray-600 mb-6">Create your first personalized tea schedule to get started!</p>
                <a href="{{ route('user.tea-timetables.create') }}" class="btn-primary">
                    Create Your First Timetable
                </a>
            </div>
        </div>
    @endforelse
</div>
@endsection
