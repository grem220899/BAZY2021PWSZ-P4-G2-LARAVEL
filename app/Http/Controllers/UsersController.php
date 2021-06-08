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
                $us->name,
                $us->surname,
                $us->email,
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
}
