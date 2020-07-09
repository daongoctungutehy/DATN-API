<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billuser', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idUser')->unsigned();
            $table->integer('price'); // tổng số tiền
            $table->integer('count'); // số lượng sản phẩm có trong hóa đơn 
            $table->string('status'); // trạng thái 
            $table->date('orderdate'); // ngày đặt 
            $table->date('receiveddate'); // ngày nhận

            $table->timestamps();

            $table->foreign('idUser')
            ->references('id')->on('user1s')
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
        Schema::dropIfExists('bill_users');
    }
}
