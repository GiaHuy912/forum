<<<<<<< HEAD
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forum - Trang chủ</title>

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


    <div class="hero">

        <div>
            <span class="hero-badge">
                COMMUNITY FORUM
            </span>

            <h1>
                Chia sẻ kiến thức.<br>
                Trò chuyện. Kết nối.
            </h1>

            <p>
                Nơi mọi người cùng chia sẻ kinh nghiệm,
                đặt câu hỏi và khám phá những điều thú vị.
            </p>

            <a href="#posts" class="hero-button">
                Khám phá bài viết →
            </a>
        </div>

        <div class="hero-decoration">
            <div class="hero-circle circle-one"></div>
            <div class="hero-circle circle-two"></div>
            <div class="hero-icon">💬</div>
        </div>

    </div>


    <div class="content-layout" id="posts">

        <section class="posts-section">

            <div class="section-heading">

                <div>
                    <span class="section-label">
                        COMMUNITY
                    </span>

                    <h2>
                        Bài viết mới nhất
                    </h2>
                </div>

            </div>


            @forelse($posts as $post)

                <article class="post-card">

                    <div class="post-top">

                        <div class="author">

                            <div class="avatar">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>

                            <div>

                                <div class="author-name">

                                    {{ $post->user->name }}

                                    @if($post->user->role === 'admin')
                                        <span class="admin-badge">
                                            ADMIN
                                        </span>
                                    @endif

                                </div>

                                <div class="post-date">
                                    {{ $post->created_at->format('d/m/Y • H:i') }}
                                </div>

                            </div>

                        </div>

                        <span class="post-tag">
                            DISCUSSION
                        </span>

                    </div>


                    <h3 class="post-title">
                        {{ $post->title }}
                    </h3>


                    <p class="post-content">
                        {{ $post->content }}
                    </p>


                    <div class="post-bottom">

                        <div class="post-stats">

                            <span>
                                💬 {{ $post->comments->count() }} bình luận
                            </span>

                            <span>•</span>

                            <span>
                                Đang thảo luận
                            </span>

                        </div>

                        <a href="#" class="read-more">
                            Đọc bài viết →
                        </a>

                    </div>

                </article>

            @empty

                <div class="empty-card">

                    <div class="empty-icon">
                        📝
                    </div>

                    <h3>
                        Chưa có bài viết
                    </h3>

                    <p>
                        Hãy là người đầu tiên tạo bài viết.
                    </p>

                </div>

            @endforelse

        </section>


        <aside class="sidebar">

            <div class="sidebar-card">

                <div class="sidebar-title">

                    <span class="section-label">
                        FORUM
                    </span>

                    <h3>
                        Thống kê
                    </h3>

                </div>


                <div class="stat-item">

                    <div class="stat-icon">
                        📝
                    </div>

                    <div>
                        <strong>
                            {{ $posts->count() }}
                        </strong>

                        <span>
                            Bài viết
                        </span>
                    </div>

                </div>


                <div class="stat-item">

                    <div class="stat-icon">
                        💬
                    </div>

                    <div>

                        <strong>
                            {{ $posts->sum(fn($post) => $post->comments->count()) }}
                        </strong>

                        <span>
                            Bình luận
                        </span>

                    </div>

                </div>


                <div class="stat-item">

                    <div class="stat-icon">
                        👥
                    </div>

                    <div>

                        <strong>
                            4
                        </strong>

                        <span>
                            Thành viên
                        </span>

                    </div>

                </div>

            </div>


            <div class="sidebar-card welcome-card">

                <div class="welcome-icon">
                    👋
                </div>

                <h3>
                    Chào mừng bạn!
                </h3>

                <p>
                    Tham gia cộng đồng để chia sẻ kiến thức
                    và kết nối với mọi người.
                </p>

                <a href="#" class="sidebar-button">
                    Tham gia ngay
                </a>

            </div>

        </aside>

    </div>

</main>


<footer class="footer">

    <div class="container">
        &copy; {{ date('Y') }} Forum
    </div>

</footer>

</body>

</html>
=======
@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="container mb-5">

    <header class="bg-primary text-white p-3 mb-4 rounded">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <a href="{{ route('posts.index') }}" class="text-white text-decoration-none fw-bold fs-4">
                CỘNG ĐỒNG SINH VIÊN
            </a>

            <div class="d-flex align-items-center gap-3">
                @guest
                    <a href="{{ route('register') }}" class="text-white text-decoration-none">
                        Đăng ký
                    </a>
                    <a href="{{ route('login') }}" class="text-white text-decoration-none">
                        Đăng nhập
                    </a>
                @endguest

                @auth
                    <span>Xin chào, {{ auth()->user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            Đăng xuất
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <h5 class="mb-3">Bài viết nổi bật</h5>

    @if($featured->count())
        <div class="row g-3 mb-4">
            @foreach($featured as $post)
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6>
                                <a href="{{ route('posts.show', $post) }}"
                                   class="text-decoration-none">
                                    {{ \Illuminate\Support\Str::limit($post->title, 60) }}
                                </a>
                            </h6>

                            <p class="text-muted small">
                                {{ \Illuminate\Support\Str::limit($post->content, 100) }}
                            </p>

                            <div class="text-muted small">
                                {{ $post->user->name }}
                                &middot;
                                {{ $post->created_at->diffForHumans() }}
                                &middot;
                                Trả lời: {{ $post->comments_count }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="fw-bold">Mới ra lò</span>

            <form method="GET" action="{{ route('posts.index') }}" class="d-flex gap-2">
                <input
                    type="text"
                    name="search"
                    class="form-control form-control-sm"
                    placeholder="Tìm theo tiêu đề..."
                >
                <button class="btn btn-primary btn-sm" type="submit">
                    Tìm
                </button>
            </form>
        </div>

        <div class="card-body p-0">
            @forelse($posts as $post)
                <div class="p-3 border-bottom">
                    <a href="{{ route('posts.show', $post) }}"
                       class="fw-semibold text-decoration-none">
                        {{ $post->title }}
                    </a>

                    <div class="text-muted small mt-1">
                        {{ $post->user->name }}
                        &middot;
                        {{ $post->created_at->diffForHumans() }}
                        &middot;
                        Trả lời: {{ $post->comments_count }}
                    </div>
                </div>
            @empty
                <div class="p-3 text-muted">
                    Chưa có bài viết nào.
                </div>
            @endforelse
        </div>

        <div class="card-footer text-center">
            <a href="{{ route('posts.index') }}">Xem tất cả bài viết &rarr;</a>
        </div>
    </div>

</div>
@endsection
>>>>>>> origin/main
