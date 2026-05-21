<?php

use App\Http\Controllers\Web\Auth\AuthController as WebAuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProposalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes  (Session-based Auth)
|--------------------------------------------------------------------------
|
| Menggunakan Laravel Session + Cookie
| Auth Guard : web (default)
| Response   : Blade view / Redirect
|
*/

// Redirect root → login
Route::get('/', fn () => redirect()->route('web.login'));

// ─── Guest only (belum login) ─────────────────────────────────────────────────
Route::middleware('guest')->group(function () {

    // GET  /login  → tampilkan form login
    Route::get('/login', [WebAuthController::class, 'showLogin'])
        ->name('web.login');

    // POST /login  → proses login session
    Route::post('/login', [WebAuthController::class, 'login'])
        ->name('web.login.post');

    // GET /register
    Route::get('/register', [WebAuthController::class, 'showRegister'])
        ->name('web.register');

    // POST /register
    Route::post('/register', [WebAuthController::class, 'register'])
        ->name('web.register.post');
});

// ─── Authenticated only ───────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('web.dashboard');
    Route::get('/proposal', [ProposalController::class, 'index'])
        ->name('web.proposal');
    Route::get('/proposal/create', [ProposalController::class, 'create'])
        ->name('web.proposal.create');
    Route::post('/proposal', [ProposalController::class, 'store'])
        ->name('web.proposal.store');
    Route::put('/proposal/{proposal}/approve', [ProposalController::class, 'approve'])
        ->name('web.proposal.approve');

    // POST /logout
    Route::post('/logout', [WebAuthController::class, 'logout'])
        ->name('web.logout');
});