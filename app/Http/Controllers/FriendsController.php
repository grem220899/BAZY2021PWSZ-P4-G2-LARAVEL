<?php

namespace App\Http\Controllers;

use App\Models\BanList;
use App\Models\FriendList;
use App\Models\Wulgaryzmy;
use App\Models\Zamienniki;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FriendsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // var_dump('<a href="'.asset('storage/60b49b14ce7c9.txt').'" target="_blank" download>a</a>');
        $data = ['error' => ''];
        $data['friend_list'] = $this->friend_list();
        $data['waiting'] = $this->wyslane_zaproszenia();
        $data['waiting2'] = $this->lista_zaproszen();
        $data['waiting3'] = $this->lista_zbanowanych();
        $data['grupy'] = $this->lista_grup();
        $data['wulgaryzmy'] = json_encode($this->wulgaryzmy());
        $data['zamienniki'] = json_encode($this->zamienniki());
        return view('list_friend', $data);
    }
    // //Usuwanie
    public function usun_znajomego()
    {
        $data = ['error' => ''];
        DB::delete("DELETE FROM friend_list WHERE (user_id=" . $_POST['id'] . " AND friend_id=" . Auth::id() . ") OR (user_id=" . Auth::id() . " AND friend_id=" . $_POST['id'] . ")");

        echo json_encode($data);

    }
    // //Akceptowanie
    public function akceptuj()
    {
        $data = ['error' => ''];
        DB::update("update friend_list set accepted=1 WHERE (user_id=" . $_POST['id'] . " AND friend_id=" . Auth::id() . ") OR (user_id=" . Auth::id() . " AND friend_id=" . $_POST['id'] . ")");

        echo json_encode($data);

    }
    //Banowanie znajomych
    public function banowanie()
    {
        $data = ['error' => ''];
        $u = DB::select("select * from users where id='" . $_POST['user_id'] . "'");
        if (!empty($u)) {
            DB::delete("DELETE FROM friend_list WHERE (user_id=" . $_POST['user_id'] . " AND friend_id=" . Auth::id() . ") OR (user_id=" . Auth::id() . " AND friend_id=" . $_POST['user_id'] . ")");
            $data['data'] = $u[0];
            BanList::insert([
                'date_ban' => date("Y-m-d H:i:s"),
                'date_uban' => null,
                'user_id' => Auth::id(),
                'user_ban_id' => $u[0]->id,
            ]);
        } else {
            $data["error"] = "Nie ma takiego użytkownika w bazie";
        }
        echo json_encode($data);
    }
    //Odbanowanie
    public function odbanuj_znajomego()
    {
        $data = ['error' => ''];
        DB::delete("DELETE FROM ban_list WHERE ( `user_id`=" . $_POST['user_id'] . " AND `user_ban_id`=" . Auth::id() .") OR (`user_id`=" . Auth::id() . " AND `user_ban_id`=" . $_POST['user_id'] . ")");
        echo json_encode($data);

    }
    //Wysyłanie zaproszenia do znajomych
    public function save()
    {
        $data = ['error' => ''];
        $u = DB::select("select * from users where email='" . $_POST['email'] . "'");
        if (!empty($u)) {
            $spr = DB::select("select * from friend_list where (friend_id=" . $u[0]->id . " AND `user_id`=" . Auth::id() . ") OR (friend_id=" . Auth::id() . " AND `user_id`=" . $u[0]->id . ")");
            if (empty($spr)) {
                //Sprawdzenie czy jest użytkownik jest zbanowany
                 $spr_ban = DB::select("select * from ban_list where (user_id =" . Auth::id() . " AND `user_ban_id`=" . $u[0]->id . ") OR (`user_id` =" . $u[0]->id . " AND `user_ban_id`=" . Auth::id() . ")");
                     if (empty($spr_ban)) {
                $data['user'] = $u[0];
                FriendList::insert([
                    'user_id' => Auth::id(),
                    'friend_id' => $u[0]->id,
                    'accepted' => 0,
                    'date_add' => date("Y-m-d H:i:s"),
                ]);
                } else{
                    $data['error'] = "Zostałeś zablokowany przez tego użytkownika";
                }
            } else {
                $data['error'] = "Już wysłałeś zaproszenie";
            }
        } else {
            $data['error'] = "Nie ma takiego adresu email w bazie.";
        }
        echo json_encode($data);
    }
    public function lista_grup()
    {
        $grupy = DB::select('SELECT * FROM `group` g INNER JOIN `group_name` gn ON gn.id=g.name_group_id WHERE g.name_group_id IN (SELECT name_group_id FROM `group` g INNER JOIN `group_name` gn ON gn.id=g.name_group_id WHERE user_id='.Auth::id().' OR gn.owner_id='.Auth::id().')');
        $grupy_arr = ['czlonkowie' => [], 'nazwy' => []];
        $owner = 0;
        $nazwa = "";
        foreach ($grupy as $v) {
            $w = DB::select("select * from users where id=" . $v->user_id);
            if ($v->name != $nazwa) {
                $grupy_arr['nazwy'][] = ['nazwa' => $v->name, 'id' => $v->name_group_id];
                $ww = DB::select("select * from users where id=" . $v->owner_id);
                $grupy_arr['czlonkowie'][$v->name][] = $ww[0];
            }
            $nazwa = $v->name;
            $owner = $v->owner_id;
            $grupy_arr['czlonkowie'][$nazwa][] = $w[0];
        }
        return $grupy_arr;
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
   // Lista zbanowanych do dokończenia
    public function lista_zbanowanych()
    {
        $waiting3 = DB::select("select * from ban_list where user_id=" . Auth::id() . "");
        $waiting_arr3 = [];
        foreach ($waiting3 as $v) {
            $w = DB::select("select * from users where id=" . $v->user_ban_id);
            $w[0]->avatar = "http://projektkt.pl/uploads/avatars/" . $w[0]->avatar;
            $waiting_arr3[] = $w[0];      
        }
        return $waiting_arr3;
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
    public function wulgaryzmy()
    {
        $wul = Wulgaryzmy::whereIn('aktywny', [1])->get();
        $wul_arr = [];
        foreach ($wul as $w) {
            $wul_arr[] = $w['nazwa'];
        }
        return $wul_arr;
    }
    public function zamienniki()
    {
        $wul = Zamienniki::whereIn('aktywny', [1])->get();
        $wul_arr = [];
        foreach ($wul as $w) {
            $wul_arr[] = $w['nazwa'];
        }
        return $wul_arr;
    }
}
