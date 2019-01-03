<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomItemOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('custom_item_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_no');
            $table->tinyInteger('tax_type_id');
            $table->string('name', 255);
            $table->double('quantity');
            $table->double('unit_price');
            $table->double('discount_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('custom_item_orders');
    }
}
