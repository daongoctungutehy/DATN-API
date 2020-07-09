<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idBill')->unsigned();
            $table->integer('idProduct')->unsigned();
            $table->integer('price');
            $table->integer('count');
            $table->string('status');
            $table->string('voucher');
            $table->date('billdate');
            $table->timestamps();

            $table->foreign('idProduct')
            ->references('id')->on('products')
            ->onDelete('cascade');

            $table->foreign('idBill')
            ->references('id')->on('billuser')
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
        Schema::dropIfExists('bills');
    }
}
