<?php


use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;


beforeEach(function () {
    $this->validData = [
        'title'=> 'Hello World',
        'body'=> 'New Post Body',
    ];
});

it('need authentication', function () {
    post(route('posts.store'))
        ->assertRedirect(route('login'));
});

it('store post', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), $this->validData);

    $this->assertDatabaseHas(Post::class,[
        ...$this->validData,
        'user_id' => $user->id,
    ]);

});

it('redirects to the post show page', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), $this->validData)
        ->assertRedirect(route('posts.show', Post::latest('id')->first() ));

});


it('requires a valid title', function ($badTitle) {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), [...$this->validData, 'title'=> $badTitle ])
        ->assertInvalid('title');
})->with([
    null,
    1,
    1.5,
    true,
    str_repeat('a',121)
]);
it('requires a valid body', function ($badBody) {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), [...$this->validData, 'body'=> $badBody ])
        ->assertInvalid('body');
})->with([
    null,
    1,
    1.5,
    true,
    str_repeat('a',2000)
]);
