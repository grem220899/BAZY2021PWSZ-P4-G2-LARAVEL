<?php

namespace App\Http\Controllers;

use App\Models\FriendList;
use App\Models\BanList;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Wulgaryzmy;
use App\Models\Zamienniki;

class AdminController extends Controller
{
    public function index(){
        $data=[];
        return view('admin.panel', $data);
    }

}
