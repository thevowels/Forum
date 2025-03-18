<?php

use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;
use App\Models\Comment;

it('requires authentication', function (): void {
    delete(route('comments.destroy', Comment::factory()->create()))
        ->assertRedirect(route('login'));
});

it('can delete a comment', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)->delete(route('comments.destroy', $comment));

    $this->assertModelMissing($comment);
});

it('redirect to the post show page', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertRedirect($comment->post->showRoute());

});

it('prevents deleting comment that is not yours', function () {
    $comment = Comment::factory()->create();

    actingAs(User::factory()->create())
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();

});
it('prevents deleting comment that is longer than 1 hour old', function () {
    $this->freezeTime();
    $comment = Comment::factory()->create();
    $this->travel(2)->hour();
    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();

});
