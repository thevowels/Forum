<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;

it('can show a post', function () {
    $post = Post::factory()->create();

    get($post->showRoute())
        ->assertInertia(fn (AssertableInertia $page) =>
        $page->component('Posts/Show')
            ->has('post')
        );
});


it('passes a post to the view' , function(){
    $post = Post::factory()->create();
    $post->load('user', 'topic');

    get($post->showRoute())
        ->assertHasResource('post', PostResource::make($post));
});

//it('passes comments to the view' , function(){
//    $post = Post::factory()->create();
//    $comments = Comment::factory(3)
//        ->for($post)
//        ->create();
//    dd(CommentResource::collection($comments->with('user')));
//
//
//
//    get($post->showRoute())
//        ->assertHasPaginatedResource('comments', CommentResource::collection($comments));
//});
