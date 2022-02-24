<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\CampeonatoController;
use App\Http\Controllers\CampeonatoTimeController;
use App\Http\Controllers\CampeonatoJogoController;
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

Route::apiResource('time', TimeController::class)->names('api.time');
Route::apiResource('campeonato', CampeonatoController::class)->names('api.campeonato');
Route::post('campeonato_time', [CampeonatoTimeController::class, 'store']);
Route::delete('campeonato_time', [CampeonatoTimeController::class, 'destroy']);
Route::get('campeonato_time/{id}', [CampeonatoTimeController::class, 'show']);
Route::get('campeonato_jogo/{id}', [CampeonatoJogoController::class, 'show']);
Route::post('campeonato_jogo/sorteio/{id}', [CampeonatoJogoController::class, 'sorteio']);
Route::post('campeonato_jogo/simula/{id}', [CampeonatoJogoController::class, 'simulacao']);
