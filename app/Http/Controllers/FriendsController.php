<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FriendList;

class FriendsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data=['error'=>''];
        $waiting=DB::select("select * from friend_list where user_id=" . Auth::id()." AND accepted=0");
        $waiting_arr=[];
        foreach($waiting as $v){
            $w=DB::select("select * from users where id=" . $v->friend_id);
            $waiting_arr[]=$w[0];
        }
        $waiting2=DB::select("select * from friend_list where friend_id=" . Auth::id()." AND accepted=0");
        $waiting_arr2=[];
        foreach($waiting2 as $v){
            $w=DB::select("select * from users where id=" . $v->user_id);
            $waiting_arr2[]=$w[0];
        }
        $friend_list=DB::select("select * from friend_list where friend_id=" . Auth::id()." AND accepted=1");
        $friend_list_arr=[];
        foreach($friend_list as $v){
            $w=DB::select("select * from users where id=" . $v->user_id);
            $friend_list_arr[]=$w[0];
        }
        $data['friend_list']=$friend_list_arr;
        $data['waiting']=$waiting_arr;
        $data['waiting2']=$waiting_arr2;
        return view('list_friend',$data);
    }
    public function save()
    {
        $u = DB::select("select * from users where email='" . $_POST['email'] . "'");
        $spr = DB::select("select * from friend_list where friend_id=" . $u[0]->id." AND `user_id`=". Auth::id());
        $data=['error'=>''];
        if (empty($spr)) {
            FriendList::insert([
                'user_id' => Auth::id(),
                'friend_id' => $u[0]->id,
                'accepted' => 0,
            ]);
        } else {
            $data['error'] = "Już wysłałeś zaproszenie";
        }
        $waiting=DB::select("select * from friend_list where user_id=" . Auth::id()." AND accepted=0");
        $waiting_arr=[];
        foreach($waiting as $v){
            $w=DB::select("select * from users where id=" . $v->friend_id);
            $waiting_arr[]=$w[0];
        }
        $waiting2=DB::select("select * from friend_list where friend_id=" . Auth::id()." AND accepted=0");
        $waiting_arr2=[];
        foreach($waiting2 as $v){
            $w=DB::select("select * from users where id=" . $v->user_id);
            $waiting_arr2[]=$w[0];
        }
        $friend_list=DB::select("select * from friend_list where friend_id=" . Auth::id()." AND accepted=1");
        $friend_list_arr=[];
        foreach($friend_list as $v){
            $w=DB::select("select * from users where id=" . $v->user_id);
            $friend_list_arr[]=$w[0];
        }
        $data['friend_list']=$friend_list_arr;
        $data['waiting']=$waiting_arr;
        $data['waiting2']=$waiting_arr2;
        return view('list_friend',$data);
    }
    public function akceptuj()
    {
        $data=['error'=>''];
        DB::update("update friend_list set accepted=1 WHERE user_id=" . $_POST['id'] . " AND friend_id=" . Auth::id());
        $waiting=DB::select("select * from friend_list where user_id=" . Auth::id()." AND accepted=0");
        $waiting_arr=[];
        foreach($waiting as $v){
            $w=DB::select("select * from users where id=" . $v->friend_id);
            $waiting_arr[]=$w[0];
        }
        $waiting2=DB::select("select * from friend_list where friend_id=" . Auth::id()." AND accepted=0");
        $waiting_arr2=[];
        foreach($waiting2 as $v){
            $w=DB::select("select * from users where id=" . $v->user_id);
            $waiting_arr2[]=$w[0];
        }
        $friend_list=DB::select("select * from friend_list where friend_id=" . Auth::id()." AND accepted=1");
        $friend_list_arr=[];
        foreach($friend_list as $v){
            $w=DB::select("select * from users where id=" . $v->user_id);
            $friend_list_arr[]=$w[0];
        }
        $data['friend_list']=$friend_list_arr;
        $data['waiting']=$waiting_arr;
        $data['waiting2']=$waiting_arr2;
        return view('list_friend',$data);
    }
}
