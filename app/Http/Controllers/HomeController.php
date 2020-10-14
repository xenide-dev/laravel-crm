<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function directory()
    {
        return view('directory');
    }

    public function accounts()
    {
        return view('accounts');
    }

    public function accountsCreate(Request $request)
    {
        dump($request);
    }
}
