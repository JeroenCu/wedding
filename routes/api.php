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

Route::get('/test', 'testController@index');

Route::get('/songs/csv', 'songsController@csvSongs');

Route::post('/guests/rsvp', 'guestController@rsvpGuest');

Route::post('/guests/newGuest', 'guestController@addGuest');

Route::post('/guests/checkGuest', 'guestController@checkGuest');

Route::get('/guests/csv', 'guestController@csvGuests');
