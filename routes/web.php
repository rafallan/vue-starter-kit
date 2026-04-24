<?php

use App\Http\Controllers\Painel\TarefaController;
use App\Http\Controllers\Painel\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::resource('/users', UserController::class)->middleware('auth');
Route::resource('/tarefas', TarefaController::class)->middleware('auth');

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';
