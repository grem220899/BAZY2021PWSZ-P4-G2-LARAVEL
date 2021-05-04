<?php

namespace App\Http\Controllers;

use App\Models\FriendList;
use DB;
use Illuminate\Support\Facades\Auth;

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
}
