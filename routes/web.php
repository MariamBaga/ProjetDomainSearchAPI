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
 Route::POST('/renew', [DomaineController::class, 'renew']);

 // Route pour transférer un domaine
 Route::post('/transfer', [DomaineController::class, 'transfer']);

 // Liste des transferts
Route::get('/transfers', [DomaineController::class, 'listTransfers'])->name('domains.transfers.list');

// Annulation d'un transfert
Route::post('/transfer/cancel', [DomaineController::class, 'cancelTransfer'])->name('domains.transfer.cancel');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
