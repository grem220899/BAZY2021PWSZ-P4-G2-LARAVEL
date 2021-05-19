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

}
