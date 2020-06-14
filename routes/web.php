<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@home')->name('page');

Auth::routes();

Route::prefix('data-latih')->name('data-latih.')->group(function () {
    Route::get('/', 'LatihController@page')->name('page');
    Route::post('/', 'LatihController@store')->name('store');
    Route::get('get-year', 'LatihController@getYear')->name('get-year');
    Route::get('export', 'LatihController@export')->name('export');
    Route::post('import', 'LatihController@import')->name('import');
    Route::delete('/{year}', 'LatihController@destroy')->name('destroy');
});

Route::prefix('data-uji')->name('data-uji.')->group(function () {
    Route::get('/', 'UjiController@page')->name('page');
    Route::post('/', 'UjiController@store')->name('store');
    Route::get('get-year', 'UjiController@getYear')->name('get-year');
    Route::get('export', 'UjiController@export')->name('export');
    Route::post('import', 'UjiController@import')->name('import');
    Route::delete('/{year}', 'UjiController@destroy')->name('destroy');
});

Route::prefix('prediksi')->name('prediksi.')->group(function () {
    Route::get('/', 'PrediksiController@page')->name('page');
    Route::get('/data-trend', 'PrediksiController@trend')->name('data-trend');
    Route::get('/data-musiman', 'PrediksiController@musiman')->name('data-musiman');
});



Route::get('/{page}', 'HomeController@index')->name('page');
