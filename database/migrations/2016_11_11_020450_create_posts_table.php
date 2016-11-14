<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('posts', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->longText('body_text')->nullable();
//            $table->text('body_image')->nullable();
//            $table->enum('public', ['yes', 'no']);
//            $table->timestamps();
//            $table->softDeletes();
//        });
        Schema::create('posts', function($collection)
        {
//            $collection->increments('id');
//            $collection->index('id');
            $collection->integer('user_id');
//            $collection->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $collection->index('user_id');

            $collection->string('body_text');
            $collection->string('body_image');
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
        Schema::drop('posts');
    }
}
