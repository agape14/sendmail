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
