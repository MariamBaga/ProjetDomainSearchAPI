<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\DomaineController;

// Groupe de routes pour les opérations sur les domaines
Route::middleware('auth:sanctum')->group(function () {

    // Route pour rechercher des domaines
    Route::get('/search', [DomaineController::class, 'index']);

    // Route pour renouveler un domaine
    Route::post('/renew', [DomaineController::class, 'renew']);

    // Route pour transférer un domaine
    Route::post('/transfer', [DomaineController::class, 'transfer']);
});
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
