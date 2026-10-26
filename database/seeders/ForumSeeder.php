<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@forum.test',
            'password' => '12345678',
            'role' => 'admin',
        ]);

        $user1 = User::create([
            'name' => 'Nguyen Van A',
            'email' => 'user1@forum.test',
            'password' => '12345678',
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Tran Thi B',
            'email' => 'user2@forum.test',
            'password' => '12345678',
            'role' => 'user',
        ]);

        $user3 = User::create([
            'name' => 'Le Van C',
            'email' => 'user3@forum.test',
            'password' => '12345678',
            'role' => 'user',
        ]);

        $post1 = Post::create([
            'user_id' => $user1->id,
            'title' => 'Chào mừng đến với Forum',
            'content' => 'Đây là bài viết đầu tiên trên diễn đàn.',
        ]);

        $post2 = Post::create([
            'user_id' => $user2->id,
            'title' => 'Laravel có gì thú vị?',
            'content' => 'Laravel là một framework PHP mạnh mẽ và dễ sử dụng.',
        ]);

        $post3 = Post::create([
            'user_id' => $user3->id,
            'title' => 'Kinh nghiệm học Laravel',
            'content' => 'Hãy bắt đầu với Route, Controller, Model và Migration.',
        ]);

        Comment::create([
            'post_id' => $post1->id,
            'user_id' => $user2->id,
            'content' => 'Chào mọi người!',
        ]);

        Comment::create([
            'post_id' => $post1->id,
            'user_id' => $user3->id,
            'content' => 'Rất vui được tham gia diễn đàn.',
        ]);

        Comment::create([
            'post_id' => $post2->id,
            'user_id' => $user1->id,
            'content' => 'Laravel khá dễ tiếp cận.',
        ]);

        Comment::create([
            'post_id' => $post3->id,
            'user_id' => $admin->id,
            'content' => 'Chúc mọi người học tốt!',
        ]);
    }
}