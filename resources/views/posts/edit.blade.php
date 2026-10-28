@extends('layouts.app')
@section('title', 'Sửa bài viết')

@section('content')
<h3 class="mb-3">Sửa bài viết</h3>
<form method="POST" action="{{ route('posts.update', $post) }}">
    @method('PUT')
    @include('posts._form', ['submit' => 'Cập nhật'])
</form>
@endsection
