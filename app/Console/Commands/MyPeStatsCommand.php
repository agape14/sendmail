<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;

class MyPeStatsCommand extends Command
{
    protected $signature = 'mype:stats';

    protected $description = 'Muestra estadísticas del bot de consultas MYPE';

    public function handle(): int
    {
        $totalQuestions = Question::count();
        $sentQuestions = Question::where('is_sent', true)->count();
        $pendingQuestions = $totalQuestions - $sentQuestions;
        
        $lastSent = Question::whereNotNull('last_sent_at')
            ->orderBy('last_sent_at', 'desc')
            ->first();

        $this->info('📊 Estadísticas del Bot de Consultas MYPE');
        $this->line('══════════════════════════════════════════');
        
        $this->line("📝 Total de preguntas: {$totalQuestions}");
        $this->line("✅ Preguntas enviadas: {$sentQuestions}");
        $this->line("⏳ Preguntas pendientes: {$pendingQuestions}");
        
        if ($lastSent) {
            $this->line("📅 Último envío: {$lastSent->last_sent_at->format('d/m/Y H:i')}");
            $this->line("❓ Última pregunta enviada: #{$lastSent->number}");
        } else {
            $this->line("📅 Último envío: Ninguno");
        }

        $this->line('');
        $this->line('⚙️  Configuración:');
        $this->line("📧 Email destino: " . config('mype.target_email', 'No configurado'));
        $this->line("👤 Nombre remitente: " . config('mype.sender_name', 'Consultas MYPE'));
        $this->line("⏱️  Días mínimos entre envíos: " . config('mype.min_days_between_emails', 1));
        $this->line("⏱️  Días máximos entre envíos: " . config('mype.max_days_between_emails', 7));

        if ($pendingQuestions > 0) {
            $this->line('');
            $this->info("💡 Puedes enviar la siguiente consulta con: php artisan mype:send-consulta");
        } elseif ($totalQuestions > 0) {
            $this->line('');
            $this->warn("🎉 ¡Todas las preguntas han sido enviadas!");
            $this->info("💡 Resetea el estado con: php artisan mype:reset-questions");
        }

        return 0;
    }
}
