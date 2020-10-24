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
Route::post("/kyclist", "ApiController@kyclist")->name("kyclist");
Route::post("/kyclist/create", "ApiController@kyclist_create")->name("kyclist-create");
Route::post("/account/get", "ApiController@account_get");

// for admin deletes
Route::post("/account/delete", "ApiController@account_delete");
Route::post("/blacklist/delete", "ApiController@blacklist_delete");

// unauthenticated api
Route::post("/kyclist/update", function(Request $request) {
    $body = $request->input("body");
    $kid = $body["kid"];
    $lid = $body["lid"];
    $kyc = \App\KnowYourClient::where("id", $lid)->where("uuid_kyc", $kid)->get()->first();
    if(!$kyc){
        // TODO log kyc update
        // TODO LOG::alert()

        return response()->json([
            'status' => "error",
        ]);
    }else{
        // perform an update
        $kyc->passbase_authKey = $body["authKey"];
        $kyc->save();

        return response()->json([
            'status' => "success",
        ]);

    }
});

Route::post("/kyclist/get", function(Request $request) {
    $body = $request->input("body");
    $id = $body["authKey"];
    $client = new GuzzleHttp\Client([
        'base_uri' => 'https://api.passbase.com/api/v1/',
        'headers' => [
            'Authorization' => config("_passbase.passbase_key"),
            'Accept' => 'application/json',
        ]
    ]);
    $json_body = [];
    try {
        $response = $client->request('GET', "authentications/by_key/{$id}");
        $body = $response->getBody()->getContents();
        $json_body = json_decode($body);
    } catch( Exception $exception) {
        return response()->json([
            'status' => "error",
            "message" => json_encode($exception),
        ]);
    }

    return response()->json([
        'status' => "success",
        "message" => $json_body,
    ]);

    // TODO version 2
//        $config = Passbase\Configuration::getDefaultConfiguration()->setApiKey("X-API-KEY", env("PASSBASE_SECRET_KEY"));
//        $apiInstance = new Passbase\api\IdentityApi(
//            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
//            // This is optional, `GuzzleHttp\Client` will be used as default.
//            new GuzzleHttp\Client(),
//            $config
//        );
//        $id = $body["authKey"]; // string | Unique ID of the identity to return
//
//        try {
//            $result = $apiInstance->getIdentyById($id);
//            return response()->json([
//                'status' => "success",
//                'data' => json_encode($result)
//            ]);
//        } catch (Exception $e) {
//            return response()->json([
//                'error' => "error",
//            ]);
//        }
});

// for debugging
Route::post("/debug", function(Request $request) {
    $id = "38431cd2-af16-41f0-8069-eba5734dbbd3";

    $client = new GuzzleHttp\Client([
        'base_uri' => 'https://api.passbase.com/api/v1/',
        'headers' => [
            'Authorization' => config("_passbase.passbase_key"),
            'Accept' => 'application/json',
        ]
    ]);
    $json_body = [];
    try {
        $response = $client->request('GET', "authentications/by_key/{$id}");
        $body = $response->getBody()->getContents();
        $json_body = json_decode($body);
    } catch( Exception $exception) {
        return response()->json([
            'status' => "error",
            "message" => json_encode($exception),
        ]);
    }

    return response()->json([
        'status' => "success",
        "message" => $json_body,
    ]);
});
