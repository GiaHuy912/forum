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