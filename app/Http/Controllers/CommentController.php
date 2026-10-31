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
            'content' => ['required', 'string', 'min:2', 'max:2000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ], [
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.min' => 'Bình luận phải có ít nhất :min ký tự.',
            'content.max' => 'Bình luận không được vượt quá :max ký tự.',
        ]);

        if (!empty($validated['parent_id'])) {
            $parentComment = Comment::find($validated['parent_id']);
            if (!$parentComment || $parentComment->post_id !== $post->id) {
                abort(403, 'Bình luận gốc không hợp lệ.');
            }
        }

        $post->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Đã đăng bình luận thành công!');
    }

    public function edit(Comment $comment)
    {
        Gate::authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $validated = $request->validate([
            'content' => ['required', 'string', 'min:2', 'max:2000'],
        ], [
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.min' => 'Bình luận phải có ít nhất :min ký tự.',
            'content.max' => 'Bình luận không được vượt quá :max ký tự.',
        ]);

        $comment->update($validated);

        return redirect()
            ->route('posts.show', $comment->post_id)
            ->with('success', 'Đã cập nhật bình luận!');
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $postId = $comment->post_id;
        $comment->delete();

        return redirect()
            ->route('posts.show', $postId)
            ->with('success', 'Đã xóa bình luận.');
    }
}