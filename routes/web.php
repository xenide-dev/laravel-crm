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
    Route::get('/accounts', 'HomeController@accounts')->name('accounts');
});

Route::get("/debug", function() {
    $users = User::get();
    foreach ($users as $user) {
        dump("For " . $user->fname);
        dump(\Illuminate\Support\Facades\Cache::get("user-is-online-" . $user->id));
        dump(!empty($user->lastSeen) ? $user->lastSeen->diffForHumans() : "no record");
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
