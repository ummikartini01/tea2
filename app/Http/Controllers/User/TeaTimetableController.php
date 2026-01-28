<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeaTimetable;
use App\Models\Tea;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeaTimetableController extends Controller
{
    public function index()
    {
        $timetables = Auth::user()->teaTimetables()
            ->latest()
            ->get();

        return view('user.tea-timetables.index', compact('timetables'));
    }

    public function create()
    {
        $teas = Tea::orderBy('name')->get();
        $timezones = $this->getTimezones();
        
        return view('user.tea-timetables.create', compact('teas', 'timezones'));
    }

    public function store(Request $request)
    {
        // Debug: Log all request data
        \Log::info('Tea timetable request data:', $request->all());
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request headers:', $request->headers->all());
        \Log::info('User authenticated: ' . (Auth::check() ? 'Yes' : 'No'));
        if (Auth::check()) {
            \Log::info('User ID: ' . Auth::id());
        }
        
        // Add validation error logging
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'timezone' => 'required|string',
            'schedule' => 'required|array|min:1',
            'schedule.*.day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'schedule.*.times' => 'required|array|min:1',
            'schedule.*.times.*.time' => 'required|string|date_format:H:i',
            'schedule.*.times.*.tea_id' => 'required|exists:teas,id',
            'schedule.*.times.*.notes' => 'nullable|string|max:255',
            'telegram_notifications_enabled' => 'boolean',
            'telegram_chat_id' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the errors in the form.');
        }

        \Log::info('Validation passed successfully, creating timetable');

        try {
            $timetable = Auth::user()->teaTimetables()->create([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'timezone' => $request->timezone,
                'schedule' => $request->schedule,
                'is_active' => true, // Set as active by default
                'telegram_notifications_enabled' => $request->boolean('telegram_notifications_enabled'),
                'telegram_chat_id' => $request->telegram_chat_id,
            ]);

            // Debug: Log successful creation
            \Log::info('Tea timetable created successfully:', [
                'id' => $timetable->id,
                'title' => $timetable->title,
                'schedule' => $timetable->schedule
            ]);

            return redirect()
                ->route('user.tea-timetables.index')
                ->with('success', 'Tea timetable created successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Error creating tea timetable: ' . $e->getMessage());
            \Log::error('Exception trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create tea timetable: ' . $e->getMessage());
        }
    }

    public function show(TeaTimetable $teaTimetable)
    {
        // $this->authorize('view', $teaTimetable);
        
        $teas = Tea::orderBy('name')->get();
        
        return view('user.tea-timetables.show', compact('teaTimetable', 'teas'));
    }

    public function edit(TeaTimetable $teaTimetable)
    {
        // $this->authorize('update', $teaTimetable);
        
        $teas = Tea::orderBy('name')->get();
        $timezones = $this->getTimezones();
        
        return view('user.tea-timetables.edit', compact('teaTimetable', 'teas', 'timezones'));
    }

    public function update(Request $request, TeaTimetable $teaTimetable)
    {
        // $this->authorize('update', $teaTimetable);

        // Debug: Log update request data
        \Log::info('Tea timetable UPDATE request data:', $request->all());
        \Log::info('Request method: ' . $request->method());
        \Log::info('Timetable ID: ' . $teaTimetable->id);
        \Log::info('Current schedule:', $teaTimetable->schedule);

        // Handle schedule data - it might be JSON string or array
        $scheduleData = $request->schedule;
        if (is_string($scheduleData)) {
            $scheduleData = json_decode($scheduleData, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['schedule' => 'Invalid schedule data format'])->withInput();
            }
        }
        
        $request->merge(['schedule' => $scheduleData]);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'timezone' => 'required|string',
            'schedule' => 'required|array|min:1',
            'schedule.*.day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'schedule.*.times' => 'required|array|min:1',
            'schedule.*.times.*.time' => 'required|string|date_format:H:i',
            'schedule.*.times.*.tea_id' => 'required|exists:teas,id',
            'schedule.*.times.*.notes' => 'nullable|string|max:255',
            'telegram_notifications_enabled' => 'boolean',
            'telegram_chat_id' => 'nullable|string|max:50',
        ]);

        $teaTimetable->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'timezone' => $request->timezone,
            'schedule' => $request->schedule,
            'telegram_notifications_enabled' => $request->boolean('telegram_notifications_enabled'),
            'telegram_chat_id' => $request->telegram_chat_id,
        ]);

        // Debug: Log successful update
        \Log::info('Tea timetable updated successfully:', [
            'id' => $teaTimetable->id,
            'title' => $teaTimetable->title,
            'new_schedule' => $teaTimetable->schedule
        ]);

        return redirect()
            ->route('user.tea-timetables.show', $teaTimetable)
            ->with('success', 'Tea timetable updated successfully!');
    }

    public function destroy(TeaTimetable $teaTimetable)
    {
        // $this->authorize('delete', $teaTimetable);
        
        $teaTimetable->delete();

        return redirect()
            ->route('user.tea-timetables.index')
            ->with('success', 'Tea timetable deleted successfully!');
    }

    public function generatePDF(TeaTimetable $teaTimetable)
    {
        // $this->authorize('view', $teaTimetable);
        
        $pdf = Pdf::loadView('user.tea-timetables.pdf', compact('teaTimetable'))
            ->setPaper('a4')
            ->setOption('margin-top', '20mm')
            ->setOption('margin-bottom', '20mm');

        $filename = 'tea-timetable-' . str_slug($teaTimetable->title) . '.pdf';
        
        return $pdf->download($filename);
    }

    public function toggleTelegramNotifications(TeaTimetable $teaTimetable)
    {
        // $this->authorize('update', $teaTimetable);
        
        $teaTimetable->update([
            'telegram_notifications_enabled' => !$teaTimetable->telegram_notifications_enabled
        ]);

        $status = $teaTimetable->telegram_notifications_enabled ? 'enabled' : 'disabled';
        
        return back()->with('success', "Telegram notifications {$status}!");
    }

    private function getTimezones(): array
    {
        return [
            'Asia/Kuala_Lumpur' => 'Kuala Lumpur & Selangor (MYT)',
            'Asia/Kuala_Lumpur_Putrajaya' => 'Putrajaya (MYT)',
            'Asia/Kuala_Lumpur_Johor' => 'Johor (MYT)',
            'Asia/Kuala_Lumpur_Melaka' => 'Melaka (MYT)',
            'Asia/Kuala_Lumpur_Negeri_Sembilan' => 'Negeri Sembilan (MYT)',
            'Asia/Kuala_Lumpur_Pahang' => 'Pahang (MYT)',
            'Asia/Kuala_Lumpur_Perak' => 'Perak (MYT)',
            'Asia/Kuala_Lumpur_Perlis' => 'Perlis (MYT)',
            'Asia/Kuala_Lumpur_Kedah' => 'Kedah (MYT)',
            'Asia/Kuala_Lumpur_Penang' => 'Penang (MYT)',
            'Asia/Kuala_Lumpur_Terengganu' => 'Terengganu (MYT)',
            'Asia/Kuala_Lumpur_Kelantan' => 'Kelantan (MYT)',
            'Asia/Kuala_Lumpur_Sabah' => 'Sabah (MYT)',
            'Asia/Kuala_Lumpur_Sarawak' => 'Sarawak (MYT)',
            'Asia/Kuala_Lumpur_Labuan' => 'Labuan (MYT)',
        ];
    }
    
    private function getActualTimezone(string $timezone): string
    {
        // Convert all Malaysia timezone keys to the actual timezone
        if (str_starts_with($timezone, 'Asia/Kuala_Lumpur')) {
            return 'Asia/Kuala_Lumpur';
        }
        return $timezone;
    }
}
