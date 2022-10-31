<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JornadaController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\MundialController;
use App\Http\Controllers\PaisesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/pais', [MundialController::class, 'pais']);
    Route::post('/ciudad', [MundialController::class, 'ciudad']);
    Route::post('/estadio', [MundialController::class, 'estadio']);
    Route::get('/mundiales', [MundialController::class, 'index']);
    Route::post('/create-mundial', [MundialController::class, 'create']);
    Route::post('/finalizar', [MundialController::class, 'finalizar']);
    Route::put('/update-mundial/{id}', [MundialController::class, 'update']);

    Route::post('/selecciones', [PaisesController::class, 'index']);
    Route::post('/clasificado', [PaisesController::class, 'create']);
    Route::post('/grupo', [PaisesController::class, 'grupo']);

    Route::post('/partidos', [JornadaController::class, 'index']);
    Route::post('/jornada', [JornadaController::class, 'create']);
    Route::put('/marcador/{id}', [JornadaController::class, 'update']);

    Route::get('/ligas', [LigaController::class, 'index']);
    Route::post('/create-liga', [LigaController::class, 'create']);
    Route::post('/equipo', [LigaController::class, 'equipo']);
    Route::post('/apuesta', [LigaController::class, 'apuesta']);
});