<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\InspecaoController;
use App\Http\Controllers\SaudeFrotaController;
use App\Http\Controllers\OficinaAtividadeController;
use App\Http\Controllers\OficinaOrdemController;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/oficina', [OficinaAtividadeController::class, 'index'])->name('oficina.index');
    Route::post('/oficina', [OficinaAtividadeController::class, 'store'])->name('oficina.store');
});

Route::middleware(['auth'])->group(function () {
    // Rota do formulário adaptável (Esta é a rota que a view está procurando)
    Route::get('/oficina/atividade/{atividade}/categoria/{categoria}', [OficinaOrdemController::class, 'create'])->name('oficina.ordem.create');
    
    // Rota de processamento do formulário no banco
    Route::post('/oficina/atividade/{atividade}/categoria/{categoria}', [OficinaOrdemController::class, 'store'])->name('oficina.ordem.store');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/oficina/atividade/{id}/saida', [App\Http\Controllers\OficinaAtividadeController::class, 'darSaida'])->name('oficina.saida');
});
