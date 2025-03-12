<?php

use function Pest\Laravel\put;
use function Pest\Laravel\actingAs;

use App\Models\Comment;

it('requires authentication', function (): void {
    put(route('comments.update', Comment::factory()->create()))
        ->assertRedirect(route('login'));
});

it('can update a comment' , function (): void {
    $comment = Comment::factory()->create(['body'=> 'This is old comment']);
    $newBody = 'This is new comment';
    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['body' => $newBody]);
    $this->assertDatabaseHas('comments', [
        'id' => $comment->id,
        'body' => $newBody]);
});

it('redirects to post show page ', function (): void {

    $comment = Comment::factory()->create(['body'=> 'This is old comment']);
    $newBody = 'This is new comment';
    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['body' => $newBody])
        ->assertRedirect(route('posts.show', $comment->post));
});
