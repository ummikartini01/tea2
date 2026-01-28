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
        
        <!-- Actions -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('user.tea-timetables.show', $teaTimetable) }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Timetable
            </a>
            <a href="{{ route('user.tea-timetables.index') }}" class="text-gray-600 hover:text-gray-900">
                ← All Timetables
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <strong>Please fix the following errors:</strong>
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('user.tea-timetables.update', $teaTimetable) }}" id="timetableForm">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="tea-card p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Timetable Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $teaTimetable->title) }}"
                           class="search-bar"
                           placeholder="e.g., My Daily Tea Routine"
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

                <div id="telegramSettings" class="{{ old('telegram_notifications_enabled', $teaTimetable->telegram_notifications_enabled) ? '' : 'hidden' }}">
                    <label for="telegram_chat_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Telegram Chat ID
                    </label>
                    <input type="text" 
                           id="telegram_chat_id" 
                           name="telegram_chat_id" 
                           value="{{ old('telegram_chat_id', $teaTimetable->telegram_chat_id) }}"
                           class="search-bar"
                           placeholder="Enter your Telegram chat ID">
                    <p class="mt-1 text-xs text-gray-500">
                        Get your chat ID by messaging @teazy_reminder_bot on Telegram
                    </p>
                    @error('telegram_chat_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tea Schedule -->
        <div class="tea-card p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">🍵 Tea Schedule</h2>
            <p class="text-gray-600 mb-4">Add your daily tea times and preferences</p>
            
            <div id="scheduleBuilder" class="space-y-4">
                <!-- Schedule days will be added here dynamically -->
            </div>
            
            <button type="button" id="addDayBtn" class="mt-4 btn-secondary">
                ➕ Add Another Day
            </button>
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

<!-- Templates -->
<template id="dayTemplate">
    <div class="schedule-day border rounded-lg p-4 bg-gray-50">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <select class="day-select search-bar" required>
                    <option value="">Select Day</option>
                    <option value="monday">Monday</option>
                    <option value="tuesday">Tuesday</option>
                    <option value="wednesday">Wednesday</option>
                    <option value="thursday">Thursday</option>
                    <option value="friday">Friday</option>
                    <option value="saturday">Saturday</option>
                    <option value="sunday">Sunday</option>
                </select>
            </div>
            <button type="button" class="remove-day-btn text-red-500 hover:text-red-700">
                🗑️ Remove Day
            </button>
        </div>
        
        <div class="time-slots space-y-2">
            <!-- Time slots will be added here -->
        </div>
        
        <button type="button" class="add-time-btn mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium">
            ➕ Add Time Slot
        </button>
    </div>
</template>

<template id="timeSlotTemplate">
    <div class="time-slot flex items-center space-x-2 p-2 bg-white rounded">
        <input type="time" class="time-input search-bar" style="width: 120px;" required>
        <select class="tea-select search-bar" style="width: 200px;" required>
            <option value="">Select Tea</option>
            @foreach($teas as $tea)
                <option value="{{ $tea->id }}">{{ $tea->name }}</option>
            @endforeach
        </select>
        <input type="text" class="notes-input search-bar" style="width: 200px;" placeholder="Notes (optional)">
        <button type="button" class="remove-slot-btn text-red-500 hover:text-red-700">✕</button>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scheduleBuilder = document.getElementById('scheduleBuilder');
    const addDayBtn = document.getElementById('addDayBtn');
    const dayTemplate = document.getElementById('dayTemplate');
    const timeSlotTemplate = document.getElementById('timeSlotTemplate');
    const telegramCheckbox = document.getElementById('telegram_notifications_enabled');
    const telegramSettings = document.getElementById('telegramSettings');
    
    let dayCount = 0;
    const usedDays = new Set();
    
    // Load existing schedule data
    const existingSchedule = @json($teaTimetable->schedule);
    
    // Define functions first
    window.addScheduleDay = function(dayData = null) {
        const dayElement = dayTemplate.content.cloneNode(true);
        const dayDiv = dayElement.querySelector('.schedule-day');
        const daySelect = dayDiv.querySelector('.day-select');
        const removeBtn = dayDiv.querySelector('.remove-day-btn');
        const addTimeBtn = dayDiv.querySelector('.add-time-btn');
        const timeSlots = dayDiv.querySelector('.time-slots');

        // Set unique data-day attribute
        dayDiv.setAttribute('data-day', dayCount++);
        
        // Load existing data if provided
        if (dayData) {
            daySelect.value = dayData.day;
            usedDays.add(dayData.day);
            dayDiv.setAttribute('data-selected-day', dayData.day);
            
            // Add existing time slots
            if (dayData.times && dayData.times.length > 0) {
                dayData.times.forEach(timeSlot => {
                    addTimeSlot(timeSlots, timeSlot);
                });
            } else {
                addTimeSlot(timeSlots);
            }
        } else {
            // Add initial time slot for new day
            addTimeSlot(timeSlots);
        }
        
        // Remove day functionality
        removeBtn.addEventListener('click', function() {
            const day = dayDiv.querySelector('.day-select').value;
            if (day) usedDays.delete(day);
            dayDiv.remove();
        });

        // Day selection change handler
        daySelect.addEventListener('change', function() {
            const oldDay = dayDiv.getAttribute('data-selected-day');
            if (oldDay) usedDays.delete(oldDay);
            
            if (this.value) {
                if (usedDays.has(this.value)) {
                    alert('This day is already added!');
                    this.value = '';
                    return;
                }
                usedDays.add(this.value);
                dayDiv.setAttribute('data-selected-day', this.value);
            }
        });

        // Add time slot functionality
        addTimeBtn.addEventListener('click', function() {
            addTimeSlot(timeSlots);
        });

        scheduleBuilder.appendChild(dayElement);
    };

    window.addTimeSlot = function(container, timeSlotData = null) {
        const slotElement = timeSlotTemplate.content.cloneNode(true);
        const slotDiv = slotElement.querySelector('.time-slot');
        const removeBtn = slotDiv.querySelector('.remove-slot-btn');

        // Load existing data if provided
        if (timeSlotData) {
            slotDiv.querySelector('.time-input').value = timeSlotData.time;
            slotDiv.querySelector('.tea-select').value = timeSlotData.tea_id;
            slotDiv.querySelector('.notes-input').value = timeSlotData.notes || '';
        }

        removeBtn.addEventListener('click', function() {
            slotDiv.remove();
        });

        container.appendChild(slotElement);
    };

    // Telegram settings toggle
    telegramCheckbox.addEventListener('change', function() {
        telegramSettings.classList.toggle('hidden', !this.checked);
    });

    // Load existing schedule
    if (existingSchedule && existingSchedule.length > 0) {
        existingSchedule.forEach(dayData => {
            window.addScheduleDay(dayData);
        });
    } else {
        // Add initial day if no existing schedule
        window.addScheduleDay();
    }

    // Add day button
    if (addDayBtn) {
        addDayBtn.addEventListener('click', window.addScheduleDay);
    }

    // Form submission handler
    document.getElementById('timetableForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        const scheduleData = [];
        const scheduleDays = document.querySelectorAll('.schedule-day');

        scheduleDays.forEach(dayDiv => {
            const day = dayDiv.querySelector('.day-select').value;
            if (!day) return;

            const timeSlots = [];
            dayDiv.querySelectorAll('.time-slot').forEach(slot => {
                const time = slot.querySelector('.time-input').value;
                const teaId = slot.querySelector('.tea-select').value;
                const notes = slot.querySelector('.notes-input').value;

                if (time && teaId) {
                    timeSlots.push({
                        time: time,
                        tea_id: parseInt(teaId),
                        notes: notes
                    });
                }
            });

            if (timeSlots.length > 0) {
                scheduleData.push({
                    day: day,
                    times: timeSlots
                });
            }
        });

        // Validate that we have schedule data
        if (scheduleData.length === 0) {
            alert('Please add at least one day with time slots to your schedule.');
            return;
        }

        // Debug: Log the schedule data
        console.log('Schedule data being submitted:', scheduleData);

        // Create a hidden input for the schedule JSON
        const scheduleInput = document.createElement('input');
        scheduleInput.type = 'hidden';
        scheduleInput.name = 'schedule';
        scheduleInput.value = JSON.stringify(scheduleData);
        
        // Remove any existing schedule inputs
        const existingInputs = this.querySelectorAll('input[name="schedule"]');
        existingInputs.forEach(input => input.remove());
        
        // Add the new schedule input
        this.appendChild(scheduleInput);

        // Debug: Log the form data
        console.log('Form data being submitted:', new FormData(this));
        console.log('Schedule JSON:', scheduleInput.value);

        // Submit the form using traditional method
        this.submit();
    });
});
</script>
@endsection
