<?php

namespace App\Http\Controllers;

use App\ReportedUser;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ReportedUserController extends Controller
{
    public function create_reported_user($uuid_ticket, $id, Request $request) {
        $ticket = Ticket::where("uuid_ticket", $uuid_ticket)->where("id", $id)->get()->first();
        if($ticket){
            if($request->input("id_number")){
                $data = $request->validate([
                    'id_number' => ['unique:reported_users,id_number,NULL,id,deleted_at,NULL'],
                ]);
            }else{
                $data = array();
            }


            if($request->input("full_name")){
                $data["full_name"] = ucwords($request->input("full_name"));
            }
            if($request->input("other_info")){
                $data["other_info"] = $request->input("other_info");
            }else{
                $data["other_info"] = "";
            }

            $data["added_by_id"] = auth()->user()->id;
            $reported_user = ReportedUser::create($data);
            $reported_user->save();

            $report_item = $reported_user->reports()->create([
                'ticket_id' => $id,
                'status' => 'pending'
            ]);

            // if org exist
            if($request->input("org")){
                foreach ($request->input("org") as $org){
                    if($org["org_name"]){
                        $reported_user->userOrganization()->create([
                            "organization_id" => $org["org_name"],
                            "organization_position" => implode("|", $org["org_position"])
                        ]);
                    }
                }
            }

            return redirect()->route("view_ticket", [ $uuid_ticket , $id ])->with([
                "status" => "success"
            ]);
        }else{
            // modified
            // TODO LOG::alert()
        }
    }
}
