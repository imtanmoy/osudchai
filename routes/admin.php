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
Route::get('datatable/product_types', 'Admin\ProductTypeController@dataTable')->name('datatable.product_types');


// Category Routes
Route::resource('categories', 'Admin\CategoryController');
Route::get('datatable/categories', 'Admin\CategoryController@dataTableCategory')->name('datatable.categories');

// Attribute Routes
Route::get('attributes/suggest', 'Admin\AttributeController@autoComplete')->name('attributes.suggest');
Route::resource('attributes', 'Admin\AttributeController');
Route::get('datatable/attributes', 'Admin\AttributeController@data_table')->name('datatable.attributes');

// Strength Routes
Route::get('strengths/suggest', 'Admin\StrengthController@autoComplete')->name('strengths.suggest');

// GenericName Routes
Route::get('generic_names/suggest', 'Admin\GenericNameController@autoComplete')->name('generic_names.suggest');

// Product Routes
Route::resource('products', 'Admin\ProductController');
Route::get('products/{id}/adjust', 'Admin\ProductController@showAdjust')->name('products.adjust');
Route::post('products/{id}/adjust', 'Admin\ProductController@updateAdjust')->name('products.updateAdjust');
Route::delete('products/{id}/attributes/{aid}', 'Admin\ProductController@deleteAttributes');








