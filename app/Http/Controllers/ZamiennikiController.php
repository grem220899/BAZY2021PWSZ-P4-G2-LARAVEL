<?php

namespace App\Http\Controllers;

use App\Models\Zamienniki;

class ZamiennikiController extends Controller
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
    public function tabela_zamienniki()
    {
        $Zamienniki = Zamienniki::get();
        $this->sortIndex = 1;
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
        foreach ($Zamienniki as $zam) {
            $rec['aaData'][] = array(
                (string) $zam->_id,
                $zam->nazwa,
                $zam->aktywny,
                date("Y-m-d H:i:s", strtotime((string) $zam->created_at)),
                date("Y-m-d H:i:s", strtotime((string) $zam->updated_at)),
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
    public function dodaj_zamiennik()
    {
        Zamienniki::create([
            'nazwa' => $_POST['nazwa'],
            'aktywny' => 1,
        ]);
        echo json_encode(1);
    }
}
