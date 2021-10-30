<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;

class UsersController extends Controller
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
    public function tabela_users()
    {
        $Users = User::get();
        $this->sortIndex = 0;
        $this->sortTypeTxt = "asc";

        if (!empty($_REQUEST['order'])) {
            $this->sortIndex = $_REQUEST['order'][0]["column"];
            $this->sortTypeTxt = $_REQUEST['order'][0]["dir"];
        }
        $rec = array(
            'iTotalRecords' => 0,
            'iTotalDisplayRecords' => 0,
            'aaData' => array(),
        );
        foreach ($Users as $us) {
            $rec['aaData'][] = array(
                (string) $us->id,
                '<a href="user?id='.(string) $us->id.'">'.$us->name.'</a>',
                '<a href="user?id='.(string) $us->id.'">'.$us->surname.'</a>',
                '<a href="user?id='.(string) $us->id.'">'.$us->email.'</a>',
                '<span class="zmianaStatusu" data-id="'.(string) $us->id.'">'.$us->status.'</span>',
                date("Y-m-d H:i:s", strtotime((string) $us->email_verified_at)),
                date("Y-m-d H:i:s", strtotime((string) $us->created_at)),
                date("Y-m-d H:i:s", strtotime((string) $us->updated_at)),
            );
        }
        usort($rec['aaData'], function ($a, $b) {
            if ("asc" == $this->sortTypeTxt) {
                return $a[$this->sortIndex] > $b[$this->sortIndex];
            } else {
                return $a[$this->sortIndex] < $b[$this->sortIndex];
            }
        });
        echo json_encode($rec);
    }
    public function zmiana_statusu(){
        if($_POST['status']=="aktywny"){
            DB::update("UPDATE users SET status='zablokowany' WHERE id=".$_POST['id']);
            echo json_encode(['status'=>"zablokowany"]);
        }else if($_POST['status']=="zablokowany"){
            DB::update("UPDATE users SET status='aktywny' WHERE id=".$_POST['id']);
            echo json_encode(['status'=>"aktywny"]);
        }
    }
    public function profil_admin(){
        $grupy = DB::select('SELECT g.id as gid,gn.name,gn.owner_id,g.date_add as date_add_user,gn.date_add as date_create,user_id,name_group_id FROM `group` g INNER JOIN `group_name` gn ON gn.id=g.name_group_id WHERE g.name_group_id IN (SELECT name_group_id FROM `group` g INNER JOIN `group_name` gn ON gn.id=g.name_group_id WHERE user_id='.$_GET['id'].' OR gn.owner_id='.$_GET['id'].')');
        $grupy_arr = ['czlonkowie' => [], 'nazwy' => []];
        $owner = 0;
        $nazwa = "";
        foreach ($grupy as $v) {
            $w = DB::select("select * from users where id=" . $v->user_id);
            if ($v->name != $nazwa) {
                $grupy_arr['nazwy'][] = ['nazwa' => $v->name, 'id' => $v->name_group_id,'create'=>$v->date_create];
                $ww = DB::select("select * from users where id=" . $v->owner_id);
                $grupy_arr['czlonkowie'][$v->name][] = $ww[0];
            }
            $nazwa = $v->name;
            $owner = $v->owner_id;
            $w[0]->od=$v->date_add_user;
            $grupy_arr['czlonkowie'][$nazwa][] = $w[0];
        }
        $data=array('grupy'=>$grupy_arr);
        // var_dump($grupy_arr);
        return view('admin.profil', $data);
    }
}
