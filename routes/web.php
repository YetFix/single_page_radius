<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/customer', function () {
    return view('customers.create');
});

Route::get('/customer1', function () {
    return view('customers.create2');
});

