<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Participant;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Trainer;
use App\Http\Middleware\EnsureRole;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Bezoekers (iedereen)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacybeleid', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/algemene-voorwaarden', [HomeController::class, 'terms'])->name('terms');

// Eén gedeeld inlogscherm; daarna per rol naar een eigen scherm.
Route::get('/inloggen', [LoginController::class, 'show'])->name('login');
Route::post('/inloggen', [LoginController::class, 'store']);
Route::post('/uitloggen', [LoginController::class, 'destroy'])->name('logout');

Route::get('/registreren', [RegisterController::class, 'show'])->name('register');
Route::post('/registreren', [RegisterController::class, 'store']);

Route::get('/wachtwoord-vergeten', [PasswordResetController::class, 'showForgot'])->name('password.request');
Route::post('/wachtwoord-vergeten', [PasswordResetController::class, 'sendLink'])->name('password.email');
Route::get('/wachtwoord-resetten/{token}', [PasswordResetController::class, 'showReset'])->name('password.reset');
Route::post('/wachtwoord-resetten', [PasswordResetController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Leden (role = participant)
|--------------------------------------------------------------------------
*/
Route::prefix('lid')->middleware(['auth', EnsureRole::class.':participant'])->group(function () {
    Route::get('/', [Participant\DashboardController::class, 'index'])->name('participant.dashboard');
    Route::get('/lessen', [Participant\LessonController::class, 'index'])->name('participant.lessons.index');
    Route::get('/mijn-lessen', [Participant\LessonController::class, 'mine'])->name('participant.lessons.mine');
    Route::post('/lessen/{lesson}/inschrijven', [Participant\LessonController::class, 'enroll'])->name('participant.lessons.enroll');
    Route::delete('/lessen/{lesson}/inschrijven', [Participant\LessonController::class, 'withdraw'])->name('participant.lessons.withdraw');
    Route::get('/activiteiten', [Participant\ActivityController::class, 'index'])->name('participant.activities');
});

/*
|--------------------------------------------------------------------------
| Trainers (role = trainer)
|--------------------------------------------------------------------------
*/
Route::prefix('trainer')->middleware(['auth', EnsureRole::class.':trainer'])->group(function () {
    Route::get('/', [Trainer\LessonController::class, 'dashboard'])->name('trainer.dashboard');
    Route::get('/lessen', [Trainer\LessonController::class, 'index'])->name('trainer.lessons.index');
    Route::get('/lessen/{lesson}', [Trainer\LessonController::class, 'show'])->name('trainer.lessons.show');
    Route::get('/lessen/{lesson}/deelnemers', [Trainer\LessonController::class, 'participants'])->name('trainer.lessons.participants');
    Route::get('/deelnemers', [Trainer\LessonController::class, 'overview'])->name('trainer.participants');
    Route::get('/agenda', [Trainer\LessonController::class, 'agenda'])->name('trainer.agenda');
});

/*
|--------------------------------------------------------------------------
| Mijn Profiel (leden en trainers)
|--------------------------------------------------------------------------
*/
Route::prefix('profiel')->middleware(['auth', EnsureRole::class.':participant,trainer'])->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Beheer (role = admin)
|--------------------------------------------------------------------------
*/
Route::prefix('beheer')->middleware(['auth', EnsureRole::class.':admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('leden', Admin\ParticipantController::class)
        ->except('show')->parameters(['leden' => 'participant'])->names('admin.participants');

    Route::resource('trainers', Admin\TrainerController::class)
        ->except('show')->names('admin.trainers');

    Route::resource('medewerkers', Admin\EmployeeController::class)
        ->except('show')->parameters(['medewerkers' => 'employee'])->names('admin.employees');

    Route::resource('lessen', Admin\LessonController::class)
        ->except('show')->parameters(['lessen' => 'lesson'])->names('admin.lessons');

    Route::resource('activiteiten', Admin\ActivityController::class)
        ->except('show')->parameters(['activiteiten' => 'activity'])->names('admin.activities');
});
