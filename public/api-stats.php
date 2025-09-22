<?php
/**
 * Endpoint directo para estadísticas
 * Acceso: https://sendmail.delacruzdev.tech/api-stats.php
 */

// Incluir el autoloader de Laravel
require_once __DIR__ . '/../vendor/autoload.php';

// Bootstrap de Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Configurar headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

try {
    $totalQuestions = \App\Models\Question::count();
    $sentQuestions = \App\Models\Question::where('is_sent', true)->count();
    $pendingQuestions = $totalQuestions - $sentQuestions;
    $lastSent = \App\Models\Question::where('is_sent', true)->orderBy('last_sent_at', 'desc')->first();
    
    echo json_encode([
        'success' => true,
        'message' => 'Estadísticas obtenidas exitosamente',
        'data' => [
            'totalQuestions' => (int)$totalQuestions,
            'sentQuestions' => (int)$sentQuestions,
            'pendingQuestions' => (int)$pendingQuestions,
            'lastSent' => $lastSent ? $lastSent->last_sent_at : null
        ]
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener estadísticas: ' . $e->getMessage(),
        'data' => [
            'totalQuestions' => 0,
            'sentQuestions' => 0,
            'pendingQuestions' => 0,
            'lastSent' => null
        ]
    ], JSON_UNESCAPED_UNICODE);
}
