<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->paginate(10);

        return view('adminPage.user', compact('users'));
    }
     public function destroy(User $user)
    {
        if ((int) $user->id === (int) Auth::id()) {
            return redirect()->to('/admin/users')
                ->with('error', 'Bạn không thể xóa chính mình.');
        }

        $user->delete();

        return redirect()->to('/admin/users')
            ->with('success', 'Đã xóa người dùng.');
    }
}
