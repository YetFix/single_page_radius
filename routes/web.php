<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/customers/{id}', function ($id) {
    $customer = [
        'id'   => $id,
        'name' => 'Kamrul Hasan',
    ];
    return view('customers.show', compact('customer'));
});
