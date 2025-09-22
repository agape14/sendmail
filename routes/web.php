<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyPeController;

// Rutas principales del dashboard
Route::get('/', [MyPeController::class, 'dashboard'])->name('home');
Route::get('/mype/dashboard', [MyPeController::class, 'dashboard'])->name('mype.dashboard');

// Rutas API para el dashboard
Route::middleware(['web'])->group(function () {
    Route::get('/mype/config', [MyPeController::class, 'getConfig'])->name('mype.config');
    Route::get('/mype/stats', [MyPeController::class, 'getStats'])->name('mype.stats');
    Route::post('/mype/send-consulta', [MyPeController::class, 'sendConsulta'])->name('mype.send-consulta');
    Route::post('/mype/reset-questions', [MyPeController::class, 'resetQuestions'])->name('mype.reset-questions');
    Route::post('/mype/update-config', [MyPeController::class, 'updateConfig'])->name('mype.update-config');
});

// Ruta de prueba para verificar que las rutas funcionan
Route::get('/test-routes', function () {
    return response()->json([
        'success' => true,
        'message' => 'Las rutas están funcionando correctamente',
        'routes' => [
            'home' => route('home'),
            'dashboard' => route('mype.dashboard'),
            'config' => route('mype.config'),
            'stats' => route('mype.stats')
        ]
    ], 200, [], JSON_UNESCAPED_UNICODE);
})->name('test.routes');

// Endpoint de respaldo para configuración (sin middleware)
Route::get('/api/config', function () {
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
        
        return response()->json([
            'success' => true,
            'message' => 'Configuración obtenida exitosamente',
            'config' => $config
        ], 200, [], JSON_UNESCAPED_UNICODE);
    } catch (\Exception $e) {
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
})->name('api.config');
