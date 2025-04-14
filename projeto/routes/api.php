<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/usuario')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::get('/{id}', [UsuarioController::class, 'show']);
    Route::post('/', [UsuarioController::class, 'store']);
    Route::put('/{id}', [UsuarioController::class, 'update']);
    Route::delete('/{id}', [UsuarioController::class, 'destroy']);
});

Route::prefix('/curso')->group(function () {
    Route::get('/', [CursoController::class, 'index']);
    Route::get('/active', [CursoController::class, 'active']);
    Route::get('/{id}', [CursoController::class, 'show']);
    Route::post('/', [CursoController::class, 'store']);
    Route::put('/{id}', [CursoController::class, 'update']);
    Route::delete('/{id}', [CursoController::class, 'destroy']);
});

Route::prefix('/inscricao')->group(function () {
    Route::get('/', [InscricaoController::class, 'index']);
    Route::get('/{id}', [InscricaoController::class, 'show']);
    Route::get('/curso/{curId}', [InscricaoController::class, 'byCurso']);
    Route::get('/aluno/{aluId}', [InscricaoController::class, 'byAluno']);
    Route::post('/', [InscricaoController::class, 'store']);
    Route::put('/{id}', [InscricaoController::class, 'update']);
    Route::patch('/{id}/status', [InscricaoController::class, 'updateStatus']);
    Route::delete('/{id}', [InscricaoController::class, 'destroy']);
});


Route::post('/login', [AuthController::class, 'login']);
