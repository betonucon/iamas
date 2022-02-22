<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unitkerja;
use App\User;
use Illuminate\Support\Facades\Hash;
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
        <div class="form-group">
            <label for="exampleInputEmail1">Pimpinan</label>
            <div class="row">
                <div class="col-3">
                    <div class="input-group m-b-10">
                        <input type="text" class="form-control" name="nik" id="nik_ubah" value="'.$data['nik'].'" placeholder="Enter..">
                        <div class="input-group-append"><span class="input-group-text" onclick="cari_nik()"><i class="fa fa-search"></i></span></div>
                    </div>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" readonly name="nama_atasan" id="nama_atasan" value="'.$data['nama_atasan'].'" placeholder="Enter..">
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" readonly name="position_name" id="position_name"  value="'.$data['position_name'].'" placeholder="Enter..">
                </div>
            </div>
            
        </div>
        
       ';
    }

    public function get_nik(request $request){
        error_reporting(0);
        $json = file_get_contents('https://portal.krakatausteel.com/eos/api/structdisp/'.$request->nik);
        $item = json_decode($json,true);
        
        $unit=$item;
        $personnel_no=$unit['personnel_no'];
        $name=$unit['name'];
        if($name==""){
            echo'Null@Null';
        }else{
            echo $name.'@'.$unit['position_name'];
        }

    }
    public function get_organisasi(){
        $json = file_get_contents('https://portal.krakatausteel.com/eos/api/organization');
        $item = json_decode($json,true);
        
        $unit=$item;
        //var_dump($item);
        foreach($unit as $o){
            $potng=explode(' ',$o['Objectname']);
            $cekdata=UnitKerja::where('kode',$o['ObjectID'])->count();
            
            if($potng[0]=='Subdit'){$unt=1; $pim='General Manager';$urut=2;}
            elseif($potng[0]=='Divisi'){$unt=3;$pim='Manager';$urut=3;}
            elseif($potng[0]=='Direktorat'){$unt=5;$pim='Direktur Utama';$urut=1;}
            elseif($potng[0]=='Dinas'){$unt=4;$pim='Supertintendant';$urut=4;}
            elseif($potng[0]=='PT'){$unt=6;$pim='Direktur Utama';$urut=1;}
            else{$unt=2;$pim='none';$urut=8;}

            if($cekdata>0){
                $key            =   UnitKerja::where('kode',$o['ObjectID'])->first();
                $key->kode      =   $o['ObjectID'];
                $key->name      =   $o['Objectname'];
                $key->kode_unit =   $o['Objectabbr'];
                $key->unit_id   =   $unt;
                $key->pimpinan  =   $pim;
                $key->save();
                
            }else{
                $key            =   New UnitKerja;
                $key->kode      =   $o['ObjectID'];
                $key->name      =   $o['Objectname'];
                $key->kode_unit =   $o['Objectabbr'];
                $key->unit_id   =   $unt;
                $key->pimpinan  =   $pim;
                $key->as  =   $urut;
                $key->save();

                
            }
           
           
            
        }
        //$items = UnitKerja::where('unit_id',$id)->get();
        var_dump($item);
       
    }

    public function simpan(request $request){

        if (trim($request->kode) == '') {$error[] = '- Isi Kode Unit Kerja';}
        if (trim($request->name) == '') {$error[] = '- Isi Nama Unit Kerja';}
        if (trim($request->nik) == '') {$error[] = '- Isi NIK Pimpinan';}
        if (trim($request->nama_atasan) == '') {$error[] = '- Isi Nama Pimpinan';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Unitkerja::where('kode',$request->kode)->count();
            if($cek>0){
                echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Kode Unit Kerja Terdaftar</p>';
            }else{
                $data=Unitkerja::create([
                    'kode'=>$request->kode,
                    'name'=>$request->name,
                    'nik'=>$request->nik,
                    'nama_atasan'=>$request->nama_atasan,
                    'position_name'=>$request->position_name,
                ]);

               
                $cek=User::where('nik',$request->nik)->count();
                if($cek>0){
                    echo'ok';
                }else{
                    $useer=User::create([
                        'nik'=>$request->nik,
                        'name'=>$request->nama_atasan,
                        'password'=>Hash::make($request->nik),
                        'jabatan'=>$request->position_name,
                        'role_id'=>8,
                    ]);
                    echo'ok';
                }
                    
               
            }
                
        }
    }

    public function simpan_ubah(request $request){
        if (trim($request->name) == '') {$error[] = '- Isi Nama Unit Kerja';}
        if (trim($request->nik) == '') {$error[] = '- Isi NIK Pimpinan';}
        if (trim($request->nama_atasan) == '') {$error[] = '- Isi Nama Pimpinan';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data=Unitkerja::where('id',$request->id)->update([
                'name'=>$request->name,
                'nik'=>$request->nik,
                'nama_atasan'=>$request->nama_atasan,
                'position_name'=>$request->position_name,
            ]);

            
                $cek=User::where('nik',$request->nik)->count();
                if($cek>0){

                }else{
                    $useer=User::create([
                        'nik'=>$request->nik,
                        'name'=>$request->nama_atasan,
                        'password'=>Hash::make($request->nik),
                        'jabatan'=>$request->position_name,
                        'role_id'=>8,
                    ]);
                }
                echo'ok';
            
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
