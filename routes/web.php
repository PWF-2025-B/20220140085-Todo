<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Todo2Controller;
use App\Http\Controllers\UserController;


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
});

Route::get('/todo',[Todo2Controller::class, 'index'])->name('todo.index');
Route::get('/todo/create',[Todo2Controller::class, 'create'])->name('todo.create');
Route::get('/todo/edit',[Todo2Controller::class, 'edit'])->name('todo.edit');

Route::get('/user',[UserController::class, 'index'])->name('user.index');
require __DIR__.'/auth.php';
