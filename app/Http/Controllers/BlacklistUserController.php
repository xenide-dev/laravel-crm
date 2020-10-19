<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlacklistUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request) {
        dd($request);
    }
}
