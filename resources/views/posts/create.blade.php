@extends('layouts.app')
@section('title', 'Đăng bài mới')

@section('content')
<h3 class="mb-3">Đăng bài mới</h3>
<form method="POST" action="{{ route('posts.store') }}">
    @include('posts._form', ['submit' => 'Đăng bài'])
</form>
@endsection
