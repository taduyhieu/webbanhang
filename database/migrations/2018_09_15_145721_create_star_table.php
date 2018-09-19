<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('star', function ($table) {
            $table->increments('id');
            $table->integer('start_1');
            $table->integer('start_2');
            $table->integer('start_3');
            $table->integer('start_4');
            $table->integer('start_5');
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
        Schema::drop('star');
    }
}
