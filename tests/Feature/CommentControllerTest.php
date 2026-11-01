<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_authenticated_user_can_reply_to_an_admin_reply(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $post = Post::create([
            'user_id' => $admin->id,
            'title' => 'Bài viết kiểm thử',
            'content' => 'Nội dung bài viết kiểm thử.',
        ]);

        $adminComment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $admin->id,
            'content' => 'Bình luận của admin',
        ]);

        $adminReply = Comment::create([
            'post_id' => $post->id,
            'user_id' => $admin->id,
            'parent_id' => $adminComment->id,
            'content' => 'Phản hồi của admin',
        ]);

        $this->actingAs($user)
            ->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee('reply-form-'.$adminReply->id);

        $this->actingAs($user)
            ->post(route('comments.store', $post), [
                'parent_id' => $adminReply->id,
                'content' => 'Phản hồi lồng bên trong',
            ])
            ->assertRedirect(route('posts.show', $post));

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'parent_id' => $adminReply->id,
            'content' => 'Phản hồi lồng bên trong',
        ]);

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSeeText('Phản hồi lồng bên trong');
    }
}
