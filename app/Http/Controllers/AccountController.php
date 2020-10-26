<?php

namespace App\Http\Controllers;

use App\Mail\MailConfirmation;
use App\Organization;
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
        if($request->input("id_number")){
            $data = $request->validate([
                'fname' => ['string', 'max:255'],
                'mname' => ['max:255'],
                'lname' => ['string', 'max:255'],
                'suffix' => ['max:255'],
                'id_number' => ['max:255', 'unique:users'],
                'phone_number' => ['required', 'string', 'max:255'],
                'country' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }else{
            $data = $request->validate([
                'fname' => ['string', 'max:255'],
                'mname' => ['max:255'],
                'lname' => ['string', 'max:255'],
                'suffix' => ['max:255'],
                'phone_number' => ['required', 'string', 'max:255'],
                'country' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }


        $user_type = "user";
        $notified = false;
        $rand_pass = Str::random(10);
        if(isset($request->mark_as_admin)){
            $user_type = "admin";
        }

        $data["temp_password"] = $rand_pass;
        $data["country"] = $request->input("country");
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
        if($request->input("venmo") != ""){
            $user->contactInfo()->create([
                "name" => "venmo",
                "value" => $request->input("venmo")
            ]);
        }
        if($request->input("cashapp") != ""){
            $user->contactInfo()->create([
                "name" => "cashapp",
                "value" => $request->input("cashapp")
            ]);
        }
        if($request->input("paypal") != ""){
            $user->contactInfo()->create([
                "name" => "paypal",
                "value" => $request->input("paypal")
            ]);
        }

        // retrieve orgs and save
        if($request->input("org")){
            foreach ($request->input("org") as $org){
                if($org["org_name"]){
                    $user->userOrganization()->create([
                        "organization_id" => $org["org_name"],
                        "organization_position" => implode("|", $org["org_position"])
                    ]);
                }

            }
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
                // TODO: Log::alert
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
             Mail::to($user->email)->send(new MailConfirmation($user));
        }catch(Swift_TransportException $e){
            dump($e);
        }

        return redirect()->route("accounts")->with([
            "event" => "updated",
            "notified" => $notified
        ]);
    }

    public function accountsUpdatePrivilege(User $user, Request $request) {
        if($request->input("isHide")){
            if($request->input("isHide") == 1){
                $isHide = 1;
                $configs = config("_privileges.urls");
                return view("accounts-role", compact("user"), compact("configs"), compact("isHide"));
            }else{
                // TODO Log::alert()
            }
        }else{
            // TODO Log::alert()
        }

    }
}
