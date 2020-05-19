<?php

use Illuminate\Support\Facades\Route;
use Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController;



Route::group(['middleware' => ['api']], function () {
    Route::post('/mobilpay/card-confirm', 'Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController@cardConfirm')->name('laravel-mobilpay.cardConfirm');
});
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/mobilpay/card', 'Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController@card')->name('laravel-mobilpay.card');
    Route::post('/mobilpay/card-redirect/{payment-parameters}','Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController@cardRedirect')->name('laravel-mobilpay.cardRedirect');
    Route::get('/mobilpay/card-confirm', 'Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController@cardConfirm')->name('laravel-mobilpay.cardConfirm');
    Route::get('/mobilpay/card-return', 'Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController@cardReturn')->name('laravel-mobilpay.cardReturn');

});
