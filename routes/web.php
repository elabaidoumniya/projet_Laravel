
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ProfileController;

// === ROUTES PUBLIQUES ===
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes();

// === ROUTES PROTÉGÉES ===
Route::middleware(['auth'])->group(function () {
    
    // === DASHBOARD ===
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // === ROUTES ÉTUDIANTS (Lecture pour tous) ===
    Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
    Route::get('/etudiants/{etudiant}', [EtudiantController::class, 'show'])->name('etudiants.show');
    
    // === ROUTES ADMIN (CRUD complet) ===
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/etudiants/create', [EtudiantController::class, 'create'])->name('etudiants.create');
        Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');
        Route::get('/etudiants/{etudiant}/edit', [EtudiantController::class, 'edit'])->name('etudiants.edit');
        Route::put('/etudiants/{etudiant}', [EtudiantController::class, 'update'])->name('etudiants.update');
        Route::delete('/etudiants/{etudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');
        Route::get('/etudiants/export/{format}', [EtudiantController::class, 'export'])->name('etudiants.export');
    });
    
    // === ROUTES ÉTUDIANT (Profil seulement) ===
    Route::middleware(['role:etudiant'])->group(function () {
        Route::get('/mon-profil', [EtudiantController::class, 'monProfil'])->name('etudiants.mon-profil');
        Route::put('/mon-profil/update', [EtudiantController::class, 'updateMonProfil'])->name('etudiants.update-mon-profil');
    });
    
    // === PROFILE ===
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // === TESTS ===
    Route::get('/test-admin', function() {
        return "TEST ADMIN - OK! User: " . auth()->user()->name;
    })->middleware(['role:admin']);
    Route::get('/admin/etudiants/ajouter', [EtudiantController::class, 'create'])
    ->name('etudiants.ajouter')
    ->middleware(['auth', 'role:admin']);
});