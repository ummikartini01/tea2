<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $teaTimetable->title }} - Tea Timetable</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2E7D32;
            margin: 0;
            font-size: 28px;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .info-label {
            font-weight: bold;
            color: #333;
        }
        
        .info-value {
            color: #666;
        }
        
        .schedule-section {
            margin-bottom: 30px;
        }
        
        .day-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #fafafa;
            border-left: 4px solid #4CAF50;
            border-radius: 5px;
        }
        
        .day-title {
            font-size: 18px;
            font-weight: bold;
            color: #2E7D32;
            margin: 0 0 15px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .time-slot {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 10px;
            background: white;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }
        
        .time-slot:last-child {
            margin-bottom: 0;
        }
        
        .time {
            font-weight: bold;
            color: #333;
            min-width: 80px;
            font-size: 14px;
        }
        
        .tea-info {
            flex: 1;
            margin-left: 15px;
        }
        
        .tea-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }
        
        .tea-details {
            font-size: 12px;
            color: #666;
        }
        
        .tea-notes {
            font-size: 11px;
            color: #888;
            font-style: italic;
            margin-top: 3px;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 12px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-active {
            background: #4CAF50;
            color: white;
        }
        
        .status-inactive {
            background: #9E9E9E;
            color: white;
        }
        
        .telegram-enabled {
            background: #2196F3;
            color: white;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🍵 {{ $teaTimetable->title }}</h1>
            <div class="subtitle">Personalized Tea Schedule</div>
        </div>

        <!-- Information Section -->
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">
                    <span class="status-badge {{ $teaTimetable->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $teaTimetable->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </span>
            </div>
            
            @if($teaTimetable->description)
                <div class="info-row">
                    <span class="info-label">Description:</span>
                    <span class="info-value">{{ $teaTimetable->description }}</span>
                </div>
            @endif
            
            <div class="info-row">
                <span class="info-label">Start Date:</span>
                <span class="info-value">{{ $teaTimetable->start_date->format('F j, Y') }}</span>
            </div>
            
            @if($teaTimetable->end_date)
                <div class="info-row">
                    <span class="info-label">End Date:</span>
                    <span class="info-value">{{ $teaTimetable->end_date->format('F j, Y') }}</span>
                </div>
            @endif
            
            <div class="info-row">
                <span class="info-label">Timezone:</span>
                <span class="info-value">{{ $teaTimetable->timezone }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Telegram Notifications:</span>
                <span class="info-value">
                    @if($teaTimetable->telegram_notifications_enabled)
                        <span class="status-badge telegram-enabled">📱 Enabled</span>
                    @else
                        <span class="status-badge status-inactive">Disabled</span>
                    @endif
                </span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Generated:</span>
                <span class="info-value">{{ now()->format('F j, Y g:i A') }}</span>
            </div>
        </div>

        <!-- Schedule Section -->
        <div class="schedule-section">
            <h2 style="color: #2E7D32; margin-bottom: 20px;">Weekly Tea Schedule</h2>
            
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
            
            @foreach($days as $dayKey => $dayName)
                @php
                    $daySchedule = $teaTimetable->getScheduleForDay($dayKey);
                @endphp
                
                @if(!empty($daySchedule['times']))
                    <div class="day-section">
                        <h3 class="day-title">{{ $dayName }}</h3>
                        
                        @foreach($daySchedule['times'] as $timeSlot)
                            @php
                                $tea = \App\Models\Tea::find($timeSlot['tea_id']);
                                $emoji = $teaEmojis[strtolower($tea->flavor ?? '')] ?? '☕';
                            @endphp
                            
                            <div class="time-slot">
                                <div class="time">{{ date('g:i A', strtotime($timeSlot['time'])) }}</div>
                                <div class="tea-info">
                                    <div class="tea-name">{{ $emoji }} {{ $tea->name }}</div>
                                    <div class="tea-details">
                                        🍃 {{ $tea->flavor }} • ⚡ {{ $tea->caffeine_level }}
                                    </div>
                                    @if(!empty($timeSlot['notes']))
                                        <div class="tea-notes">📝 {{ $timeSlot['notes'] }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This timetable was generated from the Smart Tea Recommendation System</p>
            <p>Enjoy your tea journey! 🍵✨</p>
        </div>
    </div>
</body>
</html>
