<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'body_text' => str_random(150),
            'public' => 'no',
            'user_id' => 1,
        ]);

        Post::create([
            'body_text' => str_random(150),
            'public' => 'no',
            'user_id' => 2,
        ]);
    }
}