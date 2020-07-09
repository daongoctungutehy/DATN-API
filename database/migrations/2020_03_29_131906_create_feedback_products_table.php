<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idProduct')->unsigned();
            $table->integer('idUser')->unsigned();
            $table->string('content');
            $table->Date('feedDate');
            $table->timestamps();

            $table->foreign('idUser')
            ->references('id')->on('user1s')
            ->onDelete('cascade');

            $table->foreign('idProduct')
            ->references('id')->on('products')
            ->onDelete('cascade');

           
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_products');
    }
}
