<?php

use App\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
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


// admin routes
Route::group([
    'middleware' => 'is_admin'
], function() {
    // for accounts
    Route::get('/accounts', 'AccountController@index')->name('accounts');
    Route::post('/accounts/create', 'AccountController@accountsCreate')->name('accounts-create');
    Route::get('/accounts/{user}/privilege', 'AccountController@accountsRole')->name('accounts-create-roles');
    Route::post('/accounts/{user}/privilege/update', 'AccountController@accountsRoleUpdate')->name('accounts-create-roles-update');


});

Route::get("/debug", function() {
    $user = User::find(1);
    Mail::to('newuser@example.com')->send(new \App\Mail\MailConfirmation($user));
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
