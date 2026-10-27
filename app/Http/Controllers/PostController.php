<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Danh sách bài viết + Tìm kiếm theo tiêu đề + Phân trang 10 bài
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $posts = Post::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Giữ từ khóa tìm kiếm khi bấm chuyển trang

        return view('posts.index', compact('posts', 'search'));
    }

    /**
     * Hiển thị form đăng bài mới
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Lưu bài viết mới vào Database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ], [
            'title.required'   => 'Vui lòng nhập tiêu đề bài viết.',
            'title.max'        => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung bài viết.',
            'content.min'      => 'Nội dung bài viết phải có ít nhất 10 ký tự.',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title'   => $validated['title'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Đăng bài viết thành công!');
    }

    /**
     * Xem chi tiết bài viết, tác giả và danh sách bình luận
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user']);

        return view('posts.show', compact('post'));
    }

    /**
     * Hiển thị form chỉnh sửa bài viết
     */
    public function edit(Post $post)
    {
        $this->authorizeOwnerOrAdmin($post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Cập nhật bài viết
     */
    public function update(Request $request, Post $post)
    {
        $this->authorizeOwnerOrAdmin($post);

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ], [
            'title.required'   => 'Vui lòng nhập tiêu đề bài viết.',
            'title.max'        => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung bài viết.',
            'content.min'      => 'Nội dung bài viết phải có ít nhất 10 ký tự.',
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    /**
     * Xóa bài viết
     */
    public function destroy(Post $post)
    {
        $this->authorizeOwnerOrAdmin($post);

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Đã xóa bài viết thành công!');
    }

    /**
     * Kiểm tra quyền: Chỉ chủ bài viết hoặc Admin mới được sửa/xóa
     * (Tương thích cả trước và sau khi bạn Sơn làm xong PostPolicy)
     */
    private function authorizeOwnerOrAdmin(Post $post): void
    {
        if (Gate::has('update')) {
            Gate::authorize('update', $post);
            return;
        }

        $user = Auth::user();
        $isAdmin = $user && (method_exists($user, 'isAdmin') ? $user->isAdmin() : $user->role === 'admin');

        if (!$user || ($user->id !== $post->user_id && !$isAdmin)) {
            abort(403, 'Bạn không có quyền thực hiện thao tác này.');
        }
    }
}