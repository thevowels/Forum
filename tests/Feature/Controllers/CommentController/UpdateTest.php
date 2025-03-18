<?php

use function Pest\Laravel\put;
use function Pest\Laravel\actingAs;

use App\Models\Comment;
use App\Models\User;

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
        ->assertRedirect($comment->post->showRoute());
});

it('redirects to post with correct comment pagination', function (): void {
    $comment = Comment::factory()->create(['body'=> 'This is old comment']);
    $newBody = 'This is new comment';
    actingAs($comment->user)
        ->put(route('comments.update', ['comment' => $comment, 'page'=>2]), ['body' => $newBody])
        ->assertRedirect($comment->post->showRoute() . http_build_query(['page' => 2]));

});

it('cannot update comment from another user' , function (): void {
    $comment = Comment::factory()->create(['body'=> 'This is old comment']);
    $newBody = 'This is new comment';
    actingAs(User::factory()->create())
        ->put(route('comments.update', $comment), ['body' => $newBody])
        ->assertForbidden();
});

it('requires valid body' , function ($newBody): void {
    $comment = Comment::factory()->create(['body'=> 'This is old comment']);
    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['body' => $newBody])
        ->assertInvalid('body');

})->with([
    null,
    true,
    1,
    1.5,
    str_repeat('a', 2501),

]);
