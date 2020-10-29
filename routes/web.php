<?php

use App\User;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get("/", function() { // redirect route '/' to '/home'
   return redirect('/home');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/directory', 'HomeController@directory')->name('directory');
Route::get('/tickets', 'HomeController@tickets')->name('tickets');
Route::get('/information/request', 'HomeController@informationRequest')->name('information-request');

// profiles
Route::get('/profile', 'HomeController@profile')->name('profile');

// for tickets
Route::post('/ticket/create', 'TicketController@create')->name('ticket-create');

// admin routes
Route::group([
    'middleware' => ['is_admin', 'prevent-back-history']
], function() {
    // for accounts
    Route::get('/accounts', 'AccountController@index')->name('accounts');
    Route::post('/accounts/create', 'AccountController@accountsCreate')->name('accounts-create');
    Route::get('/accounts/{user}/privilege', 'AccountController@accountsRole')->name('accounts-create-roles');
    Route::post('/accounts/{user}/privilege/update', 'AccountController@accountsRoleUpdate')->name('accounts-create-roles-update');
    Route::get('/accounts/{user}/privilege/get', 'AccountController@accountsUpdatePrivilege')->name('accounts-update-privilege');

    // for organization
    Route::get('/organization', 'HomeController@organization')->name('organization');
    Route::post('/organization/create', 'OrganizationController@create')->name('organization-create');

    // for blacklisted
    Route::post('/blacklist/create', 'BlacklistUserController@create')->name('blacklist-create');
    Route::post('/blacklist/update', 'BlacklistUserController@update')->name('blacklist-update');

    // for submitted tickets
    Route::get('/ticketlist', 'HomeController@ticketlist')->name('ticketlist');
    Route::get('/ticketlist/{uuid_ticket}/{id}', 'TicketController@view_ticket')->name('view_ticket');
    Route::post('/reported_user/{uuid_ticket}/{id}/create', 'ReportedUserController@create_reported_user')->name('create_reported_user');

    // for KYC
    Route::get('/kyc-admin', 'KnowYourClientController@kyc_list')->name('kyc-admin');
});

// for KYC
Route::get('/kyc/{uuid_kyc}/{knowYourClient}', 'KnowYourClientController@index')->name('kyc-link');
Route::post('/kyc/{uuid_kyc}/{knowYourClient}/submit', 'KnowYourClientController@submit')->name('kyc-submit');


// for debugging
Route::get("/debug", function() {

    $client = new GuzzleHttp\Client([
        'base_uri' => 'https://api.passbase.com/api/v1/',
        'headers' => [
            'Authorization' => config("_passbase.passbase_key"),
            'Accept' => 'application/json',
        ]
    ]);
    $id = "38431cd2-af16-41f0-8069-eba5734dbbd3";
// Send a request to https://app.passbase.com/api/v1/authentications/by_key/{$key}
    $response = $client->request('GET', "authentications/by_key/{$id}");
// Store the response in variable
    $body = $response->getBody()->getContents();

    dd(json_decode($body));
});

Route::get("/test-notif", function() {
   \Illuminate\Support\Facades\Log::channel("slack-error")->error("error");
});

// for apis
//Route::group([
//    'prefix' => 'auth'
//], function () {
//    Route::post('login', 'AuthController@login');
//    Route::post('signup', 'AuthController@signup');
//
//    Route::group([
//        'middleware' => 'auth:api'
//    ], function() {
//        Route::get('logout', 'AuthController@logout');
//        Route::get('user', 'AuthController@user');
//    });
//});
