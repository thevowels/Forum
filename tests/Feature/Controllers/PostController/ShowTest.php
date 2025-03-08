<?php

use App\Models\Post;
use Inertia\Inertia;
use Inertia\Testing\AssertableInertia;

it('can show a post', function () {
    $post = Post::factory()->create();

    get(route('post.show', $post))
        ->assertComponent('Posts/Show');
});
