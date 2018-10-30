<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\AuthController@login');
Route::middleware('jwt.auth')->group(function(){
    Route::get('wellcome', 'API\AuthController@index');
    Route::get('logout', 'API\AuthController@logout');
});
