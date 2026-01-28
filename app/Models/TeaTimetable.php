<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeaTimetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'schedule',
        'is_active',
        'telegram_notifications_enabled',
        'telegram_chat_id',
        'start_date',
        'end_date',
        'timezone',
    ];

    protected $casts = [
        'schedule' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'telegram_notifications_enabled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getScheduleForDay(string $day): array
    {
        return collect($this->schedule)->firstWhere('day', strtolower($day)) ?? [];
    }

    public function getTodaySchedule(): array
    {
        $actualTimezone = $this->getActualTimezone();
        $today = strtolower(now($actualTimezone)->format('l'));
        return $this->getScheduleForDay($today);
    }

    public function getNextTeaTime(): ?array
    {
        $todaySchedule = $this->getTodaySchedule();
        $actualTimezone = $this->getActualTimezone();
        $currentTime = now($actualTimezone)->format('H:i');
        
        foreach ($todaySchedule['times'] ?? [] as $timeSlot) {
            if ($timeSlot['time'] > $currentTime) {
                return $timeSlot;
            }
        }
        
        return null;
    }

    public function getActualTimezone(): string
    {
        // Convert custom Malaysia timezone keys to actual timezone
        if (str_starts_with($this->timezone, 'Asia/Kuala_Lumpur')) {
            return 'Asia/Kuala_Lumpur';
        }
        return $this->timezone;
    }

    public function isActiveForDate($date = null): bool
    {
        $actualTimezone = $this->getActualTimezone();
        $date = $date ?? now($actualTimezone)->format('Y-m-d');
        
        // Convert dates to proper timezone for comparison
        $startDate = $this->start_date->setTimezone($actualTimezone)->format('Y-m-d');
        $endDate = $this->end_date ? $this->end_date->setTimezone($actualTimezone)->format('Y-m-d') : null;
        
        // Debug logging
        \Log::info('isActiveForDate check:', [
            'date' => $date,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => $this->is_active,
            'stored_timezone' => $this->timezone,
            'actual_timezone' => $actualTimezone
        ]);
        
        if (!$this->is_active) {
            \Log::info('Not active');
            return false;
        }
        
        if ($date < $startDate) {
            \Log::info('Date before start date');
            return false;
        }
        
        if ($endDate && $date > $endDate) {
            \Log::info('Date after end date');
            return false;
        }
        
        \Log::info('Date is active');
        return true;
    }
}
