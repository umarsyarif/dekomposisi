<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::name('api.')->group(function () {
    Route::post('peramalan', 'DekomposisiController@peramalanApi')->name('dekomposisi.peramalan');
    Route::post('peramalan/chart', 'HomeController@chart')->name('home.chart');
    Route::post('dataset/{dataset}', 'DatasetController@update')->name('dataset.update');
});
