<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Nhóm "guest": chỉ dành cho người CHƯA đăng nhập.
// Nếu đã đăng nhập mà vào /login, Laravel tự chuyển họ đi chỗ khác.
Route::middleware('guest')->group(function () {

    // GET = hiển thị form; POST = xử lý dữ liệu form gửi lên
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    // Tên route 'login' RẤT quan trọng: middleware 'auth' sẽ tự chuyển
    // người chưa đăng nhập về route có tên 'login'.
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

// Đăng xuất: dùng POST (không dùng GET) để có @csrf, tránh bị lừa đăng xuất
// bằng một đường link. Middleware 'auth': chỉ người đã đăng nhập mới đăng xuất.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');