<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Audit;
use App\Lha;
use App\Timaudit;
use App\Disposisi;
use App\Surattugas;
use App\Kesimpulan;
use App\Rekomendasi;
use Artisan;
use PDF;
use Illuminate\Support\Facades\Hash;
class TemuanController extends Controller
{
    public function index(request $request){
        error_reporting(0);
        $menu='Temuan';
        $side="temuan";
        if($request->tahun==""){
            $tahun=date('Y');
        }else{
            $tahun=$request->tahun;
        }
        if(Auth::user()['role_id']==8){
            return view('Temuan.index',compact('menu','side','tahun'));
        }else{
           return view('error'); 
        }
        
        
    }

    public function proses(request $request){
        error_reporting(0);
        
        if(Auth::user()['role_id']==8){
            $data=Rekomendasi::where('id',encoder($request->id))->first();
            $menu='Temuan '.$data->kesimpulan['nomorkode'].' '.$data->nomor.'.'.$data->urutan;
            $side="temuan";
            return view('Temuan.proses',compact('menu','side','data'));
        }else{
            $data=Rekomendasi::where('id',encoder($request->id))->first();
            $menu='Temuan '.$data->kesimpulan['nomorkode'].' '.$data->nomor.'.'.$data->urutan;
            $side="temuan";
            if(Auth::user()['role_id']==5){
                return view('Temuan.view',compact('menu','side','data'));
            }else{
                if(akses_tiket_head()>0){
                    return view('Temuan.view',compact('menu','side','data'));
                }
            }
        }
        
        
    }

    public function prosesanggota(request $request){
        error_reporting(0);
        
        if(akses_tiket_anggota()>0){
            $data=Rekomendasi::where('id',encoder($request->id))->first();
            $menu='Temuan '.$data->kesimpulan['nomorkode'].' '.$data->nomor.'.'.$data->urutan;
            $side="temuan";
            return view('Temuan.viewanggota',compact('menu','side','data'));
        }else{
            return view('error'); 
        }
        
        
    }

    public function prosesketua(request $request){
        error_reporting(0);
        
        if(akses_tiket_ketua()>0){
            $data=Rekomendasi::where('id',encoder($request->id))->first();
            $menu='Temuan '.$data->kesimpulan['nomorkode'].' '.$data->nomor.'.'.$data->urutan;
            $side="temuan";
            return view('Temuan.viewketua',compact('menu','side','data'));
        }else{
            return view('error'); 
        }
        
        
    }

    public function prosespengawas(request $request){
        error_reporting(0);
        
        if(akses_tiket_pengawas()>0){
            $data=Rekomendasi::where('id',encoder($request->id))->first();
            $menu='Temuan '.$data->kesimpulan['nomorkode'].' '.$data->nomor.'.'.$data->urutan;
            $side="temuan";
            return view('Temuan.viewpengawas',compact('menu','side','data'));
        }else{
            return view('error'); 
        }
        
        
    }

    public function index_anggota(request $request){
        error_reporting(0);
        $menu='Temuan';
        $side="temuan";
        if(akses_tiket_anggota()>0){
            // dd(temuan_anggota_get());
            return view('Temuan.index_anggota',compact('menu','side'));
        }else{
           return view('error'); 
        }
        
        
    }
    public function index_rcd(request $request){
        error_reporting(0);
        $menu='Temuan';
        $side="temuan";
        // if(akses_tiket_anggota()>0){
            // dd(temuan_anggota_get());
            return view('Temuan.index_rcd',compact('menu','side'));
        // }else{
        //    return view('error'); 
        // }
        
        
    }
    public function index_temuan_head(request $request){
        error_reporting(0);
        $menu='Temuan';
        $side="temuan";
        // if(akses_tiket_anggota()>0){
            // dd(temuan_anggota_get());
            return view('Temuan.index_temuan_head',compact('menu','side'));
        // }else{
        //    return view('error'); 
        // }
        
        
    }

