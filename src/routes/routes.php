<?php

use Illuminate\Support\Facades\Route;
use Stl30\LaravelMobilpay\Http\Controllers\LaravelMobilpayController;

Route::get('/laravel-mobilpay-index', 'LaravelMobilpayController@index')->name('laravel-mobilpay.index');
