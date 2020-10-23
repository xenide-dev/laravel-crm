<?php

namespace App\Http\Controllers;

use App\KnowYourClient;
use Illuminate\Http\Request;

class KnowYourClientController extends Controller
{
    public function index($uuid_kyc, KnowYourClient $knowYourClient, Request $request) {
        if(!$request->hasValidSignature()) {
            dd("invalid");
        }
        if($knowYourClient->isDone == 1) {
            return redirect()->route("home");
        }

        $kyc = $knowYourClient;

        return view("kyc.index", compact("uuid_kyc"), compact("kyc"));
    }

    public function kyc_list(){
        return view("kyc.admin.list");
    }

    public function submit($uuid_kyc, KnowYourClient $knowYourClient, Request $request) {
        $knowYourClient->email = $request->input("email");
        $knowYourClient->id_number = $request->input("id_number");
        $knowYourClient->ign = $request->input("ign");
        $knowYourClient->club_id = $request->input("club_id");
        $knowYourClient->union_id = $request->input("union_id");
        $knowYourClient->full_name = sprintf("%s %s %s %s", ucwords($request->input("fname")), ucwords($request->input("mname")), ucwords($request->input("lname")), ucwords($request->input("suffix")));
        $knowYourClient->fname = ucwords($request->input("fname"));
        $knowYourClient->mname = ucwords($request->input("mname"));
        $knowYourClient->lname = ucwords($request->input("lname"));
        $knowYourClient->suffix = ucwords($request->input("suffix"));
        $knowYourClient->phone_number = ucwords($request->input("phone_number"));
        $knowYourClient->device_ip = $request->ip();
        $knowYourClient->status = "Submitted";
        $knowYourClient->isDone = 1;
        $knowYourClient->save();

        return view("kyc.done");
    }
}
