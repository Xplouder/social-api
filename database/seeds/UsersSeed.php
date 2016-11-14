<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => str_random(5),
            'email' => 'user1@user1.com',
            'password' => Hash::make('user1'),
        ]);

        User::create([
            'name' => str_random(5),
            'email' => 'user2@user2.com',
            'password' => Hash::make('user2'),
        ]);
    }
}