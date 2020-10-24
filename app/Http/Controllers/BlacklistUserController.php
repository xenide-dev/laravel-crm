<?php

namespace App\Http\Controllers;

use App\BlacklistUser;
use Illuminate\Http\Request;

class BlacklistUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request) {
        $data = $request->validate([
            'id_number' => ['required', 'unique:blacklist_users'],
            'banned_date' => ['required'],
        ]);

        $fname = $mname = $lname = "";
        if(isset($data["fname"])){
            $fname = ucwords($data["fname"]);
        }
        if(isset($data["mname"])){
            $mname = ucwords($data["mname"]);
        }
        if(isset($data["lname"])){
            $lname = ucwords($data["lname"]);
        }
        if($request->input("email")){
            $data["email"] = $request->input("email");
        }
        if($request->input("phone_number")){
            $data["phone_number"] = $request->input("phone_number");
        }
        if($request->input("notes")){
            $data["notes"] = $request->input("notes");
        }
        $data["full_name"] = ucwords(sprintf("%s %s %s", $fname, $mname, $lname));

        $blacklist = BlacklistUser::create($data);
        $blacklist->added_by_id = auth()->user()->id;
        $blacklist->save();

        // add contact infos
        if($request->input("telegram")){
            $blacklist->blacklistContactInfo()->create([
               "name" => "telegram",
               "value" => $request->input("telegram"),
            ]);
        }
        if($request->input("facebook")){
            $blacklist->blacklistContactInfo()->create([
                "name" => "facebook",
                "value" => $request->input("facebook"),
            ]);
        }
        if($request->input("twitter")){
            $blacklist->blacklistContactInfo()->create([
                "name" => "twitter",
                "value" => $request->input("twitter"),
            ]);
        }
        if($request->input("whatsapp")){
            $blacklist->blacklistContactInfo()->create([
                "name" => "whatsapp",
                "value" => $request->input("whatsapp"),
            ]);
        }

        // if org exist
        if($request->input("org")){
            foreach ($request->input("org") as $org){
                $blacklist->userOrganization()->create([
                    "organization_id" => $org["org_name"],
                    "organization_position" => implode("|", $org["org_position"])
                ]);
            }
        }

        // TODO notify all user to the newly added blacklist

        return redirect()->route("directory")->with([
            "status" => "success"
        ]);
    }
}
