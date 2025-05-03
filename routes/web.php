<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Todo2Controller;
use App\Http\Controllers\UserController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard hanya untuk user yang login dan terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Grup route untuk user yang sudah login
Route::middleware('auth')->group(function () {

    //Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk Todo
    Route::resource('todo', Todo2Controller::class)->except(['show']);
    Route::delete('/todo', [Todo2Controller::class, 'destroyCompleted'])->name('todo.destroyCompleted');
    Route::patch('/todo/{todo}/complete', [Todo2Controller::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/uncomplete', [Todo2Controller::class, 'uncomplete'])->name('todo.uncomplete');
});


// Grup route untuk admin
Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('/user',UserController::class)->except('show');
    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');

});

// Route untuk menampilkan semua todo
Route::patch('/todo/{todo}/complete', [Todo2Controller::class, 'complete'])->name('todo.complete');
Route::patch('/todo/{todo}/uncomplete', [Todo2Controller::class, 'uncomplete'])->name('todo.uncomplete');

// Route untuk menampilkan semua user
Route::get('/user',[UserController::class, 'index'])->name('user.index');
Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');


// Route untuk Edit todo
Route::get('/todo/{todo}/edit', [Todo2Controller::class, 'edit'])->name('todo.edit');

// Route untuk menghapus todo
Route::delete('/todo/{todo}', [Todo2Controller::class, 'destroy'])->name('todo.destroy');
Route::delete('/todo', [Todo2Controller::class, 'destroyCompleted'])->name('todo.destroyCompleted');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

require __DIR__.'/auth.php';
