<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_one');
            $table->integer('user_two');
            $table->timestamps();

            $table->foreign('user_one')->references('id')->on('users');
            $table->foreign('user_two')->references('id')->on('users');

            $table->unique(['user_one', 'user_two']);
            $table->unique(['user_two', 'user_one']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('connections');
    }
}
