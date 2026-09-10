<?php

use App\Http\Controllers\PeliculaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PeliculaController::class, 'index'])->name('peliculas.index');
Route::get('/peliculas/ciencia-ficcion', [PeliculaController::class, 'cienciaFiccion'])->name('peliculas.ciencia-ficcion');
Route::get('/peliculas/nueva', [PeliculaController::class, 'create'])->name('peliculas.create');
Route::post('/peliculas', [PeliculaController::class, 'store'])->name('peliculas.store');
Route::get('/peliculas/{id}', [PeliculaController::class, 'show'])
    ->whereNumber('id')
    ->name('peliculas.show');
