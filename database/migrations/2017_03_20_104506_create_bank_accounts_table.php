<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('account_type_id');
            $table->string('account_name', 150);
            $table->string('account_no', 30);
            $table->string('bank_name', 100);
            $table->string('bank_address', 255);
            $table->tinyInteger('default_account');
            $table->tinyInteger('deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bank_accounts');
    }
}
