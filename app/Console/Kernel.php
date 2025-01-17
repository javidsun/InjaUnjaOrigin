<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;



class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule)
    {
        // Define your scheduled commands
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
