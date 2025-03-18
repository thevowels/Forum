<?php


use Illuminate\Database\Eloquent\Model;


use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\delete;
use function Pest\Laravel\actingAs;


use App\Models\User;
use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;

it('requires authentication ' ,function () {
    delete(route('likes.destroy',['test',1]))
        ->assertRedirect(route('login'));

});

it('allows unliking a likeable', function (Model $likeable) {
    $user = User::factory()->create();

    $like = Like::factory()->for($user)->for($likeable, 'likeable')->create();

    $likeable->increment('likes_count');
    actingAs($user)
        ->fromRoute('dashboard')
        ->delete(route('likes.destroy',[$likeable->getMorphClass(), $likeable->id]))
        ->assertRedirect(route('dashboard'));

    assertDatabaseEmpty(Like::class);

    expect($likeable->refresh()->likes_count)->toBe(0);
})->with([
    fn () => Post::factory()->create(),
    fn () => Comment::factory()->create(),
]);


it('prevents unliking something you havent liked ', function () {
    $likeable = Post::factory()->create();

    actingAs(User::factory()->create())
        ->delete(route('likes.destroy',[$likeable->getMorphClass(), $likeable->id]))
        ->assertForbidden();
});

it('only allows unliking supported Models ', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->delete(route('likes.destroy', [$user->getMorphClass(), $user->id]))
        ->assertForbidden();

});

