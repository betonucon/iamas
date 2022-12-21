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
use App\Revisi;
use Artisan;
use PDF;
use Illuminate\Support\Facades\Hash;
class QcController extends Controller
{
    public function index(request $request){
        $menu='QC Audit';
        if(Auth::user()['role_id']==5){
            $side="auditpengawas";
            return view('Qc.index',compact('menu','side'));
        }
        
        else{

        }
        
    }
    public function index_head(request $request){
        $menu='LHA Hasil QC Audit';
        if(Auth::user()['role_id']==6){
            $side="audithead";
            return view('Qc.index_head',compact('menu','side'));
        }
        
        else{

        }
        
    }
    public function index_temuan(request $request){
        $menu='Temuan ';
        $side="no";
        return view('Qc.index_temuan',compact('menu','side'));
        
    }
    public function index_temuan_head(request $request){
        $menu='Temuan ';
        $side="no";
        return view('Qc.index_temuan_head',compact('menu','side'));
        
    }
    public function index_temuan_ketua(request $request){
        $menu='Temuan ';
        $side="no";
        return view('Qc.index_temuan_ketua',compact('menu','side'));
        
    }
    public function index_temuan_pengawas(request $request){
        $menu='Temuan ';
        $side="no";
        return view('Qc.index_temuan_pengawas',compact('menu','side'));
        
    }
    public function view_temuan(request $request){
        $id=encoder($request->id);
        $data=Audit::where('id',$id)->first();
        $kesimpulan=Kesimpulan::where('audit_id',$id)->orderBy('id','asc')->get();
        $menu='Temuan '.$data['nomorsurat'];
        $side="auditpengawas";
        return view('Qc.view_temuan',compact('menu','side','data','id','kesimpulan'));
        
    }
    public function index_revisi(request $request){
        $menu='Laporan Perbaikan Audit';
        $side="auditpengawas";
        return view('Qc.revisi',compact('menu','side'));
        
        
    }
    public function proses_pengerjaan(request $request){
        $data=Revisi::where('id',$request->id)->first();
        if($request->sts==1){
                if($data['kategori']=='file_lha'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_file_lha'=>0,
                    ]);
                }
                if($data['kategori']=='deskaudit_langkah'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_deskaudit_langkah'=>2,
                    ]);
                }
                if($data['kategori']=='deskaudit_catatan'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_deskaudit_catatan'=>2,
                    ]);
                }
                if($data['kategori']=='compliance_langkah'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_compliance_langkah'=>2,
                    ]);
                }
                if($data['kategori']=='compliance_catatan'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_compliance_catatan'=>2,
                    ]);
                }
                if($data['kategori']=='substantive_langkah'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_substantive_langkah'=>2,
                    ]);
                }
                if($data['kategori']=='substantive_catatan'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_substantive_catatan'=>2,
                    ]);
                }
                if($data['kategori']=='draf_lha'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_lha'=>2,
                    ]);
                }
                if($data['kategori']=='draf_lha_saran'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_lha_saran'=>2,
                    ]);
                }

                if($save){
                    $ubah=Revisi::where('id',$request->id)->update([
                        'sts'=>4,
                        'keterangan'=>'Dalam proses perbaikan'
                    ]);
                    echo'ok';
                }
        }else{
                if($data['kategori']=='file_lha'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_file_lha'=>2,
                    ]);
                }
                if($data['kategori']=='deskaudit_langkah'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_deskaudit_langkah'=>1,
                    ]);
                }
                if($data['kategori']=='deskaudit_catatan'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_deskaudit_catatan'=>1,
                    ]);
                }
                if($data['kategori']=='compliance_langkah'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_compliance_langkah'=>1,
                    ]);
                }
                if($data['kategori']=='compliance_catatan'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_compliance_catatan'=>1,
                    ]);
                }
                if($data['kategori']=='substantive_langkah'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_substantive_langkah'=>1,
                    ]);
                }
                if($data['kategori']=='substantive_catatan'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_substantive_catatan'=>1,
                    ]);
                }
                if($data['kategori']=='draf_lha'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_lha'=>1,
                    ]);
                }
                if($data['kategori']=='draf_lha_saran'){
                    $save=Audit::where('id',$data->audit_id)->update([
                        'sts_revisi_lha_saran'=>1,
                    ]);
                }

                if($save){
                    $ubah=Revisi::where('id',$request->id)->update([
                        'sts'=>0,
                        'keterangan'=>'Review Ulang',
                        'sampai'=>date('Y-m-d')
                    ]);
                    echo'ok';
                }
        }
        
        
    }

    
    public function view(request $request){
        $id=$request->id;
        $data=Audit::where('id',$id)->first();
        
        $menu='Pemeriksaan';
        $side="auditpengawas";
        return view('Qc.view',compact('menu','side','id','data'));
        
            
    }
    
    
    public function proses_revisi(request $request){
        if(aksi_proses($request->audit_id,$request->kategori)=='0'){
            if (trim($request->audit_id) == '') {$error[] = '- Pilih Obyek Audit';}
            if (trim($request->sts) == '') {$error[] = '- Pilih Status ';}
            if (isset($error)) {echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                $tiket=Audit::where('id',$request->audit_id)->first();
                if($request->sts==2){
                    if (trim($request->keterangan) == '') {$error[] = '- Lengkapi keterangan revisi ';}
                    if (isset($error)) {echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                    else{
                        $cekrevisi=Revisi::where('kategori',$request->kategori)->where('audit_id',$request->audit_id)->count();
                        if($cekrevisi>0){
                            $updaterevisi=Revisi::where('kategori',$request->kategori)->where('audit_id',$request->audit_id)->update([
                                'sts'=>6
                            ]);
                            if($updaterevisi){
                                if($request->kategori=='file_lha'){
                                    if($request->file==''){
                                        echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />- Upload file yang direkomendasikan</p>';
                                    }else{
                                        $image = $request->file('file');
                                        $size = $image->getSize();
                                        $imageFileName ='REKOMLHA'.$tiket->surattugas['nomortiket'].'.'. $image->getClientOriginalExtension();
                                        $filePath =$imageFileName;
                                        $file = \Storage::disk('public_uploads');
                                        if($image->getClientOriginalExtension()=='doc' || $image->getClientOriginalExtension()=='docx'){
                                            if($file->put($filePath, file_get_contents($image))){
                                                $revisi=Revisi::create([
                                                    'audit_id'=>$request->audit_id,
                                                    'tiket_id'=>$tiket['tiket_id'],
                                                    'kategori'=>$request->kategori,
                                                    'keterangan'=>$request->keterangan,
                                                    'mulai'=>date('Y-m-d'),
                                                    'sampai'=>tgl_kedepan(date('Y-m-d'),14),
                                                    'sts'=>1,
                                                    'file'=>$filePath,
                                                    'role_id'=>Auth::user()['role_id'],
                                                ]);
                
                                                echo'ok';
                                            }else{
                                                echo'gagal';
                                            }
                                        }else{
                                            echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />- Upload file Dokumen .doc|docx</p>'; 
                                        }
                                    }
                                }else{
                                    $revisi=Revisi::create([
                                        'audit_id'=>$request->audit_id,
                                        'tiket_id'=>$tiket['tiket_id'],
                                        'kategori'=>$request->kategori,
                                        'keterangan'=>$request->keterangan,
                                        'mulai'=>date('Y-m-d'),
                                        'sampai'=>tgl_kedepan(date('Y-m-d'),14),
                                        'sts'=>1,
                                        'role_id'=>Auth::user()['role_id'],
                                    ]);
        
                                    echo'ok';
                                }
                                        
                            }
                        }else{
                            if($request->kategori=='file_lha'){
                                if($request->file==''){
                                    echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />- Upload file yang direkomendasikan</p>';
                                }else{
                                    $image = $request->file('file');
                                    $size = $image->getSize();
                                    $imageFileName ='REKOMLHA'.$tiket->surattugas['nomortiket'].'.'. $image->getClientOriginalExtension();
                                    $filePath =$imageFileName;
                                    $file = \Storage::disk('public_uploads');
                                    if($image->getClientOriginalExtension()=='doc' || $image->getClientOriginalExtension()=='docx'){
                                        if($file->put($filePath, file_get_contents($image))){
                                            $revisi=Revisi::create([
                                                'audit_id'=>$request->audit_id,
                                                'tiket_id'=>$tiket['tiket_id'],
                                                'kategori'=>$request->kategori,
                                                'keterangan'=>$request->keterangan,
                                                'mulai'=>date('Y-m-d'),
                                                'sampai'=>tgl_kedepan(date('Y-m-d'),14),
                                                'sts'=>1,
                                                'file'=>$filePath,
                                                'role_id'=>Auth::user()['role_id'],
                                            ]);
            
                                            echo'ok';
                                        }else{
                                            echo'gagal';
                                        }
                                    }else{
                                        echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />- Upload file Dokumen .doc|docx</p>'; 
                                    }
                                }
                            }else{
                                $revisi=Revisi::create([
                                    'audit_id'=>$request->audit_id,
                                    'tiket_id'=>$tiket['tiket_id'],
                                    'kategori'=>$request->kategori,
                                    'keterangan'=>$request->keterangan,
                                    'mulai'=>date('Y-m-d'),
                                    'sampai'=>tgl_kedepan(date('Y-m-d'),14),
                                    'sts'=>1,
                                    'role_id'=>Auth::user()['role_id'],
                                ]);
    
                                echo'ok';
                            }
                        }
                            
                            
                        
                    }
                }else{
                    
                        $cekrevisi=Revisi::where('kategori',$request->kategori)->where('audit_id',$request->audit_id)->count();
                        if($cekrevisi>0){
                            $updaterevisi=Revisi::where('kategori',$request->kategori)->where('audit_id',$request->audit_id)->update([
                                'sts'=>2,
                                'sampai'=>date('Y-m-d')
                            ]);
                            if($updaterevisi){
                                
                                echo'ok';
                            }
                        }else{
                            $revisi=Revisi::create([
                                'audit_id'=>$request->audit_id,
                                'tiket_id'=>$tiket['tiket_id'],
                                'kategori'=>$request->kategori,
                                'keterangan'=>$request->keterangan,
                                'mulai'=>date('Y-m-d'),
                                'sampai'=>date('Y-m-d'),
                                'sts'=>2,
                                'role_id'=>Auth::user()['role_id'],
                            ]);

                            echo'ok';
                        }
                            
                    
                }
            }
        }else{
            echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br /> Halam ini belum terupdaten, silahkan refresh</p>';
        }

        
    }
    // public function save_rekomendasi(request $request){
    //     if($request->act=='New'){
    //         if (trim($request->kesimpulan_id) == '') {$error[] = '- Pilih Obyek Audit';}
    //         if (trim($request->kode_unit) == '') {$error[] = '- Pilih unit kerja ';}
    //         if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
    //         if (trim($request->content) == '') {$error[] = '- Lengkapi isi kesimpulan';}
    //         if (trim($request->nilai) == '') {$error[] = '- Lengkapi isi nilai';}
    //         if (isset($error)) {echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
    //         else{
    //             $data=Rekomendasi::create([
    //                 'kesimpulan_id'=>$request->kesimpulan_id,
    //                 'nomor'=>$request->nomor,
    //                 'kode_unit'=>$request->kode_unit,
    //                 'isi'=>$request->content,
    //                 'kodifikasi'=>$request->kodifikasi,
    //                 'nilai'=>ubah_uang($request->nilai),
    //             ]);

    //             $get=Rekomendasi::where('kesimpulan_id',$request->kesimpulan_id)->orderBy('id','Asc')->get();
    //             if($data){
    //                 foreach($get as $no=>$o){
                        
    //                     $data=Rekomendasi::where('id',$o['id'])->update([
    //                         'urutan'=>($no+1),
    //                     ]);
    //                 }

    //                 echo'ok';
    //             }
                
    //         }
    //     }else{
    //         if (trim($request->kode_unit) == '') {$error[] = '- Pilih unit kerja ';}
    //         if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
    //         if (trim($request->content) == '') {$error[] = '- Lengkapi isi kesimpulan';}
    //         if (trim($request->nilai) == '') {$error[] = '- Lengkapi isi nilai';}
    //         if (isset($error)) {echo '<p style="padding:5px;color:#000;background:#d5d3d2;font-weight:bold;font-size:12px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
    //         else{
    //             $data=Rekomendasi::where('id',$request->rekomendasi_id)->update([
    //                 'kode_unit'=>$request->kode_unit,
    //                 'isi'=>$request->content,
    //                 'kodifikasi'=>$request->kodifikasi,
    //                 'nilai'=>ubah_uang($request->nilai),
    //             ]);

    //             if($data){
                
    //                 echo'ok';
    //             }
                
    //         }108597
    //     }
    // }
    public function send_to_head(request $request){
        $data=Audit::where('id',$request->id)->update([
            'sts_lha'=>4,
            'tgl_sts11'=>date('Y-m-d'),
        ]);

        echo'ok';
    }
    public function penerbitan_lha(request $request){
        if($request->sts==''){
            echo'PILIH STATUS';
        }else{
            $master=Audit::where('id',$request->id)->first();
            if($request->sts==2){
                $data=Audit::where('id',$request->id)->update([
                    'sts_lha'=>3,
                    'alasan_penerbitan'=>$request->keterangan,
                ]);

                $trc=Revisi::where('audit_id',$request->id)->delete();
                echo'ok';
            }else{
        // $cek=Audit::whereIn('kode_aktivitas',array('04','05','06'))->where('bulan',date('m'))->where('tahun',date('Y'))->count();
                $cek=Audit::where('urutan_penerbitan','>',0)->where('bulan',$master['bulan'])->where('tahun',$master['tahun'])->count();
                
                if($cek>0){
                    $nom=Audit::where('bulan',$master['bulan'])->where('tahun',$master['tahun'])->orderBy('urutan_penerbitan','Desc')->firstOrfail();
                    $urutan_penerbitan=($nom['urutan_penerbitan']+1);
                    $kd=sprintf("%02s", ($nom['urutan_penerbitan']+1));
                }else{
                    $urutan_penerbitan=1;
                    $kd=sprintf("%02s",1);
                }
                $data=Audit::where('id',$request->id)->update([
                    'sts_lha'=>5,
                    'sts'=>12,
                    'urutan_penerbitan'=>$urutan_penerbitan,
                ]);

                $get=Kesimpulan::where('audit_id',$request->id)->where('kode_sumber','LHP')->orderBy('id','Asc')->get();
                foreach($get as $x=>$o){
                    $bulan=date('m');
                    $kodesumber=$o['kode_sumber'];
                    $tahun=date('Y');
                    $tahunkode=date('y');
                    $nomorkode=$kodesumber.$tahunkode.kode_bulan($bulan).$kd;
                    $data=Kesimpulan::where('id',$o['id'])->update([
                        'nomorkode'=>$nomorkode,
                        'nomor_penerbitan'=>'6.'.($x+1),
                        
                        
                    ]);
                    $rekom=Rekomendasi::where('kesimpulan_id',$o['id'])->update([
                        'terbit'=>date('Y-m-d H:i:s'),
                        'terbit_p'=>date('Y-m-d H:i:s'),
                        'sts'=>1,
                        'sts_tl'=>'B',
                        'nomor'=>'6.'.($x+1),
                        'nomorkode'=>$nomorkode,
                        'kode_sumber'=>$kodesumber,
                    ]);
                }

                $getlha=Kesimpulan::where('audit_id',$request->id)->where('kode_sumber','LHA')->orderBy('id','Asc')->get();
                foreach($getlha as $x=>$o){
                    $bulan=date('m');
                    $kodesumber=$o['kode_sumber'];
                    $tahun=date('Y');
                    $tahunkode=date('y');
                    $nomorkode=$kodesumber.$tahunkode.kode_bulan($bulan).$kd;
                    $data=Kesimpulan::where('id',$o['id'])->update([
                        'nomorkode'=>$nomorkode,
                        'nomor_penerbitan'=>'6.'.($x+1),
                        
                        
                    ]);
                    $rekom=Rekomendasi::where('kesimpulan_id',$o['id'])->update([
                        'terbit'=>date('Y-m-d H:i:s'),
                        'terbit_p'=>date('Y-m-d H:i:s'),
                        'sts'=>1,
                        'sts_tl'=>'B',
                        'nomor'=>'6.'.($x+1),
                        'nomorkode'=>$nomorkode,
                        'kode_sumber'=>$kodesumber,
                    ]);
                }

                $getlhp=Kesimpulan::where('audit_id',$request->id)->where('kode_sumber','LHK')->orderBy('id','Asc')->get();
                foreach($getlhp as $x=>$o){
                    $bulan=date('m');
                    $kodesumber=$o['kode_sumber'];
                    $tahun=date('Y');
                    $tahunkode=date('y');
                    $nomorkode=$kodesumber.$tahunkode.kode_bulan($bulan).$kd;
                    $data=Kesimpulan::where('id',$o['id'])->update([
                        'nomorkode'=>$nomorkode,
                        'nomor_penerbitan'=>'6.'.($x+1),
                        
                        
                    ]);
                    $rekom=Rekomendasi::where('kesimpulan_id',$o['id'])->update([
                        'terbit'=>date('Y-m-d H:i:s'),
                        'terbit_p'=>date('Y-m-d H:i:s'),
                        'sts'=>1,
                        'sts_tl'=>'B',
                        'nomor'=>'6.'.($x+1),
                        'nomorkode'=>$nomorkode,
                        'kode_sumber'=>$kodesumber,
                    ]);
                }
                echo'ok';
            }
        }
    }

    public function update_rekomendasi(request $request){
        
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
