<?php

use App\Http\Controllers\Api\Auth\AuthController as ApiAuthController;
use App\Http\Controllers\Api\ProposalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes  (Token-based Auth — Laravel Sanctum)
|--------------------------------------------------------------------------
|
| Menggunakan Personal Access Token (Sanctum)
*/

Route::prefix('auth')->name('api.auth.')->group(function () {

    Route::post('/login', [ApiAuthController::class, 'login'])
        ->name('login');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('auth')->name('api.auth.')->group(function () {

        // POST /api/auth/logout
        Route::post('/logout', [ApiAuthController::class, 'logout'])
            ->name('logout');

        // GET /api/auth/me
        Route::get('/me', [ApiAuthController::class, 'me'])
            ->name('me');
    });

    Route::prefix('proposals')->name('api.proposals.')->group(function () {
        // GET /api/proposals
        Route::get('/', [ProposalController::class, 'index'])
            ->name('get');

        // POST /api/proposals
        Route::post('/', [ProposalController::class, 'store'])
            ->name('store');
        // PUT /api/proposals/{proposal}/approve
        Route::put('/{proposal}/approve', [ProposalController ::class, 'approve'])
            ->name('approve');
    
    });
});
