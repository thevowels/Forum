<?php

use function Pest\Laravel\get;

use App\Models\Topic;
use App\Models\Post;

use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;


it('can filter  a topic ' , function () {
    $general = Topic::factory()->create();

    $posts = Post::factory(2)->for($general)->create();

    $otherPosts = Post::factory(3)->create();

    get(route('posts.index',['topic' => $general]))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));

});

it('passes the selected topic to a view', function () {
    $topic = Topic::factory()->create();

    get(route('posts.index',['topic' => $topic]))
        ->assertHasResource('selectedTopic', TopicResource::make($topic));
});


it('passes topics to the view' ,function () {
    $topics = Topic::factory(3)->create();
    get(route('posts.index'))
        ->assertHasResource('topics', TopicResource::collection($topics));
});
