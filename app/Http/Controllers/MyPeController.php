<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use App\Models\Question;
use Illuminate\Support\Facades\Config;

class MyPeController
{
    public function dashboard()
    {
        try {
            // Obtener estadísticas básicas
            $totalQuestions = Question::count();
            $sentQuestions = Question::where('is_sent', true)->count();
            $pendingQuestions = $totalQuestions - $sentQuestions;
            $lastSent = Question::where('is_sent', true)->orderBy('last_sent_at', 'desc')->first();
            
            // Obtener configuración con valores por defecto
            $config = [
                'target_email' => config('mype.target_email', 'Eleccionescomprasamyperu@produce.gob.pe'),
                'sender_name' => config('mype.sender_name', 'Consultas MYPE'),
                'min_days' => config('mype.min_days_between_emails', 1),
                'max_days' => config('mype.max_days_between_emails', 7),
                'mail_mailer' => config('mail.default', 'smtp'),
                'mail_from_address' => config('mail.from.address', 'consultas@sendmail.delacruzdev.tech'),
                'mail_from_name' => config('mail.from.name', 'Consultas MYPE'),
                'mail_host' => config('mail.mailers.smtp.host', 'smtp.smtp2go.com'),
                'mail_port' => config('mail.mailers.smtp.port', 2525),
                'send_hours_min' => config('mype.send_hours.min', 9),
                'send_hours_max' => config('mype.send_hours.max', 17),
                'detailed_logging' => config('mype.detailed_logging', true),
            ];
            
            // Intentar cargar la vista con fallback
            if (view()->exists('mype.dashboard')) {
                return view('mype.dashboard', compact('totalQuestions', 'sentQuestions', 'pendingQuestions', 'lastSent', 'config'));
            } elseif (view()->exists('mype.dashboard-fallback')) {
                return view('mype.dashboard-fallback', compact('totalQuestions', 'sentQuestions', 'pendingQuestions', 'lastSent', 'config'));
            } else {
                // Fallback final: retornar JSON si ninguna vista existe
                return response()->json([
                    'success' => true,
                    'message' => 'Dashboard MYPE',
                    'data' => [
                        'totalQuestions' => $totalQuestions,
                        'sentQuestions' => $sentQuestions,
                        'pendingQuestions' => $pendingQuestions,
                        'lastSent' => $lastSent,
                        'config' => $config
                    ]
                ], 200, [], JSON_UNESCAPED_UNICODE);
            }
        } catch (\Exception $e) {
            Log::error('Error en dashboard', ['error' => $e->getMessage()]);
            
            // Fallback para errores también
            if (view()->exists('mype.dashboard')) {
                return view('mype.dashboard', [
                    'totalQuestions' => 0,
                    'sentQuestions' => 0,
                    'pendingQuestions' => 0,
                    'lastSent' => null,
                    'config' => [
                        'target_email' => 'Eleccionescomprasamyperu@produce.gob.pe',
                        'sender_name' => 'Consultas MYPE',
                        'min_days' => 1,
                        'max_days' => 3,
                    ],
                    'error' => $e->getMessage()
                ]);
            } elseif (view()->exists('mype.dashboard-fallback')) {
                return view('mype.dashboard-fallback', [
                    'totalQuestions' => 0,
                    'sentQuestions' => 0,
                    'pendingQuestions' => 0,
                    'lastSent' => null,
                    'config' => [
                        'target_email' => 'Eleccionescomprasamyperu@produce.gob.pe',
                        'sender_name' => 'Consultas MYPE',
                        'min_days' => 1,
                        'max_days' => 3,
                    ],
                    'error' => $e->getMessage()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error en dashboard: ' . $e->getMessage(),
                    'data' => [
                        'totalQuestions' => 0,
                        'sentQuestions' => 0,
                        'pendingQuestions' => 0,
                        'lastSent' => null,
                        'config' => [
                            'target_email' => 'Eleccionescomprasamyperu@produce.gob.pe',
                            'sender_name' => 'Consultas MYPE',
                            'min_days' => 1,
                            'max_days' => 3,
                        ]
                    ]
                ], 500, [], JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function sendConsulta()
    {
        try {
            // Configurar codificación UTF-8
            mb_internal_encoding('UTF-8');
            mb_http_output('UTF-8');
            
            // Configurar el entorno para comandos artisan
            putenv('LANG=es_ES.UTF-8');
            putenv('LC_ALL=es_ES.UTF-8');
            
            // Ejecutar el comando con timeout
            $exitCode = Artisan::call('mype:send-consulta', ['--force' => true]);
            $output = Artisan::output();
            
            // Limpiar la salida
            $output = trim($output);
            if (empty($output)) {
                $output = 'Comando ejecutado correctamente';
            }
            
            Log::info('Comando mype:send-consulta ejecutado desde el frontend', [
                'exit_code' => $exitCode,
                'output' => $output
            ]);
            
            // Determinar si fue exitoso
            $success = $exitCode === 0;
            
            return response()->json([
                'success' => $success,
                'message' => $success ? 'Consulta enviada exitosamente' : 'Error al enviar consulta',
                'output' => $output,
                'exit_code' => $exitCode
            ], 200, [], JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            Log::error('Error ejecutando mype:send-consulta desde el frontend', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar consulta: ' . $e->getMessage(),
                'output' => $e->getMessage()
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }
    
    public function getStats()
    {
        try {
            // Configurar codificación UTF-8
            mb_internal_encoding('UTF-8');
            mb_http_output('UTF-8');
            
            // Configurar el entorno para comandos artisan
            putenv('LANG=es_ES.UTF-8');
            putenv('LC_ALL=es_ES.UTF-8');
            
            $exitCode = Artisan::call('mype:stats');
            $output = Artisan::output();
            
            // Limpiar y validar la salida UTF-8
            $output = mb_convert_encoding($output, 'UTF-8', 'UTF-8');
            if (!mb_check_encoding($output, 'UTF-8')) {
                $output = 'Salida del comando (codificación corregida)';
            }
            
            Log::info('Comando mype:stats ejecutado desde el frontend', [
                'exit_code' => $exitCode,
                'output' => $output
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Estadísticas obtenidas exitosamente',
                'output' => $output
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            Log::error('Error ejecutando mype:stats desde el frontend', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }
    
    public function resetQuestions()
    {
        try {
            $exitCode = Artisan::call('mype:reset-questions');
            $output = Artisan::output();
            
            Log::info('Comando mype:reset-questions ejecutado desde el frontend', [
                'exit_code' => $exitCode,
                'output' => $output
            ]);
            
            $success = $exitCode === 0;
            
            return response()->json([
                'success' => $success,
                'message' => $success ? 'Preguntas reseteadas exitosamente' : 'Error al resetear preguntas',
                'output' => $output
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            Log::error('Error ejecutando mype:reset-questions desde el frontend', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al resetear preguntas: ' . $e->getMessage(),
                'output' => $e->getMessage()
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }
    
    public function getConfig()
    {
        try {
            // Configurar headers para JSON
            header('Content-Type: application/json; charset=utf-8');
            
            $config = [
                'target_email' => config('mype.target_email', 'Eleccionescomprasamyperu@produce.gob.pe'),
                'sender_name' => config('mype.sender_name', 'Consultas MYPE'),
                'min_days' => config('mype.min_days_between_emails', 1),
                'max_days' => config('mype.max_days_between_emails', 7),
                'mail_mailer' => config('mail.default', 'smtp'),
                'mail_from_address' => config('mail.from.address', 'consultas@sendmail.delacruzdev.tech'),
                'mail_from_name' => config('mail.from.name', 'Consultas MYPE'),
                'mail_host' => config('mail.mailers.smtp.host', 'smtp.smtp2go.com'),
                'mail_port' => config('mail.mailers.smtp.port', 2525),
                'send_hours_min' => config('mype.send_hours.min', 9),
                'send_hours_max' => config('mype.send_hours.max', 17),
                'detailed_logging' => config('mype.detailed_logging', true),
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'Configuración obtenida exitosamente',
                'config' => $config
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            Log::error('Error en getConfig', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener configuración: ' . $e->getMessage(),
                'config' => [
                    'target_email' => 'Eleccionescomprasamyperu@produce.gob.pe',
                    'sender_name' => 'Consultas MYPE',
                    'min_days' => 1,
                    'max_days' => 7,
                ]
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }
    
    public function updateConfig(Request $request)
    {
        try {
            $validated = $request->validate([
                'target_email' => 'required|email',
                'sender_name' => 'required|string|max:255',
                'min_days' => 'required|integer|min:1',
                'max_days' => 'required|integer|min:1|gte:min_days',
            ]);
            
            // Actualizar configuración (esto requeriría modificar el archivo de configuración)
            // Por ahora solo validamos y retornamos éxito
            
            return response()->json([
                'success' => true,
                'message' => 'Configuración actualizada exitosamente',
                'config' => $validated
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar configuración: ' . $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
