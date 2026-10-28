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
    <style>
        body {
            background-color: #f4f5f7;
            font-family: Arial, sans-serif;
        }
        
        /* Phần Header */
        .header-bg {
            background-color: #104c82; /* Màu xanh đặc trưng */
        }
        .logo-text {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 1px;
        }
        .main-nav .nav-link {
            color: #d1e2f3;
            font-size: 0.9rem;
            padding: 10px 15px;
        }
        .main-nav .nav-link:hover {
            color: white;
        }
        .main-nav .nav-link.active {
            background-color: white;
            color: #104c82;
            font-weight: bold;
            border-radius: 2px 2px 0 0;
        }
        
        /* Sub Navigation */
        .sub-nav {
            background-color: white;
            border-bottom: 1px solid #ddd;
            font-size: 0.85rem;
        }
        .sub-nav a {
            color: #104c82;
            text-decoration: none;
            padding: 8px 0;
            display: inline-block;
        }

        /* Thẻ bài viết nổi bật */
        .featured-box {
            background: white;
            border: 1px solid #e2e2e2;
            padding: 15px;
            height: 100%;
        }
        .featured-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Danh sách bài viết */
        .thread-container {
            background: white;
            border: 1px solid #e2e2e2;
            margin-top: 20px;
        }
        .thread-header {
            background-color: #f8f9fa;
            color: #104c82;
            font-size: 1.1rem;
            padding: 12px 15px;
            border-bottom: 1px solid #e2e2e2;
        }
        .thread-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
        }
        .thread-item:hover {
            background-color: #f8f9fa;
        }
        .thread-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
        }
        .badge-custom {
            font-size: 0.75rem;
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: normal;
            border: 1px solid transparent;
            margin-right: 5px;
        }
        .badge-green { background-color: #e5f5e5; color: #28a745; border-color: #c3e6c3; }
        .badge-orange { background-color: #fff3cd; color: #856404; border-color: #ffeeba; }
        .badge-blue { background-color: #cce5ff; color: #004085; border-color: #b8daff; }
        
        .thread-title {
            color: #104c82;
            text-decoration: none;
            font-size: 0.95rem;
        }
        .thread-title:hover {
            text-decoration: underline;
        }
        .thread-meta {
            font-size: 0.8rem;
            color: #777;
            margin-top: 3px;
        }
        .thread-stats {
            font-size: 0.8rem;
            color: #666;
            text-align: right;
            white-space: nowrap;
        }
        .last-post {
            font-size: 0.8rem;
            text-align: right;
            min-width: 120px;
        }
        .last-post-avatar {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            vertical-align: middle;
            margin-left: 5px;
        }
    </style>
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