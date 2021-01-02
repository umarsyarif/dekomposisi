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

Route::get('/', 'HomeController@home')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Auth::routes(['register' => false]);

Route::middleware('auth')->prefix('dataset')->name('dataset.')->group(function () {
    Route::get('/', 'DatasetController@page')->name('page');
    Route::post('/', 'DatasetController@store')->name('store');
    Route::get('devide', 'DatasetController@devide')->name('devide');
    Route::get('export', 'DatasetController@export')->name('export');
    Route::post('import', 'DatasetController@import')->name('import');
    Route::delete('/{year}', 'DatasetController@destroy')->name('destroy');
});

Route::middleware('auth')->prefix('dekomposisi')->name('dekomposisi.')->group(function () {
    Route::get('trend', 'DekomposisiController@nilaiTrend')->name('trend');
    Route::get('musiman', 'DekomposisiController@nilaiIndeksMusiman')->name('musiman');
    Route::get('peramalan', 'DekomposisiController@peramalan')->name('peramalan');
    Route::get('evaluasi', 'DekomposisiController@evaluasi')->name('evaluasi');
});

Route::middleware('auth')->prefix('kecamatan')->name('kecamatan.')->group(function () {
    Route::get('/', 'KecamatanController@page')->name('page');
    Route::post('/', 'KecamatanController@store')->name('store');
    Route::put('/{kecamatan?}', 'KecamatanController@update')->name('update');
    Route::delete('/{kecamatan?}', 'KecamatanController@destroy')->name('destroy');
});


Route::get('/{page}', 'HomeController@index')->name('page');
