<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // Ai cũng được xem danh sách và xem chi tiết bài
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Post $post): bool
    {
        return true;
    }

    // Chỉ cần đăng nhập là được đăng bài
    public function create(User $user): bool
    {
        return true;
    }

    // Sửa: chủ bài hoặc admin
    public function update(User $user, Post $post): bool
    {
        // Bước 1: admin thì cho qua
        if ($user->isAdmin()) {
            return true;
        }

        // Bước 2: chủ bài thì cho qua 
        if ((int) $user->id === (int) $post->user_id) {
            return true;
        }

        // Bước 3: còn lại thì chặn
        return false;
    }

    // Xóa:
    public function delete(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ((int) $user->id === (int) $post->user_id) {
            return true;
        }

        return false;
    }
}