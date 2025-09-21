<?php

namespace App\Console\Commands;

use App\Mail\MyPeConsultaMail;
use App\Models\Question;
use App\Services\SmartSenderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMyPeConsultaCommand extends Command
{
    protected $signature = 'mype:send-consulta {--force : Forzar envío aunque ya se haya enviado una pregunta recientemente}';

    protected $description = 'Envía una consulta aleatoria sobre el proceso electoral MYPE';

    public function handle(): int
    {
        try {
            // Verificar si hay preguntas disponibles
            $totalQuestions = Question::count();
            if ($totalQuestions === 0) {
                $this->error('No hay preguntas en la base de datos. Ejecuta php artisan db:seed primero.');
                return 1;
            }

            // Obtener una pregunta aleatoria no enviada recientemente
            $question = Question::getRandomUnsent();

            if (!$question) {
                if ($this->option('force')) {
                    // Si se fuerza, obtener cualquier pregunta aleatoria
                    $question = Question::inRandomOrder()->first();
                    $this->warn('Forzando envío: todas las preguntas fueron enviadas recientemente.');
                } else {
                    // Si todas las preguntas fueron enviadas recientemente, resetear el estado
                    $minDays = config('mype.min_days_between_emails', 1);
                    $this->info("Todas las preguntas fueron enviadas en los últimos {$minDays} días.");
                    
                    if ($this->confirm('¿Deseas resetear el estado de envío y comenzar de nuevo?')) {
                        Question::resetAllSentStatus();
                        $question = Question::getRandomUnsent();
                        $this->info('Estado de envío reseteado.');
                    } else {
                        $this->info('Operación cancelada.');
                        return 0;
                    }
                }
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

            // Mostrar información antes del envío
            $this->info("Preparando envío de consulta:");
            $this->line("  Pregunta #{$question->number}");
            $this->line("  Destinatario: {$targetEmail}");
            $this->line("  Remitente: {$senderName}");
            $this->line("  Contenido: " . substr($question->content, 0, 100) . '...');

            if (!$this->option('force') && !$this->confirm('¿Proceder con el envío?')) {
                $this->info('Envío cancelado.');
                return 0;
            }

            // Crear instancia del correo para obtener el sender
            $mailInstance = new MyPeConsultaMail($question);
            
            // Configurar el sender dinámicamente
            SmartSenderService::configureSenderEmail($mailInstance->sender);
            
            // Enviar el correo
            $this->info('Enviando correo...');
            $this->line("📧 Desde: {$mailInstance->sender['name']} <{$mailInstance->sender['email']}>");
            
            Mail::to($targetEmail)->send($mailInstance);
            
            // Restaurar configuración original
            SmartSenderService::restoreOriginalConfig();

            // Marcar la pregunta como enviada
            $question->markAsSent();

            // Log del envío
            Log::info('Consulta MYPE enviada', [
                'question_id' => $question->id,
                'question_number' => $question->number,
                'target_email' => $targetEmail,
                'sent_at' => now()->toDateTimeString()
            ]);

            $this->info("✅ Consulta #{$question->number} enviada exitosamente a {$targetEmail}");
            
            // Mostrar estadísticas
            $sentCount = Question::where('is_sent', true)->count();
            $remainingCount = $totalQuestions - $sentCount;
            
            $this->line("📊 Estadísticas:");
            $this->line("  Total de preguntas: {$totalQuestions}");
            $this->line("  Enviadas: {$sentCount}");
            $this->line("  Pendientes: {$remainingCount}");

            if ($remainingCount === 0) {
                $this->warn('🎉 ¡Todas las preguntas han sido enviadas!');
                $this->line('Puedes resetear el estado con: php artisan mype:reset-questions');
            }

            return 0;

        } catch (\Exception $e) {
            $this->error('Error al enviar la consulta: ' . $e->getMessage());
            Log::error('Error enviando consulta MYPE', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }
}
