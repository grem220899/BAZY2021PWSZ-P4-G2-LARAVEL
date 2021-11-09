<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;

class GrupyController extends Controller
{
//Tworzenie grupy
    public function utworz_grupe()
    {
        DB::insert('INSERT INTO `group_name`(`id`, `name`, `owner_id`) VALUES (null,"' . $_POST['nazwa_grupy'] . '",' . Auth::id() . ')');
        $id_grupy = DB::select('SELECT id from group_name WHERE name="' . $_POST['nazwa_grupy'] . '" ORDER BY name DESC');
        $_POST['czlonkowie'] = explode(",", $_POST['czlonkowie']);
        foreach ($_POST['czlonkowie'] as $czlonek) {
            DB::insert('INSERT INTO `group`(`id`, `user_id`, `name_group_id`) VALUES (null,' . $czlonek . ',' . $id_grupy[0]->id . ')');
        }
        echo json_encode(1);
    }
//Usuwanie Grupy
    public function usun_grupe()
    {
        $data = ['error' => ''];
        $owner = DB::select("SELECT owner_id FROM group_name WHERE (owner_id=" . Auth::id() . " )");
        if (null != $owner) {
            DB::delete("DELETE FROM group_name WHERE (owner_id=" . Auth::id() . " AND id=" . $_POST['id'] . ") ");
        } else {
            $data["error"] = "Ten użytkownik nie jest właścicielem grupy.";
        }
        echo json_encode($data);
    }
//Usuwanie z Grupy WiP
    public function usun_czlonka()
    {
        $data = ['error' => ''];
        $owner = DB::select("SELECT owner_id FROM group_name WHERE (owner_id=" . Auth::id() . " )");
        if (null != $owner) {
            DB::delete("DELETE FROM `group` WHERE (name_group_id=" . $_POST['name_group_id'] . " AND user_id=" . $_POST['user_id'] . ")");
        } else {
            $data["error"] = "Ten użytkownik nie jest właścicielem grupy.";
        }
        echo json_encode($data);
    }
//Opuszczanie Grupy
    public function opusc_grupe()
    {
        $data = ['error' => ''];
        $owner = DB::select("SELECT owner_id FROM group_name WHERE (owner_id=" . Auth::id() . " AND id=" . $_POST['id'] . ")");
        if (null != $owner) {
            DB::delete("DELETE FROM group_name WHERE (owner_id=" . Auth::id() . " AND id=" . $_POST['id'] . ") ");
        } else {
            DB::delete("DELETE FROM `group` WHERE (name_group_id=" . $_POST['id'] . " AND user_id=" . Auth::id() . ")");
        }
        echo json_encode($data);
    }

}
