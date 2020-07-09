<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idProductType')->unsigned();
            $table->string('name');
            $table->string('origin');
            $table->string('color');
            $table->string('weight');
            $table->longText('describe'); 
            $table->integer('price');
            $table->integer('promotion');
            $table->string('image'); 
            $table->integer('amount');
            $table->integer('rate');
            $table->timestamps();
            $table->foreign('idProductType')->references('id')->on('product_types')->onDelete('cascade');
        });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
