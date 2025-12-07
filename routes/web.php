<?php

use App\Http\Controllers\MovimientoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovimientoController::class, 'index']);

Route::post('/movimiento', [MovimientoController::class, 'store'])->name('movimiento.guardar');
