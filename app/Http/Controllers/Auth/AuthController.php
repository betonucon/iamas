<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\User;
use App\Warga;
use App\Mail\KirimEmail;
use Illuminate\Support\Facades\Mail;
class AuthController extends Controller
{
    protected $redirectTo = '/';
    public function register(request $request){
        return view('authcsm.register');
    }
    public function aktivasi(request $request){
        $data=User::where('aktivasi',$request->link)->where('sts',0)->count();
        if($data>0){
             $akt=User::where('aktivasi',$request->link)->update([
                 'sts'=>1,
             ]);
             
             $notatas='Sukses';
             $not='Akun Telah diaktikan';
        }else{
            $notatas='Sorry';
             $not='Link sudah kadaluarsa';
        }

        return view('auth.aktivasi',compact('notatas','not'));
    }
    
    public function prosesregister(request $request){
        error_reporting(0);
        if($request->sts_warga==1){
            $notwarga='Nomor KTP';
        }else{
            $notwarga='Nomor KTP/Pasport';
        }

        $rules = [
            'name'                  => 'required',
            'username'              => 'required|numeric|unique:users',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed',
            'sts_warga'             => 'required',
            'password'              => 'required|confirmed',
            'kode_provinsi'         => 'required',
            'kode_kota'             => 'required',
            'kode_kecamatan'        => 'required',
            'kode_kelurahan'        => 'required',
            'rw'                    => 'required',
            'rt'                    => 'required',
            'kode_provinsi_tinggal' => 'required',
            'kode_kota_tinggal'     => 'required',
            'kode_kecamatan_tinggal'=> 'required',
            'kode_kelurahan_tinggal'=> 'required',
            'rw_tinggal'            => 'required',
            'rt_tinggal'            => 'required',
        ];
  
        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'username.unique'       => ''.$notwarga.' Sudah Terdaftar',
            'username.required'     => ''.$notwarga.' Harus diisi',
            'username.numeric'      => ''.$notwarga.' Harus diisi angka',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'sts_warga.required'    => 'Pilih Warga Negara',
            'kode_provinsi.required'=> 'Pilih Provinsi',
            'kode_kota.required'    => 'Pilih Kota/Kab',
            'kode_kecamatan.required'=> 'Pilih Kecamatan',
            'kode_kelurahan.required'=> 'Pilih Kelurahan',
            'rw.required'           => 'Pilih RW',
            'rt.required'           => 'Pilih RT',
            'kode_provinsi_tinggal.required'=> 'Pilih Provinsi',
            'kode_kota_tinggal.required'    => 'Pilih Kota/Kab',
            'kode_kecamatan_tinggal.required'=> 'Pilih Kecamatan',
            'kode_kelurahan_tinggal.required'=> 'Pilih Kelurahan',
            'rw_tinggal.required'           => 'Pilih RW',
            'rt_tinggal.required'           => 'Pilih RT',
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();
        $name='';
        $username='';
        $email='';
        $password='';
        $sts_warga='';
        $kode_provinsi='';
        $kode_kota='';
        $kode_kecamatan='';
        $kode_kelurahan='';
        $rw='';
        $rt='';
        $kode_provinsi_tinggal='';
        $kode_kota_tinggal='';
        $kode_kecamatan_tinggal='';
        $kode_kelurahan_tinggal='';
        $rw_tinggal='';
        $rt_tinggal='';

        foreach(parsing_validator($val)['name'] as $value){
            $name.=$value;
        }
        foreach(parsing_validator($val)['username'] as $value){
            $username.=$value;
        }
        foreach(parsing_validator($val)['email'] as $value){
            $email.=$value;
        }
        foreach(parsing_validator($val)['password'] as $value){
            $password.=$value;
        }
        foreach(parsing_validator($val)['sts_warga'] as $value){
            $sts_warga.=$value;
        }
        foreach(parsing_validator($val)['kode_provinsi'] as $value){
            $kode_provinsi.=$value;
        }
        foreach(parsing_validator($val)['kode_kota'] as $value){
            $kode_kota.=$value;
        }
        foreach(parsing_validator($val)['kode_kecamatan'] as $value){
            $kode_kecamatan.=$value;
        }
        foreach(parsing_validator($val)['kode_kelurahan'] as $value){
            $kode_kelurahan.=$value;
        }
        foreach(parsing_validator($val)['rw'] as $value){
            $rw.=$value;
        }
        foreach(parsing_validator($val)['rt'] as $value){
            $rt.=$value;
        }

        foreach(parsing_validator($val)['kode_provinsi_tinggal'] as $value){
            $kode_provinsi_tinggal.=$value;
        }
        foreach(parsing_validator($val)['kode_kota_tinggal'] as $value){
            $kode_kota_tinggal.=$value;
        }
        foreach(parsing_validator($val)['kode_kecamatan_tinggal'] as $value){
            $kode_kecamatan_tinggal.=$value;
        }
        foreach(parsing_validator($val)['kode_kelurahan_tinggal'] as $value){
            $kode_kelurahan_tinggal.=$value;
        }
        foreach(parsing_validator($val)['rw_tinggal'] as $value){
            $rw_tinggal.=$value;
        }
        foreach(parsing_validator($val)['rt_tinggal'] as $value){
            $rt_tinggal.=$value;
        }
        
        if ($validator->fails()) {
            echo $name.'@'; //0
            echo $username.'@';//1
            echo $email.'@';//2
            echo $password.'@';//3
            echo $sts_warga.'@';//4
            echo $kode_provinsi.'@';//5
            echo $kode_kota.'@';//6
            echo $kode_kecamatan.'@';//7
            echo $kode_kelurahan.'@';//8
            echo $rw.'@';//9
            echo $rt.'@';//10
            echo $kode_provinsi_tinggal.'@';//11
            echo $kode_kota_tinggal.'@';//12
            echo $kode_kecamatan_tinggal.'@';//13
            echo $kode_kelurahan_tinggal.'@';//14
            echo $rw_tinggal.'@';//15
            echo $rt_tinggal.'@';//16
        }else{
            $save=Warga::create([
                    'name' => ucwords($request->name),
                    'nik' => $request->username,
                    'no_kk' => $request->no_kk,
                    'kode_provinsi' => $request->kode_provinsi,
                    'kode_kota' => $request->kode_kota,
                    'kode_kecamatan' => $request->kode_kecamatan,
                    'kode_kelurahan' => $request->kode_kelurahan,
                    'alamat' => $request->alamat,
                    'rt' => $request->rt,
                    'rw' => $request->rw,
                    'warganegara' => $request->sts_warga,
                    'foto_profile' => 'default.png',
                    'alamat_tinggal' => $request->alamat_tinggal,
                    'rt_tinggal' => $request->rt_tinggal,
                    'rw_tinggal' => $request->rw_tinggal,
                    'kode_kelurahan_tinggal' => $request->kode_kelurahan_tinggal,
                    'kode_kecamatan_tinggal' => $request->kode_kecamatan_tinggal,
                    'kode_kota_tinggal' => $request->kode_kota_tinggal,
                    'kode_provinsi_tinggal' => $request->kode_provinsi_tinggal,
                    'nomor_paspor' => $request->username,
                    'kode_negara' => '+62',
                ]);
            if($save){
                $user=User::create([
                    'name' => ucwords($request->name),
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'aktivasi' => Hash::make($request->username),
                    'email' => $request->email,
                    'role_id' =>'6',
                    
                ]);
                echo'ok';
            }
        }
  
    }

    
}
