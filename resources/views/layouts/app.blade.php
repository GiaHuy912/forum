<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'XAMVN - Bố cục Diễn đàn')</title>
    <!-- Tích hợp Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome cho các icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Bắt đầu Header -->
    <header class="header-bg pt-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end">
                <div class="d-flex align-items-end">
                    <a href="{{ route('posts.index') }}" class="logo-text mb-2 me-4">CỘNG ĐỒNG SINH VIÊN&trade;</a>
                    <ul class="nav main-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('posts.index') }}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-newspaper"></i> Lều báo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-beer-mug-empty"></i> Quán con sò say</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-pen-nib"></i> Trại sáng tác</a>
                        </li>
                    </ul>
                </div>
                <div class="pb-2">
                    @auth
                        <span class="text-white" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-user"></i> {{ auth()->user()->name }}
                        </span>
                        <form method="POST" action="{{ url('/logout') }}" class="d-inline ms-3">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 text-white text-decoration-none" style="font-size: 0.9rem;">
                                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                            </button>
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="text-white text-decoration-none me-3" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
                        </a>
                        <a href="{{ url('/register') }}" class="text-white text-decoration-none" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-lock"></i> Đăng ký
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Sub Navigation -->
    <div class="sub-nav mb-3">
        <div class="container">
            <a href="{{ route('posts.index') }}">Bài viết mới</a>
        </div>
    </div>

    <!-- Nội dung chính -->
    <main class="container mb-5">
        <p class="text-muted mb-3">&copy; XAMVN.COM</p>

        <!-- Thông báo flash -->
        @foreach(['success' => 'success', 'error' => 'danger', 'status' => 'info'] as $key => $type)
            @if(session($key))
                <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                    {{ session($key) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach

        @yield('content')
    </main>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>