<?php

use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Topic;

use App\Http\Resources\TopicResource;

it('requires authentication', function () {
    get(route('posts.create'))
        ->assertRedirect(route('login'));
});

it('returns the correct component', function () {
    actingAs(User::factory()->create())
    ->get(route('posts.create'))
    ->assertComponent('Posts/Create');
});

it('passes topics to the view', function () {
    $topics = Topic::factory(3)->create();
    actingAs(User::factory()->create())
        ->get(route('posts.create'))
        ->assertHasResource('topics', TopicResource::collection($topics));
});
