<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
<<<<<<< HEAD
=======
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
>>>>>>> origin/main
</head>
<body>
    <h2>Đăng ký</h2>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div>
            <label for="name">Họ tên</label><br>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name') <div style="color:red">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email') <div style="color:red">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="password">Mật khẩu (tối thiểu 8 ký tự)</label><br>
            <input type="password" id="password" name="password">
            @error('password') <div style="color:red">{{ $message }}</div> @enderror
        </div>

        <div>
            {{-- Tên BẮT BUỘC là password_confirmation để rule 'confirmed' hoạt động --}}
            <label for="password_confirmation">Nhập lại mật khẩu</label><br>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit">Đăng ký</button>
    </form>

    <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
</body>
</html>