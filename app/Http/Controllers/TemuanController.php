<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Audit;
use App\Lha;
use App\Timaudit;
use App\Surattugas;
use App\Kesimpulan;
use App\Rekomendasi;
use Artisan;
use PDF;
use Illuminate\Support\Facades\Hash;
class TemuanController extends Controller
{
    public function index(request $request){
        $menu='Temuan';
        $side="temuan";
        if(Auth::user()['role_id']==8){
            return view('Temuan.index',compact('menu','side'));
        }else{
           return view('error'); 
        }
        
        
    }
    public function proses(request $request){
        
        if(Auth::user()['role_id']==8){
            $data=Rekomendasi::where('id',encoder($request->id))->first();
            $menu='Temuan '.$data->kesimpulan['nomorkode'].' '.$data->nomor.'.'.$data->urutan;
            $side="temuan";
            return view('Temuan.proses',compact('menu','side','data'));
        }else{
           return view('error'); 
        }
        
        
    }
    public function index_anggota(request $request){
        $menu='Temuan';
        $side="temuan";
        if(akses_tiket_anggota()>0){
            // dd(temuan_anggota_get());
            return view('Temuan.index_anggota',compact('menu','side'));
        }else{
           return view('error'); 
        }
        
        
    }

    public function simpan(request $request){

        if (trim($request->file) == '') {$error[] = '-Upload File Pendukung';}
        if (trim($request->catatan) == '') {$error[] = '-Isi Catatan';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{

        }
    }
    
}
