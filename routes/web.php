
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CommentController;
use App\Models\Post;

Route::get('/test', function(){
    return view('home');
});

Route::redirect('/', '/posts');

Route::resource('posts', PostController::class)
    ->except(['index', 'show'])
    ->middleware('auth');

Route::resource('posts', PostController::class)
    ->only(['index', 'show']);
    
Route::get('/admin/posts', [AdminPostController::class, 'index'])
    ->middleware('admin')
    ->name('admin.posts.index');

Route::delete('/admin/posts/{post}', [AdminPostController::class, 'destroy'])
    ->middleware('admin')   
    ->name('admin.posts.destroy');


Route::get('/admin/users', [AdminUserController::class, 'index'])
    ->middleware('admin')
    ->name('admin.users.index');

Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])
    ->middleware('admin')
    ->name('admin.users.destroy');

Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::resource('comments', CommentController::class)
        ->only(['edit', 'update', 'destroy']);
});
require __DIR__.'/auth.php';

