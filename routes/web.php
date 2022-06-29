<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', function () {
    return view('Dashboeard');
});
Route::get('/', function () {
    return view('home');
});


// slove vue router problem
Route::get('/admin/{any}',function(){
    return view('Dashboeard');
})->where('any','.*');
Route::get('{any}',function(){
    return view('home');
})->where('any','.*');
