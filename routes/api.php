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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
    /*Get free slots whit date*/
    Route::post('appointments/free','AppointmentsController@getFree');
    /*Get all slots*/
    Route::post('appointments/all','AppointmentsController@getAll');
    /*Add new appointment*/
    Route::post('appointments/markit','AppointmentsController@markit');
    /*Delete appointment*/
    Route::delete('appointments/delete','AppointmentsController@delete');
