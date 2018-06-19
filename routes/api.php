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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// user routes
Route::group([
    'middleware' => 'api',
], function ($router) {

    Route::post('auth/login', 'Auth\JwtAuthController@login');
    Route::post('auth/signup', 'Auth\JwtAuthController@signup');
    Route::post('auth/logout', 'Auth\JwtAuthController@logout');
    Route::post('auth/refresh', 'Auth\JwtAuthController@refresh');
    Route::post('auth/me', 'Auth\JwtAuthController@me');

    Route::post('channels/list', 'Api\ChannelsController@index');
    Route::post('channels/store', 'Api\ChannelsController@store');
    Route::post('channels/get', 'Api\ChannelsController@show');
    Route::post('channels/update', 'Api\ChannelsController@update');
    Route::post('channels/delete', 'Api\ChannelsController@destroy');

});


// admin routes
Route::group([
    'middleware' => ['api', 'activated', 'role:admin'],
], function ($router) {
    
    Route::post('users/list', 'Api\UserManagementController@index');
    Route::post('users/store', 'Api\UserManagementController@store');
    Route::post('users/get', 'Api\UserManagementController@show');
    Route::post('users/update', 'Api\UserManagementController@update');
    Route::post('users/delete', 'Api\UserManagementController@destroy');
    Route::post('users/search', 'Api\UserManagementController@search');

    Route::post('itemtypes/list', 'Api\ItemTypesManagementController@index');
    Route::post('itemtypes/store', 'Api\ItemTypesManagementController@store');
    Route::post('itemtypes/get', 'Api\ItemTypesManagementController@show');
    Route::post('itemtypes/update', 'Api\ItemTypesManagementController@update');
    Route::post('itemtypes/delete', 'Api\ItemTypesManagementController@destroy');

});