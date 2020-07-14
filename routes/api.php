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

Route::middleware('auth:api')->get('/jobs', 'Api\JobController@index');
Route::middleware('auth:api')->post('/jobs', 'Api\JobController@store');
Route::middleware('auth:api')->put('/jobs/{id}', 'Api\JobController@update');
Route::middleware('auth:api')->put('/finish/{id}', 'Api\JobController@finishJob');

Route::middleware('auth:api')->get('/next', 'Api\JobController@nextJob');
Route::middleware('auth:api')->get('/status/{id}', 'Api\JobController@status');
