<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

// Auth
Auth::routes();

// Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

// Companies
Route::resource('companies', 'CompanyController')->except(['show']);

// Users
Route::resource('users', 'UserController')->except(['show']);
Route::get('users/profile', 'UserController@profile')->name('users.profile');
Route::post('users/profile', 'UserController@updateProfile')->name('users.profile.update');

// Folders
Route::post('folders', 'FolderController@store')->name('folders.store');
Route::patch('folders/{folder}/status', 'FolderController@updateStatus')->name('folders.update.status');
Route::patch('folders/{folder}/tag', 'FolderController@updateTag')->name('folders.update.tag');

// Files
Route::post('files', 'FileController@store')->name('files.store');
