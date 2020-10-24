<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'prevent-back-history']);
    }

    public function index()
    {
        return view('home');
    }

    public function directory()
    {
        if (Gate::denies('view-directory')) {
            dd("denies");
        }
        return view('directory');
    }

    public function tickets() {
        if (Auth::user()->user_type != "user") {
            dd("for user only");
        }
        return view("tickets");
    }

    public function informationRequest() {
        return view("information-request");
    }

    public function profile() {
        return view("user.profile");
    }

    public function organization() {
        return view("organization");
    }

    public function ticketlist() {
        return view("ticketlist");
    }
}
