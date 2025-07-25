<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegistroLecturasController;

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

Route::middleware(['api.key'])->prefix('registro-lecturas')->group(function () {
    Route::get('/', [RegistroLecturasController::class, 'index']);
    Route::get('/buscar', [RegistroLecturasController::class, 'buscar']);
    Route::post('/', [RegistroLecturasController::class, 'store']);
    Route::get('/{id}', [RegistroLecturasController::class, 'show']);
    Route::put('/{id}', [RegistroLecturasController::class, 'update']);
    Route::delete('/{id}', [RegistroLecturasController::class, 'destroy']);
    Route::post('/{id}/estatus', [RegistroLecturasController::class, 'actualizarEstatus']);
});


