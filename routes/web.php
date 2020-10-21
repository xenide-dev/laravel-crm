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
});

Route::get("/debug", function() {
    $blacklist = \App\BlacklistUser::find(1);
    $orgs = $blacklist->userOrganization()->get();
    foreach ($orgs as $org){

    }
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
