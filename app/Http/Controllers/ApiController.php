<?php

namespace App\Http\Controllers;

use App\BlacklistUser;
use App\Organization;
use App\ReportedUser;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;

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
                $nestedData['last_online_at'] = (auth()->user()->id == $user->id) ?
                    "<span class='label label-pill label-inline label-info'>You</span>" :
                    (!empty($user->lastSeen) ?
                        "<span class='label label-pill label-inline label-success'>" . $user->lastSeen->diffForHumans() . "</span>" :
                        "<span class='label label-pill label-inline label-primary'>New</span>"
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
            1 =>'name',
            2 => 'type',
            3 => 'added_by_id',
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

                $nestedData['id'] = $organization->id;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($organization->created_at));
                $nestedData['name'] = $organization->name;
                $nestedData['type'] = $organization->type;
                $nestedData['added_by'] = auth()->user()->fname . " " . auth()->user()->lname;
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

                $nestedData['id_number'] = $blacklist->id_number;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($blacklist->created_at));
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
                        $nestedData['organizations'] = "<span class='label {$type_color} label-inline'>{$org_details->type}</span> " . $org_details->name . " [" . $org->organization_position . "]<br/> ";
                    }else{
                        $nestedData['organizations'] .= "<span class='label {$type_color} label-inline'>{$org_details->type}</span> " . $org_details->name . " [" . $org->organization_position . "]<br/> ";
                    }
                }
                $nestedData['added_by'] = auth()->user()->fname . " " . auth()->user()->lname;
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
        $columns = array(
            0 =>'id',
            1 =>'input_names',
            2 =>'status',
        );

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
}
