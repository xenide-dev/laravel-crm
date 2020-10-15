<?php

namespace App\Http\Controllers;

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
            4 => 'user_type',
            5 => 'last_online_at',
        );

        $totalData = User::where("user_type", "!=", "user")->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $users = User::where("user_type", "!=", "user")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $users =  User::where("user_type", "!=", "user")
                ->where(function ($query) use ($search) {
                    $query->where('id_number','LIKE',"%{$search}%")
                        ->orWhere('fname', 'LIKE',"%{$search}%")
                        ->orWhere('mname', 'LIKE',"%{$search}%")
                        ->orWhere('lname', 'LIKE',"%{$search}%")
                        ->orWhere('user_type', 'LIKE',"%{$search}%");
                })
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
}
