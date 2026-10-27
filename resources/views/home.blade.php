@extends('layouts.app')
@section('title', 'Trang chủ')

@section('content')

    <!-- Phần nổi bật: 2 bài nhiều bình luận nhất -->
    @if($featured->count())
    <div class="row g-0 border mb-4">
        @foreach($featured as $post)
            <div class="col-md-6 {{ $loop->first ? 'border-end' : '' }}">
                <div class="featured-box d-flex">
                    <div class="featured-avatar me-3 bg-primary text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0">
                        {{ mb_strtoupper(mb_substr($post->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="mb-1">
                            <a href="{{ route('posts.show', $post) }}" class="{{ $loop->first ? 'text-danger' : 'text-primary' }} text-decoration-none">
                                {{ \Illuminate\Support\Str::limit($post->title, 60) }}
                            </a>
                        </h6>
                        <div class="text-muted" style="font-size: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;">
                            {{ \Illuminate\Support\Str::limit($post->content, 80) }}
                        </div>
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">
                            {{ $post->user->name }} &middot; {{ $post->created_at->diffForHumans() }} &middot; Trả lời: {{ $post->comments_count }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    <!-- Danh sách bài viết -->
    <div class="thread-container">
        <div class="thread-header d-flex justify-content-between align-items-center">
            <span>Mới ra lò</span>
            <form method="GET" action="{{ route('posts.index') }}" class="d-flex" style="gap:6px">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm theo tiêu đề...">
                <button class="btn btn-sm btn-primary" type="submit">Tìm</button>
            </form>
        </div>

        @forelse($posts as $post)
            <div class="thread-item">
                <div class="thread-avatar me-3 bg-secondary text-white d-flex align-items-center justify-content-center flex-shrink-0">
                    {{ mb_strtoupper(mb_substr($post->user->name, 0, 1)) }}
                </div>
                <div class="flex-grow-1">
                    <div>
                        <a href="{{ route('posts.show', $post) }}" class="thread-title">{{ $post->title }}</a>
                    </div>
                    <div class="thread-meta">
                        {{ $post->user->name }} &middot; {{ $post->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="thread-stats px-3">
                    <div>Trả lời: <span class="fw-bold">{{ $post->comments_count }}</span></div>
                </div>
            </div>
        @empty
            <div class="thread-item text-muted">Chưa có bài viết nào.</div>
        @endforelse

        <div class="p-3 text-center">
            <a href="{{ route('posts.index') }}">Xem tất cả bài viết &rarr;</a>
        </div>
    </div>
@endsection