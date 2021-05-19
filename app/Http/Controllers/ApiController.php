<?php

namespace App\Http\Controllers;

use App\Models\FriendList;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Files;

class ApiController extends Controller
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
     public function logowanie()
    {
        $data = array();
        header('Content-Type: application/json');
        $password = urldecode($_GET["password"]);
        $u = DB::select("select * from users where email='" . $_GET['email'] . "'");
        if(count($u)>0){
            if(password_verify($password,$u[0]->password)){
                $data["status"]="success";
                $data["message"]="";
                $data["data"]=$u[0];
            }
            else{
                $data["status"]="failed";
                $data["message"]="nie udało sie zalogować";
                $data["data"]=NULL;
            }
        }
        else{
            $data["status"]="failed";
            $data["message"]="nie udało sie zalogować";
            $data["data"]=NULL;
        }
        echo json_encode($data);
    }
    public function changeAvatar(){
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if (false !== $check) {
                $roz=explode('/',$_FILES['file']['type']);
                $nazwa=uniqid();
                Files::create([
                    'nazwa' => $nazwa,
                    'rozszerzenie' => $roz[1],
                    'przeznaczenie' => 'avatar',
                    'uzytkownik_id'=>Auth::id()
                ]);
                move_uploaded_file($_FILES['file']['tmp_name'], __DIR__.'/../../../public/uploads/avatars/' . $nazwa.'.'.$roz[1]);
                DB::update('UPDATE users SET avatar="'.$nazwa.'.'.$roz[1].'" WHERE id='.Auth::id());

                echo json_encode($nazwa.'.'.$roz[1]);

            }else{
                echo json_encode(0);
            }
    }
    
     public function friend_list()
   {
       header('Content-Type: application/json');
       $data = array();
       if(isset($_GET['id'])){
       $friend_list = DB::select("select * from friend_list where (user_id=" . $_GET['id'] . " OR friend_id=" . $_GET['id'] . ") AND accepted=1");
       $friend_list_arr = [];
       foreach ($friend_list as $v) {
           if ($_GET['id'] == $v->friend_id) {
               $w = DB::select("select name,surname,nick,email,avatar from users where id=" . $v->user_id);
           } else {
               $w = DB::select("select name,surname,nick,email,avatar from users where id=" . $v->friend_id);
           }
            $w[0]->avatar="http://projektkt.cba.pl/uploads/avatars/".$w[0]->avatar;

           $friend_list_arr[] = $w[0];
       }

       $data["status"]="success";
       $data["message"]="";
       $data["data"]=$friend_list_arr;

    }
    else{

        $data["status"]="failed";
        $data["message"]="brak id";
        $data["data"]=[];

    }
       echo json_encode($data);
       
    }

     public function wysylanie_zaproszenia()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['email'])) {
            if (isset($_GET['id'])) {
                $u = DB::select("select * from users where email='" . $_GET['email'] . "'");
                if (!empty($u)) {
                    $spr = DB::select("select * from friend_list where (friend_id=" . $u[0]->id . " AND `user_id`=" . $_GET['id'] . ") OR (friend_id=" . $_GET['id'] . " AND `user_id`=" . $u[0]->id . ")");
                    if (empty($spr)) {
                        $data['data'] = $u[0];
                        FriendList::insert([
                            'user_id' => $_GET['id'],
                            'friend_id' => $u[0]->id,
                            'accepted' => 0,
                            'date_add' => date("Y-m-d H:i:s"),
                        ]);
                        $data["status"] = "success";
                    } else {
                        $data["status"] = "failed";
                        $data["message"] = "Zaproszenie zostało wcześniej wysłane";
                    }
                } else {
                    $data["status"] = "failed";
                    $data["message"] = "Nie ma takiego adresu email w bazie.";
                }

            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano id";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano emaila";
        }
        echo json_encode($data);
    }

    public function akceptowanie_zaproszenia()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['user_id'])) {
            if (isset($_GET['friend_id'])) {
                DB::update("update friend_list set accepted=1 WHERE (user_id=" . $_GET['user_id'] . " AND friend_id=" . $_GET['friend_id'] . ") OR (user_id=" . $_GET['friend_id'] . " AND friend_id=" . $_GET['user_id'] . ")");
                $data["status"] = "success";
            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano friend_id ";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano user_id ";
        }

        echo json_encode($data);
    }

    public function usuwanie_znajomych()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['user_id'])) {
            if (isset($_GET['friend_id'])) {
                DB::delete("DELETE FROM friend_list WHERE (user_id=" . $_GET['user_id'] . " AND friend_id=" . $_GET['friend_id'] . ") OR (user_id=" . $_GET['friend_id'] . " AND friend_id=" . $_GET['user_id'] . ")");
            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano friend_id ";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano user_id ";
        }

        echo json_encode($data);
    }

    public function banowanie_znajomych()
    {
        header('Content-Type: application/json');
        $data = ['message' => ''];
        if (isset($_GET['user_ban_id'])) {
            if (isset($_GET['user_id'])) {
                $data['data'] = $u[0];
                BanList::insert([
                    'date_ban' => date("Y-m-d H:i:s"),
                    'date_uban' => null,
                    'user_id' => (int) $_GET['user_id'],
                    'user_ban_id' => (int) $_GET['user_ban_id'],
                ]);
                $data["status"] = "success";

            } else {
                $data["status"] = "failed";
                $data["message"] = "Nie podano user_id";
            }
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano user_ban_id";
        }
        echo json_encode($data);
    }

    public function wyslane_zaproszenia()
    {
        $data = array();
        header('Content-Type: application/json');
        if (isset($_GET['id'])) {
            $u = DB::select("select * from friend_list where user_id=" . $_GET['id'] . " AND accepted=0");
            $waiting_arr = [];
            foreach ($waiting as $v) {
                $w = DB::select("select * from users where id=" . $v->friend_id);
                $w[0]->avatar = "http://projektkt.cba.pl/uploads/avatars/" . $w[0]->avatar;
                $waiting_arr[] = $w[0];
            }
            
            $data["status"] = "success";
            $data["data"] = $waiting_arr;
        } else {
            $data["status"] = "failed";
            $data["message"] = "Nie podano id";
            $data["data"] = [];
        }

        echo json_encode($data);
    }
    
}
