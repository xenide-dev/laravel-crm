<?php

namespace App\Http\Controllers;

use App\Mail\MailConfirmation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Mockery\Exception;
use Swift_TransportException;

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
        $data["full_name"] = $data["fname"] . " " . $data["mname"] . " " . $data["lname"];
        $data["password"] = Hash::make($rand_pass);

        // to avoid mass assignable vulnerability
        $user = User::create($data);
        $user->user_type = $user_type;
        $user->api_token = Hash::make(now());
        $user->ign = $request->input("ign");
        $user->save();

        if($request->input("telegram") != ""){
            $user->contactInfo()->create([
                "name" => "telegram",
                "value" => $request->input("telegram")
            ]);
        }
        if($request->input("whatsapp") != ""){
            $user->contactInfo()->create([
                "name" => "whatsapp",
                "value" => $request->input("whatsapp")
            ]);
        }

        // populate the user's permission
        // by default all
        // get the config in _privileges.php
        $configs = config("_privileges.urls");
        foreach ($configs as $config){
            foreach ($config["access"] as $access){
                // filter the privilege based on user type
                if($config["type"] == $user_type || $config["type"] == "all"){
                    $user->userPermission()->create([
                        "name" => $config["name"],
                        "slug" => Str::slug($access . " " . $config["name"])
                    ]);
                }
            }
        }


        // send notification message thru email
        if($request->is_send_confirmation){
            // TODO notify
            try {
                Mail::to($user->email)->send(new MailConfirmation($user));
            }catch (Swift_TransportException $e) {
                dump($e);
            }
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
        $notified = false;

        // clear the assoc records
        $user->userPermission()->delete();

        // get the configs
        $configs = config("_privileges.urls");

        // repopulate
        foreach ($configs as $config) {
            $temp = $request->input($config["name"]);
            if($temp){
                foreach ($temp as $access) {
                    $user->userPermission()->create([
                        "name" => $config["name"],
                        "slug" => $access . "-" . $config["name"]
                    ]);
                }
            }
        }

        // TODO notify the user
        try{
//            Mail::to($user->email)->send(new MailConfirmation($user));
        }catch(Swift_TransportException $e){
            dump($e);
        }

        return redirect()->route("accounts")->with([
            "event" => "updated",
            "notified" => $notified
        ]);
    }
}
