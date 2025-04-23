<?php

use Illuminate\Support\Facades\Route;

// User Panel Routes
Route::get('/', function () {
    return view('userPanel.welcomeUser');
});
Route::get('/tracking', function () {
    return view('userPanel.tracking');
})->name('tracking');




//Admin Panel Routes
Route::get('/admin', function () {
    return view('adminPanel.welcomeAdmin');
})->name('admin.dashboard');





