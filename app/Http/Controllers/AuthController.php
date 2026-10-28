<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ---------- ĐĂNG KÝ ----------

    // GET /register: chỉ trả về form
    public function showRegister()
    {
        return view('auth.register');
    }

    // POST /register: nhận dữ liệu form, kiểm tra, tạo user
    public function register(Request $request)
    {
        // validate: nếu sai, Laravel tự quay lại form kèm lỗi ($errors)
        // và giữ lại giá trị cũ (old()). Chỉ khi đúng mới chạy tiếp.
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'], // chưa tồn tại trong bảng users
            'password' => ['required', 'string', 'min:8', 'confirmed'],           // confirmed: cần ô password_confirmation
        ]);

        // Tạo user. Chỉ lấy đúng 3 trường đã validate, KHÔNG lấy role từ form,
        // nên người dùng không thể tự gửi role=admin. Cột role tự mặc định 'user'.
        // Hash::make: băm mật khẩu một chiều, không bao giờ lưu mật khẩu thô.
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Đăng nhập luôn cho user vừa tạo (lưu id user vào session)
        Auth::login($user);

        // Đổi session ID để chống tấn công session fixation
        $request->session()->regenerate();

        // with('success', ...) = flash message: chỉ tồn tại đúng 1 request kế tiếp
        return redirect('/')->with('success', 'Đăng ký thành công');
    }

    // ---------- ĐĂNG NHẬP ----------

    // GET /login: chỉ trả về form
    public function showLogin()
    {
        return view('auth.login');
    }

    // POST /login: kiểm tra email + mật khẩu
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Auth::attempt: tìm user theo email, so mật khẩu với hash trong DB.
        // Tham số thứ 2 (true/false) = "ghi nhớ đăng nhập": nếu true, Laravel
        // sinh remember_token lưu vào bảng users và đặt cookie dài hạn.
        // $request->boolean('remember') đọc checkbox name="remember" ở form.
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate(); // chống session fixation
            return redirect('/')->with('success', 'Đăng nhập thành công');
        }

        // Sai: quay lại form, báo lỗi ở ô email, giữ lại email đã nhập
        // (không giữ mật khẩu, và cố ý không nói rõ sai email hay sai mật khẩu).
        return back()
            ->withErrors(['email' => 'Email hoặc mật khẩu không đúng'])
            ->onlyInput('email');
    }

    // ---------- ĐĂNG XUẤT ----------

    public function logout(Request $request)
    {
        Auth::logout();                          // bỏ trạng thái đăng nhập
        $request->session()->invalidate();       // hủy session cũ
        $request->session()->regenerateToken();  // đổi token CSRF

        return redirect('/')->with('success', 'Đã đăng xuất');
    }
}