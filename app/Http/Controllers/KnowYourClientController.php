<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnowYourClientController extends Controller
{
    public function index($uuid_kyc, Request $request) {
        if(!$request->hasValidSignature()) {
            dd("invalid");
        }
        return view("kyc.index");
    }

    public function kyc_list(){
        return view("kyc.admin.list");
    }
}
