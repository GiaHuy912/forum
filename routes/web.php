<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $posts = Post::with('user', 'comments')
        ->latest()
        ->get();

    return view('home', compact('posts'));
});