<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request) {
        $data = $request->validate([
            'message' => ['required'],
        ]);
        $fullNames = json_decode($request->input("full_names"));
        $input_names = "";
        foreach ($fullNames as $fullName) {
            $input_names .= ucwords($fullName->value) . ", ";
        }

        $data["status"] = "Pending";
        $data["input_names"] = $input_names;
        $data["user_id"] = auth()->user()->id;
        $ticket = Ticket::create($data);

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
        return redirect()->route("tickets")->with([
            "status" => "success",
        ]);
    }
}
