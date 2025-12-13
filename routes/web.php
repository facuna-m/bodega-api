<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientoController;

Route::get('/', function(){
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/bodega', [MovimientoController::class, 'index'])->name('dashboard');
    Route::post('/movimientos', [MovimientoController::class, 'store'])->name('movimiento.guardar');
    Route::post('/reporte', [MovimientoController::class, 'getReport'])->name('bodega.reporte');
});

require __DIR__.'/auth.php';
