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

// Manufacturer Routes
Route::resource('manufacturers', 'Admin\ManufacturerController');
Route::get('datatable/manufacturers', 'Admin\ManufacturerController@dataTableManufacturer')->name('datatable.manufacturers');


// ProductType Routes
Route::resource('product_types', 'Admin\ProductTypeController');

// Category Routes
Route::resource('categories', 'Admin\CategoryController');
Route::get('datatable/categories', 'Admin\CategoryController@dataTableCategory')->name('datatable.categories');

// Attribute Routes
Route::resource('attributes', 'Admin\AttributeController');
Route::get('datatable/attributes', 'Admin\AttributeController@data_table')->name('datatable.attributes');







