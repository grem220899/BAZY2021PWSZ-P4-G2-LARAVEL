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
        header('Content-Type: application/json');
        $u=DB::select("select * from users where email='" . $_GET['email'] . "'");
        echo json_encode($u);
    }
}
