<?php

namespace App\Http\Controllers;

use App\Models\FriendList;
use DB;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = ['error' => ''];
        $data['friend_list'] = $this->friend_list();
        $data['waiting'] = $this->wyslane_zaproszenia();
        $data['waiting2'] = $this->lista_zaproszen();
        return view('list_friend', $data);
    }
    public function usun_znajomego(){
        $data = ['error' => ''];
        DB::delete("DELETE FROM friend_list WHERE (user_id=" . $_POST['id'] . " AND friend_id=" . Auth::id().") OR (user_id=" . Auth::id()." AND friend_id=" . $_POST['id'] . ")");
        $data['friend_list'] = $this->friend_list();
        $data['waiting'] = $this->wyslane_zaproszenia();
        $data['waiting2'] = $this->lista_zaproszen();
        return view('list_friend', $data);
    }
    public function save()
    {
        $data = ['error' => ''];
        $u = DB::select("select * from users where email='" . $_POST['email'] . "'");
        if (!empty($u)) {
            $spr = DB::select("select * from friend_list where (friend_id=" . $u[0]->id . " AND `user_id`=" . Auth::id().") OR (friend_id=" . Auth::id()." AND `user_id`=" . $u[0]->id . ")");
            if (empty($spr)) {
                FriendList::insert([
                    'user_id' => Auth::id(),
                    'friend_id' => $u[0]->id,
                    'accepted' => 0,
                ]);
            } else {
                $data['error'] = "Już wysłałeś zaproszenie";
            }
        } else {
            $data['error'] = "Nie ma takiego adresu email w bazie.";
        }
        $data['friend_list'] = $this->friend_list();
        $data['waiting'] = $this->wyslane_zaproszenia();
        $data['waiting2'] = $this->lista_zaproszen();
        return view('list_friend', $data);
    }
    public function akceptuj()
    {
        $data = ['error' => ''];
        DB::update("update friend_list set accepted=1 WHERE (user_id=" . $_POST['id'] . " AND friend_id=" . Auth::id().") OR (user_id=" . Auth::id()." AND friend_id=" . $_POST['id'] . ")");
        $data['friend_list'] = $this->friend_list();
        $data['waiting'] = $this->wyslane_zaproszenia();
        $data['waiting2'] = $this->lista_zaproszen();
        return view('list_friend', $data);
    }
    public function lista_zaproszen()
    {
        $waiting2 = DB::select("select * from friend_list where friend_id=" . Auth::id() . " AND accepted=0");
        $waiting_arr2 = [];
        foreach ($waiting2 as $v) {
            $w = DB::select("select * from users where id=" . $v->user_id);
            $waiting_arr2[] = $w[0];
        }
        return $waiting_arr2;
    }
    public function wyslane_zaproszenia()
    {
        $waiting = DB::select("select * from friend_list where user_id=" . Auth::id() . " AND accepted=0");
        $waiting_arr = [];
        foreach ($waiting as $v) {
            $w = DB::select("select * from users where id=" . $v->friend_id);
            $waiting_arr[] = $w[0];
        }
        return $waiting_arr;
    }
    public function friend_list()
    {
        $friend_list = DB::select("select * from friend_list where (user_id=" . Auth::id() . " OR friend_id=" . Auth::id() . ") AND accepted=1");
        $friend_list_arr = [];
        foreach ($friend_list as $v) {
            if (Auth::id() == $v->friend_id) {
                $w = DB::select("select * from users where id=" . $v->user_id);
            } else {
                $w = DB::select("select * from users where id=" . $v->friend_id);
            }

            $friend_list_arr[] = $w[0];
        }
        return $friend_list_arr;
    }
}
