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
        Schema::create('mobilpay_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('id_transaction')->default(null);
            $table->char('type')->default(null)->comment('person - payer is a person; company - payer is a company;');
            $table->integer('request_status')->default(0)->comment('0-order sent by client 1- order ok returned by mobilpay 2- order with errors returned by mobilpay');
            $table->text('status')->default(null);
            $table->text('value')->default(null);
            $table->text('currency')->default(null);
            $table->text('promotion_code')->default(null);
            $table->integer('installments_number')->default(null);
            $table->integer('installment_number')->default(null);
            $table->text('details')->default(null);
            $table->text('client_name')->default(null);
            $table->text('client_surname')->default(null);
            $table->text('client_address')->default(null);
            $table->text('client_email')->default(null);
            $table->text('client_phone')->default(null);
            $table->text('request_object')->comment('data we send to mobilpay');
            $table->text('return_request_object')->comment('data we receive from mobilpay');
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
        Schema::dropIfExists('mobilpay_transactions');
    }
}
