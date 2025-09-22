<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyPeController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/mype/send-consulta', [MyPeController::class, 'sendConsulta']);
Route::get('/mype/stats', [MyPeController::class, 'getStats']);
