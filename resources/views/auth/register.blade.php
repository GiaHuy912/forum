@extends('layouts.app')

@section('title', 'Đăng ký tài khoản')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h1 class="h4 mb-4 text-center fw-bold">Đăng ký tài khoản</h1>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên hiển thị</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                </form>

                <div class="text-center mt-3">
                    <span class="text-muted">Đã có tài khoản?</span>
                    <a href="{{ route('login') }}" class="text-decoration-none">Đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection