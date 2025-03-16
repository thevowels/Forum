<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'slug' => 'general',
                'name' => 'General',
                'description' => 'General',
            ],
            [
                'slug' => 'social',
                'name' => 'Social',
                'description' => 'Social',
            ],
            [
                'slug' => 'social-media',
                'name' => 'Social Media',
                'description' => 'Social Media',
            ],
            [
                'slug' => 'reviews',
                'name' => 'Reviews',
                'description' => 'Reviews',
            ]

        ];

        Topic::upsert($data, ['slug']);

    }
}
