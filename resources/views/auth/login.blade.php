<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>

    {{-- Thông báo flash (ví dụ "Đã đăng xuất") --}}
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        {{-- @csrf: token ẩn chống giả mạo request. Thiếu là lỗi 419. --}}
        @csrf

        <div>
            <label for="email">Email</label><br>
            {{-- old('email'): giữ lại email đã nhập khi đăng nhập sai --}}
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            {{-- @error: hiện lỗi validate của đúng ô này --}}
            @error('email') <div style="color:red">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="password">Mật khẩu</label><br>
            <input type="password" id="password" name="password">
            @error('password') <div style="color:red">{{ $message }}</div> @enderror
        </div>

        <div>
            {{-- name="remember" khớp với $request->boolean('remember') ở controller --}}
            <label><input type="checkbox" name="remember"> Ghi nhớ đăng nhập</label>
        </div>

        <button type="submit">Đăng nhập</button>
    </form>

    <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
</body>
</html>