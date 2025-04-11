<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ActualizarPaginasImpresoras;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ActualizarPaginasImpresoras::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('impresoras:actualizar_paginas')->daily(); // o ->everyMinute() para probar
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
