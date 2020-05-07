<?php

namespace Stl30\LaravelMobilpay\Http\Controllers;

class LaravelMobilpayController extends Controller
{
    public function index()
    {
        //
        return view('laravel-mobilpay.card');
    }

    public function show()
    {
        //
        die(__METHOD__.'show');
    }

    public function store()
    {
        die(__METHOD__.'store');
    }
}
