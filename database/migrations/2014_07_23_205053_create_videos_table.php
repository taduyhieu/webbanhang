<?php

use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('videos', function ($table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('url', 255);
            $table->string('slug')->nullable();
            $table->string('lang', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('videos');
    }
}
