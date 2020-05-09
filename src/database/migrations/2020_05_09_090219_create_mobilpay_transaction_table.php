<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilpayTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobilpay_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('id_transaction');
            $table->char('type')->comment('person - payer is a person; company - payer is a company;');
            $table->integer('request_status')->comment('0-order sent by client 1- order ok returned by mobilpay 2- order with errors returned by mobilpay');
            $table->text('status');
            $table->text('value');
            $table->text('currency');
            $table->text('promotion_code');
            $table->integer('installments_number');
            $table->integer('installment_number');
            $table->text('details');
            $table->text('client_name');
            $table->text('client_surname');
            $table->text('client_address');
            $table->text('client_email');
            $table->text('client_phone');
            $table->text('request_object')->comment('data we send to mobilpay');
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
        Schema::dropIfExists('mobilpay_transaction');
    }
}
