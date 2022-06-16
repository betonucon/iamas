<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Audit;
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
    {   
        error_reporting(0);
        if(Auth::user()['role_id']==8){
            
            $menu='Dashboard STIA';
            $side="home";
            if($request->tahun==''){
                $tahun=date('Y');
            }else{
                $tahun=$request->tahun;
            }
            return view('home02',compact('menu','tahun','side'));
        }else{
            $menu='Dashboard STIA[1,2,3]';
            $side="home";
            if($request->tahun==''){
                $tahun=date('Y');
            }else{
                $tahun=$request->tahun;
            }
            return view('home',compact('menu','tahun','side'));
        }
            
    }

    public function index_stia2(request $request)
    {   
        error_reporting(0);
        if(Auth::user()['role_id']==8){
            $menu='Dashboard Temuan';
            $side="temuan";
            if($request->tahun==''){
                $tahun=date('Y');
            }else{
                $tahun=$request->tahun;
            }
            return view('home_temuan',compact('menu','tahun','side'));

        }else{
            
        }
            
    }

    public function index_audit(request $request)
    {   
        error_reporting(0);
        $menu='Dashboard STIA[4,5,6]';
        $side="home";
        
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        $data=Audit::where('tahun',$tahun)->orderBy('kode_aktivitas')->get();
        return view('homeaudit',compact('menu','tahun','side','data'));
    }
    public function modal_audit(request $request)
    {   
        error_reporting(0);
        $data=Audit::where('id',$request->id)->first();
        return view('modalaudit',compact('data'));
    }

    public function index_temuan(request $request)
    {   
        error_reporting(0);
        $menu='Dashboard Temuan';
        $side="temuan";
        if($request->tahun==''){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        return view('home_temuan_auditor',compact('menu','tahun','side'));
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
