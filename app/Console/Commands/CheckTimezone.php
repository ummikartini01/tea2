<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TeaTimetable;

class CheckTimezone extends Command
{
    protected $signature = 'tea:check-timezone {id}';
    protected $description = 'Check the timezone of a specific timetable';

    public function handle()
    {
        $id = $this->argument('id');
        
        $timetable = TeaTimetable::find($id);
        
        if (!$timetable) {
            $this->error('❌ Timetable not found!');
            return 1;
        }
        
        $this->info('🕐 Timezone Check for Timetable ID: ' . $id);
        $this->info('🍵 Title: ' . $timetable->title);
        $this->info('🌐 Stored Timezone: ' . $timetable->timezone);
        $this->info('📅 Created: ' . $timetable->created_at->format('Y-m-d H:i:s'));
        $this->info('📅 Updated: ' . $timetable->updated_at->format('Y-m-d H:i:s'));
        
        // Check if it's a custom Malaysia timezone
        $malaysiaTimezones = [
            'Asia/Kuala_Lumpur' => 'Kuala Lumpur & Selangor',
            'Asia/Kuala_Lumpur_Putrajaya' => 'Putrajaya',
            'Asia/Kuala_Lumpur_Johor' => 'Johor',
            'Asia/Kuala_Lumpur_Melaka' => 'Melaka',
            'Asia/Kuala_Lumpur_Negeri_Sembilan' => 'Negeri Sembilan',
            'Asia/Kuala_Lumpur_Pahang' => 'Pahang',
            'Asia/Kuala_Lumpur_Perak' => 'Perak',
            'Asia/Kuala_Lumpur_Perlis' => 'Perlis',
            'Asia/Kuala_Lumpur_Kedah' => 'Kedah',
            'Asia/Kuala_Lumpur_Penang' => 'Penang',
            'Asia/Kuala_Lumpur_Terengganu' => 'Terengganu',
            'Asia/Kuala_Lumpur_Kelantan' => 'Kelantan',
            'Asia/Kuala_Lumpur_Sabah' => 'Sabah',
            'Asia/Kuala_Lumpur_Sarawak' => 'Sarawak',
            'Asia/Kuala_Lumpur_Labuan' => 'Labuan',
        ];
        
        if (isset($malaysiaTimezones[$timetable->timezone])) {
            $this->info('🇲🇾 Malaysia State: ' . $malaysiaTimezones[$timetable->timezone]);
        } else {
            $this->info('🌍 International Timezone');
        }
        
        return 0;
    }
}
