<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\InspecaoController;
use App\Http\Controllers\SaudeFrotaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Cria automaticamente as rotas de Listar, Cadastrar, Editar, Atualizar e Deletar
    Route::resource('veiculos', VeiculoController::class);
    Route::resource('manutencoes', ManutencaoController::class);
});

Route::middleware(['auth'])->group(function () {
    // Rota customizada para a impressão antes do resource
    Route::get('inspecoes/{inspecao}/imprimir', [InspecaoController::class, 'imprimir'])->name('inspecoes.imprimir');
    
    // Cria automaticamente as rotas de index, create, store, edit, update e destroy
    Route::resource('inspecoes', InspecaoController::class);
});

require __DIR__.'/auth.php';
Route::middleware(['auth'])->group(function () {
    Route::get('/saude-da-frota', [SaudeFrotaController::class, 'index'])->name('saude.frota');
});
