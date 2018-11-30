<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

// Companies
Route::resource('companies', 'CompanyController')->except(['show']);

// Users
Route::resource('users', 'UserController')->except(['show']);

// Folders
Route::post('folders', 'FolderController@store')->name('folders.store');
