<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TMDBController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {

    // ROTAS DO PERFIL DO USUÁRIO
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROTAS DO TMDB
    Route::get('/tmdb/search', [TMDBController::class, 'search'])->name('tmdb.search');

    // ROTAS DE FILMES
    Route::resource('movies', MovieController::class)->names([
        'index' => 'movies.index',
        'create' => 'movies.create',
        'store' => 'movies.store',
        'edit' => 'movies.edit',
        'update' => 'movies.update',
        'destroy' => 'movies.destroy',
    ]);
});

require __DIR__ . '/auth.php';
