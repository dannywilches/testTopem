<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function (){
    Route::post('login', 'App\Http\Controllers\LoginController@login');
    Route::post('register', 'App\Http\Controllers\LoginController@register');
});

Route::group(['middleware' => ['jwt.auth']], function (){
    Route::group(['prefix' => 'auth'], function () {
        Route::post('user', 'App\Http\Controllers\LoginController@getAuthenticatedUser');
        Route::get('expire', 'App\Http\Controllers\LoginController@expireToken');
        Route::post('me', 'App\Http\Controllers\LoginController@me');
    });

    Route::group(['prefix' => 'bills'], function () {
        Route::get('list-all','App\Http\Controllers\BillsController@index');
    });
});
