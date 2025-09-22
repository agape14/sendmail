<?php
/**
 * Endpoint directo para resetear preguntas
 * Acceso: https://sendmail.delacruzdev.tech/api-reset-questions.php
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

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido. Use POST.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $exitCode = \Illuminate\Support\Facades\Artisan::call('mype:reset-questions');
    $output = \Illuminate\Support\Facades\Artisan::output();
    
    echo json_encode([
        'success' => $exitCode === 0,
        'message' => $exitCode === 0 ? 'Preguntas reseteadas exitosamente' : 'Error al resetear preguntas',
        'output' => $output,
        'exit_code' => $exitCode
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al resetear preguntas: ' . $e->getMessage(),
        'output' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
