<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FacturaController;

Route::get('/', function () {
    return redirect('/factura');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/factura', [FacturaController::class, 'index']);
Route::post('/factura', [FacturaController::class, 'calcular']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
