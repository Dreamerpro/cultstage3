<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('from')->unsigned();
            $table->foreign('from')->references('id')->on('users')->onDelete('cascade');
            $table->integer('to')->unsigned();
            $table->foreign('to')->references('id')->on('users')->onDelete('cascade');
            $table->string('subject');
            $table->longText('body');
            $table->tinyInteger('seen', 0);//for from 
            $table->tinyInteger('deleted', 0);//refer to info 
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
        Schema::drop('messages');
    }
}
