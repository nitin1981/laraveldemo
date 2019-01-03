<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('bank_trans', function (Blueprint $table) {
            
            $table->increments('id');
            $table->double('amount');
            $table->string('trans_type',100);
            $table->integer('account_no');
            $table->date('trans_date');
            $table->integer('person_id');
            $table->string('reference', 100);
            $table->text('description');
            $table->integer('category_id');
            $table->integer('payment_method');
            $table->string('attachment',50);
            $table->dateTime('created_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bank_trans');
    }
}
