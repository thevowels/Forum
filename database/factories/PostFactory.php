<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\en_US\Company;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id'=> User::factory(),
            'topic_id' => Topic::factory(),
            'title' => fake()->catchPhrase,
            'body' => Collection::times(4, fn() => fake()->realText(1000))->join(PHP_EOL.PHP_EOL),
            'likes_count' => 0,
        ];
    }
}
