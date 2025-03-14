<?php

use App\Models\Post;

it('uses title case for titles',function() {
    $post = Post::factory()->create(['title'=>'Hello How are you?']);

    expect($post->title)->toBe('Hello How Are You?');
} );
