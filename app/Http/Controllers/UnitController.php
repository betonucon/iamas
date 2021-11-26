<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unitkerja;
class UnitController extends Controller
{
    public function index(request $request){
        $menu='Unit Kerja';
        $side="master";
        return view('unitkerja.index',compact('menu','side'));
    }

    public function ubah(request $request){
       $data=Unitkerja::find($request->id);
       echo'
        <input type="hidden" name="id" value="'.$data['id'].'">
        <div class="form-group">
            <label for="exampleInputEmail1">Unit Kerja</label>
            <input type="text" class="form-control" name="name" value="'.$data['name'].'" placeholder="Enter..">
        </div>
        
       ';
    }

    public function simpan(request $request){

        if (trim($request->kode) == '') {$error[] = '- Isi Kode Unit Kerja';}
        if (trim($request->name) == '') {$error[] = '- Isi Nama Unit Kerja';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Unitkerja::where('kode',$request->kode)->count();
            if($cek>0){
                echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Kode Unit Kerja Terdaftar</p>';
            }else{
                $data=Unitkerja::create([
                    'kode'=>$request->kode,
                    'name'=>$request->name,
                ]);

                if($data){
                    echo'ok';
                }
            }
                
        }
    }

    public function simpan_ubah(request $request){
        if (trim($request->name) == '') {$error[] = '- Isi Nama Unit Kerja';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data=Unitkerja::where('id',$request->id)->update([
                'name'=>$request->name,
            ]);

            if($data){
                echo'ok';
            }
        }
    }

    public function hapus(request $request){
        error_reporting(0);
        $count=count($request->id);
        if (trim($count) == 0) {$error[] = '- Pilih Unit Kerja';}
        if (isset($error)) {echo implode('<br />', $error);} 
        else{
            for($x=0;$x<$count;$x++){
                $data=Unitkerja::where('kode',$request->id)->delete();
            }
            echo'ok';
        }
    }
}
