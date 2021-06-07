<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wulgaryzmy;

class WulgaryzmyController extends Controller
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
    public function tabela_wulgaryzmy()
    {

        if (empty($_REQUEST['start'])) {
            $_REQUEST['start'] = 0;
        }
        if (empty($_REQUEST['length'])) {
            $_REQUEST['length'] = 20;
        }
        $Wulgaryzmy = Wulgaryzmy::skip((int)$_REQUEST['start'])->take((int)$_REQUEST['length'])->get();
        $this->sortIndex = 1;
        $this->sortTypeTxt = "asc";

        if (!empty($_REQUEST['order'])) {
            $this->sortIndex = $_REQUEST['order'][0]["column"];
            $this->sortTypeTxt = $_REQUEST['order'][0]["dir"];
        }
        $rec = array(
            'iTotalRecords' => Wulgaryzmy::skip((int)$_REQUEST['start'])->take((int)$_REQUEST['length'])->count(),
            'iTotalDisplayRecords' => Wulgaryzmy::skip((int)$_REQUEST['start'])->take((int)$_REQUEST['length'])->count(),
            'aaData' => array(),
        );
        foreach ($Wulgaryzmy as $wul) {
            $rec['aaData'][] = array(
                (string) $wul->_id,
                $wul->nazwa,
                $wul->aktywny,
                date("Y-m-d H:i:s", strtotime((string) $wul->created_at)),
                date("Y-m-d H:i:s", strtotime((string) $wul->updated_at)),
            );
        }
        // usort($rec['aaData'], function ($a, $b) {
        //     if ("asc" == $this->sortTypeTxt) {
        //         return $a[$this->sortIndex] > $b[$this->sortIndex];
        //     } else {
        //         return $a[$this->sortIndex] < $b[$this->sortIndex];
        //     }
        // });
        echo json_encode($rec);
    }
    public function dodaj_wulgaryzm()
    {
        Wulgaryzmy::create([
            'nazwa' => $_POST['nazwa'],
            'aktywny' => 1,
        ]);
        echo json_encode(1);
    }
}
