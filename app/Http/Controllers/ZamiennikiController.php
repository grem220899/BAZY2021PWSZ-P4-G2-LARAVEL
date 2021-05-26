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
    public function index()
    {
        $arr = [
            'Psiakostka',
            'Motyla noga',
            'Kurza stopa',
            'Piernik jasny',
            'Kurczę blade',
            'Kurtka na wacie',
            'Do kroćset fur beczek',
            'Na krowie kopytko',
            'Kurcze pióro',
            'Kurczę pieczone',
            'Kuchnia felek',
            'Kurza melodia',
        ];
        foreach ($arr as $a) {
            Zamienniki::create([
                'nazwa' => $a,
                'aktywny' => 1,
            ]);
        }
    }
}
