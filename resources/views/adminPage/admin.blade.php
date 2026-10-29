@extends('layouts.app')

@section('content')
    <h1>Quản lý bài viết</h1>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Nội dung</th>
                <th>Tác giả</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($post->content, 80) }}</td>
                    <td>{{ $post->user->name ?? 'Không tồn tại' }}</td>
                    <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post) }}">Xem</a>

                        <form action="{{ route('admin.posts.destroy', $post) }}"
                              method="POST"
                              style="display: inline;"
                              onsubmit="return confirm('Xóa bài này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Chưa có bài viết nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="/admin/users">Chuyển sang trang quản lý người dùng</a>

    {{ $posts->links() }}
@endsection