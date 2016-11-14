<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        $this->call(UsersSeed::class);
//        $this->call(PostsSeed::class);

        $this->call(DemoSeed::class);

        Model::reguard();
    }
}
