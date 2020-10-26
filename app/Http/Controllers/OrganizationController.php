<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        $data = $request->validate([
            'id_number' => ['required', "unique:organizations"],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $data["added_by_id"] = auth()->user()->id;
        if($request->input("name")){
            $data["name"] = ucwords($request->input("name"));
        }
        Organization::create($data);

        return redirect()->route("organization")->with([
            "status" => "success",
        ]);
    }
}
