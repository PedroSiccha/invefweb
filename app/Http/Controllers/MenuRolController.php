<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuRolController extends Controller
{
    public function index()
    {
        $rols = DB::SELECT('SELECT * FROM rol');
        $menus = DB::SELECT('SELECT * FROM menus');
        $menuRols = DB::SELECT('SELECT * FROM menurol mr
                                 INNER JOIN rol r ON mr.rol_id = r.id');
        
        return view('menuRol.index', compact('rols', 'menus', 'menuRols'));
    }
}
