<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Homepage
Route::view('/', 'home')->name('home');

// Inloggen (alleen voor gasten)
Route::middleware('guest')->group(function () {
    Route::get('/inloggen', ['App\\Http\\Controllers\\LoginController', 'showLoginForm'])->name('login');
    Route::post('/inloggen', ['App\\Http\\Controllers\\LoginController', 'login'])->name('login.submit');
});

Route::post('/uitloggen', ['App\\Http\\Controllers\\LoginController', 'logout'])
    ->middleware('auth')
    ->name('logout');

// Per rol een eigen beveiligde pagina
Route::middleware(['auth', 'role:lid'])->group(function () {
    Route::view('/lid', 'lid.dashboard')->name('lid.dashboard');
});

Route::middleware(['auth', 'role:trainer'])->group(function () {
    Route::view('/trainer', 'trainer.dashboard')->name('trainer.dashboard');
});

Route::middleware(['auth', 'role:beheerder'])->group(function () {
    Route::view('/beheerder', 'beheerder.dashboard')->name('beheerder.dashboard');
});
