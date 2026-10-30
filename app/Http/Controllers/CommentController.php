<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ], [
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Đã đăng bình luận thành công.');
    }

    public function edit(Comment $comment)
    {
        Gate::authorize('update', $comment);

        $comment->load('post');

        return view('comments.edit', compact('comment'));
    }


    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ], [
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
        ]);

        $comment->update($validated);

        return redirect()
            ->route('posts.show', $comment->post_id)
            ->with('success', 'Đã cập nhật bình luận thành công.');
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $postId = $comment->post_id;
        $comment->delete();

        return redirect()
            ->route('posts.show', $postId)
            ->with('success', 'Đã xóa bình luận thành công.');
    }
}