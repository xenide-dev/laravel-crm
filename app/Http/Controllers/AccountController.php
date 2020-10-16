<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::denies('view-accounts')) {
            dd("denies");
        }
        return view('accounts');
    }

    public function accountsCreate(Request $request)
    {
        $data = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'suffix' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255', 'unique:users'],
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

        // populate the user's permission
        // by default all
        // get the config in _privileges.php
        $configs = config("_privileges.urls");
        foreach ($configs as $config){
            foreach ($config["access"] as $access){
                $user->userPermission()->create([
                    "name" => $config["name"],
                    "slug" => Str::slug($access . " " . $config["name"])
                ]);
            }
        }


        // send notification message thru email
        if($request->is_send_confirmation){
            // TODO


            $notified = true;
        }


        if(isset($request->is_modify_role)){
            // redirect to modify role page
            // update the expiry time
            return redirect()->temporarySignedRoute('accounts-create-roles', now()->addMinutes(60), [$user]);
//            return redirect()->route("accounts-create-roles", [$user]);
        }else{
            // redirect to account page
            return redirect()->route("accounts")->with([
                "temp_pass" => $rand_pass,
                "status" => "success",
                "notified" => $notified
            ]);
        }
    }

    public function accountsRole(User $user, Request $request){
        if(!$request->hasValidSignature()){
            // invalid signature
            // TODO: Log::alert
            // TODO: redirect to error page
        }else{
            $configs = config("_privileges.urls");
            return view("accounts-role", compact("user"), compact("configs"));
        }
    }

    public function accountsRoleUpdate(User $user, Request $request) {
        dump($user);
        dump($request);
    }
}
