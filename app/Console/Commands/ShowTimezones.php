<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowTimezones extends Command
{
    protected $signature = 'tea:show-timezones';
    protected $description = 'Show Malaysia timezone options';

    public function handle()
    {
        $this->info('🕐 Malaysia Timezone Options:');
        $this->info('');
        
        $timezones = [
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
        
        foreach ($timezones as $value => $label) {
            $this->info("📍 {$label}");
        }
        
        $this->info('');
        $this->info('✅ Updated successfully!');
        $this->info('🌐 All states use Asia/Kuala_Lumpur timezone (MYT)');
        $this->info('📱 Visit: http://127.0.0.1:8000/tea-timetables/create');
        $this->info('💡 Select your state from the timezone dropdown');
        
        return 0;
    }
}
