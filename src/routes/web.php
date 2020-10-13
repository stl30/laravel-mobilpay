<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaravelMobilpay\LaravelMobilpayController;



Route::group(['middleware' => ['api']], function () {
    Route::post('/mobilpay/card-confirm', [LaravelMobilpayController::class, 'cardConfirm'])->name('laravel-mobilpay.cardConfirm');
});

Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/mobilpay/card', [LaravelMobilpayController::class,'card'])->name('laravel-mobilpay.card');
    Route::post('/mobilpay/card-redirect',[LaravelMobilpayController::class,'cardRedirect'])->name('laravel-mobilpay.cardRedirect');
    Route::get('/mobilpay/card-return', [LaravelMobilpayController::class,'cardReturn'])->name('laravel-mobilpay.cardReturn');
});
