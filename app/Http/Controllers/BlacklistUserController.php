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
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'unique:blacklist_users'],
        ]);

        $data["fname"] = ucwords($data["fname"]);
        $data["mname"] = ucwords($data["mname"]);
        $data["lname"] = ucwords($data["lname"]);
        $data["full_name"] = ucwords(sprintf("%s %s %s", $data["fname"], $data["mname"], $data["lname"]));

        $blacklist = BlacklistUser::create($data);
        $blacklist->added_by_id = auth()->user()->id;
        $blacklist->save();

        foreach ($request->input("org") as $org){
            $blacklist->userOrganization()->create([
                "organization_id" => $org["org_name"],
                "organization_position" => implode("|", $org["org_position"])
            ]);
        }

        // TODO notify all user to the newly added blacklist

        return redirect()->route("directory")->with([
            "status" => "success"
        ]);
    }
}
