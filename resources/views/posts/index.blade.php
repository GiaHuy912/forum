@extends('layouts.app')
@section('title', 'Danh sách bài viết')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h3 class="mb-0">Bài viết</h3>
    @auth
        <a href="{{ route('posts.create') }}" class="btn btn-primary">+ Đăng bài</a>
    @endauth
</div>

<form method="GET" action="{{ route('posts.index') }}" class="input-group mb-3">
    <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Tìm theo tiêu đề...">
    <button class="btn btn-outline-primary" type="submit">Tìm</button>
    @if($search !== '')
        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
    @endif
    @if(request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
    @endif
</form>

@if($search !== '')
    <p class="text-muted">Kết quả cho "<strong>{{ $search }}</strong>": {{ $posts->total() }} bài</p>
@endif

<div class="list-group mb-3">
    @forelse($posts as $post)
        <a href="{{ route('posts.show', $post) }}" class="list-group-item list-group-item-action">
            <div class="d-flex justify-content-between">
                <h6 class="mb-1">{{ $post->title }}</h6>
                <small class="text-muted">{{ $post->comments_count }} bình luận</small>
            </div>
            <small class="text-muted">{{ $post->user->name }} &middot; {{ $post->created_at->diffForHumans() }}</small>
        </a>
    @empty
        <div class="list-group-item text-muted">Không có bài viết nào.</div>
    @endforelse
</div>

{{ $posts->links() }}
@endsection
