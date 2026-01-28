@extends('layouts.sidebar')

@section('content')
<div class="max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Tea Timetable</h1>
                <p class="text-gray-600">Update your tea schedule and preferences</p>
            </div>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('user.tea-timetables.update', $teaTimetable) }}">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="tea-card p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $teaTimetable->title) }}"
                           class="search-bar"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">
                        Timezone <span class="text-red-500">*</span>
                    </label>
                    <select id="timezone" name="timezone" class="search-bar" required>
                        @foreach($timezones as $value => $label)
                            <option value="{{ $value }}" {{ old('timezone', $teaTimetable->timezone) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('timezone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Start Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="start_date" 
                           name="start_date" 
                           value="{{ old('start_date', $teaTimetable->start_date->format('Y-m-d')) }}"
                           class="search-bar"
                           required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        End Date (optional)
                    </label>
                    <input type="date" 
                           id="end_date" 
                           name="end_date" 
                           value="{{ old('end_date', $teaTimetable->end_date ? $teaTimetable->end_date->format('Y-m-d') : '') }}"
                           class="search-bar">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="search-bar"
                          placeholder="Describe your tea schedule...">{{ old('description', $teaTimetable->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Simple Schedule Input -->
        <div class="tea-card p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">🍵 Tea Schedule</h2>
            <p class="text-gray-600 mb-4">Enter your schedule data in JSON format</p>
            
            <div class="mb-4">
                <label for="schedule_json" class="block text-sm font-medium text-gray-700 mb-2">
                    Schedule Data (JSON)
                </label>
                <textarea id="schedule_json" 
                          name="schedule" 
                          rows="8"
                          class="search-bar font-mono text-sm"
                          placeholder='[{"day": "monday", "times": [{"time": "09:00", "tea_id": "1", "notes": "Morning tea"}]}]'>{{ old('schedule', json_encode($teaTimetable->schedule, JSON_PRETTY_PRINT)) }}</textarea>
                @error('schedule')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    Format: [{"day": "monday", "times": [{"time": "09:00", "tea_id": "1", "notes": "Morning tea"}]}]
                </p>
            </div>
        </div>

        <!-- Telegram Settings -->
        <div class="tea-card p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">📱 Telegram Notifications</h2>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="telegram_notifications_enabled" 
                           name="telegram_notifications_enabled" 
                           value="1"
                           {{ old('telegram_notifications_enabled', $teaTimetable->telegram_notifications_enabled) ? 'checked' : '' }}
                           class="mr-2">
                    <label for="telegram_notifications_enabled" class="text-sm font-medium text-gray-700">
                        Enable Telegram notifications
                    </label>
                </div>

                <div id="telegramSettings" {{ old('telegram_notifications_enabled', $teaTimetable->telegram_notifications_enabled) ? '' : 'class="hidden"' }}>
                    <label for="telegram_chat_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Telegram Chat ID
                    </label>
                    <input type="text" 
                           id="telegram_chat_id" 
                           name="telegram_chat_id" 
                           value="{{ old('telegram_chat_id', $teaTimetable->telegram_chat_id) }}"
                           class="search-bar"
                           placeholder="Your Telegram chat ID">
                    @error('telegram_chat_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('user.tea-timetables.index') }}" class="text-gray-600 hover:text-gray-900">
                Cancel
            </a>
            <button type="submit" class="btn-primary">
                Update Timetable
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const telegramCheckbox = document.getElementById('telegram_notifications_enabled');
    const telegramSettings = document.getElementById('telegramSettings');
    
    if (telegramCheckbox && telegramSettings) {
        telegramCheckbox.addEventListener('change', function() {
            telegramSettings.classList.toggle('hidden', !this.checked);
        });
    }
});
</script>
@endsection
