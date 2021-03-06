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

// Auth.Verification
Route::get('thanks', 'Auth\VerificationController@thanks')->name('auth.thanks');
Route::get('verify/{token}', 'Auth\VerificationController@verify')->name('auth.verify');

// Dashboard
Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

// Permissions
Route::get('permissions', 'PermissionController@index')->name('permissions.index');
Route::get('permissions/{company}', 'PermissionController@edit')->name('permissions.edit');
Route::post('permissions/{company}', 'PermissionController@update')->name('permissions.update');

// Companies
Route::resource('companies', 'CompanyController')->except(['show']);
Route::get('companies/{company}/users', 'CompanyController@users')->name('companies.users');
Route::get('companies/{company}/folders', 'CompanyController@folders')->name('companies.folders');
Route::get('companies/{company}/folders/{folder}/copy', 'CompanyController@foldersCopy')->name('companies.folders.copy');
Route::get('companies/{company}/folders/{folder}/move', 'CompanyController@foldersMove')->name('companies.folders.move');
Route::post('companies/{company}/users/notify', 'CompanyController@usersNotify')->name('companies.users.notify');

// Companies.Permissions
Route::get('companies/{company}/permissions', 'CompanyPermissionController@edit')->name('companies.permissions.edit');
Route::patch('companies/{company}/permissions', 'CompanyPermissionController@update')->name('companies.permissions.update');

// Users
Route::resource('users', 'UserController')->except(['show']);

// Users.Profile
Route::get('users/profile', 'UserController@profile')->name('users.profile');
Route::post('users/profile', 'UserController@updateProfile')->name('users.profile.update');

// Users.Password
Route::get('users/password', 'UserController@password')->name('users.password');
Route::post('users/password', 'UserController@updatePassword')->name('users.password.update');

// Users.Permissions
Route::get('users/{user}/permissions', 'UserPermissionController@edit')->name('users.permissions.edit');
Route::patch('users/{user}/permissions', 'UserPermissionController@update')->name('users.permissions.update');

// Folders
Route::post('folders', 'FolderController@store')->name('folders.store');
Route::post('folders/create', 'FolderController@create')->name('folders.create');
Route::patch('folders/{folder}/status', 'FolderController@updateStatus')->name('folders.update.status');
Route::patch('folders/{folder}/tag', 'FolderController@updateTag')->name('folders.update.tag');
Route::post('folders/{folder}/rename', 'FolderController@rename')->name('folders.rename');
Route::post('folders/{folder}/copy', 'FolderController@copy')->name('folders.copy');
Route::post('folders/{folder}/move', 'FolderController@move')->name('folders.move');
Route::get('folders/{folder}/destroy', 'FolderController@destroy')->name('folders.destroy');

// Files
Route::post('files', 'FileController@store')->name('files.store');
Route::post('files/{file}/rename', 'FileController@rename')->name('files.rename');
Route::post('files/{file}/copy', 'FileController@copy')->name('files.copy');
Route::post('files/{file}/move', 'FileController@move')->name('files.move');
Route::get('files/{file}/download', 'FileController@download')->name('files.download');
Route::post('files/download', 'FileController@downloadMultiple')->name('files.download.multiple');
Route::post('files/delete', 'FileController@deleteMultiple')->name('files.delete.multiple');
Route::get('files/{file}/destroy', 'FileController@destroy')->name('files.destroy');
