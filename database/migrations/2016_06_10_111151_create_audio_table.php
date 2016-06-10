<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio', function (Blueprint $table) {
              $table->increments('id');
              $table->string('name');
              $table->string('title')->nullable();;
              $table->string('originalname');
              $table->integer('user_id')->unsigned();
              $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('audio');
    }
}
