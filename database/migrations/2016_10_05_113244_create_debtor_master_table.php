<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtorMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtors_master', function (Blueprint $table) {
            $table->increments('debtor_no');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->text('address');
            $table->string('phone', 20);
            $table->integer('sales_type');
            $table->string('remember_token');
            $table->tinyInteger('inactive')->default(0);
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
        Schema::drop('debtors_master');
    }
}
