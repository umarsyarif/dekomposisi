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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes();

Route::prefix('api')->name('api.')->group(function () {
    Route::get('export', 'ApiController@export')->name('export');
    Route::post('import', 'ApiController@import')->name('import');
});

Route::get('/{page}', 'HomeController@index')->name('page');
