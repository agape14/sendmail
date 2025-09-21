<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;

class ResetMyPeQuestionsCommand extends Command
{
    protected $signature = 'mype:reset-questions {--force : No pedir confirmación}';

    protected $description = 'Resetea el estado de envío de todas las preguntas MYPE';

    public function handle(): int
    {
        $totalQuestions = Question::count();
        $sentQuestions = Question::where('is_sent', true)->count();

        if ($totalQuestions === 0) {
            $this->error('No hay preguntas en la base de datos.');
            return 1;
        }

        $this->info("Estado actual:");
        $this->line("  Total de preguntas: {$totalQuestions}");
        $this->line("  Preguntas enviadas: {$sentQuestions}");
        $this->line("  Preguntas pendientes: " . ($totalQuestions - $sentQuestions));

        if ($sentQuestions === 0) {
            $this->info('No hay preguntas marcadas como enviadas.');
            return 0;
        }

        if (!$this->option('force') && !$this->confirm('¿Estás seguro de que quieres resetear todas las preguntas como no enviadas?')) {
            $this->info('Operación cancelada.');
            return 0;
        }

        Question::resetAllSentStatus();

        $this->info("✅ Se resetearon {$sentQuestions} preguntas. Todas están ahora disponibles para envío.");

        return 0;
    }
}
