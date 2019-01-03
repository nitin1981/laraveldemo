<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->increments('order_no');
            $table->mediumInteger('trans_type');
            $table->string('invoice_type', 15);
            $table->integer('debtor_no');
            $table->tinyInteger('branch_id');
            $table->integer('person_id');
            $table->string('reference', 30);
            $table->string('customer_ref', 20)->nullable()->default(NULL);
            $table->integer('order_reference_id');
            $table->string('order_reference', 30)->nullable()->default(NULL);
            $table->string('comments')->nullable()->default(NULL);
            $table->date('ord_date');
            $table->integer('order_type');
            $table->string('from_stk_loc', 20)->nullable()->default(NULL);
            $table->mediumInteger('payment_id');
            $table->double('total')->default(0);
            $table->double('paid_amount')->default(0);
            $table->tinyInteger('payment_term');
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
        Schema::drop('sales_orders');
    }
}
