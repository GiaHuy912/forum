@extends('layouts.app')

@section('content')
    <h1>Quản lý người dùng</h1>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        @if ($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}"
                                  method="POST"
                                  style="display: inline;"
                                  onsubmit="return confirm('Xóa người dùng này? Bài viết và comment của họ cũng bị xóa theo.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Xóa</button>
                            </form>
                        @else
                            (Bạn)
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Chưa có người dùng nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="http://127.0.0.1:8000/admin/posts">Chuyển sang trang quản lý bài viết</a>

    {{ $users->links() }}
@endsection