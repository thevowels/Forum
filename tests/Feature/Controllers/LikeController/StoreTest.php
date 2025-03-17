<?php


use function Pest\Laravel\post;

it('requires authentication ' ,function () {
    post(route('likes.store'))
        ->assertRedirect(route('login'));
});
