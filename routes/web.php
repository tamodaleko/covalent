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

// Companies.Permissions
Route::get('companies/permissions', 'CompanyPermissionController@index')->name('companies.permissions.index');
Route::get('companies/{company}/permissions', 'CompanyPermissionController@edit')->name('companies.permissions.edit');
Route::patch('companies/{company}/permissions', 'CompanyPermissionController@update')->name('companies.permissions.update');

// Users
Route::resource('users', 'UserController')->except(['show']);

// Users.Profile
Route::get('users/profile', 'UserController@profile')->name('users.profile');
Route::post('users/profile', 'UserController@updateProfile')->name('users.profile.update');

// Users.Permissions
Route::get('users/{user}/permissions', 'UserPermissionController@edit')->name('users.permissions.edit');
Route::patch('users/{user}/permissions', 'UserPermissionController@update')->name('users.permissions.update');

// Folders
Route::post('folders', 'FolderController@store')->name('folders.store');
Route::patch('folders/{folder}/status', 'FolderController@updateStatus')->name('folders.update.status');
Route::patch('folders/{folder}/tag', 'FolderController@updateTag')->name('folders.update.tag');
Route::delete('folders/{folder}', 'FolderController@destroy')->name('folders.destroy');

// Files
Route::post('files', 'FileController@store')->name('files.store');
Route::post('files/download/selected', 'FileController@download')->name('files.download');
Route::delete('files/{file}', 'FileController@destroy')->name('files.destroy');
Route::post('files/{file}/copy', 'FileController@copy')->name('files.copy');
