@extends('layouts.app')

@section('title', 'Chỉnh sửa bình luận')

@section('content')
    <div style="margin-bottom: 16px;">
        <a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-outline">← Quay lại bài viết</a>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <h1 class="page-title">Chỉnh sửa bình luận</h1>
                <p class="page-subtitle">
                    Trong bài viết: <strong>{{ $comment->post->title ?? '' }}</strong>
                </p>
            </div>
        </div>

        <form action="{{ route('comments.update', $comment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="content" class="form-label">Nội dung bình luận</label>
                <textarea
                    id="content"
                    name="content"
                    rows="5"
                    class="form-control @error('content') is-invalid @enderror"
                >{{ old('content', $comment->content) }}</textarea>
                @error('content')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 10px; align-items: center;">
                <button type="submit" class="btn btn-primary">Cập nhật bình luận</button>
                <a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-outline">Hủy</a>
            </div>
        </form>
    </div>
@endsection