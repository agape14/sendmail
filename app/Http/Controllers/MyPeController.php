<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class MyPeController
{
    public function sendConsulta()
    {
        try {
            // Configurar codificación UTF-8
            mb_internal_encoding('UTF-8');
            mb_http_output('UTF-8');
            
            // Configurar el entorno para comandos artisan
            putenv('LANG=es_ES.UTF-8');
            putenv('LC_ALL=es_ES.UTF-8');
            
            $exitCode = Artisan::call('mype:send-consulta', ['--force' => true]);
            $output = Artisan::output();
            
            // Limpiar y validar la salida UTF-8
            $output = mb_convert_encoding($output, 'UTF-8', 'UTF-8');
            if (!mb_check_encoding($output, 'UTF-8')) {
                $output = 'Salida del comando (codificación corregida)';
            }
            
            Log::info('Comando mype:send-consulta ejecutado desde el frontend', [
                'exit_code' => $exitCode,
                'output' => $output
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Consulta enviada exitosamente',
                'output' => $output
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            Log::error('Error ejecutando mype:send-consulta desde el frontend', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar consulta: ' . $e->getMessage()
            ], 500, [], JSON_UNESCAPED_UNICODE);
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
}
