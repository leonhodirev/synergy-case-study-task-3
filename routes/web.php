<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';

Route::get('/dashboard', [HomeController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/subscribe', [UserController::class, 'subscribe'])->name('users.subscribe');
    Route::post('/users/{user}/unsubscribe', [UserController::class, 'unsubscribe'])->name('users.unsubscribe');

    Route::resource('posts', PostController::class);
    Route::get('/feed', [PostController::class, 'feed'])->name('posts.feed');
    Route::post('/posts/{post}/request-access', [PostController::class, 'requestAccess'])->name('posts.request_access');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
});


