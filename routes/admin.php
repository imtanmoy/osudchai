<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.home');
})->name('home');

Route::get('/', 'Admin\AdminController@index');

// Permission Routes
Route::resource('permissions', 'Admin\PermissionsController');

// Role Routes
Route::resource('roles', 'Admin\RolesController');




