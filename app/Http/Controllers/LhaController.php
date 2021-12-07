<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Audit;
use App\Lha;
use App\Timaudit;
use App\Surattugas;
use Artisan;
use PDF;
use Illuminate\Support\Facades\Hash;
class LhaController extends Controller
{
    public function index(request $request){
        $menu='LHA';
        $side="auditpengawas";
        return view('LHA.index',compact('menu','side'));
    }

    public function index_acc(request $request){
        $menu='LHA';
        $side="audithead";
        return view('LHA.index_acc',compact('menu','side'));
    }

    public function create(request $request){
        $menu='Buat LHA';
        $side="auditpengawas";
        return view('LHA.create',compact('menu','side'));
    }

    public function edit(request $request){
        $side="auditpengawas";
        $data=Audit::where('tiket_id',$request->id)->first();
        $lha=Lha::where('tiket_id',$request->id)->first();
        if($data['sts_lha']==1){
            $menu='View LHA';
            return view('LHA.edit',compact('menu','data','side','lha'));
        }else{
            $menu='View ';
            return view('LHA.view',compact('menu','data','side'));
        }
        
    }

    public function acc(request $request){
        
        $data=Lha::where('tiket_id',$request->id)->first();
        $side="audithead";
        if($data['sts_audit']==1){
            $menu='Approve ';
            return view('LHA.acc_head',compact('menu','data','side'));
        }else{
            $menu='View ';
            return view('LHA.view',compact('menu','data','side'));
        }
        
        
    }

    public function pilih_surat_tugas(request $request){
        error_reporting(0);
        $data=Surattugas::where('tiket_id',$request->id)->first();
        $pengawas=TimLha::where('tiket_id',$data['tiket_id'])->where('role_id',2)->first();
        $ketua=TimLha::where('tiket_id',$data['tiket_id'])->where('role_id',1)->first();
        $agt=TimLha::where('tiket_id',$data['tiket_id'])->where('role_id',3)->get();
        $anggota='<select class="multiple-select2 form-control" id="mySelect2" disabled name="nik[]" multiple="multiple">';
        foreach($agt as $o){
            $anggota.='<option value="'.$o['nik'].'"selected > '.$o->user['name'].'</option>';
        }
        $anggota.='</select>';
        
        echo $data['name'].'@'.$data['kode_unit'].'@'.$data->unitkerja['name'].'@'.$pengawas->user['name'].'@'.$ketua->user['name'].'@'.$anggota.'@'.$data['sampai'].'@';
        
        echo'
            <script>
                $("#mySelect2").select2();
            </script>

        ';
    }

    
    public function send_to_head(request $request){
        $data=Lha::where('id',$request->id)->update([
            'sts'=>2,
            'tgl_sts2'=>date('Y-m-d'),
        ]);
    }

    public function send_to_pengawas(request $request){
        
            $data=Audit::where('id',$request->id)->update([
                'sts_lha'=>1,
            ]);
            
    }

    public function save(request $request){
        
        if (trim($request->audit_id) == '') {$error[] = '- Pilih Obyek Audit';}
        if (trim($request->latar_belakang) == '') {$error[] = '- Isi Latar Belakang';}
        if (trim($request->sasaran) == '') {$error[] = '- Isi Sasaran';}
        if (trim($request->ruang_lingkup) == '') {$error[] = '- Isi Ruang Lingkup';}
        if (trim($request->pelaksanaan) == '') {$error[] = '- Isi Pelaksanaan';}
        if (trim($request->kesimpulan) == '') {$error[] = '- Isi Kesimpulan';}
        if (trim($request->penjelasan) == '') {$error[] = '- Isi Penjelasan';}
        if (trim($request->penutup) == '') {$error[] = '- Isi Penutup';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $audit=Audit::where('id',$request->audit_id)->first();
            $cek=Lha::where('audit_id',$request->audit_id)->count();
            if($cek>0){
                echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />- Obyek audit ini sudah digunakan</p>';
            }else{
                $data=Lha::create([
                    'latar_belakang'=>$request->latar_belakang,
                    'sasaran'=>$request->sasaran,
                    'ruang_lingkup'=>$request->ruang_lingkup,
                    'pelaksanaan'=>$request->pelaksanaan,
                    'kesimpulan'=>$request->kesimpulan,
                    'penjelasan'=>$request->penjelasan,
                    'penutup'=>$request->penutup,
                    'tiket_id'=>$audit['tiket_id'],
                    'audit_id'=>$request->audit_id,
                    'tanggal'=>date('Y-m-d'),
                    'sts'=>'0',
                ]);
                if($data){
                    $aud=Audit::where('id',$request->audit_id)->update([
                        'sts'=>10,
                        'sts_lha'=>0,
                    ]);
                    echo'ok';
                }else{
                    echo'gagal';
                }
                
            }
        }
    }

    public function update(request $request){
        if (trim($request->audit_id) == '') {$error[] = '- Pilih Obyek Audit';}
        if (trim($request->latar_belakang) == '') {$error[] = '- Isi Latar Belakang';}
        if (trim($request->sasaran) == '') {$error[] = '- Isi Sasaran';}
        if (trim($request->ruang_lingkup) == '') {$error[] = '- Isi Ruang Lingkup';}
        if (trim($request->pelaksanaan) == '') {$error[] = '- Isi Pelaksanaan';}
        if (trim($request->kesimpulan) == '') {$error[] = '- Isi Kesimpulan';}
        if (trim($request->penjelasan) == '') {$error[] = '- Isi Penjelasan';}
        if (trim($request->penutup) == '') {$error[] = '- Isi Penutup';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
            $data=Lha::where('id',$request->id)->where('sts',1)->update([
                'latar_belakang'=>$request->latar_belakang,
                'sasaran'=>$request->sasaran,
                'ruang_lingkup'=>$request->ruang_lingkup,
                'pelaksanaan'=>$request->pelaksanaan,
                'kesimpulan'=>$request->kesimpulan,
                'penjelasan'=>$request->penjelasan,
                'penutup'=>$request->penutup,
                'tanggal'=>date('Y-m-d'),
                'sts'=>'0',
                
            ]);
            echo'ok';
        }
    }

    public function acc_head(request $request){
        if (trim($request->sts) == '') {$error[] = '- Pilih Status';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            if($request->sts==2){
                $acc=Lha::where('id',$request->id)->update([
                    'sts'=>1,
                    'alasan_head'=>$request->alasan,
                ]);
                echo'ok';
            }else{
                $acc=Lha::where('id',$request->id)->update([
                    'sts'=>$request->sts,
                    'tgl_sts3'=>date('Y-m-d'),
                ]);
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
            
        }
    }

    public function file(request $request){
        $data=Lha::where('id',$request->id)->first();
        $tim=TimLha::where('tiket_id',$data['tiket_id'])->where('role_id','!=',6)->orderBy('id','Asc')->get();
        $pdf = PDF::loadView('pdf.LHA', compact('data','tim'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
    }
}
