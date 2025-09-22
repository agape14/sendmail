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

// Endpoints directos sin middleware para evitar problemas de servidor
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

// Endpoint directo para estadísticas
Route::get('/api/stats', function () {
    try {
        $totalQuestions = \App\Models\Question::count();
        $sentQuestions = \App\Models\Question::where('is_sent', true)->count();
        $pendingQuestions = $totalQuestions - $sentQuestions;
        $lastSent = \App\Models\Question::where('is_sent', true)->orderBy('last_sent_at', 'desc')->first();
        
        return response()->json([
            'success' => true,
            'message' => 'Estadísticas obtenidas exitosamente',
            'data' => [
                'totalQuestions' => $totalQuestions,
                'sentQuestions' => $sentQuestions,
                'pendingQuestions' => $pendingQuestions,
                'lastSent' => $lastSent ? $lastSent->last_sent_at : null
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener estadísticas: ' . $e->getMessage(),
            'data' => [
                'totalQuestions' => 0,
                'sentQuestions' => 0,
                'pendingQuestions' => 0,
                'lastSent' => null
            ]
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
})->name('api.stats');

// Endpoint directo para enviar consulta
Route::post('/api/send-consulta', function () {
    try {
        $exitCode = \Illuminate\Support\Facades\Artisan::call('mype:send-consulta', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        
        return response()->json([
            'success' => $exitCode === 0,
            'message' => $exitCode === 0 ? 'Consulta enviada exitosamente' : 'Error al enviar consulta',
            'output' => $output,
            'exit_code' => $exitCode
        ], 200, [], JSON_UNESCAPED_UNICODE);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al enviar consulta: ' . $e->getMessage(),
            'output' => $e->getMessage()
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
})->name('api.send-consulta');

// Endpoint directo para resetear preguntas
Route::post('/api/reset-questions', function () {
    try {
        $exitCode = \Illuminate\Support\Facades\Artisan::call('mype:reset-questions');
        $output = \Illuminate\Support\Facades\Artisan::output();
        
        return response()->json([
            'success' => $exitCode === 0,
            'message' => $exitCode === 0 ? 'Preguntas reseteadas exitosamente' : 'Error al resetear preguntas',
            'output' => $output,
            'exit_code' => $exitCode
        ], 200, [], JSON_UNESCAPED_UNICODE);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al resetear preguntas: ' . $e->getMessage(),
            'output' => $e->getMessage()
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
})->name('api.reset-questions');
