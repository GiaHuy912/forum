
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

