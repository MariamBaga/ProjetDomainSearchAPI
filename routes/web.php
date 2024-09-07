<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomaineController;
Route::get('/', function () {
    return view('auth.login');
});

 // Route pour rechercher des domaines
 Route::get('/search', [DomaineController::class, 'index']);

 // Enregistrement d'un domaine
Route::post('/register', [DomaineController::class, 'register'])->name('domains.register');


 // Route pour renouveler un domaine
 Route::get('/renew', [DomaineController::class, 'renew']);

 // Route pour transférer un domaine
 Route::post('/transfer', [DomaineController::class, 'transfer']);



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
