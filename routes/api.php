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

Route::group(['middleware' => ['api', 'cors']], function () {

    Route::post('auth/login', 'Api\AuthController@login');
    Route::post('auth/register', 'Api\AuthController@register');

    Route::group(['prefix' => 'auth', 'middleware' => 'jwt.auth'], function () {
        Route::get('user', 'Api\AuthController@getAuthUser');
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('refresh', 'Api\AuthController@refresh');
        Route::get('me', 'Api\AuthController@me');
    });

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::resource('prescriptions', 'Api\PrescriptionController')->except(['create', 'edit']);
        Route::resource('addresses', 'Api\AddressController')->except(['create', 'edit']);
        Route::resource('orders', 'Api\OrderController')->except(['create', 'edit']);
    });
});


Route::get('/products', 'Api\ProductController@index');
Route::get('/products/{id}', 'Api\ProductController@show');

Route::get('/categories', 'Api\CategoryController@index');
Route::get('/categories/{id}', 'Api\CategoryController@show');
Route::get('/categories/{id}/products', 'Api\CategoryController@productsByCategory');
