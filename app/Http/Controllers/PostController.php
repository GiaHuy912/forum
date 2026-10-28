<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    private const MESSAGES = [
        'title.required'   => 'Vui lòng nhập tiêu đề bài viết.',
        'title.max'        => 'Tiêu đề không được vượt quá 255 ký tự.',
        'content.required' => 'Vui lòng nhập nội dung bài viết.',
        'content.min'      => 'Nội dung bài viết phải có ít nhất 10 ký tự.',
        'content.max'      => 'Nội dung không được vượt quá 10000 ký tự.',
    ];

    private const RULES = [
        'title'   => 'required|string|max:255',
        'content' => 'required|string|min:10|max:10000',
    ];

    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $posts = Post::with('user')
            ->withCount('comments')
            ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', compact('posts', 'search'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::RULES, self::MESSAGES);

        $post = Post::create($validated + ['user_id' => Auth::id()]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Đăng bài viết thành công!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user']);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorizePost('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorizePost('update', $post);

        $post->update($request->validate(self::RULES, self::MESSAGES));

        return redirect()->route('posts.show', $post)
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy(Post $post)
    {
        $this->authorizePost('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Đã xóa bài viết thành công!');
    }

    /**
     * Có PostPolicy (Sơn làm) thì dùng Gate::authorize, chưa có thì tạm so sánh user_id / admin.
     * Lưu ý: Gate::has() chỉ nhận ability đăng ký bằng Gate::define, KHÔNG nhận Policy,
     * nên dùng Gate::getPolicyFor() để kiểm tra.
     */
    private function authorizePost(string $ability, Post $post): void
    {
        if (Gate::getPolicyFor($post)) {
            Gate::authorize($ability, $post);
            return;
        }

        $user = Auth::user();
        if (! $user || ($user->id !== $post->user_id && ! $user->isAdmin())) {
            abort(403, 'Bạn không có quyền thực hiện thao tác này.');
        }
    }
}