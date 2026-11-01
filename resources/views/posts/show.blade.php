@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div style="margin-bottom: 16px;">
        <a href="{{ route('posts.index') }}" class="btn btn-outline">← Quay lại danh sách bài viết</a>
    </div>

    <article class="card">
        <div class="post-detail-header">
            <h1 class="page-title">{{ $post->title }}</h1>
            <div class="post-meta">
                <span>Tác giả: <strong>{{ $post->user->name ?? 'Ẩn danh' }}</strong></span>
                <span>•</span>
                <span>Chuyên mục: <strong>{{ $post->category->name ?? 'Chưa phân loại' }}</strong></span>
                <span>•</span>
                <span>Đăng lúc {{ $post->created_at?->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <div class="post-detail-content">{!! nl2br(e($post->content)) !!}</div>

        @auth
            @can('update', $post)
                <div class="post-actions">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline">Chỉnh sửa bài viết</a>

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
        <div class="card-header" style="margin-bottom: 14px;">
            <div>
                <h2 class="section-title">Bình luận ({{ $post->comments->count() }})</h2>
                <p class="section-subtitle">Trao đổi lịch sự, rõ ràng và đúng tinh thần giữ bình tĩnh.</p>
            </div>
        </div>

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
                    >{{ old('parent_id') ? '' : old('content') }}</textarea>
                    @if (!old('parent_id'))
                        @error('content')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Đăng bình luận</button>
            </form>
        @else
            <div class="empty-state" style="padding: 18px; margin-bottom: 20px;">
                Vui lòng <a href="{{ route('login') }}" style="color: #1a73e8; font-weight: 600;">đăng nhập</a> để tham gia bình luận.
            </div>
        @endauth

        @php
            $rootComments = $post->comments->whereNull('parent_id');
        @endphp

        @if ($rootComments->isEmpty())
            <div class="empty-state">
                Chưa có bình luận nào cho bài viết này.
            </div>
        @else
            <div class="comment-list">
                @foreach ($rootComments as $comment)
                    @include('posts.partials.comment', ['comment' => $comment, 'comments' => $post->comments, 'post' => $post])
                @endforeach
            </div>
        @endif
    </section>

    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            if (form) {
                form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
            }
        }

        function toggleEditForm(commentId) {
            const contentDiv = document.getElementById('comment-content-' + commentId);
            const editForm = document.getElementById('edit-form-' + commentId);
            const actionsDiv = document.getElementById('comment-actions-' + commentId);

            if (editForm.style.display === 'none' || editForm.style.display === '') {
                editForm.style.display = 'block';
                contentDiv.style.display = 'none';
                if (actionsDiv) actionsDiv.style.display = 'none';
            } else {
                editForm.style.display = 'none';
                contentDiv.style.display = 'block';
                if (actionsDiv) actionsDiv.style.display = 'flex';
            }
        }
    </script>
@endsection