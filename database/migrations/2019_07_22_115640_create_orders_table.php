<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('oid');
            $table->integer('id');
            $table->string('orderer_name', 50);
            $table->string('orderer_tel', 12);
            $table->string('orderer_email', 100);
            $table->string('orderer_add', 100);
            $table->string('recipient_name', 50);
            $table->string('recipient_tel', 12);
            $table->string('recipient_email', 100);
            $table->string('recipient_add', 100);
            $table->string('status', 10);
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
        Schema::dropIfExists('orders');
    }
}
