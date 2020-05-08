<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/records/create', 'RecordController@showCreateFrom')->name('records.create');
    Route::post('/records/create', 'RecordController@create');
    
    Route::group(['middleware' => 'can:view,record'], function() {
        Route::get('/records/{record}/edit', 'RecordController@showEditFrom')->name('records.edit');
        Route::post('/records/{record}/edit', 'RecordController@edit');
        Route::post('/records/{record}/delete', 'RecordController@delete')->name('records.delete');
    });
});
Auth::routes();