    public function index_temuan_ketua(request $request){
        error_reporting(0);
        $menu='Temuan ';
        $side="temuan";
        if(akses_tiket_ketua()>0){
            return view('Temuan.index_temuan_ketua',compact('menu','side'));
        }else{
            return view('error'); 
        }
        
    }
    
    public function index_temuan_pengawas(request $request){
        error_reporting(0);
        $menu='Temuan ';
        $side="temuan";
        if(akses_tiket_pengawas()>0){
            return view('Temuan.index_temuan_pengawas',compact('menu','side'));
        }else{
            return view('error'); 
        }
        
    }

    public function approve(request $request){
        error_reporting(0);
        if($request->name=='RCD'){
            $data=Rekomendasi::where('id',$request->id)->update([
                'sts'=>3,
                'revisi'=>1,
            ]);
        }
        if($request->name=='Anggota'){

        }
        if($request->name=='Pengawas'){
            $data=Rekomendasi::where('id',$request->id)->update([
                'sts'=>5
            ]);
        }
        
    }

    public function send_data(request $request){
        error_reporting(0);
        if (trim($request->status) == '') {$error[] = '-Pilih Status';}
        if (trim($request->catatan) == '') {$error[] = '-Isi Catatan ';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;background:orange;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $rekom=Rekomendasi::where('id',$request->id)->first();
            
            if($request->name=='Anggota'){
                if($request->status==2){
                    if (trim($request->nilai) == '' && $rekom['sts_tl']=='P0') {$error[] = '-Tentukan Penilaian Tindak Lanjut ';}
                    if (isset($error)) {echo '<p style="padding:5px;color:#000;background:orange;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                    else{
                        if($rekom['revisi']==1){
                            $tl='P'.(substr($rekom['sts_tl'],1)+1);
                        }else{
                            $tl=$rekom['sts_tl'];
                        }
                        if($rekom['sts_tl']=='P0'){
                            $nilai=$request->nilai;
                        }else{
                            $nilai=$rekom['nilai'];
                        }
                        
                        $data=Rekomendasi::where('id',$request->id)->update([
                            'sts'=>4,
                            'revisi'=>2,
                            'sts_tl'=>$tl,
                            'tgl_progres'=>date('Y-m-d'),
                            'nilai'=>$nilai,
                        ]);
                        
                        if($rekom['revisi']==1){
                            $dis=Disposisi::create([
                                'catatan'=>$request->catatan,
                                'tanggal'=>date('Y-m-d'),
                                'nomortl'=>$rekom['nomortl'],
                                'rekomendasi_id'=>$rekom['id'],
                                'sts_tl'=>$tl,
                            ]);
                            echo 'ok';
                        }else{
                            $dis=Disposisi::where('sts_tl',$tl)->where('rekomendasi_id',$rekom['id'])->update([
                                'catatan'=>$request->catatan,
                                'tanggal'=>date('Y-m-d'),
                            ]);
                            echo 'ok';
                        }
                    }
                }else{
                    $data=Rekomendasi::where('id',$request->id)->update([
                        'sts'=>4,
                        'sts_tl'=>'S',
                        'tgl_progres'=>date('Y-m-d'),
                        'revisi'=>2,
                        'nilai'=>'A',
                    ]);

                    if($rekom['revisi']==1){
                        $dis=Disposisi::create([
                            'catatan'=>$request->catatan,
                            'tanggal'=>date('Y-m-d'),
                            'nomortl'=>$rekom['nomortl'],
                            'rekomendasi_id'=>$rekom['id'],
                            'sts_tl'=>'S',
                        ]);
                        echo 'ok';
                    }else{
                        $dis=Disposisi::where('sts_tl','S')->where('rekomendasi_id',$rekom['id'])->update([
                            'catatan'=>$request->catatan,
                            'tanggal'=>date('Y-m-d'),
                        ]);
                        echo 'ok';
                    }
                }
            }
        }
    }

