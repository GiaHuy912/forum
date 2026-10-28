
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::redirect('/', '/posts');

Route::resource('posts', PostController::class)
    ->except(['index', 'show'])
    ->middleware('auth');

Route::resource('posts', PostController::class)
    ->only(['index', 'show']);

require __DIR__.'/auth.php';

Route::get('/test-auth', fn () => 'Đã đăng nhập, vào được')->middleware('auth');