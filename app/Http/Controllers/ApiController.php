<?php

namespace App\Http\Controllers;

use App\BlacklistUser;
use App\KnowYourClient;
use App\Organization;
use App\ReportedUser;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function __construct() {
        $this->middleware("auth:api");
    }

    public function list_accounts(Request $request){
        $columns = array(
            0 =>'id_number',
            1 =>'fname',
            2 => 'mname',
            3 => 'lname',
            4 => 'email',
            5 => 'user_type',
            6 => 'last_online_at',
        );

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $users = User::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $users =  User::where('id_number','LIKE',"%{$search}%")
                ->orWhere('fname', 'LIKE',"%{$search}%")
                ->orWhere('mname', 'LIKE',"%{$search}%")
                ->orWhere('lname', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('user_type', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

//            $totalFiltered = User::where('id','LIKE',"%{$search}%")
//                ->orWhere('fname', 'LIKE',"%{$search}%")
//                ->count();
            $totalFiltered = $users->count();
        }

        $data = array();
        if(!empty($users))
        {
            foreach ($users as $user)
            {
//                $show =  route('posts.show',$user->id);
//                $edit =  route('posts.edit',$user->id);
                $show =  '';
                $edit =  '';

                $nestedData['id_number'] = $user->id_number;
                $nestedData['fname'] = $user->fname;
                $nestedData['mname'] = $user->mname;
                $nestedData['lname'] = $user->lname;
                $nestedData['email'] = $user->email;
                $nestedData['user_type'] = $user->user_type;
                $nestedData['iM'] = auth()->user()->id == $user->id;
                $nestedData['id'] = $user->id;
                // config("app.key") is used for added security
                $nestedData['id_key'] = Hash::make($user->id . config("app.key"));

                $nestedData['last_online_at'] = (auth()->user()->id == $user->id) ?
                    "<span class='label label-pill label-inline label-info'>You</span>" :
                    (!empty($user->lastSeen) ?
                        "<span class='label label-pill label-inline label-success'>" . $user->lastSeen->diffForHumans() . "</span>" :
                        "<span class='label label-pill label-inline label-primary' data-container='body' data-toggle='tooltip' data-placement='top' title='" . (($user->temp_password) ? $user->temp_password : $user->email) . "'>New</span>"
                    );
//                $nestedData['body'] = substr(strip_tags($post->body),0,50)."...";
//                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
//                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function list_organizations(Request $request) {
        $columns = array(
            0 =>'id',
            1 =>'id_number',
            2 =>'name',
            3 => 'type',
            4 => 'added_by_id',
        );

        $totalData = Organization::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $organizations = Organization::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $organizations =  Organization::where('name','LIKE',"%{$search}%")
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('id_number', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = $organizations->count();
        }

        $data = array();
        if(!empty($organizations))
        {
            foreach ($organizations as $organization)
            {
//                $show =  route('posts.show',$user->id);
//                $edit =  route('posts.edit',$user->id);
                $show =  '';
                $edit =  '';
                $added_by = User::where("id", $organization->added_by_id)->get()->first();

                $nestedData['id'] = $organization->id;
                $nestedData['id_number'] = $organization->id_number;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($organization->created_at));
                $nestedData['name'] = $organization->name;
                $nestedData['type'] = $organization->type;
                $nestedData['added_by'] = $added_by->fname . " " . $added_by->lname;
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
//                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function list_blacklisted(Request $request) {
        $columns = array(
            0 =>'id_number',
            1 =>'name',
            2 =>'organization',
            3 => 'added_by',
        );

        $totalData = BlacklistUser::count();

        $totalFiltered = $totalData;

        if(empty($request->input('search.value')))
        {
            $blacklists = BlacklistUser::get();
        }
        else {
            $search = $request->input('search.value');

            $blacklists =  BlacklistUser::where('fname','LIKE',"%{$search}%")
                ->orWhere('mname', 'LIKE',"%{$search}%")
                ->orWhere('lname', 'LIKE',"%{$search}%")
                ->orWhere('id_number', 'LIKE',"%{$search}%")
                ->orWhere('position', 'LIKE',"%{$search}%")
                ->get();

            $totalFiltered = $blacklists->count();
        }

        $data = array();
        if(!empty($blacklists))
        {
            foreach ($blacklists as $blacklist)
            {
//                $show =  route('posts.show',$user->id);
//                $edit =  route('posts.edit',$user->id);
                $show =  '';
                $edit =  '';
                $added_by = User::where("id", $blacklist->added_by_id)->get()->first();

                $nestedData['id'] = $blacklist->id;
                $nestedData['id_key'] = Hash::make($blacklist->id . config("app.key"));
                $nestedData['id_number'] = $blacklist->id_number;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($blacklist->banned_date));
                $nestedData['name'] = $blacklist->fname . " " . $blacklist->mname . " " . $blacklist->lname;
                $nestedData['organizations'] = "";
                // get the organization
                $orgs = $blacklist->userOrganization()->get();
                foreach ($orgs as $org){
                    $org_details = $org->organization()->get()->first();
                    $type_color = "";
                    if($org_details->type == "Union") $type_color = "label-info";
                    if($org_details->type == "Club") $type_color = "label-primary";
                    if($nestedData['organizations'] == ""){
                        $nestedData['organizations'] = "<span class='label {$type_color} label-inline'>{$org_details->type}</span> " . " (" . $org_details->id_number . ") " . $org_details->name . " [" . $org->organization_position . "]<br/> ";
                    }else{
                        $nestedData['organizations'] .= "<span class='label {$type_color} label-inline'>{$org_details->type}</span> " . " (" . $org_details->id_number . ") " . $org_details->name . " [" . $org->organization_position . "]<br/> ";
                    }
                }
                $nestedData['added_by'] = $added_by->fname . " " . $added_by->lname;
                $nestedData['user_type'] = Auth::guard("api")->user()->user_type;
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
//                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function basic_organizations(Request $request) {
        $data = Organization::get();
        echo json_encode($data);
    }

    public function basic_reported(Request $request) {
        $reports = ReportedUser::where("isAddedToBlacklist", 0)->get();
        $data = array();
        foreach ($reports as $report){
            $nestedData["id"] = $report->id;
            $nestedData["value"] = $report->full_name;
            $nestedData["id_number"] = $report->id_number;
            $nestedData["active_case"] = $report->reports()->count();
            $nestedData["class"] = "tagify__tag--primary";
            $data[] = $nestedData;
        }
        echo json_encode($data);
    }

    public function list_tickets(Request $request) {
        $totalData = Ticket::count();

        $totalFiltered = $totalData;

        $tickets = Ticket::where("user_id", auth()->user()->id)->get();

        $data = array();
        if(!empty($tickets))
        {
            foreach ($tickets as $ticket)
            {
                $show =  '';
                $edit =  '';

                $nestedData['id'] = $ticket->id;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($ticket->created_at));
                $nestedData['input_names'] = $ticket->input_names;
                $nestedData['status'] = "<span class='label label-warning label-inline'>$ticket->status</span>";
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
//                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function ticketlist(Request $request) {
        $totalData = Ticket::count();

        $totalFiltered = $totalData;

        $tickets = Ticket::with("ticket_item")->where("status","Pending")->get();

        $data = array();
        if(!empty($tickets))
        {
            foreach ($tickets as $ticket)
            {
                $show =  '';
                $edit =  '';
                $input_names_count = count(explode(",", trim($ticket->input_names))) - 1;
                $nestedData['id'] = $ticket->id;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($ticket->created_at));
                $nestedData['from'] = $ticket->user->full_name;
                $nestedData['input_names'] = $ticket->input_names;
                $nestedData['uuid_ticket'] = $ticket->uuid_ticket;
                $nestedData['other_info'] = "";
                $diff = $input_names_count - $ticket->ticket_item->count();
                if($input_names_count > $ticket->ticket_item->count()){
                    $nestedData['other_info'] = "<span class='label label-primary label-inline'>{$diff} new name/s</span>";
                }
                $nestedData['status'] = "<span class='label label-warning label-inline'>$ticket->status</span>";
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
//                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function create_organization(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', "unique:organizations"],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $data["name"] = ucwords($data["name"]);
        $data["added_by_id"] = Auth::guard("api")->user()->id;
        $org = Organization::create($data);

        $json_data = array(
            "status" => "success",
        );

        echo json_encode($json_data);
    }

    public function create_reported_user(Request $request) {
        dd($request);
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'unique:reported_users'],
        ]);

        $data["full_name"] = ucwords($data["full_name"]);
        $reported_user = ReportedUser::create($data);
        $reported_user->added_by_id = auth()->user()->id;
        $reported_user->save();

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

    public function kyclist(Request $request) {
        $totalData = KnowYourClient::with("user")->count();

        $totalFiltered = $totalData;

        $kyclists = KnowYourClient::get();

        $data = array();
        if(!empty($kyclists))
        {
            foreach ($kyclists as $kyclist)
            {
                $show =  '';
                $edit =  '';
                $nestedData['id'] = $kyclist->id;
                $nestedData['auth_id_partial'] = substr($kyclist->uuid_kyc, 0, 6) . "...";
                $nestedData['auth_id'] = $kyclist->uuid_kyc;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($kyclist->created_at));
                $nestedData['id_number'] = $kyclist->id_number;
                $nestedData['name'] = $kyclist->full_name;
                $unions = "";
                $clubs = "";
                if($kyclist->union_id){
                    $unions = $kyclist->union_id;
                }
                if($kyclist->club_id){
                    $clubs = $kyclist->club_id;
                }
                $organization = "";
                if($unions != ""){
                    $organization .= $unions . " | ";
                }
                if($clubs != ""){
                    $organization .= $clubs;
                }
                $nestedData['organization'] = $organization;
                $nestedData['completed'] = ($kyclist->isDone == 1) ? "Yes" : "No";
                // TODO Maybe send a request to passbase using the authkey
                $nestedData['passbase_status'] = "TODO";
                $nestedData['added_by_id'] = $kyclist->user->fname . " " . $kyclist->user->lname;
                $nestedData['url'] = URL::temporarySignedRoute('kyc-link', now()->addMinutes(120) ,[ $kyclist->uuid_kyc, $kyclist->id ]);
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
//                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function kyclist_create(Request $request) {
        $user = Auth::guard("api")->user();

        $data["uuid_kyc"] = Str::uuid();
        $kyc = $user->kyc()->create($data);

        $json_data = array(
            "status"          => "success",
            "data"            => $kyc
        );

        echo json_encode($json_data);
    }

    public function account_delete(Request $request) {
        $id = $request->input("id");
        $id_key = $request->input("id_key");

        // check if matched
        if(Hash::check($id . config("app.key"), $id_key)){
            $user = User::find($id);
            $user->delete();

            return response()->json([
                'status' => "success",
            ]);
        }else{
            // TODO LOG::alert()
            return response()->json([
                'status' => "error",
            ]);
        }
    }

    public function account_get(Request $request) {
        $id = $request->input("id");
        $id_key = $request->input("id_key");

        // check if matched
        if(Hash::check($id . config("app.key"), $id_key)){
            $user = User::with("contactInfo", "userOrganization")->find($id);
            $user->userOrganization->load("organization");

            return response()->json([
                'status' => "success",
                'user' => $user
            ]);
        }else{
            // TODO LOG::alert()
            return response()->json([
                'status' => "error",
            ]);
        }
    }

    public function blacklist_delete(Request $request) {
        $id = $request->input("id");
        $id_key = $request->input("id_key");

        // check if matched
        if(Hash::check($id . config("app.key"), $id_key)){
            $user = BlacklistUser::find($id);
            $user->delete();

            return response()->json([
                'status' => "success",
            ]);
        }else{
            // TODO LOG::alert()
            return response()->json([
                'status' => "error",
            ]);
        }
    }

    public function blacklist_get(Request $request) {
        $id = $request->input("id");
        $id_key = $request->input("id_key");

        // check if matched
        if(Hash::check($id . config("app.key"), $id_key)){
            $user = BlacklistUser::with("blacklistContactInfo", "userOrganization")->find($id);
            $user->userOrganization->load("organization");
            $banned_date = date('j M Y h:i a',strtotime($user->banned_date));
            return response()->json([
                'status' => "success",
                'user' => $user,
                'banned_date' => $banned_date,
            ]);
        }else{
            // TODO LOG::alert()
            return response()->json([
                'status' => "error",
            ]);
        }
    }
}
