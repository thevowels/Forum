<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('can store a new comment', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create();

    actingAs($user)->post(route('posts.comments.store', $post),[
        'body' => 'test comment' ,
    ]);

    $this->assertDatabaseHas(Comment::class, [
        'body' => 'test comment' ,
        'post_id' => $post->id,
        'user_id' => $user->id,
    ]);
});


it('redirct to post show page', function () {
    $post = Post::factory()->create();
    actingAs(User::factory()->create())->post(route('posts.comments.store', $post),[
        'body' => 'test comment' ,
    ])
        ->assertRedirect(route('posts.show', $post));

});
