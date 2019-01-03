<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purch_orders', function (Blueprint $table) {
            $table->increments('order_no');
            $table->integer('supplier_id');
            $table->integer('person_id');
            $table->string('comments', 30);
            $table->date('ord_date');
            $table->string('reference', 30);
            $table->string('into_stock_location', 50);
            $table->double('total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purch_orders');
    }
}
