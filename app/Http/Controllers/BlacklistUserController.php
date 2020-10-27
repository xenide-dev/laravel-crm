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
        if($request->input("id_number")){
            $data = $request->validate([
                'id_number' => ['unique:blacklist_users,id_number,NULL,id,deleted_at,NULL'],
            ]);
        }else{
            $data = array();
        }


        $fname = $mname = $lname = "";
        if($request->input("fname")){
            $data["fname"] = ucwords($request->input("fname"));
        }
        if($request->input("mname")){
            $data["mname"] = ucwords($request->input("mname"));
        }
        if($request->input("lname")){
            $data["lname"] = ucwords($request->input("lname"));
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
        if($request->input("ign")){
            $data["ign"] = $request->input("ign");
        }
        if($request->input("country")){
            $data["country"] = $request->input("country");
        }
        if($request->input("banned_date")){
            $data["banned_date"] = $request->input("banned_date");
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
        if($request->input("instagram")){
            $blacklist->blacklistContactInfo()->create([
                "name" => "instagram",
                "value" => $request->input("instagram"),
            ]);
        }
        if($request->input("venmo")){
            $blacklist->blacklistContactInfo()->create([
                "name" => "venmo",
                "value" => $request->input("venmo"),
            ]);
        }
        if($request->input("cashapp")){
            $blacklist->blacklistContactInfo()->create([
                "name" => "cashapp",
                "value" => $request->input("cashapp"),
            ]);
        }
        if($request->input("paypal")){
            $blacklist->blacklistContactInfo()->create([
                "name" => "paypal",
                "value" => $request->input("paypal"),
            ]);
        }

        // if org exist
        if($request->input("org")){
            foreach ($request->input("org") as $org){
                if($org["org_name"]){
                    $blacklist->userOrganization()->create([
                        "organization_id" => $org["org_name"],
                        "organization_position" => implode("|", $org["org_position"])
                    ]);
                }
            }
        }

        // TODO notify all user to the newly added blacklist

        return redirect()->route("directory")->with([
            "status" => "success"
        ]);
    }

    public function update(Request $request) {
        // TODO
        $b = BlacklistUser::where("id_number", $request->input("id_number"))->get()->first();
        $data = $request->validate([
            'id_number' => ['unique:blacklist_users,id_number,' . $b->id],
        ]);
        $fname = $mname = $lname = "";
        if($request->input("fname")){
            $data["fname"] = ucwords($request->input("fname"));
        }
        if($request->input("mname")){
            $data["mname"] = ucwords($request->input("mname"));
        }
        if($request->input("lname")){
            $data["lname"] = ucwords($request->input("lname"));
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
        if($request->input("ign")){
            $data["ign"] = $request->input("ign");
        }
        if($request->input("country")){
            $data["country"] = $request->input("country");
        }
        if($request->input("banned_date")){
            $data["banned_date"] = $request->input("banned_date");
        }
        $data["full_name"] = ucwords(sprintf("%s %s %s", $fname, $mname, $lname));

        $blacklist = BlacklistUser::where("id", $b->id)->update($data);

        // add contact infos
        if($request->input("telegram")){
            $b->blacklistContactInfo()->where("name", "telegram")->update([
                "value" => $request->input("telegram"),
            ]);
        }
        if($request->input("facebook")){
            $b->blacklistContactInfo()->where("name", "facebook")->update([
                "value" => $request->input("facebook"),
            ]);
        }
        if($request->input("twitter")){
            $b->blacklistContactInfo()->where("name", "twitter")->update([
                "value" => $request->input("twitter"),
            ]);
        }
        if($request->input("whatsapp")){
            $b->blacklistContactInfo()->where("name", "whatsapp")->update([
                "value" => $request->input("whatsapp"),
            ]);
        }
        if($request->input("instagram")){
            $b->blacklistContactInfo()->where("name", "instagram")->update([
                "value" => $request->input("instagram"),
            ]);
        }
        if($request->input("venmo")){
            $b->blacklistContactInfo()->where("name", "venmo")->update([
                "value" => $request->input("venmo"),
            ]);
        }
        if($request->input("cashapp")){
            $b->blacklistContactInfo()->where("name", "cashapp")->update([
                "value" => $request->input("cashapp"),
            ]);
        }
        if($request->input("paypal")){
            $b->blacklistContactInfo()->where("name", "paypal")->update([
                "value" => $request->input("paypal"),
            ]);
        }


        return redirect()->route("directory")->with([
            "status-update" => "success"
        ]);
    }
}