    public function send_data_head(request $request){
        error_reporting(0);
        if (trim($request->status) == '') {$error[] = '-Pilih Status';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;background:orange;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $rekom=Rekomendasi::where('id',$request->id)->first();
            if($request->status==1){
                $data=Rekomendasi::where('id',$request->id)->update([
                    'sts'=>5,
                ]);
                echo 'ok';
            }else{
                if (trim($request->catatan) == '') {$error[] = '-Isi catatan/alasan pengembalian';}
                if (isset($error)) {echo '<p style="padding:5px;color:#000;background:orange;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                else{
                    $data=Rekomendasi::where('id',$request->id)->update([
                        'sts'=>3,
                        'revisi'=>3,
                    ]);

                    $dis=Disposisi::where('sts_tl',$rekom['sts_tl'])->where('rekomendasi_id',$request->id)->update([
                        'catatan_pengawas'=>$request->catatan,
                        'tanggal'=>date('Y-m-d'),
                    ]);
                    echo 'ok';
                }
            }
        }
    }

    public function send_data_akhir(request $request){
        error_reporting(0);
        if (trim($request->status) == '') {$error[] = '-Pilih Status';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;background:orange;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $rekom=Rekomendasi::where('id',$request->id)->first();
            if($rekom['sts_tl']=='S'){
                $data=Rekomendasi::where('id',$request->id)->update([
                    'sts'=>6,
                ]);

                
                echo 'ok';
            }else{
               
                    $data=Rekomendasi::where('id',$request->id)->update([
                        'sts'=>1,
                        'terbit_p'=>date('Y-m-d H:i:s'),
                        'revisi'=>3,
                        'nomormtl'=>'M'.$rekom['nomortl'],
                    ]);

                    $dis=Disposisi::where('sts_tl',$rekom['sts_tl'])->where('rekomendasi_id',$request->id)->update([
                        'catatan_pengawas'=>$request->catatan,
                        'nomormtl'=>'M'.$rekom['nomortl'],
                    ]);
                    echo 'ok';
                
            }
        }
    }

