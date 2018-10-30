<?php

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

Route::get('/index', function () {
    return view('index');
})->middleware('jwt.auth');
Route::post('jwt/login', 'Auth\AuthController@login')->name('jwt.login');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
