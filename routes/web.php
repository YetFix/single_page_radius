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

Route::get('/search', function () {
    return view('search');
});

Route::get('/managers', function () {
    return view('managers');
});

Route::get('/pops', function () {
    return view('pops');
});

Route::get('/lists', function () {
    return view('lists');
});

Route::get('/packages', function () {
    return view('packages');
});

Route::get('/pendings', function () {
    return view('pendings');
});

Route::get('/cycle', function () {
    return view('cycle');
});

Route::get('/sms-gateway', function () {
    return view('sms-gateway');
});

