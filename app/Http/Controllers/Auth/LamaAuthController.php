<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\User;
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
        $rules = [
            'name'                  => 'required|alpha',
            'username'              => 'required|numeric',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed'
        ];
  
        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.alpha'            => 'Nama Harus diisi huruf',
            'username.required'     => 'Username Harus diisi',
            'username.numeric'      => 'Username Harus diisi angka',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $aktivasi=Hash::make($request->username.$request->email);
        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->username =$request->username;
        $user->aktivasi = $aktivasi;
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->sts = 0;
        $simpan = $user->save();
        if($simpan){
            $nama=$aktivasi;
            $untuk=$request->name;
            $kirim = Mail::to($request->email)->send(new KirimEmail($nama,$untuk));
    
            if($kirim){
                return redirect()->route('login');
            }else{
                return redirect('/register')->with(['success' => 'Pesan Berhasil']);
            }
            
        }
  
    }

    public function proseslogin(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];
  
        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];
  
        Auth::attempt($data);
  
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('/');
  
        } else { // false
  
            //Login Fail
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }
  
    }
    public function simpan(request $request){
        $rules = [
            'nama'                 => 'required|max:10',
            'notelepon'              => 'required'
        ];
  
        $messages = [
            'nama.required'        => 'nama wajib diisi',
            'nama.max'        => 'nama maxsimal 10 karakter',
            'notelepon.required'     => 'notelepon wajib diisi',
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
    }
    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }

    
}
