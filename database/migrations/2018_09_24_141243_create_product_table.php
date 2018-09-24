<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function ($table) {
            $table->increments('id');
            $table->string('id_product', 255);
            $table->string('code', 255);
            $table->string('content', 255);
            $table->string('slug', 255);
            $table->integer('product_categories_id');
            $table->integer('quatities');
            $table->double('price', 20,2);
            $table->integer('color');
            $table->integer('agency_product_id');
            $table->string('description');
            $table->string('description_short');
            $table->string('lang', 255);
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
        Schema::drop('product');
    }
}
