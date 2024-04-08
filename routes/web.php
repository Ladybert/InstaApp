<?php

use App\Http\Controllers\CommentPostController;
use App\Http\Controllers\LikePostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/post', PostController::class)->middleware(['auth', 'verified']);
Route::resource('/post/comment', CommentPostController::class)->middleware(['auth', 'verified']);
Route::post('/like/{post}', [LikePostController::class, 'post'])->name('like.post')->middleware(['auth', 'verified']);


// Route::get('/post', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
