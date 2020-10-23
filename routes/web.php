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
    'middleware' => 'is_admin'
], function() {
    // for accounts
    Route::get('/accounts', 'AccountController@index')->name('accounts');
    Route::post('/accounts/create', 'AccountController@accountsCreate')->name('accounts-create');
    Route::get('/accounts/{user}/privilege', 'AccountController@accountsRole')->name('accounts-create-roles');
    Route::post('/accounts/{user}/privilege/update', 'AccountController@accountsRoleUpdate')->name('accounts-create-roles-update');

    // for organization
    Route::get('/organization', 'HomeController@organization')->name('organization');
    Route::post('/organization/create', 'OrganizationController@create')->name('organization-create');

    // for blacklisted
    Route::post('/blacklist/create', 'BlacklistUserController@create')->name('blacklist-create');

    // for submitted tickets
    Route::get('/ticketlist', 'HomeController@ticketlist')->name('ticketlist');
    Route::get('/ticketlist/{uuid_ticket}/{id}', 'TicketController@view_ticket')->name('view_ticket');

    // for KYC
    Route::get('/kyc-admin', 'KnowYourClientController@kyc_list')->name('kyc-admin');
});

// for KYC
Route::get('/kyc/{uuid_kyc}', 'KnowYourClientController@index')->name('kyc-home');


// for debugging
Route::get("/debug", function() {
    return redirect()->temporarySignedRoute('kyc-home', now()->addMinutes(120), [ "123456"]);
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
