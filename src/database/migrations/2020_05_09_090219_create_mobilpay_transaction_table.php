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
            $table->char('id_transaction')->nullable();
            $table->char('type')->nullable()->comment('person - payer is a person; company - payer is a company;');
            $table->integer('request_status')->default(0)->comment('0-order sent by client 1- order ok returned by mobilpay 2- order with errors returned by mobilpay');
            $table->text('status')->nullable();
            $table->text('value')->nullable();
            $table->text('currency')->nullable();
            $table->text('promotion_code')->nullable();
            $table->integer('installments_number')->nullable();
            $table->integer('installment_number')->nullable();
            $table->text('details')->nullable();
            $table->text('client_name')->nullable();
            $table->text('client_surname')->nullable();
            $table->text('client_address')->nullable();
            $table->text('client_email')->nullable();
            $table->text('client_phone')->nullable();
            $table->text('request_object')->nullable()->comment('data we send to mobilpay');
            $table->text('return_request_object')->nullable()->comment('data we receive from mobilpay');
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
