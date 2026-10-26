<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Forum')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<header class="header">
    <div class="container header-inner">

        <a href="{{ url('/') }}" class="logo">
            Forum
        </a>

        <nav class="menu">
            <a href="{{ url('/') }}">Trang chủ</a>
            <a href="#">Bài viết</a>

            @auth
                <span>
                    Xin chào, {{ auth()->user()->name }}
                </span>

                @if(auth()->user()->role === 'admin')
                    <a href="#">Admin</a>
                @endif
            @endauth

            @guest
                <a href="#">Đăng nhập</a>
                <a href="#">Đăng ký</a>
            @endguest
        </nav>

    </div>
</header>

<main class="container main-content">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    @yield('content')

</main>

<footer class="footer">
    <div class="container">
        &copy; {{ date('Y') }} Forum
    </div>
</footer>

</body>
</html>