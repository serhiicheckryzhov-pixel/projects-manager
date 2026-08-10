<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//\DB::listen(function ($query) {
//    dump($query->sql); // Выведет каждый выполненный SQL-запрос
//});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/projects/index', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/edit/{project}', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::patch('/projects/edit/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
    Route::delete('/projects/delete/{project}', [ProjectController::class, 'delete'])->name('projects.delete');


    Route::get('/users/index', [UserController::class, 'index'])->middleware('can:admin-access')->name('users');
    Route::get('/users/edit/{project}', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::patch('/users/edit/{project}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/delete/{project}', [UserController::class, 'delete'])->name('users.delete');

});

require __DIR__.'/auth.php';
