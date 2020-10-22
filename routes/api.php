<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post("/list/accounts", "ApiController@list_accounts")->name("list-accounts");
Route::post("/list/organizations", "ApiController@list_organizations")->name("list-organizations");
Route::post("/list/blacklisted", "ApiController@list_blacklisted")->name("list-blacklisted");
Route::post("/list/tickets", "ApiController@list_tickets")->name("list-tickets");
Route::post("/basicload/reported", "ApiController@basic_reported")->name("basic-reported");

// for organization
Route::post("/basicload/organizations", "ApiController@basic_organizations")->name("basic-organizations");
Route::post("/organization/create", "ApiController@create_organization")->name("create-organizations");

// for reported user
Route::post("/reported_user/create", "ApiController@create_reported_user")->name("create-reported-user");


// for admin
Route::post("/ticketlist", "ApiController@ticketlist")->name("ticketlist");
