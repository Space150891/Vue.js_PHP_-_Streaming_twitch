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

    Route::post('items/list', 'Api\ItemsManagementController@index');
    Route::post('items/store', 'Api\ItemsManagementController@store');
    Route::post('items/get', 'Api\ItemsManagementController@show');
    Route::post('items/update', 'Api\ItemsManagementController@update');
    Route::post('items/delete', 'Api\ItemsManagementController@destroy');

    Route::post('rarities/list', 'Api\RaritiesManagementController@index');
    Route::post('rarities/store', 'Api\RaritiesManagementController@store');
    Route::post('rarities/get', 'Api\RaritiesManagementController@show');
    Route::post('rarities/update', 'Api\RaritiesManagementController@update');
    Route::post('rarities/delete', 'Api\RaritiesManagementController@destroy');

    Route::post('casetypes/list', 'Api\CaseTypesManagementController@index');
    Route::post('casetypes/store', 'Api\CaseTypesManagementController@store');
    Route::post('casetypes/get', 'Api\CaseTypesManagementController@show');
    Route::post('casetypes/update', 'Api\CaseTypesManagementController@update');
    Route::post('casetypes/delete', 'Api\CaseTypesManagementController@destroy');

    Route::post('cases/list', 'Api\CasesManagementController@index');
    Route::post('cases/store', 'Api\CasesManagementController@store');
    Route::post('cases/get', 'Api\CasesManagementController@show');
    Route::post('cases/update', 'Api\CasesManagementController@update');
    Route::post('cases/delete', 'Api\CasesManagementController@destroy');
    
});