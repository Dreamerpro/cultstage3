<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('detail')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->mediumText('address');
            $table->string('image')->nullable();
            $table->time('starting_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->tinyInteger('status',0);
            $table->softDeletes();
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
        Schema::drop('events');
    }
}
