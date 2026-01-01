<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\HomeController;

// === ROUTES PUBLIQUES ===
Route::get('/', function () {
    return view('welcome');
});

// === AUTHENTIFICATION GOOGLE OAUTH 2 ===
Route::get('/login', function () {
    return view('auth.google-login');
})->name('login');

Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])
    ->name('auth.google');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');

Route::post('/logout', [GoogleAuthController::class, 'logout'])
    ->name('logout');

// === ROUTES PROTÉGÉES ===
Route::middleware(['auth'])->group(function () {
    
    // === DASHBOARD ===
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // === ROUTES ADMIN (CRUD) ===
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
        Route::get('/etudiants/ajouter', [EtudiantController::class, 'create'])
        ->name('etudiants.ajouter');
        Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');
        Route::get('/etudiants/{etudiant}/edit', [EtudiantController::class, 'edit'])->name('etudiants.edit');
        Route::put('/etudiants/{etudiant}', [EtudiantController::class, 'update'])->name('etudiants.update');
        Route::delete('/etudiants/{etudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');
        Route::get('/etudiants/export/{format}', [EtudiantController::class, 'export'])->name('etudiants.export');
    });
    
    // === ROUTES ÉTUDIANT ===
    Route::middleware(['role:etudiant'])->group(function () {
        Route::get('/mon-profil', [EtudiantController::class, 'monProfil'])->name('etudiants.mon-profil');
        Route::put('/mon-profil/update', [EtudiantController::class, 'updateMonProfil'])->name('etudiants.update-mon-profil');
    });
    
    // Route show (accessible par tous les utilisateurs authentifiés)
    Route::get('/etudiants/{etudiant}', [EtudiantController::class, 'show'])->name('etudiants.show');
});

// === ROUTE FALLBACK ===
Route::fallback(function () {
    return redirect('/');
});