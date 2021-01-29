<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaravelMobilpay\LaravelMobilpayController;



Route::group(['middleware' => ['api']], function () {
    Route::post('/payment/card-confirm', [LaravelMobilpayController::class, 'cardConfirm'])->name('laravel-mobilpay.cardConfirm');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/payment/card', [LaravelMobilpayController::class,'card'])->name('laravel-mobilpay.card');
    Route::post('/payment/card-redirect',[LaravelMobilpayController::class,'cardRedirect'])->name('laravel-mobilpay.cardRedirect');
    Route::get('/payment/card-return', [LaravelMobilpayController::class,'cardReturn'])->name('laravel-mobilpay.cardReturn');
});
