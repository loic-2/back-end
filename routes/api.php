<?php

use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\AssureurController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\TacheController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/assureurs', [AssureurController::class, 'index']);
Route::get('/clients', [ClientController::class, 'index']);
Route::get('/personnels', [PersonnelController::class, 'index']);
Route::get('/personnes', [PersonneController::class, 'index']);
Route::get('/activites', [ActiviteController::class, 'index']);
Route::get('/taches', [TacheController::class, 'index']);

Route::delete('/activites/{id}', [ActiviteController::class, 'destroy']);
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
Route::delete('/personnels/{id}', [PersonnelController::class, 'destroy']);
Route::delete('/assureurs/{id}', [AssureurController::class, 'destroy']);
Route::delete('/taches/{id}', [TacheController::class, 'destroy']);

Route::post('/personnels', [PersonnelController::class, 'store']);
Route::post('/assureurs', [AssureurController::class, 'store']);
Route::post('/clients', [ClientController::class, 'store']);
Route::post('/activites', [ActiviteController::class, 'store']);

//Routes de modification
Route::put('/personnels', [PersonnelController::class, 'update']);
Route::put('/assureurs', [AssureurController::class, 'update']);
Route::put('/clients', [ClientController::class, 'update']);