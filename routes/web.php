<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// le nom des 2e paramètres de tableau est celui des fonctions dans les controllers correspondants

// middleware guest pour les droits d'accès aux pages d'inscription/connexion (statut guest)
Route::middleware('guest')->group(function () {
    // route formulaire inscription
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // route inscription nouveau membre
    Route::post('/register', [RegisterController::class, 'register']);
    // route formulaire connexion
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // route connexion membre
    Route::post('/login', [LoginController::class, 'login']);
});

// middleware pour droit d'accès au compte utilisateur (statut auth)
Route::middleware('auth')->group(function () {
    // route compte utilisateur (home est une valeur laravel par défaut)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // route déconnexion
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // route postage de commentaire
    Route::post('/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    // route changement de mdp
    Route::patch('/home', [HomeController::class, 'updatePassword']);
});

// middleware pour droit d'accès admin
Route::middleware('admin')->group(function () {
    // route administration des posts / 'except show' car on l'utilise déjà ailleurs
    // names au pluriel car il y aura plusieurs noms pour les routes générées
    Route::resource('/admin/posts', AdminController::class)->except('show')->names('admin.posts');
});

// route index le premier 'index' est le nom de la fonction dans PostController.php
Route::get('/', [PostController::class, 'index'])->name('index');
// route pour le filtrage des posts par categories
Route::get('/categories/{category}', [PostController::class, 'postsByCategory'])->name('posts.byCategory');
// route pour le filtrage des posts par tags
Route::get('/tags/{tag}', [PostController::class, 'postsByTag'])->name('posts.byTag');
// route page individuelle article
Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');