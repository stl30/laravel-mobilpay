<?php

use Illuminate\Support\Facades\Route;
use Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController;

Route::get('/mobilpay/card', 'Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController@card')->name('laravel-mobilpay.card');
Route::get('/mobilpay/card-redirect', 'Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController@cardRedirect')->name('laravel-mobilpay.cardRedirect');
Route::get('/mobilpay/card-confirm', 'Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController@cardConfirm')->name('laravel-mobilpay.cardConfirm');
Route::get('/mobilpay/card-return', 'Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController@cardReturn')->name('laravel-mobilpay.cardReturn');
