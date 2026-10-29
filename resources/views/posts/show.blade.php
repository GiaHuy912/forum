@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div style="margin-bottom: 16px;">
        <a href="{{ route('posts.index') }}" class="btn btn-outline">← Quay lại danh sách bài viết</a>
    </div>

    <article class="card">
        <div class="post-detail-header">
            <div class="post-meta">
                <span>Tác giả: <strong>{{ $post->user->name ?? 'Ẩn danh' }}</strong></span>
                <span>•</span>
                <span>Chuyên mục: <strong>{{ $post->category->name ?? 'Chưa phân loại' }}</strong></span>
                <span>•</span>
                <span>Đăng lúc {{ $post->created_at?->format('d/m/Y H:i') }}</span>
                @if ($post->updated_at && $post->updated_at->ne($post->created_at))
                    <span>•</span>
                    <span>Cập nhật {{ $post->updated_at->format('d/m/Y H:i') }}</span>
                @endif
            </div>

            <h1 class="page-title" style="margin-top: 10px;">{{ $post->title }}</h1>
        </div>

        <div class="post-detail-content">{{ $post->content }}</div>

        @auth
            @can('update', $post)
                <div class="post-actions" style="margin-top: 22px;">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline">Sửa bài viết</a>

                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa bài viết</button>
                        </form>
                    @endcan
                </div>
            @endcan
        @endauth
    </article>

    <section class="card">
        <div class="card-header">
            <div>
                <h2 class="section-title">Bình luận ({{ $post->comments->count() }})</h2>
                <p class="section-subtitle">Trao đổi lịch sự, rõ ràng và đúng tinh thần giữ bình tĩnh.</p>
            </div>
        </div>

        {{-- Form đăng bình luận (chỉ hiện khi đã đăng nhập) --}}
        @auth
            <form action="{{ route('comments.store', $post) }}" method="POST" style="margin-bottom: 24px;">
                @csrf
                <div class="form-group">
                    <label for="content" class="form-label">Viết bình luận của bạn</label>
                    <textarea
                        id="content"
                        name="content"
                        rows="3"
                        class="form-control @error('content') is-invalid @enderror"
                        placeholder="Chia sẻ góc nhìn của bạn một cách bình tĩnh..."
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Đăng bình luận</button>
            </form>
        @else
            <div class="empty-state" style="margin-bottom: 20px; padding: 16px;">
                Vui lòng <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600;">đăng nhập</a> để tham gia bình luận.
            </div>
        @endauth

        {{-- Danh sách bình luận --}}
        @if ($post->comments->isEmpty())
            <div class="empty-state">
                Chưa có bình luận nào cho bài viết này.
            </div>
        @else
            <div class="comment-list">
                @foreach ($post->comments as $comment)
                    <div class="comment-item">
                        <div class="comment-meta">
                            <strong>{{ $comment->user->name ?? 'Ẩn danh' }}</strong>
                            <span>•</span>
                            <span>{{ $comment->created_at?->format('d/m/Y H:i') }}</span>
                            @if ($comment->updated_at && $comment->updated_at->ne($comment->created_at))
                                <span>•</span>
                                <span>Đã chỉnh sửa</span>
                            @endif
                        </div>

                        <div class="comment-content">{{ $comment->content }}</div>

                        @auth
                            @can('update', $comment)
                                <div class="comment-actions">
                                    <a href="{{ route('comments.edit', $comment) }}" class="btn btn-outline" style="padding: 5px 12px; font-size: 0.84rem;">Sửa</a>

                                    @can('delete', $comment)
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="padding: 5px 12px; font-size: 0.84rem;">Xóa</button>
                                        </form>
                                    @endcan
                                </div>
                            @endcan
                        @endauth
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection