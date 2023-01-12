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
class LhaController extends Controller
{
    public function index(request $request){
        error_reporting(0);
        $menu='LHA';
        if(akses_tiket_ketua()>0 || akses_tiket_anggota()>0){
            $side="auditpengawas";
            return view('LHA.index',compact('menu','side'));
        }
        elseif(akses_tiket_pengawas()>0){
            $side="auditpengawas";
            return view('LHA.index_pengawas',compact('menu','side'));
        }
        elseif(akses_tiket_head()>0){
            $side="audithead";
            return view('LHA.index_head',compact('menu','side'));
        }
        else{

        }
        
    }
    public function index_ketua(request $request){
        error_reporting(0);
        $menu='LHA';
        $side="auditpengawas";
        return view('LHA.index_ketua',compact('menu','side'));
        
    }

    public function index_acc(request $request){
        error_reporting(0);
        $menu='LHA';
        $side="audithead";
        return view('LHA.index_acc',compact('menu','side'));
    }

    public function create(request $request){
        error_reporting(0);
        $id=encoder($request->id);
        $halaman=$request->halaman;
        $act=$request->act;
        $data=Audit::where('id',$id)->first();
        if(akses_tiket_ketua()>0 || akses_tiket_anggota()>0){
                if($data->sts_lha=='0' || $data->sts_lha==''){
                    $menu='Buat Kesimpulan';
                    $side="auditpengawas";
                    return view('LHA.create',compact('menu','halaman','side','id','act'));
                }else{
                    if($data->sts_revisi_lha=='2'){
                        $menu='Revisi Kesimpulan';
                        $side="auditpengawas";
                        return view('LHA.create',compact('menu','halaman','side','id','act'));
                    }else{
                        $menu='View Kesimpulan';
                        $side="auditpengawas";
                        return view('LHA.view_temuan',compact('menu','halaman','side','id'));
                    }
                    
                }
        }else{
                    $menu='View Kesimpulan';
                    $side="auditpengawas";
                    return view('LHA.view_temuan',compact('menu','halaman','side','id'));
        }
            
    }
    public function view_head(request $request){
        error_reporting(0);
        $id=encoder($request->id);
        $data=Audit::where('id',$id)->first();
        if($request->aksi==''){
            $menu='View Draf LHA (Kesimpulan/Temuan)';
            $side="auditpengawas";
            return view('LHA.view_lha',compact('menu','side','id'));
        }
        else{
            $menu='View Draf LHA (Rekomendasi)';
            $side="auditpengawas";
            $kesimpulan=Kesimpulan::where('audit_id',$id)->orderBy('id','Asc')->firstOrfail();
            if($request->nomor==''){
                $kesimpulan_id=$kesimpulan['id'];
                $namakesimpulan=$kesimpulan['name'];
                $nomor=$kesimpulan['nomor'];
            }else{
                $nomkesimpulan=Kesimpulan::where('audit_id',$id)->where('id',$request->nomor)->first();
                $kesimpulan_id=$nomkesimpulan['id'];
                $namakesimpulan=$nomkesimpulan['name'];
                $nomor=$nomkesimpulan['nomor'];
            }
            return view('LHA.view_lha_rekomendasi',compact('menu','side','id','kesimpulan_id','nomor','namakesimpulan'));
        }
        
        
            
    }
    public function view(request $request){
        error_reporting(0);
        $id=$request->id;
        return view('LHA.view',compact('id'));
    }
    public function tampiltambahtemuan(request $request){
        error_reporting(0);
        
        $id=$request->id;
        
        if($request->kesimpulan_id==''){
            $kesimpulan_id='0';
            $act='New';
        }else{
            $kesimpulan_id=$request->kesimpulan_id;
            $act='Edit';
        }
        $data=Kesimpulan::where('id',$kesimpulan_id)->first();
        return view('LHA.modaltemuan',compact('id','kesimpulan_id','data','act'));
    }
    public function tampiltambahrekomendasi(request $request){
        error_reporting(0);
        
        $kesimpulan_id=$request->kesimpulan_id;
        $nomor=$request->nomor;
        
        if($request->rekomendasi_id==''){
            $rekomendasi_id='0';
            $act='New';
        }else{
            $rekomendasi_id=$request->rekomendasi_id;
            $act='Edit';
        }
        $data=Rekomendasi::where('id',$rekomendasi_id)->first();
        return view('LHA.modalrekomendasi',compact('kesimpulan_id','nomor','rekomendasi_id','data','act'));
    }
    public function word(request $request){
        error_reporting(0);
        $id=$request->id;
        return view('LHA.word',compact('id'));
    }
    public function createrekomendasi(request $request){
        error_reporting(0);
        $id=encoder($request->id);
        $ide=$request->id;
        $act=$request->act;
        $halaman=$request->halaman;
        $data=Audit::where('id',$id)->first();
        $kesimpulan=Kesimpulan::where('audit_id',$id)->orderBy('id','Asc')->firstOrfail();
        if($request->nomor==''){
            $kesimpulan_id=$kesimpulan['id'];
            $namakesimpulan=$kesimpulan['name'];
            $nomor=$kesimpulan['nomor'];
        }else{
            $nomkesimpulan=Kesimpulan::where('audit_id',$id)->where('id',$request->nomor)->first();
            $namakesimpulan=$nomkesimpulan['name'];
            $kesimpulan_id=$nomkesimpulan['id'];
            $nomor=$nomkesimpulan['nomor'];
        }
        if(akses_tiket_ketua()>0 || akses_tiket_anggota()>0){
                if($data->sts_lha=='0'  || $data->sts_lha==''){
                    $menu='Buat Rekomendasi';
                    $side="auditpengawas";
                    return view('LHA.createrekomendasi',compact('menu','halaman','side','id','ide','kesimpulan_id','nomor','act','namakesimpulan'));
                }else{
                    if($data->sts_revisi_lha_saran=='2'){
                        $menu='Revisi Rekomendasi';
                        $side="auditpengawas";
                        return view('LHA.createrekomendasi',compact('menu','halaman','side','id','ide','kesimpulan_id','nomor','act','namakesimpulan'));
                    }else{
                        $menu='View Rekomendasi';
                        $side="auditpengawas";
                        return view('LHA.view_rekomendasi',compact('menu','halaman','side','id','ide','kesimpulan_id','nomor','namakesimpulan'));
                    }
                    
                }
        }else{
            $menu='View Rekomendasi';
            $side="auditpengawas";
            return view('LHA.view_rekomendasi',compact('menu','halaman','side','id','ide','kesimpulan_id','nomor','namakesimpulan'));
        }
        
        
    }

    public function edit(request $request){
        error_reporting(0);
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
        error_reporting(0);
        
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

    
   
    
    public function delete(request $request){
        error_reporting(0);
        $data=Kesimpulan::where('id',$request->id)->delete();
        $rekomen=Rekomendasi::where('kesimpulan_id',$request->id)->delete();
    }
    public function delete_rekomendasi(request $request){
        error_reporting(0);
        $delete=Rekomendasi::where('id',$request->id)->delete();
        $get=Rekomendasi::where('kesimpulan_id',$request->kesimpulan_id)->orderBy('id','Asc')->get();
                
        $audit=Kesimpulan::where('id',$request->kesimpulan_id)->first();
        foreach($get as $no=>$o){
            
            $data=Rekomendasi::where('id',$o['id'])->update([
                'urutan'=>($no+1),
                'audit_id'=>$audit['audit_id'],
            ]);
        }
    }

    public function send_to_head(request $request){
        error_reporting(0);
        $data=Audit::where('id',$request->audit_id)->update([
            'sts_lha'=>3,
            
            'tgl_sts10'=>date('Y-m-d'),
        ]);
        echo'ok';
    }
    public function upload_data(request $request){
        error_reporting(0);
        $audit=Audit::where('id',$request->audit_id)->first();
        if($request->file==""){echo'Upload file';}
        else{
            $image = $request->file('file');
            $size = $image->getSize();
            $imageFileName ='LHA'.$audit->surattugas['nomortiket'].'.'. $image->getClientOriginalExtension();
            $filePath =$imageFileName;
            $file = \Storage::disk('public_uploads');
            if($image->getClientOriginalExtension()=='doc' || $image->getClientOriginalExtension()=='docx'){
                if($file->put($filePath, file_get_contents($image))){
                    $data=Audit::where('id',$request->audit_id)->update([
                        'file_lha'=>$filePath,
                        'sts_file_lha'=>1,
                    ]);
                    echo'ok';
                }else{

                }
            }else{
                echo'Format file harus word .doc|docx';
            }
        }
    }

    public function send_to_pengawas(request $request){
        error_reporting(0);
        
        $id=encoder($request->audit_id);
        if($request->sts=='0'){
            $data=Audit::where('id',$id)->update([
                'sts_lha'=>$request->sts,
                
                'alasan_lha'=>$request->alasan,
            ]);
            echo'ok';
        }else{
            
            $lha=Kesimpulan::where('audit_id',$id)->whereNull('kdr')->where('kode_sumber','LHA')->orderBy('id','Asc')->get();
            foreach($lha as $x=>$o){
                $bulan=date('m');
                $kodesumber='LHA';
                $tahun=date('Y');
                $tahunkode=date('y');
                $cekcount=Kesimpulan::where('bulan',$bulan)->where('tahun',$tahun)->where('kode_sumber','LHA')->where('kdr','>',0)->count();
                if($cekcount>0){
                    $cek=Kesimpulan::where('bulan',$bulan)->where('tahun',$tahun)->where('kode_sumber','LHA')->where('kdr','>',0)->orderBy('id','Desc')->firstOrfail();
                    $nm=$cek['kdr'];
                }else{
                    $nm=0;
                }
                $nomor=$nm+1;
                $kesi=Kesimpulan::where('id',$o['id'])->update([
                    'kdr'=>$nomor,
                ]);
            }
            $lhp=Kesimpulan::where('audit_id',$id)->whereNull('kdr')->where('kode_sumber','LHP')->orderBy('id','Asc')->get();
            foreach($lhp as $x=>$o){
                $bulan=date('m');
                $kodesumber='LHP';
                $tahun=date('Y');
                $tahunkode=date('y');
                $cekcount=Kesimpulan::where('bulan',$bulan)->where('tahun',$tahun)->where('kode_sumber','LHP')->where('kdr','>',0)->count();
                if($cekcount>0){
                    $cek=Kesimpulan::where('bulan',$bulan)->where('tahun',$tahun)->where('kode_sumber','LHP')->where('kdr','>',0)->orderBy('id','Desc')->firstOrfail();
                    $nm=$cek['kdr'];
                }else{
                    $nm=0;
                }
                $nomor=($nm+1);
                $kesi=Kesimpulan::where('id',$o['id'])->update([
                    'kdr'=>$nomor,
                ]);
            }
            $data=Audit::where('id',$id)->update([
                'sts_lha'=>3,
                'tgl_sts10'=>date('Y-m-d'),
                'sts'=>10,
            ]);
            echo'ok';
            
        }   
            
    }

    public function save(request $request){
        error_reporting(0);
        if($request->act=='New'){
            if (trim($request->audit_id) == '') {$error[] = '- Pilih Obyek Audit';}
            if (trim($request->name) == '') {$error[] = '- Lengkapi judul ';}
            if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
            if (trim($request->content) == '') {$error[] = '- Lengkapi isi kesimpulan';}
            if (trim($request->risiko) == '') {$error[] = '- Lengkapi isi risiko';}
            if (isset($error)) {echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                $audit=Audit::where('id',$request->audit_id)->first();
                $data=Kesimpulan::create([
                    'audit_id'=>$request->audit_id,
                    'name'=>$request->name,
                    'risiko'=>$request->risiko,
                    'estimasi'=>$request->estimasi,
                    'ket_risiko'=>ket_risiko($request->risiko),
                    'kodifikasi'=>$request->kodifikasi,
                    'kode'=>$audit['kode_aktivitas'],
                    'isi'=>$request->content,
                    'sts'=>1,
                    'kode_sumber'=>kodesumber(ket_risiko($request->risiko),$audit['kode_aktivitas'],$request->kodifikasi),
                    'tanggal'=>date('Y-m-d'),
                    'bulan'=>date('m'),
                    'tahun'=>date('Y'),
                ]);

                $get=Kesimpulan::where('audit_id',$request->audit_id)->orderBy('id','Asc')->get();
                if($data){
                    foreach($get as $no=>$o){
                        $nomor='6.'.($no+1);
                        $data=Kesimpulan::where('id',$o['id'])->update([
                            'nomor'=>$nomor,
                            
                            
                        ]);
                        
                    }

                    echo'ok';
                }
                
            }

        }else{
            if (trim($request->kesimpulan_id) == '') {$error[] = '- Error ';}
            if (trim($request->name) == '') {$error[] = '- Lengkapi judul ';}
            if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
            if (trim($request->content) == '') {$error[] = '- Lengkapi isi kesimpulan';}
            if (trim($request->risiko) == '') {$error[] = '- Lengkapi isi risiko';}
            if (isset($error)) {echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                $kesim=Kesimpulan::where('id',$request->kesimpulan_id)->first();
                
                $data=Kesimpulan::where('id',$request->kesimpulan_id)->update([
                    'name'=>$request->name,
                    'estimasi'=>$request->estimasi,
                    'risiko'=>$request->risiko,
                    'ket_risiko'=>ket_risiko($request->risiko),
                    'kode_sumber'=>kodesumber(ket_risiko($request->risiko),$kesim['kode'],$request->kodifikasi),
                    'kodifikasi'=>$request->kodifikasi,
                    'isi'=>$request->content,
                ]);

                if($data){
                    echo'ok';
                }
                
            }
        }
    }
    public function save_rekomendasi(request $request){
        error_reporting(0);
        if($request->act=='New'){
            if (trim($request->kesimpulan_id) == '') {$error[] = '- Pilih Obyek Audit';}
            if (trim($request->kode_unit) == '') {$error[] = '- Pilih unit kerja ';}
            if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
            if (trim($request->content) == '') {$error[] = '- Lengkapi isi kesimpulan';}
            if (trim($request->risiko) == '') {$error[] = '- Lengkapi isi risko';}
            if (isset($error)) {echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                $kesim=Kesimpulan::where('id',$request->kesimpulan_id)->first();
                $data=Rekomendasi::create([
                    'kesimpulan_id'=>$request->kesimpulan_id,
                    'nomor'=>$request->nomor,
                    'estimasi'=>$request->estimasi,
                    'kode_unit'=>$request->kode_unit,
                    'isi'=>$request->content,
                    'kodifikasi'=>$request->kodifikasi,
                    'risiko'=>$request->risiko,
                    'kode'=>$kesim['kode'],
                    'ket_risiko'=>ket_risiko($request->risiko),
                    'sts'=>0,
                ]);

                $get=Rekomendasi::where('kesimpulan_id',$request->kesimpulan_id)->orderBy('id','Asc')->get();
                
                if($data){
                    $audit=Kesimpulan::where('id',$request->kesimpulan_id)->first();
                    foreach($get as $no=>$o){
                        
                        $data=Rekomendasi::where('id',$o['id'])->update([
                            'urutan'=>($no+1),
                            'audit_id'=>$audit['audit_id'],
                        ]);
                    }

                    echo'ok';
                }
                
            }
        }else{
            if (trim($request->kode_unit) == '') {$error[] = '- Pilih unit kerja ';}
            if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
            if (trim($request->content) == '') {$error[] = '- Lengkapi isi kesimpulan';}
            if (trim($request->risiko) == '') {$error[] = '- Lengkapi isi risiko';}
            if (isset($error)) {echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                $kesim=Rekomendasi::where('id',$request->rekomendasi_id)->first();
                $data=Rekomendasi::where('id',$request->rekomendasi_id)->update([
                    'kode_unit'=>$request->kode_unit,
                    'isi'=>$request->content,
                    'estimasi'=>$request->estimasi,
                    'kodifikasi'=>$request->kodifikasi,
                    'risiko'=>$request->risiko,
                    'ket_risiko'=>ket_risiko($request->risiko),
                ]);

                if($data){
                
                    echo'ok';
                }
                
            }
        }
    }
    public function send_data(request $request){
        error_reporting(0);
        $data=Audit::where('id',$request->audit_id)->update([
            'sts_lha'=>1,
            'sts'=>9,
        ]);

        echo'ok';
    }

    public function update_rekomendasi(request $request){
        error_reporting(0);
        
        if (trim($request->kode_unit) == '') {$error[] = '- Pilih unit kerja ';}
        if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
        if (trim($request->isi) == '') {$error[] = '- Lengkapi isi kesimpulan';}
        if (trim($request->nilai) == '') {$error[] = '- Lengkapi isi nilai';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data=Rekomendasi::where('id',$request->id)->update([
                'kode_unit'=>$request->kode_unit,
                'isi'=>$request->isi,
                'kodifikasi'=>$request->kodifikasi,
                'nilai'=>ubah_uang($request->nilai),
            ]);

            $get=Rekomendasi::where('kesimpulan_id',$request->kesimpulan_id)->orderBy('id','Asc')->get();
            if($data){
               
                echo'ok';
            }
            
        }
    }
    

    

    public function acc_head(request $request){
        error_reporting(0);
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
        error_reporting(0);
        $data=Lha::where('id',$request->id)->first();
        $tim=TimLha::where('tiket_id',$data['tiket_id'])->where('role_id','!=',6)->orderBy('id','Asc')->get();
        $pdf = PDF::loadView('pdf.LHA', compact('data','tim'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
    }
}
