<?php

use App\Http\Controllers\TicketController;
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

//Ticket
Route::get('tickets', 'TicketController@index')->name('tickets');
Route::post('ticket', 'TicketController@store')->name('ticket');

Route::post('tickets/assignee/{ticket}', 'TicketController@assignTicket')->name('assignTicket');
Route::post('tickets/attend/{ticket}', 'TicketController@attendTicket')->name('attendicket');

//Ticket Attend
Route::get('attend', 'ServiceController@index')->name('attend');


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});



