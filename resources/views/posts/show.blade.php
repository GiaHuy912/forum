@extends('layouts.app')
@section('title', $post->title)

@section('content')
<article class="bg-white border p-4 mb-4">
    <h3>{{ $post->title }}</h3>
    <p class="text-muted small">
        Đăng bởi <strong>{{ $post->user->name }}</strong>
        &middot; {{ $post->created_at->format('d/m/Y H:i') }}
        @if($post->updated_at->gt($post->created_at))
            &middot; (đã sửa {{ $post->updated_at->diffForHumans() }})
        @endif
    </p>
    <hr>
    <div style="white-space: pre-line">{{ $post->content }}</div>

    @auth
        @if(auth()->id() === $post->user_id || auth()->user()->isAdmin())
            <hr>
            <div class="d-flex gap-2">
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Sửa</a>
                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                      onsubmit="return confirm('Bạn chắc chắn muốn xóa bài viết này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </div>
        @endif
    @endauth
</article>

<h5>Bình luận ({{ $post->comments->count() }})</h5>
{{-- Người làm Bình luận: thay đoạn dưới bằng form + nút sửa/xóa comment --}}
@forelse($post->comments as $comment)
    <div class="bg-white border p-3 mb-2">
        <strong>{{ $comment->user->name }}</strong>
        <small class="text-muted">&middot; {{ $comment->created_at->diffForHumans() }}</small>
        <div style="white-space: pre-line">{{ $comment->content }}</div>
    </div>
@empty
    <p class="text-muted">Chưa có bình luận nào.</p>
@endforelse

<a href="{{ route('posts.index') }}" class="btn btn-link mt-2">&larr; Quay lại danh sách</a>
@endsection
