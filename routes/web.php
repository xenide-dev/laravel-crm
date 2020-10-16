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
    $users = User::find("23");
    if($users->userPermission()->where("slug", "view-directory")->count() > 0){
        dump("y");
    }else{
        dump("n");
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
