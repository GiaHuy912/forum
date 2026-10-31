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
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
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
                    <div class="comment-item">
                        <div class="comment-meta">
                            <strong>{{ $comment->user->name ?? 'Ẩn danh' }}</strong>
                            <span>•</span>
                            <span>{{ $comment->created_at?->format('d/m/Y H:i') }}</span>
                        </div>

                        <div id="comment-content-{{ $comment->id }}" class="comment-content">{{ $comment->content }}</div>

                        @auth
                            @can('update', $comment)
                                <form id="edit-form-{{ $comment->id }}" action="{{ route('comments.update', $comment) }}" method="POST" style="display: none; margin-top: 8px; margin-bottom: 8px;">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group" style="margin-bottom: 8px;">
                                        <textarea name="content" rows="2" class="form-control" required>{{ $comment->content }}</textarea>
                                    </div>
                                    <div style="display: flex; gap: 8px;">
                                        <button type="submit" class="btn btn-primary" style="padding: 5px 12px; font-size: 0.85rem;">Lưu lại</button>
                                        <button type="button" onclick="toggleEditForm({{ $comment->id }})" class="btn btn-outline" style="padding: 5px 12px; font-size: 0.85rem;">Hủy</button>
                                    </div>
                                </form>
                            @endcan
                        @endauth

                        @auth
                            <div id="comment-actions-{{ $comment->id }}" class="comment-actions" style="margin-top: 8px; display: flex; gap: 12px; align-items: center;">
                                <button type="button" onclick="toggleReplyForm({{ $comment->id }})" style="background: none; border: none; color: #1a73e8; cursor: pointer; padding: 0; font-size: 0.85rem; font-weight: 500;">
                                    Trả lời
                                </button>

                                @can('update', $comment)
                                    <button type="button" onclick="toggleEditForm({{ $comment->id }})" style="background: none; border: none; color: #1a73e8; cursor: pointer; padding: 0; font-size: 0.85rem;">
                                        Sửa
                                    </button>

                                    @can('delete', $comment)
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Xóa bình luận này?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #d93025; cursor: pointer; padding: 0; font-size: 0.85rem;">Xóa</button>
                                        </form>
                                    @endcan
                                @endcan
                            </div>

                            <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.store', $post) }}" method="POST" style="display: none; margin-top: 12px; padding-left: 16px; border-left: 2px solid #e0e0e0;">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <textarea
                                        name="content"
                                        rows="2"
                                        class="form-control"
                                        placeholder="Trả lời {{ $comment->user->name ?? 'bình luận này' }}..."
                                        required
                                    ></textarea>
                                </div>
                                <div style="display: flex; gap: 8px;">
                                    <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.85rem;">Gửi trả lời</button>
                                    <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;">Hủy</button>
                                </div>
                            </form>
                        @endauth

                        @php
                            $replies = $post->comments->where('parent_id', $comment->id);
                        @endphp

                        @if ($replies->isNotEmpty())
                            <div style="margin-left: 24px; margin-top: 12px; padding-left: 14px; border-left: 2px solid #eaeaea;">
                                @foreach ($replies as $reply)
                                    <div style="padding: 10px 0; border-top: 1px dashed #eee;">
                                        <div class="comment-meta" style="font-size: 0.85rem;">
                                            <strong>{{ $reply->user->name ?? 'Ẩn danh' }}</strong>
                                            <span>•</span>
                                            <span>{{ $reply->created_at?->format('d/m/Y H:i') }}</span>
                                        </div>

                                        <div id="comment-content-{{ $reply->id }}" class="comment-content" style="margin-top: 4px;">{{ $reply->content }}</div>

                                        @auth
                                            @can('update', $reply)
                                                <form id="edit-form-{{ $reply->id }}" action="{{ route('comments.update', $reply) }}" method="POST" style="display: none; margin-top: 6px; margin-bottom: 6px;">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group" style="margin-bottom: 6px;">
                                                        <textarea name="content" rows="2" class="form-control" required>{{ $reply->content }}</textarea>
                                                    </div>
                                                    <div style="display: flex; gap: 8px;">
                                                        <button type="submit" class="btn btn-primary" style="padding: 4px 10px; font-size: 0.82rem;">Lưu lại</button>
                                                        <button type="button" onclick="toggleEditForm({{ $reply->id }})" class="btn btn-outline" style="padding: 4px 10px; font-size: 0.82rem;">Hủy</button>
                                                    </div>
                                                </form>

                                                <div id="comment-actions-{{ $reply->id }}" class="comment-actions" style="margin-top: 6px; display: flex; gap: 10px;">
                                                    <button type="button" onclick="toggleEditForm({{ $reply->id }})" style="background: none; border: none; color: #1a73e8; cursor: pointer; padding: 0; font-size: 0.82rem;">
                                                        Sửa
                                                    </button>

                                                    @can('delete', $reply)
                                                        <form action="{{ route('comments.destroy', $reply) }}" method="POST" onsubmit="return confirm('Xóa phản hồi này?');" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" style="background: none; border: none; color: #d93025; cursor: pointer; padding: 0; font-size: 0.82rem;">Xóa</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            @endcan
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
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