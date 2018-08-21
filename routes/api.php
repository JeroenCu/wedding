<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', 'testController@index');

Route::post('/guests/edit', 'guestController@createOrUpdate');

Route::get('/guests', 'guestController@getAllGuests');

Route::post('/keys/add', 'keysController@add');

Route::get('/keys/unused', 'keysController@getUnused');
