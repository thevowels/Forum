<?php

use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

it('requires authentication', function () {
    get(route('posts.create'))
        ->assertRedirect(route('login'));
});

it('returns the correct component', function () {
    actingAs(User::factory()->create())
    ->get(route('posts.create'))
    ->assertComponent('Posts/Create');
});
