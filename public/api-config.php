<?php
/**
 * Endpoint directo para configuración
 * Acceso: https://sendmail.delacruzdev.tech/api-config.php
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
    
    echo json_encode([
        'success' => true,
        'message' => 'Configuración obtenida exitosamente',
        'config' => $config
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener configuración: ' . $e->getMessage(),
        'config' => [
            'target_email' => 'Eleccionescomprasamyperu@produce.gob.pe',
            'sender_name' => 'Consultas MYPE',
            'min_days' => 1,
            'max_days' => 7,
        ]
    ], JSON_UNESCAPED_UNICODE);
}
