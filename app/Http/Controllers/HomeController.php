<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $data = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'suffix' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user_type = "user";
        $notified = false;
        $rand_pass = Str::random(10);
        if(isset($request->mark_as_admin)){
            $user_type = "admin";
        }

        $data["temp_password"] = $rand_pass;
        $data["password"] = Hash::make($rand_pass);

        // to avoid mass assignable vulnerability
        $user = User::create($data);
        $user->user_type = $user_type;
        $user->api_token = Hash::make(now());
        $user->save();

        // send notification message thru email
        if($request->is_send_confirmation){
            // TODO


            $notified = true;
        }


        if(isset($request->is_modify_role)){
            // redirect to modify role page

        }else{
            // redirect to account page
            return redirect("/accounts")->with([
                "temp_pass" => $rand_pass,
                "status" => "success",
                "notified" => $notified
            ]);
        }
    }
}
