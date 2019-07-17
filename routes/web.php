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

Route::get('/', 'Front\WebsiteController@index');
Route::get('/login', 'Front\AccountController@showUserLoginForm');
Route::post('/login', 'Front\AccountController@userLogin')->name('login');
Route::get('/register', 'Front\AccountController@showUserRegisterForm');
Route::post('/register', 'Front\AccountController@userRegister')->name('register');

Route::get('/product-lists/{cid}', 'Front\ProductController@index');
Route::get('/product-lists/{cid}/order/{order?}/perpage/{perpage?}', 'Front\ProductController@index');

Route::get('/product/{cid}/{pid}', 'Front\ProductController@showProduct');

// use auth middleware to authenticate user
Route::middleware(['auth:web'])->group(function () {
    // logout
    Route::get('/logout', 'Front\AccountController@logout');

    // add review
    Route::post('/product/review/{pid}', 'Front\ProductController@addReview')->name('product.review');
});

Route::get('/admin/login', 'Back\AccountController@showAdminLoginForm');
Route::post('/admin/login', 'Back\AccountController@adminLogin')->name('admin.login');

// use auth middleware to authenticate
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    // index
    Route::get('/', 'Back\WebsiteController@index');

    // logout
    Route::get('/logout', 'Back\AccountController@logout')->name('logout');

    // modify category page
    Route::resource('/category', 'Back\CategoryController', ['except' => ['show']]);

    // modify product page
    Route::resource('/product', 'Back\ProductController', ['except' => ['show', 'destroy']]);
    Route::get('/product/{c_name?}/{c_subname?}', 'Back\ProductController@index')->name('product.search');
    Route::get('/product/changestatus/{pid}/{status}', 'Back\ProductController@changeStatus')->name('product.changestatus');
});
