<?php

use App\User;
use Spatie\Permission\Models\Permission;

Route::get('/', 'ClientController@index')->name('client_index');
Route::get('/search', 'ClientController@search')->name('client_search');
Route::get('/get_cat_files/{id}', 'ClientController@getCatFiles')->name('client_get_cat_files');
Route::post('/get_cat_files/{id}', 'ClientController@CatFiles')->name('client_cat_files');

Route::get('/download', 'ClientController@save')->name('download_get');
Route::post('/download', 'ClientController@download')->name('download_post');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/admin', 'HomeController@index')->name('home')->middleware('permission:نمایش داشبورد');

    Route::get('/admin/files', 'FileController@index')->name('files_index')->middleware('permission:نمایش فایل ها');
    Route::get('/admin/files/search', 'FileController@search')->name('files_search')->middleware('permission:نمایش فایل ها');
    Route::get('/admin/files/add', 'FileController@create')->name('files_add')->middleware('permission:افزودن فایل');
    Route::post('/admin/files/add', 'FileController@store')->name('files_add_save')->middleware('permission:افزودن فایل');
    Route::get('/admin/files/delete/{id}', 'FileController@destroy')->name('files_delete')->middleware('permission:حذف فایل');
    Route::get('/admin/files/edit/{id}', 'FileController@edit')->name('files_edit')->middleware('permission:ویرایش فایل');
    Route::post('/admin/files/edit/{id}', 'FileController@update')->name('files_edit_save')->middleware('permission:ویرایش فایل');

    Route::get('/admin/categories', 'CategoryController@index')->name('categories_index')->middleware('permission:نمایش دسته بندی ها');
    Route::get('/admin/categories/search', 'CategoryController@search')->name('categories_search')->middleware('permission:نمایش دسته بندی ها');
    Route::get('/admin/categories/add', 'CategoryController@create')->name('categories_add')->middleware('permission:افزودن دسته بندی');
    Route::post('/admin/categories/add', 'CategoryController@store')->name('categories_add_save')->middleware('permission:افزودن دسته بندی');
    Route::get('/admin/categories/delete/{id}', 'CategoryController@destroy')->name('categories_delete')->middleware('permission:حذف دسته بندی');
    Route::get('/admin/categories/edit/{id}', 'CategoryController@edit')->name('categories_edit')->middleware('permission:ویرایش دسته بندی');
    Route::post('/admin/categories/edit/{id}', 'CategoryController@update')->name('categories_edit_save')->middleware('permission:ویرایش دسته بندی');

    Route::get('/admin/users', 'UserController@index')->name('users_index')->middleware('permission:نمایش مدیران');
    Route::get('/admin/users/search', 'UserController@search')->name('users_search')->middleware('permission:نمایش مدیران');
    Route::get('/admin/users/add', 'UserController@create')->name('users_add')->middleware('permission:افزودن مدیر');
    Route::post('/admin/users/add', 'UserController@store')->name('users_add_save')->middleware('permission:افزودن مدیر');
    Route::get('/admin/users/delete/{id}', 'UserController@destroy')->name('users_delete')->middleware('permission:حذف مدیر');
    Route::get('/admin/users/edit/{id}', 'UserController@edit')->name('users_edit')->middleware('permission:ویرایش مدیر');
    Route::post('/admin/users/edit/{id}', 'UserController@update')->name('users_edit_save')->middleware('permission:ویرایش مدیر');

});

Route::get('/login', 'HomeController@login')->name('login');
Route::post('/login', 'HomeController@doLogin')->name('doLogin');
Route::get('/logout', 'HomeController@logout')->name('logout');

//Route::get('create_super_admin', function () {
//
//    Permission::create(['name' => 'نمایش مدیران', 'guard_name' => 'web']);
//    Permission::create(['name' => 'افزودن مدیر', 'guard_name' => 'web']);
//    Permission::create(['name' => 'ویرایش مدیر', 'guard_name' => 'web']);
//    Permission::create(['name' => 'حذف مدیر', 'guard_name' => 'web']);
//    Permission::create(['name' => 'نمایش فایل ها', 'guard_name' => 'web']);
//    Permission::create(['name' => 'افزودن فایل', 'guard_name' => 'web']);
//    Permission::create(['name' => 'ویرایش فایل', 'guard_name' => 'web']);
//    Permission::create(['name' => 'حذف فایل', 'guard_name' => 'web']);
//    Permission::create(['name' => 'دانلود فایل', 'guard_name' => 'web']);
//    Permission::create(['name' => 'نمایش دسته بندی ها', 'guard_name' => 'web']);
//    Permission::create(['name' => 'افزودن دسته بندی', 'guard_name' => 'web']);
//    Permission::create(['name' => 'ویرایش دسته بندی', 'guard_name' => 'web']);
//    Permission::create(['name' => 'حذف دسته بندی', 'guard_name' => 'web']);
//    Permission::create(['name' => 'نمایش داشبورد', 'guard_name' => 'web']);
//
//    $superAdmin = User::create([
//        'username' => 'admin',
//        'password' => Hash::make('12345678'),
//        'name' => 'admin',
//        'email' => 'admin@gmail.com',
//        'role' => 1,
//    ]);
//    $superAdmin->givePermissionTo([
//        'نمایش مدیران', 'افزودن مدیر', 'ویرایش مدیر', 'حذف مدیر', 'نمایش فایل ها', 'افزودن فایل', 'ویرایش فایل', 'حذف فایل', 'دانلود فایل', 'نمایش دسته بندی ها',
//        'افزودن دسته بندی', 'ویرایش دسته بندی', 'حذف دسته بندی', 'نمایش داشبورد'
//    ]);
//    echo 'done';
//});
