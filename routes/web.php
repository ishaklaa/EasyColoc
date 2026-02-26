<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/profile.dashboard', [AuthenticatedSessionController::class,'store'])->name('profile.dashboard');
    Route::get('/profile.dashboard', [UtilisateurController::class,'roleCheck'])->name('profile.dashboard');
    Route::get('/login.dashboard', [AdminController::class,'dashboard'])->name('login.dashboard');
    Route::put('/admin.users.updateStatus/{id}', [AdminController::class,'update'])->name('admin.users.updateStatus');
});

require __DIR__.'/auth.php';
