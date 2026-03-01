<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleCheckController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/profile.dashboard', [AuthenticatedSessionController::class,'store'])->name('profile.dashboard');
    Route::get('/profile.dashboard', [RoleCheckController::class,'roleCheck'])->name('profile.dashboard');
    Route::get('/login.dashboard', [AdminController::class,'dashboard'])->name('login.dashboard');
    Route::put('/admin.users.updateStatus/{id}', [AdminController::class,'update'])->name('admin.users.updateStatus');
    // Route::get('/login.user.dashboard', [UtilisateurController::class,'index'])->name('login.user.dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/admin.colocations.index', [ColocationController::class,'index'])->name('admin.colocations.index');
    Route::get('/admin.colocations.create', [ColocationController::class,'create'])->name('admin.colocations.create');
    Route::post('/admin.colocations.store', [ColocationController::class,'store'])->name('admin.colocations.store');
    Route::get('/colocations.show/{id}', [ColocationController::class,'show'])->name('colocations.show');
    Route::post('/owner.colocation.token/{id}',[ColocationController::class,'tokenGenerate'])->name('owner.colocation.token');
    Route::post('/store.categorie/{id}',[CategorieController::class,'store'])->name('store.categorie');
    Route::get('/colocations.joinForm',[ColocationController::class,'join'])->name('colocations.joinForm');
    Route::post('/colocations.joinByToken',[ColocationController::class,'tokenCheck'])->name('colocations.joinByToken');
    Route::get('/depense.create/{id}',[DepenseController::class,'create'])->name('depense.create');
});

require __DIR__.'/auth.php';
