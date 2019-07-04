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

Route::get('/admin/login', 'Back\AccountController@showAdminLoginForm');

Route::post('/admin/login', 'Back\AccountController@adminLogin')->name('admin.login');

// use auth middleware to authenticate
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    // index
    Route::get('/', 'Back\WebsiteController@index');

    // logout
    Route::get('/logout', 'Back\AccountController@logout')->name('logout');

    // modify product page
    Route::resource('/category', 'Back\CategoryController', ['except' => ['show']]);

});
