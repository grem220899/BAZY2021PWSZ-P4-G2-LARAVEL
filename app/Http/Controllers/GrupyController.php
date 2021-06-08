<?php

namespace App\Http\Controllers;

use App\Models\FriendList;
use App\Models\BanList;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Wulgaryzmy;
use App\Models\Zamienniki;

class GrupyController extends Controller
{
//Tworzenie grupy
    public function utworz_grupe(){
        DB::insert('INSERT INTO `group_name`(`id`, `name`, `owner_id`) VALUES (null,"'.$_POST['nazwa_grupy'].'",'.Auth::id().')');
        $id_grupy=DB::select('SELECT id from group_name WHERE name="'.$_POST['nazwa_grupy'].'" ORDER BY name DESC');
        $_POST['czlonkowie']=explode(",",$_POST['czlonkowie']);
        foreach($_POST['czlonkowie'] as $czlonek){
            DB::insert('INSERT INTO `group`(`id`, `user_id`, `name_group_id`) VALUES (null,'.$czlonek.','.$id_grupy[0]->id.')');
        }
        echo json_encode(1);
    }
//Usuwanie Grupy
//          public function usun_grupe()
//     {
//         DB::delete("DELETE FROM group_name WHERE (owner_id=" . $_POST['id'] . ") OR (owner_id=" . Auth::id() . ")");
//         echo json_encode(1);

 }
