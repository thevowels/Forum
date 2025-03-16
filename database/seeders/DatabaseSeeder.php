<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(TopicSeeder::class);

        $topics = Topic::all();

        $users =  User::factory(10)
            ->create();

        $posts = Post::factory(150)
            ->recycle([$users, $topics])
            ->has(Comment::factory(5))
            ->create();

        $testuser =  User::factory()
                    ->has(Post::factory(20)->recycle($topics))
                    ->has(Comment::factory(300)->recycle(Post::all()))
                    ->create(
                        [
                            'name' => 'Test User',
                            'email' => 'test@example.com',
                        ]
                    );


    }
}
