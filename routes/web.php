<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\Admin\TrackController as AdminTrackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route d'accueil
Route::get('/', function () {
    return view('home');
});

// Route spécifique pour mix-vault (doit être AVANT la route générique)
Route::get('/mix-vault', [TrackController::class, 'index']);

// Routes d'administration (sans authentification)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Route "resource" pour les tracks (génère index, create, store, etc.)
    Route::resource('tracks', AdminTrackController::class);
});

// Route générique pour les autres sections (doit être APRÈS les routes spécifiques)
Route::get('/{section}', function ($section) {
    // Vérifier si la vue existe
    if (view()->exists($section)) {
        return view($section);
    }
    
    // Rediriger vers la page d'accueil si la section n'existe pas
    return redirect('/');
})->where('section', 'home|top50|bande-joyeuse|contributions|maestro-playlist|lavise|contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');