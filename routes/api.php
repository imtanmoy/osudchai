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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('logout', 'AuthController@logout');
    Route::get('test', function () {
        return response()->json(['foo' => 'bar']);
    });
});

Route::group(['middleware' => ['api']], function () {

    Route::post('auth/login', 'Api\AuthController@login');

    Route::group(['prefix' => 'auth', 'middleware' => 'jwt.auth'], function () {
        Route::get('user', 'Api\AuthController@getAuthUser');
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('refresh', 'Api\AuthController@refresh');
        Route::get('me', 'Api\AuthController@me');
    });
});


Route::get('/products', 'Api\ProductController@index');
