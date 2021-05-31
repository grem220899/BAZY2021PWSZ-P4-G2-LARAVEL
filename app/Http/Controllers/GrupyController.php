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
    public function utworz_grupe(){
        DB::insert('INSERT INTO `group_name`(`id`, `name`, `owner_id`) VALUES (null,"'.$_POST['nazwa_grupy'].'",'.Auth::id().')');
        $id_grupy=DB::select('SELECT id from group_name WHERE name="'.$_POST['nazwa_grupy'].'" ORDER BY name DESC');
        $_POST['czlonkowie']=explode(",",$_POST['czlonkowie']);
        foreach($_POST['czlonkowie'] as $czlonek){
            DB::insert('INSERT INTO `group`(`id`, `user_id`, `name_group_id`) VALUES (null,'.$czlonek.','.$id_grupy[0]->id.')');
        }
        echo json_encode(1);
    }
//Usuwanie członka grupy
    // public function usun_czlonka()
    // {
    //     $id_grupy=DB::select('SELECT id from group_name WHERE name="'.$_POST['nazwa_grupy'].'" ORDER BY name DESC');
    //     $_POST['czlonkowie']=explode(",",$_POST['czlonkowie']);
    //     foreach($_POST['czlonkowie'] as $czlonek){
    //          DB::delete("DELETE FROM 'group' WHERE (user_id=" . $_POST['id'] . " AND friend_id=" . Auth::id() . ") OR (user_id=" . Auth::id() . " AND friend_id=" . $_POST['id'] . ")");

    //     echo json_encode($data);

    // }
//Usuwanie Grupy
        // public function usun_grupe()
    // {
    //          DB::delete("DELETE FROM 'group_name' WHERE (user_id=" . $_POST['id'] . " AND friend_id=" . Auth::id() . ") OR (user_id=" . Auth::id() . " AND friend_id=" . $_POST['id'] . ")");

    //     echo json_encode($data);

    // }
    // Dodawanie członków
    // public function save()
    // {
    //     $data = ['error' => ''];
    //     $u = DB::select("select * from users where email='" . $_POST['email'] . "'");
    //     if (!empty($u)) {
    //         $spr = DB::select("select * from friend_list where (friend_id=" . $u[0]->id . " AND `user_id`=" . Auth::id() . ") OR (friend_id=" . Auth::id() . " AND `user_id`=" . $u[0]->id . ")");
    //         if (empty($spr)) {
    //             $data['user'] = $u[0];
    //             FriendList::insert([
    //                 'user_id' => Auth::id(),
    //                 'friend_id' => $u[0]->id,
    //                 'accepted' => 0,
    //                 'date_add' => date("Y-m-d H:i:s"),
    //             ]);
    //         } else {
    //             $data['error'] = "Już wysłałeś zaproszenie";
    //         }
    //     } else {
    //         $data['error'] = "Nie ma takiego adresu email w bazie.";
    //     }
    //     echo json_encode($data);

    // }
}
