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

/**
 * Llamados con el prefijo auth donde se realiza el login y el registro, estás funciones no
 * son protegidas por el middleware así que pueden ser llamadas sin problema
 */
Route::group(['prefix' => 'auth'], function (){
    Route::post('login', 'App\Http\Controllers\LoginController@login');
    Route::post('register', 'App\Http\Controllers\LoginController@register');
});

/**
 * Agrupación de llamados dentro del middleware haciendo uso del JWT, el cual debe enviarse el token
 * generado una vez logeado para poder acceder a estas funciones
 */
Route::group(['middleware' => ['jwt.auth']], function (){
    Route::group(['prefix' => 'auth'], function () {
        Route::post('user', 'App\Http\Controllers\LoginController@getAuthenticatedUser');
        Route::get('expire', 'App\Http\Controllers\LoginController@expireToken');
    });

    /**
     * Agrupación de llamados para el CRUD y gestión de las facturas
    */
    Route::group(['prefix' => 'bills'], function () {
        Route::get('list','App\Http\Controllers\BillsController@index');
        Route::get('detail/{id}','App\Http\Controllers\BillsController@show');
        Route::post('create','App\Http\Controllers\BillsController@store');
        Route::put('update/{id}','App\Http\Controllers\BillsController@update');
        Route::delete('delete/{id}','App\Http\Controllers\BillsController@destroy');
    });
});
