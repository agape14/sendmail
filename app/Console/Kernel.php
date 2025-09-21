<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Envío automático SOLO en fechas específicas: 20, 21, 22 de Septiembre 2025
        // IMPORTANTE: Este scheduler es para uso con 'php artisan schedule:run'
        // Para Hostinger cPanel, usar directamente el comando en cron job
        
        // Sábado 21 Sept: 5 consultas (9 AM, 11 AM, 1 PM, 3 PM, 5 PM)
        $schedule->command('mype:send-consulta --force')
            ->cron('0 9,11,13,15,17 21 09 6') // Sábado 21
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/mype-bot.log'));

        // Domingo 22 Sept: 5 consultas (10 AM, 12 PM, 2 PM, 4 PM, 6 PM)  
        $schedule->command('mype:send-consulta --force')
            ->cron('0 10,12,14,16,18 22 09 0') // Domingo 22
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/mype-bot.log'));

        // Lunes 23 Sept: 5 consultas (9 AM, 11 AM, 1 PM, 3 PM, 5 PM)
        $schedule->command('mype:send-consulta --force')
            ->cron('0 9,11,13,15,17 23 09 1') // Lunes 23
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/mype-bot.log'));

        // Log de estadísticas diario
        $schedule->command('mype:stats')
            ->dailyAt('08:00')
            ->appendOutputTo(storage_path('logs/mype-stats.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
