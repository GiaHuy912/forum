<div @if ($depth ?? 0) style="padding: 10px 0; border-top: 1px dashed #eee;" @else class="comment-item" @endif>
    <div class="comment-meta" @if ($depth ?? 0) style="font-size: 0.85rem;" @endif>
        <strong>{{ $comment->user->name ?? 'Ẩn danh' }}</strong>
        <span>•</span>
        <span>{{ $comment->created_at?->format('d/m/Y H:i') }}</span>
    </div>

    <div id="comment-content-{{ $comment->id }}" class="comment-content" @if ($depth ?? 0) style="margin-top: 4px;" @endif>{{ $comment->content }}</div>

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

        @php($replyFormIsOpen = (string) old('parent_id') === (string) $comment->id)
        <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.store', $post) }}" method="POST" style="{{ $replyFormIsOpen ? 'display: block;' : 'display: none;' }} margin-top: 12px; padding-left: 16px; border-left: 2px solid #e0e0e0;">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <div class="form-group" style="margin-bottom: 8px;">
                <textarea
                    name="content"
                    rows="2"
                    class="form-control"
                    placeholder="Trả lời {{ $comment->user->name ?? 'bình luận này' }}..."
                    required
                >{{ $replyFormIsOpen ? old('content') : '' }}</textarea>
                @if ($replyFormIsOpen)
                    @error('content')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                @endif
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.85rem;">Gửi trả lời</button>
                <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;">Hủy</button>
            </div>
        </form>
    @endauth

    @php($replies = $comments->where('parent_id', $comment->id))
    @if ($replies->isNotEmpty())
        <div style="margin-left: 24px; margin-top: 12px; padding-left: 14px; border-left: 2px solid #eaeaea;">
            @foreach ($replies as $reply)
                @include('posts.partials.comment', ['comment' => $reply, 'comments' => $comments, 'post' => $post, 'depth' => ($depth ?? 0) + 1])
            @endforeach
        </div>
    @endif
</div>
