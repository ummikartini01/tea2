<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tea;

class CheckTeas extends Command
{
    protected $signature = 'tea:check-teas';
    protected $description = 'Check available teas in database';

    public function handle()
    {
        $this->info('🍵 Available teas:');
        
        $teas = Tea::all();
        
        if ($teas->isEmpty()) {
            $this->error('❌ No teas found in database!');
            return 1;
        }
        
        foreach ($teas as $tea) {
            $this->info("ID: {$tea->id} - Name: {$tea->name} (Flavor: {$tea->flavor})");
        }
        
        return 0;
    }
}