    public function simpan(request $request){
        error_reporting(0);
        $cekcreate=Rekomendasi::where('id',$request->id)->first();
        if($cekcreate['sts']==1){
            $aktivitas='08';
            $kodetl='TL'.substr($cekcreate->kesimpulan['kode_sumber'],2);
            $count=Rekomendasi::where('bulan',date('m'))->where('tahun',date('Y'))->where('kode_aktivitas',$aktivitas)->count();
            
            if($count>0){
                $cek=Rekomendasi::where('bulan',date('m'))->where('tahun',date('Y'))->orderBy('nomortiket','Desc')->firstOrfail();
                $urutan = (int) substr($cek['nomortiket'], 9, 2);
                $urutan++;
                $notiket='STIA'.$aktivitas.date('y').kode_bulan(date('m')).sprintf("%02s", $urutan);
            }else{
                $notiket='STIA'.$aktivitas.date('y').kode_bulan(date('m')).sprintf("%02s", 1);
                
            }

            if($cekcreate['nomortiket']!=null){
                $nomortiket=$cekcreate['nomortiket'];
            }else{
                $nomortiket=$notiket;
            }

            $counttl=Rekomendasi::where('bulan',date('m'))->where('tahun',date('Y'))->where('kode_tl',$kodetl)->count();
            
            if($count>0){
                $cektl=Rekomendasi::where('bulan',date('m'))->where('tahun',date('Y'))->orderBy('nomortl','Desc')->firstOrfail();
                $urutantl = (int) substr($cektl['nomortl'], 9, 4);
                $urutantl++;
                $nomortl=$kodetl.date('y').kode_bulan(date('m')).sprintf("%04s", $urutantl);
            }else{
                $nomortl=$kodetl.date('y').kode_bulan(date('m')).sprintf("%04s", 1);
                
            }

            
            if($cekcreate['sts_tl']=="B"){
                
                if($request->act==1){
                    $status=2;
                    $ttl=$nomortl;
                    if($request->file==""){
                        if($cekcreate['file']!=""){
                            $save=Rekomendasi::where('id',$request->id)->update([
                                'catatan'=>$request->content,
                                'kode_aktivitas'=>$aktivitas,
                                'bulan'=>date('m'),
                                'tahun'=>date('Y'),
                                'sts_create'=>1,
                                'nomortiket'=>$nomortiket,
                                'tgl_mulai'=>date('Y-m-d'),
                                'tgl_sampai'=>tgl_berikutnya(date('Y-m-d'),14),
                                'nomortl'=>$nomortl,
                                'kode_tl'=>$kodetl,
                                'sts_tl'=>'P0',
                                'sts'=>$status,
                            ]);

                            if($status==2){
                                $dis=Disposisi::create([
                                    'nomortl'=>$nomortl,
                                    'catatan_tl'=>$request->content,
                                    'rekomendasi_id'=>$request->id,
                                    'tanggal'=>date('Y-m-d'),
                                    'sts_tl'=>'P0',
                                ]);
                            }
                            echo'ok';
                        }else{
                            echo'<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br /> Lengkapi Lampiran</p>';
                        }
                    }else{
                        $image = $request->file('file');
                        $size = $image->getSize();
                        $imageFileName =$nomortiket.'.'. $image->getClientOriginalExtension();
                        $filePath =$imageFileName;
                        $file = \Storage::disk('public_uploads');
                        if($image->getClientOriginalExtension()=='pdf'){
                            if($file->put($filePath, file_get_contents($image))){

                                
                                    $save=Rekomendasi::where('id',$request->id)->update([
                                        'catatan'=>$request->content,
                                        'file'=>$filePath,
                                        'kode_aktivitas'=>$aktivitas,
                                        'bulan'=>date('m'),
                                        'tahun'=>date('Y'),
                                        'sts_create'=>1,
                                        'sts_tl'=>'P0',
                                        'nomortiket'=>$nomortiket,
                                        'tgl_mulai'=>date('Y-m-d'),
                                        'tgl_sampai'=>tgl_berikutnya(date('Y-m-d'),14),
                                        'nomortl'=>$nomortl,
                                        'kode_tl'=>$kodetl,
                                        'sts'=>$status,
                                    ]);

                                    if($status==2){
                                        $dis=Disposisi::create([
                                            'nomortl'=>$nomortl,
                                            'catatan_tl'=>$request->content,
                                            'rekomendasi_id'=>$request->id,
                                            'tanggal'=>date('Y-m-d'),
                                            'sts_tl'=>'P0',
                                        ]);
                                    }
                                    echo'ok';
                                
                            }

                        }else{
                            echo'<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br /> Format file harus pdf</p>';
                        }
                    }
                }else{
                    
                        if (trim($request->content) == '') {$error[] = '-Isi Catatan';}
                        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                        else{
                            
                            if($request->file==""){
                                $save=Rekomendasi::where('id',$request->id)->update([
                                    'catatan'=>$request->content,
                                    'kode_aktivitas'=>$aktivitas,
                                    'bulan'=>date('m'),
                                    'tahun'=>date('Y'),
                                    'sts_create'=>1,
                                    'nomortiket'=>$nomortiket,
                                    
                                ]);
                                echo'ok';
                                
                            }else{
                                // echo $kodetl.'-'.$nomortl.'-'.$nomortiket;
                                $image = $request->file('file');
                                $size = $image->getSize();
                                $imageFileName =$nomortiket.'.'. $image->getClientOriginalExtension();
                                $filePath =$imageFileName;
                                $file = \Storage::disk('public_uploads');
                                if($image->getClientOriginalExtension()=='pdf'){
                                    if($file->put($filePath, file_get_contents($image))){
                                            $save=Rekomendasi::where('id',$request->id)->update([
                                                'catatan'=>$request->content,
                                                'file'=>$filePath,
                                                'kode_aktivitas'=>$aktivitas,
                                                'bulan'=>date('m'),
                                                'tahun'=>date('Y'),
                                                'sts_create'=>1,
                                                'nomortiket'=>$nomortiket,
                                                
                                            ]);
                                            echo'ok';
                                        
                                    }

                                }else{
                                    echo'<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br /> Format file harus pdf</p>';
                                }
                            }
                            
                        }
                }
                
            }else{
                if($request->act==1){
                    $status=2;
                    $ttl=$nomortl;
                    if (trim($request->content) == '') {$error[] = '-Isi Catatan';}
                    if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                    else{
                            $disposisi=Disposisi::where('rekomendasi_id',$request->id)->where('sts_tl','!=','S')->count();
                        
                            $disposisiakhir=Disposisi::where('rekomendasi_id',$request->id)->where('sts_tl','!=','S')->orderBy('id','Desc')->firstOrfail();
                            $st=substr($disposisiakhir['sts_tl'],1);
                            $sts='P'.($st+1);
                            
                            if($request->file==""){
                                $save=Rekomendasi::where('id',$request->id)->update([
                                    'catatan'=>$request->content,
                                    'tgl_mulai'=>date('Y-m-d'),
                                    'nomortl'=>$nomortl,
                                    'tgl_sampai'=>tgl_berikutnya(date('Y-m-d'),14),
                                    'sts'=>$status,
                                    // 'sts_tl'=>$sts,
                                ]);

                                if($status==2){
                                    $dis=Disposisi::create([
                                        'nomortl'=>$nomortl,
                                        'rekomendasi_id'=>$request->id,
                                        'catatan_tl'=>$request->content,
                                        'tanggal'=>date('Y-m-d'),
                                        'sts_tl'=>$cekcreate['sts_tl'],
                                    ]);
                                }
                                echo'ok';
                            }else{
                                $image = $request->file('file');
                                $size = $image->getSize();
                                $imageFileName =$cekcreate['nomortiket'].'.'. $image->getClientOriginalExtension();
                                $filePath =$imageFileName;
                                $file = \Storage::disk('public_uploads');
                                if($image->getClientOriginalExtension()=='pdf'){
                                    if($file->put($filePath, file_get_contents($image))){

                                        
                                            $save=Rekomendasi::where('id',$request->id)->update([
                                                'catatan'=>$request->content,
                                                'file'=>$filePath,
                                                'tgl_mulai'=>date('Y-m-d'),
                                                'nomortl'=>$nomortl,
                                                'tgl_sampai'=>tgl_berikutnya(date('Y-m-d'),14),
                                                'sts'=>$status,
                                            ]);

                                            if($status==2){
                                                $dis=Disposisi::create([
                                                    'nomortl'=>$nomortl,
                                                    'catatan_tl'=>$request->content,
                                                    'rekomendasi_id'=>$request->id,
                                                    'tanggal'=>date('Y-m-d'),
                                                    'sts_tl'=>$cekcreate['sts_tl'],
                                                ]);
                                            }
                                            echo'ok';
                                        
                                    }

                                }else{
                                    echo'<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br /> Format file harus pdf</p>';
                                }
                            }
                        
                    }
                }else{
                    if (trim($request->content) == '') {$error[] = '-Isi Catatan';}
                    if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                    else{
                            if($request->file==""){
                                $save=Rekomendasi::where('id',$request->id)->update([
                                    'catatan'=>$request->content,
                                ]);

                                
                                echo'ok';
                            }else{
                                $image = $request->file('file');
                                $size = $image->getSize();
                                $imageFileName =$cekcreate['nomortiket'].'.'. $image->getClientOriginalExtension();
                                $filePath =$imageFileName;
                                $file = \Storage::disk('public_uploads');
                                if($image->getClientOriginalExtension()=='pdf'){
                                    if($file->put($filePath, file_get_contents($image))){

                                        
                                            $save=Rekomendasi::where('id',$request->id)->update([
                                                'catatan'=>$request->content,
                                                'file'=>$filePath,
                                            ]);

                                            
                                            echo'ok';
                                        
                                    }

                                }else{
                                    echo'<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br /> Format file harus pdf</p>';
                                }
                            }
                        
                    }
                }

            }
        }else{
            echo'Tidak dapat merubah, Silahkan refresh halaman';
        }
    }

    public function cetak(request $request){
        error_reporting(0);
        $data=Rekomendasi::where('id',$request->id)->first();
        $pdf = PDF::loadView('temuan.cetak', compact('data'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
    }
    
}
