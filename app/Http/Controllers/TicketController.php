<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'prevent-back-history']);
    }

    public function create(Request $request) {
        $data = $request->validate([
            'message' => ['required'],
            'subjects' => ['required'],
        ]);
        $input_names = $fullNames = "";
        if($request->input("full_names")){
            $fullNames = json_decode($request->input("full_names"));
            $input_names = "";
            foreach ($fullNames as $fullName) {
                $input_names .= ucwords($fullName->value) . ", ";
            }
        }


        $data["status"] = "Pending";
        $data["input_names"] = $input_names;
        $data["user_id"] = auth()->user()->id;
        $data["uuid_ticket"] = Str::uuid();
        $ticket = Ticket::create($data);

        if($fullNames != "") {
            foreach ($fullNames as $fullName){
                // existing
                if(isset($fullName->id)){
                    $nestData["reported_user_id"] = $fullName->id;
                    $nestData["status"] = "Pending";
                    $ticket->ticket_item()->create($nestData);
                }else{
                    // change ticket status to reviewed if done adding by admin
                    // manual adding by admin
                }
            }
        }
        return redirect()->route("tickets")->with([
            "status" => "success",
        ]);
    }

    public function view_ticket($uuid_ticket, $id){
        $ticket = Ticket::with("user", "ticket_item")->where("id", $id)->where("uuid_ticket", $uuid_ticket)->get()->first();
        if($ticket){
            $input_names = explode(",", trim($ticket->input_names));
            return view("ticketlist-detail", compact("ticket"), compact("input_names"));
        }else{
            // TODO "url modified"
            // TODO Log::alert()
        }
    }
}
