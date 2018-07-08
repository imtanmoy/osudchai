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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'AdminAuth\RegisterController@register')->name('admin.store');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.request');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('admin.password.email');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Auth::routes();

Route::group(['middleware' => ['isVerified']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
Route::get('auth/verify/{token}', 'Auth\VerificationController@verifyUser');

Route::get('auth/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

