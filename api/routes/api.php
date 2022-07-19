<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefasController;
use App\Http\Controllers\UsuariosController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('tarefas')->group(function() {
    Route::get('/', [TarefasController::class, 'index']);
    Route::get('/{id}', [TarefasController::class, 'show']);
    Route::post('/', [TarefasController::class, 'store']);
    Route::put('/{id}', [TarefasController::class, 'update']);
    Route::delete('/{id}', [TarefasController::class, 'destroy']);
});

Route::prefix('usuarios')->group(function() {
    Route::get('/', [UsuariosController::class, 'index']);
    Route::get('/{id}', [UsuariosController::class, 'show']);
    Route::post('/', [UsuariosController::class, 'store']);
    Route::put('/{id}', [UsuariosController::class, 'update']);
    Route::delete('/{id}', [UsuariosController::class, 'destroy']);
});