<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request)
    {   $menu='Dashboard STIA[1,2,3]';
        $side="home";
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        return view('home',compact('menu','tahun','side'));
    }

    public function index_kodifikasi(request $request)
    {   $menu='Dashboard Kodifikasi';
        $side="home";
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        return view('home_kodifikasi',compact('menu','tahun','side'));
    }
}
