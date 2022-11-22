<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
class PenggunaController extends Controller
{
    public function index(request $request){
        error_reporting(0);
        $menu='Pengguna Aplikasi';
        $side="master";
        return view('pengguna.index',compact('menu','side'));
    }

    public function ubah(request $request){
       $data=User::find($request->id);
       echo'
        <input type="hidden" name="id" value="'.$data['id'].'">
        <div class="form-group">
            <label for="exampleInputEmail1">Jabatan</label>
            <select class="form-control" name="posisi_id" >
                <option value="">Pilih Posisi</option>';
                foreach(posisi_get() as $posisi){
                    if($posisi['id']==$data['posisi_id']){$cek='selected';}else{$cek='';}
                    echo'<option value="'.$posisi['id'].'" '.$cek.'>'.$posisi['name'].'</option>';
                }
        echo'
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Jabatan</label>
            <select class="form-control" name="role_id" >
                <option value="">Pilih Role</option>';
                foreach(role_get() as $role){
                    if($role['id']==$data['role_id']){$cek='selected';}else{$cek='';}
                    echo'<option value="'.$role['id'].'" '.$cek.'>'.$role['name'].'</option>';
                }
        echo'
            </select>
        </div>
       ';
    }

    public function simpan(request $request){

        if (trim($request->nik) == '') {$error[] = '- Isi NIK';}
        if (trim($request->name) == '') {$error[] = '-Isi Nama';}
        if (trim($request->posisi_id) == '') {$error[] = '- Pilih Jabatan';}
        if (trim($request->role_id) == '') {$error[] = '- Pilih Role';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=User::where('nik',$request->nik)->count();
            if($cek>0){
                echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Kode Unit Kerja Terdaftar</p>';
            }else{
                $data=User::create([
                    'nik'=>$request->nik,
                    'name'=>$request->name,
                    'password'=>Hash::make($request->nik),
                    'posisi_id'=>$request->posisi_id,
                    'role_id'=>$request->role_id,
                ]);

                if($data){
                    echo'ok';
                }
            }
                
        }
    }

    public function simpan_ubah(request $request){
        if (trim($request->posisi_id) == '') {$error[] = '- Pilih Jabatan';}
        if (trim($request->role_id) == '') {$error[] = '- Pilih Role';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data=User::where('id',$request->id)->update([
                'posisi_id'=>$request->posisi_id,
                'role_id'=>$request->role_id,
            ]);

            if($data){
                echo'ok';
            }
        }
    }

    public function hapus(request $request){
        error_reporting(0);
        $count=count($request->id);
        if (trim($count) == 0) {$error[] = '- Pilih Pengguna';}
        if (isset($error)) {echo implode('<br />', $error);} 
        else{
            for($x=0;$x<$count;$x++){
                $data=User::where('nik',$request->id)->delete();
            }
            echo'ok';
        }
    }
}
