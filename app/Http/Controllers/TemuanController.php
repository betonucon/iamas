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
        $menu='Temuan ';
        $side="temuan";
        if(akses_tiket_ketua()>0){
            return view('Temuan.index_temuan_ketua',compact('menu','side'));
        }else{
            return view('error'); 
        }
        
    }
    
    public function index_temuan_pengawas(request $request){
        $menu='Temuan ';
        $side="temuan";
        if(akses_tiket_pengawas()>0){
            return view('Temuan.index_temuan_pengawas',compact('menu','side'));
        }else{
            return view('error'); 
        }
        
    }

    public function approve(request $request){
        if($request->name=='RCD'){
            $data=Rekomendasi::where('id',$request->id)->update([
                'sts'=>3
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
        if (trim($request->status) == '') {$error[] = '-Pilih Status';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;background:orange;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data=Rekomendasi::where('id',$request->id)->first();
            
            if($request->name=='Anggota'){
                if($request->status==2){
                    $data=Rekomendasi::where('id',$request->id)->update([
                        'sts'=>4,
                    ]);
                    echo'ok';
                }else{
                    $data=Rekomendasi::where('id',$request->id)->update([
                        'sts'=>4,
                        'sts_tl'=>'S',
                    ]);

                    echo'ok';
                }
            }
        }
    }

    public function send_data_head(request $request){
        if (trim($request->status) == '') {$error[] = '-Pilih Status';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;background:orange;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $datarek=Rekomendasi::where('id',$request->id)->first();
            $disposisi=Disposisi::where('rekomendasi_id',$request->id)->where('sts_tl','!=','S')->orderBy('id','Desc')->firstOrfail();
            $st=substr($disposisi['sts_tl'],1);
            $sts='P'.($st+1);
            if($datarek['sts_tl']=='S'){
                if($request->status==2){
                    if (trim($request->alasan) == '') {$error[] = '-Isi Kolom Catatan';}
                    if (isset($error)) {echo '<p style="padding:5px;color:#000;background:orange;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                    else{
                        $data=Rekomendasi::where('id',$request->id)->update([
                            'sts'=>1,
                            'sts_tl'=>$sts,
                        ]);

                        $dis=Disposisi::create([
                            'nomortl'=>$datarek['nomortl'],
                            'rekomendasi_id'=>$request->id,
                            'tanggal'=>date('Y-m-d'),
                            'sts_tl'=>$sts,
                            'alasan'=>$request->alasan,
                        ]);
                        
                        echo'ok';
                    }
                }else{
                    $data=Rekomendasi::where('id',$request->id)->update([
                        'sts'=>6,
                        'sts_tl'=>'S',
                        'tgl_finis'=>date('Y-m-d'),
                    ]);

                    echo'ok';
                }
            }else{
                if($request->status==2){
                    if (trim($request->alasan) == '') {$error[] = '-Isi Kolom Catatan';}
                    if (isset($error)) {echo '<p style="padding:5px;color:#000;background:orange;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                    else{
                        $data=Rekomendasi::where('id',$request->id)->update([
                            'sts'=>1,
                        ]);
                        $dis=Disposisi::where('nomortl',$datarek['nomortl'])->update([
                            'tanggal'=>date('Y-m-d'),
                            'alasan'=>$request->alasan,
                        ]);
                        echo'ok';
                    }
                }else{
                    $data=Rekomendasi::where('id',$request->id)->update([
                        'sts'=>6,
                        'sts_tl'=>'S',
                        'tgl_finis'=>date('Y-m-d'),
                    ]);

                    echo'ok';
                }
            }
        }
    }

    public function simpan(request $request){
        $cekcreate=Rekomendasi::where('id',$request->id)->first();
        if($cekcreate['sts']==1){
            $aktivitas='08';
            $kodetl='TL'.substr($cekcreate->kesimpulan['kode_sumber'],2);
            $count=Rekomendasi::where('bulan',date('m'))->where('tahun',date('Y'))->where('kode_aktivitas',$aktivitas)->count();
            
            if($count>0){
                $cek=Rekomendasi::where('bulan',date('m'))->where('tahun',date('Y'))->orderBy('nomortiket','Desc')->firstOrfail();
                $urutan = (int) substr($cek['nomortiket'], 9, 2);
                $urutan++;
                $nomortiket='STIA'.$aktivitas.date('y').kode_bulan(date('m')).sprintf("%02s", $urutan);
            }else{
                $nomortiket='STIA'.$aktivitas.date('y').kode_bulan(date('m')).sprintf("%02s", 1);
                
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

            if($request->act==1){
                $status=2;
                $ttl=$nomortl;
            }else{
                $status=$cekcreate['sts'];
                $ttl=$cekcreate['nomortl'];
            }
            if($cekcreate['sts_create']==""){
                    if (trim($request->file) == '') {$error[] = '-Upload File Pendukung';}
                    if (trim($request->content) == '') {$error[] = '-Isi Catatan';}
                    if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                    else{
                        
                            

                            $image = $request->file('file');
                            $size = $image->getSize();
                            $imageFileName =$nomortiket.'.'. $image->getClientOriginalExtension();
                            $filePath =$imageFileName;
                            $file = \Storage::disk('public_uploads');
                            if($image->getClientOriginalExtension()=='pdf'){
                                if($file->put($filePath, file_get_contents($image))){
                                        if($status==2){
                                            $dis=Disposisi::create([
                                                'nomortl'=>$nomortl,
                                                'rekomendasi_id'=>$request->id,
                                                'tanggal'=>date('Y-m-d'),
                                                'sts_tl'=>'P0',
                                            ]);
                                        }
                                        $save=Rekomendasi::where('id',$request->id)->update([
                                            'catatan'=>$request->content,
                                            'file'=>$filePath,
                                            'kode_aktivitas'=>$aktivitas,
                                            'bulan'=>date('m'),
                                            'tahun'=>date('Y'),
                                            'tgl_mulai'=>date('Y-m-d'),
                                            'tgl_sampai'=>tgl_berikutnya(date('Y-m-d'),14),
                                            'sts_tl'=>'P0',
                                            'sts_create'=>1,
                                            'nomortiket'=>$nomortiket,
                                            'nomortl'=>$nomortl,
                                            'kode_tl'=>$kodetl,
                                            'sts'=>$status,
                                        ]);
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
                        $disposisi=Disposisi::where('rekomendasi_id',$request->id)->where('sts_tl','!=','S')->count();
                        $disposisiakhir=Disposisi::where('rekomendasi_id',$request->id)->where('sts_tl','!=','S')->orderBy('id','Desc')->firstOrfail();
                        $st=substr($disposisiakhir['sts_tl'],1);
                        $sts='P'.($st+1);
                        if($disposisi>0){
                            if($request->file==""){
                                $save=Rekomendasi::where('id',$request->id)->update([
                                    'catatan'=>$request->content,
                                    'tgl_mulai'=>date('Y-m-d'),
                                    'nomortl'=>$nomortl,
                                    'tgl_sampai'=>tgl_berikutnya(date('Y-m-d'),14),
                                    'sts'=>$status,
                                    'sts_tl'=>$sts,
                                ]);

                                if($status==2){
                                    $dis=Disposisi::create([
                                        'nomortl'=>$nomortl,
                                        'rekomendasi_id'=>$request->id,
                                        'tanggal'=>date('Y-m-d'),
                                        'sts_tl'=>$sts,
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
                                                'tgl_sampai'=>tgl_berikutnya(date('Y-m-d'),14),
                                                'sts'=>$status,
                                            ]);

                                            if($status==2){
                                                $dis=Disposisi::create([
                                                    'nomortl'=>$nomortl,
                                                    'rekomendasi_id'=>$request->id,
                                                    'tanggal'=>date('Y-m-d'),
                                                    'sts_tl'=>$sts,
                                                ]);
                                            }
                                            echo'ok';
                                        
                                    }

                                }else{
                                    echo'<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br /> Format file harus pdf</p>';
                                }
                            }
                        }else{

                         
                            if($request->file==""){
                                $save=Rekomendasi::where('id',$request->id)->update([
                                    'catatan'=>$request->content,
                                    'tgl_mulai'=>date('Y-m-d'),
                                    'tgl_sampai'=>tgl_berikutnya(date('Y-m-d'),14),
                                    'sts'=>$status,
                                ]);

                                if($status==2){
                                    $dis=Disposisi::create([
                                        'nomortl'=>$nomortl,
                                        'rekomendasi_id'=>$request->id,
                                        'tanggal'=>date('Y-m-d'),
                                        'sts_tl'=>'P0',
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
                                                'tgl_sampai'=>tgl_berikutnya(date('Y-m-d'),14),
                                                'sts'=>$status,
                                            ]);

                                            if($status==2){
                                                $dis=Disposisi::create([
                                                    'nomortl'=>$nomortl,
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
                        }
                        
                    }

            }
        }else{
            echo'Tidak dapat merubah, Silahkan refresh halaman';
        }
    }
    
}
