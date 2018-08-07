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

    Route::post('viewers/get', 'Api\ViewersController@show');
    Route::post('viewers/current', 'Api\ViewersController@current');
    Route::post('viewer/redeem', 'Api\ViewersController@redeem');

    Route::post('streamers/get', 'Api\StreamersController@show');
    Route::post('streamers/list', 'Api\StreamersController@list');
    Route::post('streamers/list/pagg', 'Api\StreamersController@pagination');
    Route::post('streamers/promoted/list', 'Api\PromotedStreamersManagementController@list');
    Route::post('streamers/promoted/up', 'Api\PromotedStreamersManagementController@up');
    Route::post('streamers/promoted/down', 'Api\PromotedStreamersManagementController@down');
    Route::post('streamers/current', 'Api\StreamersController@current');
    Route::post('streamers/bygamename', 'Api\StreamersController@getListByGame');

    Route::post('contacts/list', 'Api\ContactsController@index');
    Route::post('contacts/store', 'Api\ContactsController@store');
    Route::post('contacts/get', 'Api\ContactsController@show');
    Route::post('contacts/update', 'Api\ContactsController@update');
    Route::post('contacts/delete', 'Api\ContactsController@destroy');
    
    Route::post('referals/viewer/add', 'Api\ReferalViewersController@store');
    Route::post('referals/viewer/get', 'Api\ReferalViewersController@show');
    Route::post('referals/viewer/me', 'Api\ReferalViewersController@me');

    Route::post('referals/streamer/add', 'Api\ReferalStreamersController@store');
    Route::post('referals/streamer/get', 'Api\ReferalStreamersController@show');
    Route::post('referals/streamer/me', 'Api\ReferalStreamersController@me');

    Route::post('viewer/items/list', 'Api\ViewerItemsController@index');
    Route::post('viewer/items/add', 'Api\ViewerItemsController@store');
    Route::post('viewer/items/get', 'Api\ViewerItemsController@show');
    Route::post('viewer/items/delete', 'Api\ViewerItemsController@destroy');

    Route::post('viewer/cases/list', 'Api\ViewerCaseTypesController@index');
    Route::post('viewer/cases/add', 'Api\ViewerCaseTypesController@store');
    
    Route::post('cards/list', 'Api\CardsController@index');
    Route::post('cards/add', 'Api\CardsController@store');
    Route::post('cards/main', 'Api\CardsController@main');
    Route::post('cards/get', 'Api\CardsController@show');
    Route::post('cards/delete', 'Api\CardsController@destroy');
    Route::post('card/items/list', 'Api\CardsController@itemsList');
    Route::post('card/items/add', 'Api\CardsController@itemAdd');
    Route::post('card/items/delete', 'Api\CardsController@itemDestroy');

    Route::post('profile/get', 'Api\ProfileController@get');
    Route::post('profile/current', 'Api\ProfileController@getCurrent');

    Route::post('subscriptionplans/list', 'Api\SubscribeController@listSubscriptionPlans');
    Route::post('monthplans/list', 'Api\SubscribeController@listMonthPlans');

    Route::post('signedviewers/myviewers/list', 'Api\SignedViewersController@myViewersList');
    Route::post('signedviewers/mystreamers/list', 'Api\SignedViewersController@myStreamersList');
    Route::post('signedviewers/add', 'Api\SignedViewersController@store');
    Route::post('signedviewers/delete', 'Api\SignedViewersController@destroy');

    Route::post('afiliates/mylist', 'Api\AfiliateController@mylist');
    Route::get('afiliate/{id}', 'Api\AfiliateController@visiter');

    Route::post('games/list', 'Api\GamesController@list');

    Route::post('notifications/list', 'Api\NotificationsController@list');

    Route::post('achivements/list', 'Api\AchivementsController@list');
    Route::post('achivements/card', 'Api\AchivementsController@card');
    Route::post('achivements/add', 'Api\AchivementsController@addProgress');

    Route::post('content/show', 'Api\ContentManagementController@show');
    Route::post('streamers/main/show', 'Api\MainStreamersManagementController@show');
    Route::post('activity/update', 'Api\ActivitiesController@update');

    Route::post('sms/code/get', 'Api\SmsController@getSms');
    Route::post('sms/code/check', 'Api\SmsController@checkCode');

    Route::post('roulette/channels/get', 'Api\ChannelsController@randomChannels');

    Route::post('diamonds/list', 'Api\DiamondsController@index');
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

    Route::post('cases/types/list', 'Api\CaseTypesManagementController@index');
    Route::post('cases/types/store', 'Api\CaseTypesManagementController@store');
    Route::post('cases/types/get', 'Api\CaseTypesManagementController@show');
    Route::post('cases/types/update', 'Api\CaseTypesManagementController@update');
    Route::post('cases/types/delete', 'Api\CaseTypesManagementController@destroy');

    Route::post('cases/list', 'Api\CasesManagementController@index');
    Route::post('cases/store', 'Api\CasesManagementController@store');
    Route::post('cases/get', 'Api\CasesManagementController@show');
    Route::post('cases/update', 'Api\CasesManagementController@update');
    Route::post('cases/delete', 'Api\CasesManagementController@destroy');
    Route::post('cases/item/delete', 'Api\CasesManagementController@deleteItem');
    Route::post('cases/item/add', 'Api\CasesManagementController@addItem');
    Route::post('cases/item/list', 'Api\CasesManagementController@itemsList');

    Route::post('contact/types/list', 'Api\ContactTypesManagementController@index');
    Route::post('contact/types/store', 'Api\ContactTypesManagementController@store');
    Route::post('contact/types/get', 'Api\ContactTypesManagementController@show');
    Route::post('contact/types/update', 'Api\ContactTypesManagementController@update');
    Route::post('contact/types/delete', 'Api\ContactTypesManagementController@destroy');

    Route::post('streamers/promoted/get', 'Api\PromotedStreamersManagementController@show');
    
    Route::post('streamers/promoted/add', 'Api\PromotedStreamersManagementController@store');
    Route::post('streamers/promoted/delete', 'Api\PromotedStreamersManagementController@delete');

    Route::post('streamers/main/store', 'Api\MainStreamersManagementController@store');
    Route::post('streamers/main/list', 'Api\MainStreamersManagementController@list');
    Route::post('streamers/main/delete', 'Api\MainStreamersManagementController@delete');
    Route::post('streamers/main/update', 'Api\MainStreamersManagementController@update');
    
    Route::post('content/store', 'Api\ContentManagementController@store');

    Route::post('streamers/subscribe/admin', 'Api\SubscribeController@adminSubscribe');
    
    Route::post('store/prizes/list', 'Api\StockPrizesController@index');
    Route::post('store/prizes/store', 'Api\StockPrizesController@store');
    Route::post('store/prizes/update', 'Api\StockPrizesController@update');
    Route::post('store/prizes/delete', 'Api\StockPrizesController@destroy');

    Route::post('diamonds/store', 'Api\DiamondsController@store');
    Route::post('diamonds/update', 'Api\DiamondsController@update');
    Route::post('diamonds/delete', 'Api\DiamondsController@destroy');
});

// bot routes
Route::group([
    'middleware' => ['api'],
], function ($router) {
    Route::post('bot/', 'Api\BotController@getEvent');
});

// Route::post('api/bot/', 'Api\BotController@getEvent');