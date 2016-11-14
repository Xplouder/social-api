<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class DemoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => str_random(5),
            'email' => 'user1@user1.com',
            'password' => Hash::make('user1'),
        ]);

        $user2 = User::create([
            'name' => str_random(5),
            'email' => 'user2@user2.com',
            'password' => Hash::make('user2'),
        ]);

        Post::create([
            'body_text' => str_random(150),
            'public' => 'no',
            'user_id' => $user1->id,
        ]);

        Post::create([
            'body_text' => str_random(150),
            'public' => 'yes',
            'user_id' => $user1->id,
        ]);

        Post::create([
            'body_text' => str_random(150),
            'public' => 'no',
            'user_id' => $user2->id,
        ]);

        Post::create([
            'body_text' => str_random(150),
            'public' => 'yes',
            'user_id' => $user2->id,
        ]);
    }
}