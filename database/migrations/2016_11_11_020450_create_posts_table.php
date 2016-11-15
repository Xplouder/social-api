<?php

use Illuminate\Support\Facades\Schema;
use Moloquent\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{

    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Mongo version
        Schema::connection($this->connection)->create('posts', function (Blueprint $collection) {
            $collection->integer('user_id');
            $collection->string('body_text');
            $collection->string('body_image');
            $collection->enum('social', ['yes', 'no'])->default('no');
            $collection->timestamps();
            $collection->softDeletes();
        });

        // MySql version
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

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->drop('posts');
    }
}
