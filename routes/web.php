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

Route::get('/sms-settings', function () {
    return view('sms-settings');
});

Route::get('/sms-logs', function () {
    return view('sms-logs');
});

Route::get('/tokens', function () {
    return view('tokens');
});

Route::get('/users', function () {
    return view('users');
});

Route::get('/settings', function () {
    return view('settings');
});

Route::get('/roles', function () {
    return view('roles');
});

Route::get('/permissions', function () {
    return view('permissions');
});

Route::get('/payment-history', function () {
    return view('payment-history');
});

Route::get('/mikrotiks', function () {
    return view('mikrotiks');
});

Route::get('/sync', function () {
    return view('sync');
});

Route::get('/online', function () {
    return view('online');
});

Route::get('/offline', function () {
    return view('offline');
});

