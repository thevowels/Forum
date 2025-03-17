<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(['email' => 'test'.Str::uuid().'@example.com' ]),
            'likeable_type' => fn ($values) => $this->likeableType($values ),
            'likeable_id' => Post::factory(),
        ];
    }

    protected function likeableType(array $values)
    {
        $type = $values['likeable_id'];

        $modelName = $type instanceof Factory
                ? $type->modelName()
                : $type::class;

        return ( new $modelName)->getMorphClass();
    }
}
