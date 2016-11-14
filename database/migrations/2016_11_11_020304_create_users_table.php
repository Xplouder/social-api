<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('users', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name', 100);
//            $table->string('email', 60)->unique();
//            $table->string('password', 64)->nullable();
//            $table->enum('social', ['yes', 'no'])->default('no');
//            $table->timestamps();
//            $table->softDeletes();
//        });

        Schema::create('users', function($collection)
        {
//            $collection->increments('id');
//            $collection->index('id');
            $collection->string('name');
            $collection->unique('email');
            $collection->string('password');
            $collection->enum('social', ['yes', 'no'])->default('no');
            $collection->timestamps();
            $collection->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
