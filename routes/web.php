<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Pages Route
Route::get('/', 'PagesController@main')->name('main');
Route::get('/games', 'PagesController@games');
Route::get('/game/{gameName}', 'PagesController@game');
Route::get('/stream-watch/{streamName}', 'PagesController@watchStream');
Route::get('/prizes', 'PagesController@allPrizes');
Route::get('/store/{caseId?}', 'PagesController@shop');
Route::get('/cabinet', 'PagesController@cabinet');
Route::get('/my-inventory', 'PagesController@myInventory');
Route::get('/upgrade', 'PagesController@upgrade');
Route::get('/profile/{streamName}', 'PagesController@profile');
Route::get('/redeem/{prizeId}', 'PagesController@redeem');

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => ['web', 'activity']], function () {

    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'RestoreUserController@userReActivate']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@show',
    ]);
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@deleteUserAccount',
    ]);

    // Routes to Subscribe
    Route::get('subscribe', 'SubscribeController@index');
    Route::post('subscribe', 'SubscribeController@makePayment');

    // Route to show user avatar
    // Route::get('images/profile/{id}/avatar/{image}', [
    //     'uses' => 'ProfilesController@userProfileAvatar',
    // ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity', 'twostep']], function () {
    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', 'UsersManagementController@search')->name('search-users');

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'AdminDetailsController@listRoutes');
    Route::get('active-users', 'AdminDetailsController@activeUsers');
});

Route::get('streams1', 'StreamController@streams1');
Route::get('streams2', 'StreamController@streams2');
Route::get('streams4', 'StreamController@streams4');

Route::get('twitch/redirect', 'Auth\SocialController@twitchRedirect');
Route::get('twitch/callback', 'Auth\SocialController@twitchCallback');

Route::redirect('/php', '/phpinfo', 301);

Route::get('/vue/{vue_capture?}', function () {
    return view('vue.index');
   })->where('vue_capture', '[\/\w\.-]*');

// Route::get('/video', 'VideoPageController');
// Route::get('/homepage', 'HomePageController');
// Route::get('/directory', 'DirectoryPageController');

Route::post('front/gettoken', 'Auth\SocialController@getToken');

// admin routes
Route::get('admin', 'AdminController@adminPage');

Route::post('paypal/pay', 'PayPalController@getExpressCheckout');
Route::get('paypal/success', 'PayPalController@getExpressCheckoutSuccess');
Route::post('paypal/notify', 'PayPalController@notify');
Route::post('paypal/notify2', 'PayPalController@notify2');
Route::get('start-stream/{token}', 'StreamController@startStream');
Route::post('liqpay/getform', 'LiqpayController@genSubscribeForm');
Route::post('liqpay/subscribe', 'LiqpayController@acceptSubscribe');

Route::post('stripe/subscribe', 'StripeController@subscribe');

Route::get('streamlabs/login', 'StreamlabsController@Login');
Route::get('streamlabs/oauth', 'StreamlabsController@Oauth');

