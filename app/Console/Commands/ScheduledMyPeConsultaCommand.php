<?php

namespace App\Console\Commands;

use App\Mail\MyPeConsultaMail;
use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ScheduledMyPeConsultaCommand extends Command
{
    protected $signature = 'mype:scheduled-send';

    protected $description = 'Envía consultas MYPE de forma programada con intervalos aleatorios';

    public function handle(): int
    {
        try {
            // Verificar si debe enviarse hoy
            if (!$this->shouldSendToday()) {
                $nextSendDate = Cache::get('mype_next_send_date');
                $this->info("No corresponde envío hoy. Próximo envío programado: {$nextSendDate}");
                return 0;
            }

            // Verificar si hay preguntas disponibles
            $totalQuestions = Question::count();
            if ($totalQuestions === 0) {
                $this->error('No hay preguntas en la base de datos.');
                return 1;
            }

            // Obtener una pregunta aleatoria no enviada recientemente
            $question = Question::getRandomUnsent();

            if (!$question) {
                // Si todas las preguntas fueron enviadas, resetear y continuar
                Question::resetAllSentStatus();
                $question = Question::getRandomUnsent();
                $this->info('Todas las preguntas fueron enviadas. Estado reseteado automáticamente.');
            }

            if (!$question) {
                $this->error('No se pudo obtener una pregunta para enviar.');
                return 1;
            }

            // Configurar destinatario y remitente
            $targetEmail = config('mype.target_email');
            $senderName = config('mype.sender_name', 'Consultas MYPE');

            if (!$targetEmail) {
                $this->error('No se ha configurado el email de destino en MYPE_TARGET_EMAIL');
                return 1;
            }

            // Enviar el correo
            $this->info("Enviando consulta #{$question->number} a {$targetEmail}");
            
            Mail::to($targetEmail)->send(new MyPeConsultaMail($question));

            // Marcar la pregunta como enviada
            $question->markAsSent();

            // Programar el próximo envío
            $this->scheduleNextSend();

            // Log del envío
            Log::info('Consulta MYPE enviada automáticamente', [
                'question_id' => $question->id,
                'question_number' => $question->number,
                'target_email' => $targetEmail,
                'sent_at' => now()->toDateTimeString(),
                'next_send_date' => Cache::get('mype_next_send_date')
            ]);

            $this->info("✅ Consulta #{$question->number} enviada exitosamente");
            
            // Mostrar información del próximo envío
            $nextSendDate = Cache::get('mype_next_send_date');
            $this->info("📅 Próximo envío programado: {$nextSendDate}");

            return 0;

        } catch (\Exception $e) {
            $this->error('Error al enviar la consulta: ' . $e->getMessage());
            Log::error('Error enviando consulta MYPE programada', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Determina si debe enviarse una consulta hoy
     */
    private function shouldSendToday(): bool
    {
        $nextSendDate = Cache::get('mype_next_send_date');
        
        // Si no hay fecha programada, programar la primera
        if (!$nextSendDate) {
            $this->scheduleNextSend();
            return false; // No enviar el primer día
        }

        // Verificar si hoy es el día programado
        return now()->toDateString() >= $nextSendDate;
    }

    /**
     * Programa el próximo envío con intervalo aleatorio
     */
    private function scheduleNextSend(): void
    {
        $minDays = config('mype.min_days_between_emails', 1);
        $maxDays = config('mype.max_days_between_emails', 7);
        
        $randomDays = rand($minDays, $maxDays);
        $nextSendDate = now()->addDays($randomDays)->toDateString();
        
        Cache::put('mype_next_send_date', $nextSendDate, now()->addDays($maxDays + 1));
        
        Log::info('Próximo envío MYPE programado', [
            'next_send_date' => $nextSendDate,
            'days_from_now' => $randomDays
        ]);
    }
}
