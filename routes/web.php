<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyPeController;

Route::get('/', [MyPeController::class, 'dashboard']);
Route::get('/mype/dashboard', [MyPeController::class, 'dashboard']);
Route::post('/mype/send-consulta', [MyPeController::class, 'sendConsulta'])->middleware('web');
Route::get('/mype/stats', [MyPeController::class, 'getStats']);
Route::post('/mype/reset-questions', [MyPeController::class, 'resetQuestions'])->middleware('web');
Route::get('/mype/config', [MyPeController::class, 'getConfig']);
Route::post('/mype/update-config', [MyPeController::class, 'updateConfig'])->middleware('web');
