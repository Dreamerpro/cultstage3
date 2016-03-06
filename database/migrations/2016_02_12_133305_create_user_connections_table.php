<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_connections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id1')->unsigned();
            $table->foreign('user_id1')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_id2')->unsigned();
            $table->foreign('user_id2')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('status',0);
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
        Schema::drop('user_connections');
    }
}
