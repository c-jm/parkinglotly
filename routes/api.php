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


Route::post('lots/{lot}/tickets', 'TicketsController@create');
Route::get('lots/{lot}/tickets/{ticketId}', 'TicketsController@show');

Route::post('/leave');

Route::post('lots/{lot}/payments/{ticketId}', 'PaymentsController@create');
