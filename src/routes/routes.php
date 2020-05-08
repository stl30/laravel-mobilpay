<?php

use Illuminate\Support\Facades\Route;
use Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController;

Route::get('/mobilpay-card', 'LaravelMobilpayController@card')->name('laravel-mobilpay.card');
Route::get('/mobilpay-card-redirect', 'LaravelMobilpayController@cardRedirect')->name('laravel-mobilpay.cardRedirect');
Route::get('/mobilpay-card-confirm', 'LaravelMobilpayController@cardConfirm')->name('laravel-mobilpay.cardConfirm');
Route::get('/mobilpay-card-return', 'LaravelMobilpayController@cardReturn')->name('laravel-mobilpay.cardReturn');
