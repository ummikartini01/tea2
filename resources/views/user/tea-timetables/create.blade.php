@extends('layouts.sidebar')

@section('content')
<div class="mb-6">
    <div class="flex items-center">
        <a href="{{ route('user.tea-timetables.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
            ← Back to Timetables
        </a>
        <h1 class="text-3xl font-bold">Create Tea Timetable</h1>
    </div>
</div>

<div class="max-w-4xl">
    <form method="POST" action="{{ route('user.tea-timetables.store') }}" id="timetableForm">
        @csrf
        
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
                           value="{{ old('title') }}"
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
                            <option value="{{ $value }}" {{ old('timezone', config('app.timezone')) == $value ? 'selected' : '' }}>
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
                           value="{{ old('start_date', now()->format('Y-m-d')) }}"
                           class="search-bar"
                           required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        End Date (Optional)
                    </label>
                    <input type="date" 
                           id="end_date" 
                           name="end_date" 
                           value="{{ old('end_date') }}"
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
                          placeholder="Describe your tea routine...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Schedule Builder -->
        <div class="tea-card p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Tea Schedule</h2>
            <p class="text-gray-600 mb-4">Add tea times for each day of the week</p>
            
            <div id="scheduleBuilder" class="space-y-4">
                <!-- Schedule days will be dynamically added here -->
            </div>
            
            <button type="button" id="addDayBtn" class="btn-secondary mt-4" style="cursor: pointer; display: inline-block; padding: 8px 16px;">
                ➕ Add Another Day
            </button>
        </div>

        <!-- Telegram Integration -->
        <div class="tea-card p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">📱 Telegram Notifications</h2>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="telegram_notifications_enabled" 
                           name="telegram_notifications_enabled" 
                           value="1"
                           class="mr-2">
                    <label for="telegram_notifications_enabled" class="text-sm font-medium text-gray-700">
                        Enable Telegram notifications for tea reminders
                    </label>
                </div>

                <div id="telegramSettings" class="hidden space-y-4 pl-6">
                    <div>
                        <label for="telegram_chat_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Telegram Chat ID
                        </label>
                        <input type="text" 
                               id="telegram_chat_id" 
                               name="telegram_chat_id" 
                               value="{{ old('telegram_chat_id') }}"
                               class="search-bar"
                               placeholder="e.g., 123456789">
                        <p class="mt-1 text-xs text-gray-500">
                            Get your chat ID by messaging @userinfobot on Telegram
                        </p>
                        @error('telegram_chat_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('user.tea-timetables.index') }}" class="btn-secondary">
                Cancel
            </a>
            <button type="submit" class="btn-primary">
                Create Timetable
            </button>
        </div>
    </form>
</div>

<!-- Hidden template for schedule day -->
<template id="dayTemplate">
    <div class="schedule-day border rounded-lg p-4" data-day="">
        <div class="flex items-center justify-between mb-4">
            <select class="day-select search-bar" style="width: 150px;">
                <option value="">Select Day</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>
                <option value="sunday">Sunday</option>
            </select>
            <button type="button" class="remove-day-btn text-red-600 hover:text-red-900">
                🗑️ Remove Day
            </button>
        </div>
        
        <div class="time-slots space-y-2">
            <!-- Time slots will be added here -->
        </div>
        
        <button type="button" class="add-time-btn btn-secondary text-sm mt-2" style="cursor: pointer;">
            ➕ Add Time Slot
        </button>
    </div>
</template>

<!-- Hidden template for time slot -->
<template id="timeSlotTemplate">
    <div class="time-slot flex items-center space-x-2 p-2 bg-gray-50 rounded">
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
    const dayTemplate = document.getElementById('dayTemplate');
    const timeSlotTemplate = document.getElementById('timeSlotTemplate');
    const addDayBtn = document.getElementById('addDayBtn');
    const telegramCheckbox = document.getElementById('telegram_notifications_enabled');
    const telegramSettings = document.getElementById('telegramSettings');
    
    let dayCount = 0;
    let usedDays = new Set();

    // Define functions first
    window.addScheduleDay = function() {
        const dayElement = dayTemplate.content.cloneNode(true);
        const dayDiv = dayElement.querySelector('.schedule-day');
        const daySelect = dayDiv.querySelector('.day-select');
        const removeBtn = dayDiv.querySelector('.remove-day-btn');
        const addTimeBtn = dayDiv.querySelector('.add-time-btn');
        const timeSlots = dayDiv.querySelector('.time-slots');

        // Set unique data-day attribute
        dayDiv.setAttribute('data-day', dayCount++);
        
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

        // Add initial time slot
        addTimeSlot(timeSlots);

        scheduleBuilder.appendChild(dayElement);
    };

    window.addTimeSlot = function(container) {
        const slotElement = timeSlotTemplate.content.cloneNode(true);
        const slotDiv = slotElement.querySelector('.time-slot');
        const removeBtn = slotDiv.querySelector('.remove-slot-btn');

        removeBtn.addEventListener('click', function() {
            slotDiv.remove();
        });

        container.appendChild(slotElement);
    };

    // Telegram settings toggle
    telegramCheckbox.addEventListener('change', function() {
        telegramSettings.classList.toggle('hidden', !this.checked);
    });

    // Add initial day
    window.addScheduleDay();

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

        // Remove any existing schedule inputs
        const existingScheduleInputs = this.querySelectorAll('input[name^="schedule"]');
        existingScheduleInputs.forEach(input => input.remove());

        // Add schedule data as array structure
        scheduleData.forEach((daySchedule, dayIndex) => {
            // Add day input
            const dayInput = document.createElement('input');
            dayInput.type = 'hidden';
            dayInput.name = `schedule[${dayIndex}][day]`;
            dayInput.value = daySchedule.day;
            this.appendChild(dayInput);

            // Add time slots
            daySchedule.times.forEach((timeSlot, timeIndex) => {
                // Time input
                const timeInput = document.createElement('input');
                timeInput.type = 'hidden';
                timeInput.name = `schedule[${dayIndex}][times][${timeIndex}][time]`;
                timeInput.value = timeSlot.time;
                this.appendChild(timeInput);

                // Tea ID input
                const teaIdInput = document.createElement('input');
                teaIdInput.type = 'hidden';
                teaIdInput.name = `schedule[${dayIndex}][times][${timeIndex}][tea_id]`;
                teaIdInput.value = timeSlot.tea_id;
                this.appendChild(teaIdInput);

                // Notes input
                const notesInput = document.createElement('input');
                notesInput.type = 'hidden';
                notesInput.name = `schedule[${dayIndex}][times][${timeIndex}][notes]`;
                notesInput.value = timeSlot.notes || '';
                this.appendChild(notesInput);
            });
        });

        // Debug: Log the form data
        console.log('Form data being submitted:', new FormData(this));
        console.log('Schedule data:', scheduleData);

        // Submit the form
        try {
            this.submit();
        } catch (error) {
            console.error('Form submission error:', error);
            alert('Error submitting form: ' + error.message);
        }
    });
});
</script>
@endsection
