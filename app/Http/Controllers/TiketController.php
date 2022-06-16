<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Tiket;
use App\Timaudit;
use App\Surattugas;
use App\Judul;
use Artisan;
use PDF;
use Illuminate\Support\Facades\Hash;
class TiketController extends Controller
{
    public function index(request $request){
        
        if(Auth::user()->posisi_id==3 || Auth::user()->posisi_id==11 ){
            $menu='Sumber Informasi ';
            $side='tiket';
            return view('Tiket.index',compact('menu','side'));

        }else{
            if(Auth::user()->role_id==8){
                $menu='Sumber Informasi ';
                $side='tiket';
                return view('Tiket.index',compact('menu','side'));
            }else{
                return view('error');
            }
            
        }
    }
    public function index_gl(request $request){
        if(Auth::user()->posisi_id==12){
            $menu='Sumber Informasi ';
            $side='tiket';
            return view('Tiket.index_gl',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }
    public function index_hd(request $request){
        if(Auth::user()->posisi_id==1 || Auth::user()->posisi_id==13){
            $menu='Sumber Informasi ';
            $side='tiket';
            return view('Tiket.index_hd',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }
    public function index_head(request $request){
        if(Auth::user()->posisi_id==1){
            $menu='Sumber Informasi ';
            $side='tiket';
            return view('Tiket.index_head',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }
    public function index_tiket(request $request){
        if(Auth::user()->posisi_id==12){
            $menu='List Tiket ';
            $side='tiket';
            return view('Tiket.index_tiket',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }
    
    public function create_tiket(request $request){
        if(Auth::user()->posisi_id==12){
            $menu='Buat Tiket ';
            $side='tiket';
            return view('Tiket.create_tiket',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }

    public function view_tiket_pengawas(request $request){
        
        $data=Tiket::find($request->id);
        $side='tiket';
        if($data->surattugas['sts']==3){
            $menu='Approve Penyelesaian Tiket ';
            return view('Tiket.view_tiket_pengawas',compact('menu','data','side'));
        }else{
            $menu='View Penyelesaian Tiket ';
            return view('Tiket.view_tiket_penyelesaian',compact('menu','data','side'));
        }
    }
    public function update_tiket(request $request){
        if(Auth::user()->posisi_id==12){
            $menu='View Tiket ';
            $side='tiket';
            $data=Tiket::find($request->id);
            if($data->surattugas['sts']==1){
                return view('Tiket.update_tiket',compact('menu','data','side'));
            }else{
                return view('Tiket.view_tiket',compact('menu','data','side'));
            }
            
        }else{
            $side='tiket';
            if(Auth::user()->posisi_id==1 || Auth::user()->posisi_id==13){
                $menu='Approve Tiket ';
                $data=Tiket::find($request->id);
                return view('Tiket.view_tiket_head',compact('menu','data','side'));
            }else{
                $menu='View Tiket ';
                $data=Tiket::find($request->id);
                return view('Tiket.view_tiket',compact('menu','data','side'));
            }
           
        }
        
    }

    public function index_anggota(request $request){
        if(akses_tiket_anggota()>0){
            $menu='List Tiket ';
            $side='tiket';
            return view('Tiket.index_tiket_anggota',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }
    public function index_ketua(request $request){
        if(akses_tiket_ketua()>0){
            $menu='List Tiket ';
            $side='tiket';
            return view('Tiket.index_tiket_ketua',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }
    public function index_pengawas(request $request){
        if(Auth::user()->posisi_id==3 || Auth::user()->posisi_id==11 || Auth::user()->posisi_id==12){
            $menu='List Tiket ';
            $side='tiket';
            return view('Tiket.index_tiket_pengawas',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }
    public function index_acc_pengawas(request $request){
        if(akses_tiket_pengawas()>0){
            $menu='Approve Penyelesaian Tiket ';
            $side='tiket';
            return view('Tiket.index_tiket_accpengawas',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }
    public function index_acc_head(request $request){
        if(Auth::user()->posisi_id==1 || Auth::user()->posisi_id==13){
            $menu='Approve Penyelesaian Tiket ';
            $side='tiket';
            return view('Tiket.index_tiket_acchead',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }
    public function index_tiket_head(request $request){
        if(Auth::user()->posisi_id==1 || Auth::user()->posisi_id==13){
            $menu='List Tiket ';
            $side='tiket';
            return view('Tiket.index_tiket_head',compact('menu','side'));
        }else{
            return view('error');
        }
        
    }

    public function cek_tim(request $request){
        $data=Timaudit::where('tiket_id',$request->id)->where('role_id',2)->first();
        $anggota=Timaudit::where('tiket_id',$request->id)->where('role_id',3)->get();
        echo'
            <style>
                .rth{
                    padding: 2px 4px!important;
                    background: #595998;
                    color: #fff;
                    text-align: left;
                }
                .rtd{
                    padding: 1% !important;
                    background: #e4f1f1;
                    color: #000;
                    border-bottom: solid 1px #c5bdbd;
                    text-align: left;
                }
            </style>
            
           
            <table width="100%">
                <tr>
                    <th class="rth" width="10%"></th>
                    <th class="rth" >PENGAWAS</th>
                </tr>
                <tr>
                    <td class="rtd" colspan="2"> ['.$data['nik'].'] '.$data->user['name'].'</td>
                </tr>
            </table><br>
            <table width="100%">
                <tr>
                    <th class="rth" width="20%"><span title="Tambah Anggota" class="btn btn-yellow btn-xs" onclick="cari_timaudit('.$request->id.',3)">+ <i class="fa fa-user"></i></span></th>
                    <th class="rth">ANGGOTA</th>
                </tr>';
                foreach($anggota as $dat){
                    echo'
                    <tr>
                        <td class="rtd" colspan="2"><span class="btn btn-danger btn-xs" onclick="hapus_tim('.$dat['id'].','.$dat['tiket_id'].')">X</span> <b>['.$dat['nik'].']</b> '.$dat->user['name'].'</td>
                    </tr>';
                }
                echo'
            </table>
        ';
    }

    public function tampil_pilihan_sumber(request $request){
        
        
        foreach(sumbertiket_get($request->kode_aktivitas) as $x=>$sumbertiket_get){
            if($x%2==0){$color="alert-lime";}else{$color="alert-pink";}
            echo'
            <div class="col-md-12" style="padding-top:1%;cursor: pointer;" onclick="cek_pilih_sumber(`['.$sumbertiket_get->nomorinformasi.'] '.$sumbertiket_get->judul.' `,`'.$sumbertiket_get->id.'`,`'.$sumbertiket_get->kode_unit.'`,`'.nama_unit($sumbertiket_get->kode_unit).'`,`'.$sumbertiket_get->judul.'`)">
                <div class="alert  '.$color.' fade show m-b-10">
                    <span class="close" onclick="cek_pilih_sumber(`['.$sumbertiket_get->nomorinformasi.'] '.$sumbertiket_get->judul.' `,`'.$sumbertiket_get->id.'`,`'.$sumbertiket_get->kode_unit.'`,`'.nama_unit($sumbertiket_get->kode_unit).'`,`'.$sumbertiket_get->judul.'`)"><i class="fas fa-check-square"></i></span>
                    <h5> Kode Informasi : '.$sumbertiket_get->nomorinformasi.' </h5>
                    <a href="#" style="font-weight: 100;" onclick="cek_pilih_sumber(`['.$sumbertiket_get->nomorinformasi.'] '.$sumbertiket_get->judul.' `,`'.$sumbertiket_get->id.'`,`'.$sumbertiket_get->kode_unit.'`,`'.nama_unit($sumbertiket_get->kode_unit).'`,`'.$sumbertiket_get->judul.'`)" class="alert-link">
                        <b>'.$sumbertiket_get->judul.'</b><br>
                        '.$sumbertiket_get->keterangan.'
                    </a>.
                </div>
            </div>';
        }
    }

    public function tampil_tim(request $request){
        
    }

    public function tampil_tim_lama(request $request){
        error_reporting(0);
        $cekpengawas=Timaudit::where('tiket_id',$request->id)->where('role_id',2)->count();
        
        if($request->act==2){
            if($cekpengawas>0){
                $peng=Timaudit::where('role_id',2)->where('tiket_id',$request->id)->update([
                    'nik'=>nik_pengawas($request->kode_aktivitas),
                ]);
            }else{
                $peng       = New Timaudit;
                $peng->tiket_id =$request->id;
                $peng->role_id =2;
                $peng->nik =nik_pengawas($request->kode_aktivitas);
                $peng->save();
            }
        }else{
            
        }
        $pengawas=Timaudit::where('tiket_id',$request->id)->where('role_id',2)->first();
        $cekanggota=Timaudit::where('tiket_id',$request->id)->where('role_id',3)->count();
        $anggota=Timaudit::where('tiket_id',$request->id)->where('role_id',3)->get();
        echo'
            <style>
                .tth{
                    padding: 2px !important;
                    background: #595998;
                    color: #fff;
                    text-align: center;
                }
                .ttd{
                    padding: 2px !important;
                    background: #fff;
                    color: #000;
                    vertical-align: text-top !important;
                }
                p {
                    margin-top: 0;
                    margin-bottom: 4px;
                }
            </style>
            <input type="hidden" name="anggota" value="'.$cekanggota.'">
            <input type="hidden" name="pengawas" value="'.$cekpengawas.'">
            <table class="table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline collapsed">
                
                <tr>
                    <th class="tth" width="20%">PENGAWAS</th>
                    <th class="tth" width="8%"><span title="Tambah Anggota"  class="btn btn-yellow btn-xs" onclick="cari_timaudit('.$request->id.',3)">+ <i class="fa fa-user"></i></span></th>
                    <th class="tth">PELAKSANA</th>
                </tr>

                <tr>
                    <td class="ttd"><p><span class="btn btn-danger btn-xs"><i class="fas fa-user"></i></span>&nbsp;&nbsp;<b>'.$pengawas['nik'].'</b> '.$pengawas->user['name'].'</p></td>
                    <td class="ttd" colspan="2">';
                        foreach($anggota as $ag){
                            echo'<p><span class="btn btn-danger btn-xs" onclick="hapus_tim('.$ag['id'].','.$ag['tiket_id'].')">X</span>&nbsp;&nbsp;<b>'. $ag['nik'].'</b> '.$ag->user['name'].' </p>';
                        }
                    echo'
                </tr>
            </table>

        ';
    }

    public function hapus_tim(request $request){
        $data=Timaudit::where('id',$request->id)->delete();
        echo $request->tiket;
    }

    public function cek_sumber(request $request){
       echo'<option value="">Pilih Sumber</option>';
       foreach(sumber_get($request->id) as $data){
           echo'<option value="'.$data['kode'].'">['.$data['kode'].'] '.$data['name'].'</option>';
       }
    }

    public function cek_nomor_tiket(request $request){
        
        $bulan=date('m');
        $tahun=date('Y');
        $tahunkode=date('y');
        $cekcount=Tiket::where('bulan',$bulan)->where('tahun',$tahun)->where('aktivitas_id','!=',3)->count();
        
        if($cekcount>0){
            $cek=Tiket::where('bulan',$bulan)->where('tahun',$tahun)->where('aktivitas_id','!=',3)->orderBy('id','Desc')->firstOrfail();
            $urutan = (int) substr($cek['nomorinformasi'], 5, 2);
            $urutan++;
            $nomor=$request->id.$tahunkode.kode_bulan($bulan).sprintf("%02s", $urutan);
           
        }else{
            $nomor=$request->id.$tahunkode.kode_bulan($bulan).sprintf("%02s", 1);
        }
        
        echo $nomor;
    }

    public function ubah(request $request){
       $data=Tiket::find($request->id);
       echo'
       <input type="hidden" name="id" value="'.$data['id'].'">
       <div class="col-xl-10 offset-xl-1">
            <div class="form-group row m-b-10" >
                <label class="col-lg-3 text-lg-right col-form-label">Sumber Infomasi </label>
                <div class="col-lg-9 col-xl-9">
                    <select class="form-control" disabled name="kode_sumber" id="sumber-informasi" onchange="cek_nomor_tiket(this.value)">
                        <option value="">Pilih Sumber Infomasi</option>';
                        foreach(sumber_get(0) as $sumber){
                           echo'<option value="'.$sumber['kode'].'"'; if($data['kode_sumber']==$sumber['kode']){echo'selected';} echo' >['.$sumber['kode'].'] '.$sumber['name'].'</option>';
                        }
                        echo'
                    </select>
                </div>
            </div>
            <div class="form-group row m-b-10" >
                <label class="col-lg-3 text-lg-right col-form-label">Kodifikasi & Lampiran </label>
                <div class="col-lg-9 col-xl-5">
                    <select class="form-control" name="kodifikasi" >
                        <option value="">Pilih Kodefikasi</option>';
                        foreach(kodefikasi_get() as $kodefikasi){
                            
                            echo'<option value="'.$kodefikasi['kodifikasi'].'"'; if($kodefikasi['kodifikasi']==$data['kodifikasi']){echo'selected';} echo' >['.$kodefikasi['kodifikasi'].'] '.$kodefikasi['kategori'].'</option>';
                        }
                    echo'
                    </select>
                </div>
                <div class="col-lg-9 col-xl-4">
                    <input type="file" class="form-control"  name="lampiran" >
                </div>
            </div>
            <div class="form-group row m-b-10" >
                <label class="col-lg-3 text-lg-right col-form-label">Judul </label>
                <div class="col-lg-9 col-xl-9">
                    <input type="text" class="form-control" value="'.$data['judul'].'" name="judul" placeholder="Enter text ...">
                </div>
                
            </div>
            <div class="form-group row m-b-10" >
                <label class="col-lg-3 text-lg-right col-form-label">Isi/ Keterangan </label>
                <div class="col-lg-9 col-xl-9">
                    <textarea class="textarea form-control" name="keterangan" id="textarea" placeholder="Enter text ..." rows="12">'.$data['keterangan'].'</textarea>
                </div>
                
            </div>
        </div>
        
        
       ';
       echo'
            <script type="text/javascript">
                $("#textarea").wysihtml5();
            </script>

       ';
    }

    public function view(request $request){
       $data=Tiket::find($request->id);
       echo'
       <input type="hidden" name="id" value="'.$data['id'].'">
       <div class="col-xl-10 offset-xl-1">
            <div class="form-group row m-b-10" >
                <label class="col-lg-3 text-lg-right col-form-label">Sumber Infomasi </label>
                <div class="col-lg-9 col-xl-9">
                    <select class="form-control" disabled name="kode_sumber" id="sumber-informasi" onchange="cek_nomor_tiket(this.value)">
                        <option value="">Pilih Sumber Infomasi</option>';
                        foreach(sumber_get(0) as $sumber){
                           echo'<option value="'.$sumber['kode'].'"'; if($data['kode_sumber']==$sumber['kode']){echo'selected';} echo' >['.$sumber['kode'].'] '.$sumber['name'].'</option>';
                        }
                        echo'
                    </select>
                </div>
            </div>
            <div class="form-group row m-b-10" >
                <label class="col-lg-3 text-lg-right col-form-label">Kodifikasi & Lampiran </label>
                <div class="col-lg-9 col-xl-5">
                    <select class="form-control" disabled name="kodifikasi" >
                        <option value="">Pilih Kodefikasi</option>';
                        foreach(kodefikasi_get() as $kodefikasi){
                            
                            echo'<option value="'.$kodefikasi['kodifikasi'].'"'; if($kodefikasi['kodifikasi']==$data['kodifikasi']){echo'selected';} echo' >['.$kodefikasi['kodifikasi'].'] '.$kodefikasi['kategori'].'</option>';
                        }
                    echo'
                    </select>
                </div>
                <div class="col-lg-9 col-xl-4">
                    <input type="file" class="form-control" disabled name="lampiran" >
                </div>
            </div>
            <div class="form-group row m-b-10" >
                <label class="col-lg-3 text-lg-right col-form-label">Judul </label>
                <div class="col-lg-9 col-xl-9">
                    <input type="text" class="form-control" disabled value="'.$data['judul'].'" name="judul" placeholder="Enter text ...">
                </div>
                
            </div>
            <div class="form-group row m-b-10" >
                <label class="col-lg-3 text-lg-right col-form-label">Isi/ Keterangan </label>
                <div class="col-lg-9 col-xl-9">
                    <textarea class="textarea form-control" disabled name="keterangan" id="textarea" placeholder="Enter text ..." rows="12">'.$data['keterangan'].'</textarea>
                </div>
                
            </div>
        </div>
        
        
       ';
       echo'
            <script type="text/javascript">
                $("#textarea").wysihtml5();
            </script>

       ';
    }
    
    public function ubah_tiket(request $request){
       $data=Tiket::find($request->id);
       echo'
       <input type="hidden" name="id" value="'.$data['id'].'">
        <div class="form-group">
            <label for="exampleInputEmail1">Lampiran</label>
            <input type="file" class="form-control"  name="lampiran" >
        </div>	
    
        <div class="form-group">
            <label for="exampleInputEmail1">Judul</label>
            <input type="text" class="form-control" value="'.$data['judul_tiket'].'" name="judul" placeholder="Enter text ...">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Isi</label>
            <textarea class="textarea form-control" name="keterangan" id="textarea" placeholder="Enter text ..." rows="12">'.$data['keterangan_tiket'].'</textarea>
        </div>
       ';
       echo'
            <script type="text/javascript">
                $("#textarea").wysihtml5();
            </script>

       ';
    }

    public function simpan_tim(request $request){
        error_reporting(0);
        $jum=count($request->nik);
        
        
            for($ss=0;$ss<$jum;$ss++){
                $cek=Timaudit::where('tiket_id',$request->tim_id)->where('nik',$request->nik[$ss])->count();
                if($cek>0){

                }else{
                    $data       = New Timaudit;
                    $data->tiket_id =$request->tim_id;
                    $data->role_id =3;
                    $data->nik =$request->nik[$ss];
                    $data->save();
                }
                    
            }
            echo $request->tim_id;
        
    }

    public function tampil_judul(request $request){
        $data=Judul::where('tiket_id',$request->tiket_id)->get();
        echo'
            <style>
                .tth{
                   background:aqua;
                   color:#000;
                }
            </style>
            <table class="table table-bordered m-b-0">
                <thead>
                    <tr>
                        <th class="tth" width="5%">No</th>
                        <th class="tth"  width="30%">Judul</th>
                        <th class="tth" >Tujuan</th>
                        <th  class="tth" width="15%">Kodifikasi</th>
                        <th  class="tth" width="15%">Unit Kerja</th>
                        <th  class="tth" width="5%"></th>
                    </tr>
                </thead>
                <tbody>';
                foreach($data as $no=>$o){
                    echo' 
                    <tr>
                        <td>'.($no+1).'</td>
                        <td>'.$o['judul'].'</td>
                        <td>'.$o['tujuan'].'</td>
                        <td>'.$o['kodifikasi'].'</td>
                        <td>'.$o->unitkerja['name'].'</td>
                        <td><span onclick="hapus_judul('.$o['id'].')" class="btn btn-red btn-xs">Hapus</span></td>
                    </tr>';
                }
                echo'   
                </tbody>
            </table>

        ';
    }

    public function hapus_judul(request $request){
        $data=Judul::where('id',$request->id)->delete();
    }

    public function save_judul(request $request){
        if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
        if (trim($request->kode_unit) == '') {$error[] = '- Pilih Unit Kerja';}
        if (trim($request->risiko) == '') {$error[] = '- Isi Risiko';}
        if (trim($request->judul) == '') {$error[] = '- Isi Judul';}
        if (trim($request->keterangan) == '') {$error[] = '- Isi Keterangan';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data=Judul::create([
                'judul'=>$request->judul,
                'kodifikasi'=>$request->kodifikasi,
                'kode_unit'=>$request->kode_unit,
                'as'=>unit_as($request->kode_unit),
                'tujuan'=>$request->keterangan,
                'risiko'=>$request->risiko,
                'tiket_id'=>$request->tiket_id,
            ]);

            if($data){
                echo'ok';
            }
        }
    }

    public function simpan(request $request){

        if (trim($request->kode_sumber) == '') {$error[] = '-Pilih Sumber';}
        if (trim($request->kodifikasi) == '') {$error[] = '-Pilih kodifikasi';}
        if (trim($request->nomorinformasi) == '') {$error[] = '- Isi Kode Informasi';}
        if (trim($request->judul) == '') {$error[] = '- Isi Judul';}
        if (trim($request->lampiran) == '') {$error[] = '- Upload file Lampiran';}
        if (trim($request->keterangan) == '') {$error[] = '- Isi Keterangan';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Tiket::where('nomorinformasi',$request->nomorinformasi)->count();
            if($cek>0){
                echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Kode Unit Kerja Terdaftar</p>';
            }else{
                $image = $request->file('lampiran');
                $size = $image->getSize();
                $imageFileName =$request->nomorinformasi.'.'. $image->getClientOriginalExtension();
                $filePath =$imageFileName;
                $file = \Storage::disk('public_uploads');
                if($image->getClientOriginalExtension()=='pdf'){
                    if($file->put($filePath, file_get_contents($image))){
                        $data=Tiket::create([
                            'nik'=>Auth::user()['nik'],
                            'kode_sumber'=>$request->kode_sumber,
                            'aktivitas_id'=>cek_aktivitas($request->kode_sumber),
                            'nomorinformasi'=>$request->nomorinformasi,
                            'judul'=>$request->judul,
                            'bulan'=>date('m'),
                            'tahun'=>date('Y'),
                            'keterangan'=>$request->keterangan,
                            'kodifikasi'=>$request->kodifikasi,
                            'lampiran'=>$filePath,
                            'tanggal_create_sumber'=>date('Y-m-d'),
                            'sts'=>0,
                        ]);

                        if($data){
                            echo'ok';
                        }
                    }
                }else{
                    echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Format File Harus PDF</p>';
                }
            }
                
        }
    }

    
    public function approve_pengawas(request $request){
        error_reporting(0);
        $tiket=Tiket::find($request->id);
        if($tiket['kode_aktivitas']=='03'){
            if($tiket['kode_aktivitas']=='AR'){
                
                if (trim($request->kode_laporan) == '') {$error[] = '-Pilih laporan';}
                if (trim($request->kodifikasi) == '') {$error[] = '- Pilih kodifikasi';}
                if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                else{
                    $tiket=Tiket::find($request->id);
                    $count=Tiket::where('nomorlaporan','!=',null)->count();
                    
                    if($count>0){
                        $cek=Tiket::where('nomorlaporan','!=',null)->orderBy('nomorlaporan','Desc')->firstOrfail();
                        $urutan = (int) substr($cek['nomorlaporan'], 6, 2);
                        $urutan++;
                        $nomorlaporan=$request->kode_laporan.date('y').kode_bulan(date('m')).sprintf("%02s", $urutan);
                    }else{
                        $nomorlaporan=$request->kode_laporan.date('y').kode_bulan(date('m')).sprintf("%02s", 1);
                        
                    }
                    $upddata=Tiket::where('id',$request->id)->update([
                        'nomorlaporan'=>$nomorlaporan,
                        'kode_laporan'=>$request->kode_laporan,
                        'sts'=>4,
                        'kodifikasi_laporan'=>$request->kodifikasi,
                        
                    ]);
                    $surattugas=Surattugas::where('tiket_id',$request->id)->update([
                        'nomorlaporan'=>$nomorlaporan,
                        'kode_laporan'=>$request->kode_laporan,
                        'sts'=>4,
                        'kodifikasi_laporan'=>$request->kodifikasi,
                        'tgl_pengawas'=>date('Y-m-d'),
                        
                    ]);
                    
                    $data=Tiket::create([
                        'nik'=>Auth::user()['nik'],
                        'kode_sumber'=>$request->kode_laporan,
                        'aktivitas_id'=>cek_aktivitas($request->kode_laporan),
                        'nomorinformasi'=>$nomorlaporan,
                        'judul'=>$tiket['judul_laporan'],
                        'bulan'=>date('m'),
                        'tahun'=>date('Y'),
                        'keterangan'=>$tiket['keterangan_laporan'],
                        'kodifikasi'=>$request->kodifikasi,
                        'lampiran'=>$tiket['lampiran_laporan'],
                        'tanggal_create_sumber'=>date('Y-m-d'),
                        'sts'=>2,
                    ]);

                    echo'ok';
                }

            }else{
                $cekjudul=Judul::where('tiket_id',$request->id)->count();
                $getjudul=Judul::where('tiket_id',$request->id)->orderBy('id','Asc')->get();
                $jum=0;
                foreach($getjudul as $o){
                    if($request->kodifikasi[$o['id']]==''){
                        $jum+=0;
                    }else{
                        $jum+=1;
                    }
                }
                if($jum==$cekjudul){
                    $upddata=Tiket::where('id',$request->id)->update([
                        'sts'=>4,
                    ]);
                    $surattugas=Surattugas::where('tiket_id',$request->id)->update([
                        'sts'=>4,
                        'tgl_pengawas'=>date('Y-m-d'),
                    ]);
                    $jumlpk=Tiket::where('kode_sumber','LPK')->count();
                    if($jumlpk>0){

                    }else{

                    }
                    foreach($getjudul as $no=>$o){
                        $noo=$no+1;
                        $nomorlaporan='LPK'.(date('y')+1).$o['as'].sprintf("%02s", ($jumlpk+$noo));
                        
                        $jdul=Judul::where('id',$o['id'])->update([
                            'kodifikasi'=>$request->kodifikasi[$o['id']],
                        ]);

                        $data=Tiket::create([
                            'nik'=>Auth::user()['nik'],
                            'kode_sumber'=>'LPK',
                            'aktivitas_id'=>cek_aktivitas('LPK'),
                            'nomorinformasi'=>$nomorlaporan,
                            'judul'=>$o['judul'],
                            'bulan'=>date('m'),
                            'tahun'=>date('Y'),
                            'keterangan'=>$o['tujuan'],
                            'kode_unit'=>$o['kode_unit'],
                            'kodifikasi'=>$request->kodifikasi[$o[id]],
                            'lampiran'=>'null',
                            'tanggal_create_sumber'=>date('Y-m-d'),
                            'sts'=>2,
                        ]);
                    }

                    echo'ok';
                   
                }else{
                    echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br /> Lengkapi Semua kodifikasi</p>';
                }
            }
        }else{

        
                if (trim($request->kode_laporan) == '') {$error[] = '-Pilih laporan';}
                if (trim($request->kodifikasi) == '') {$error[] = '- Pilih kodifikasi';}
                if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                else{
                    $tiket=Tiket::find($request->id);
                    $count=Tiket::where('nomorlaporan','!=',null)->count();
                    
                    if($count>0){
                        $cek=Tiket::where('nomorlaporan','!=',null)->orderBy('nomorlaporan','Desc')->firstOrfail();
                        $urutan = (int) substr($cek['nomorlaporan'], 6, 2);
                        $urutan++;
                        $nomorlaporan=$request->kode_laporan.date('y').kode_bulan(date('m')).sprintf("%02s", $urutan);
                    }else{
                        $nomorlaporan=$request->kode_laporan.date('y').kode_bulan(date('m')).sprintf("%02s", 1);
                        
                    }
                    $upddata=Tiket::where('id',$request->id)->update([
                        'nomorlaporan'=>$nomorlaporan,
                        'kode_laporan'=>$request->kode_laporan,
                        'sts'=>4,
                        'kodifikasi_laporan'=>$request->kodifikasi,
                        
                    ]);
                    $datasurat=Surattugas::where('tiket_id',$request->id)->first();
                    $surattugas=Surattugas::where('tiket_id',$request->id)->update([
                        'nomorlaporan'=>$nomorlaporan,
                        'kode_laporan'=>$request->kode_laporan,
                        'sts'=>4,
                        'kodifikasi_laporan'=>$request->kodifikasi,
                        'tgl_pengawas'=>date('Y-m-d'),
                        
                    ]);
                    
                    $data=Tiket::create([
                        'nik'=>Auth::user()['nik'],
                        'kode_sumber'=>$request->kode_laporan,
                        'kode_unit'=>$datasurat['kode_unit'],
                        'aktivitas_id'=>cek_aktivitas($request->kode_laporan),
                        'nomorinformasi'=>$nomorlaporan,
                        'judul'=>$tiket['judul_laporan'],
                        'bulan'=>date('m'),
                        'tahun'=>date('Y'),
                        'keterangan'=>$tiket['keterangan_laporan'],
                        'kodifikasi'=>$request->kodifikasi,
                        'lampiran'=>$tiket['lampiran_laporan'],
                        'tanggal_create_sumber'=>date('Y-m-d'),
                        'sts'=>2,
                    ]);

                    echo'ok';
                }
        }
    }
    public function approve_head(request $request){
        
            
            $surattugas=Surattugas::where('tiket_id',$request->id)->update([
                'tanggal_tiket_approve_head'=>date('Y-m-d'),
                'sts'=>5,
                'tgl_approval'=>date('Y-m-d'),
            ]);
            
            
            echo'ok';
        
    }
    public function simpan_hasil(request $request){
        $tiket=Tiket::where('id',$request->id)->first();
        if($tiket['kode_aktivitas']=='03'){
            if($tiket['kode_sumber']=='AR'){
                if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
                if (trim($request->judul) == '') {$error[] = '- Isi Judul';}
                if (trim($request->risiko) == '') {$error[] = '- Tentukan Risiko';}
                if (trim($request->kodifikasi_rekomendasi) == '') {$error[] = '- Pilih kode rekomendasi';}
                if (trim($request->rekomendasi) == '') {$error[] = '- Isi rekomendasi';}
                if (trim($request->kode_laporan) == '') {$error[] = '- Pilih kode laporan';}
                if (trim($request->lampiran) == '') {$error[] = '- Upload file Lampiran';}
                if (trim($request->keterangan) == '') {$error[] = '- Isi Keterangan';}
                if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                else{
                    
                    
                    
                        $image = $request->file('lampiran');
                        $size = $image->getSize();
                        $imageFileName =Auth::user()['nik'].date('ymdhis').'.'. $image->getClientOriginalExtension();
                        $filePath =$imageFileName;
                        $file = \Storage::disk('public_uploads');
                        if($image->getClientOriginalExtension()=='pdf'){
                            if($file->put($filePath, file_get_contents($image))){
                                $data=Tiket::where('id',$request->id)->update([
                                    'judul_laporan'=>$request->judul,
                                    'kode_laporan'=>$request->kode_laporan,
                                    'kodifikasi_laporan'=>$request->kodifikasi,
                                    'keterangan_laporan'=>$request->keterangan,
                                    'kodifikasi_rekomendasi'=>$request->kodifikasi_rekomendasi,
                                    'rekomendasi'=>$request->rekomendasi,
                                    'risiko'=>$request->risiko,
                                    'lampiran_laporan'=>$filePath,
                                    'tanggal_laporan'=>date('Y-m-d'),
                                    'sts'=>5,
                                ]);

                                $surat=Surattugas::where('tiket_id',$request->id)->update([
                                    'sts'=>3,
                                    'risiko'=>$request->risiko,
                                    'kode_laporan'=>$request->kode_laporan,
                                    'kodifikasi_rekomendasi'=>$request->kodifikasi_rekomendasi,
                                    'rekomendasi'=>$request->rekomendasi,
                                    'tgl_anggota'=>date('Y-m-d'),
                                ]);

                                if($tiket['kode_aktivitas']=='03'){
                                    echo'ok';
                                }else{
                                    // $data=Tiket::create([
                                    //     'nik'=>Auth::user()['nik'],
                                    //     'kode_sumber'=>$request->kode_laporan,
                                    //     'aktivitas_id'=>cek_aktivitas($request->kode_laporan),
                                    //     'nomorinformasi'=>$nomorlaporan,
                                    //     'judul'=>$request->judul,
                                    //     'bulan'=>date('m'),
                                    //     'tahun'=>date('Y'),
                                    //     'keterangan'=>$request->keterangan,
                                    //     'kodifikasi'=>$request->kodifikasi,
                                    //     'lampiran'=>$filePath,
                                    //     'tanggal_create_sumber'=>date('Y-m-d'),
                                    //     'sts'=>0,
                                    // ]);

                                    echo'ok';
                                }
                            }
                        }else{
                            echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Format File Harus PDF</p>';
                        }
                        
                }
            }else{
                $judul=Judul::where('tiket_id',$request->id)->count();
                if($judul>0){
                    $data=Tiket::where('id',$request->id)->update([
                        'sts'=>5,
                    ]);

                    $surat=Surattugas::where('tiket_id',$request->id)->update([
                        'sts'=>3,
                        'tgl_anggota'=>date('Y-m-d'),
                    ]);

                    echo'ok';
                }else{
                    echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br /> Isi Judul dan Tujuan</p>';
                }

            }
                
        }else{
            if (trim($request->kodifikasi) == '') {$error[] = '- Pilih Kodifikasi';}
            if (trim($request->judul) == '') {$error[] = '- Isi Judul';}
            if (trim($request->risiko) == '') {$error[] = '- Tentukan Risiko';}
            if (trim($request->rekomendasi) == '') {$error[] = '- Pilih rekomendasi';}
            if (trim($request->rekomendasi) == '') {$error[] = '- Pilih rekomendasi';}
            if (trim($request->kode_laporan) == '') {$error[] = '- Pilih kode laporan';}
            if (trim($request->lampiran) == '') {$error[] = '- Upload file Lampiran';}
            if (trim($request->keterangan) == '') {$error[] = '- Isi Keterangan';}
            if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                
                
                
                    $image = $request->file('lampiran');
                    $size = $image->getSize();
                    $imageFileName =Auth::user()['nik'].date('ymdhis').'.'. $image->getClientOriginalExtension();
                    $filePath =$imageFileName;
                    $file = \Storage::disk('public_uploads');
                    if($image->getClientOriginalExtension()=='pdf'){
                        if($file->put($filePath, file_get_contents($image))){
                            $data=Tiket::where('id',$request->id)->update([
                                'judul_laporan'=>$request->judul,
                                'kode_laporan'=>$request->kode_laporan,
                                'kodifikasi_laporan'=>$request->kodifikasi,
                                'keterangan_laporan'=>$request->keterangan,
                                'kodifikasi_rekomendasi'=>$request->kodifikasi_rekomendasi,
                                'rekomendasi'=>$request->rekomendasi,
                                'risiko'=>$request->risiko,
                                'lampiran_laporan'=>$filePath,
                                'tanggal_laporan'=>date('Y-m-d'),
                                'sts'=>5,
                            ]);

                            $surat=Surattugas::where('tiket_id',$request->id)->update([
                                'sts'=>3,
                                'risiko'=>$request->risiko,
                                'kode_laporan'=>$request->kode_laporan,
                                'kodifikasi_rekomendasi'=>$request->kodifikasi_rekomendasi,
                                'rekomendasi'=>$request->rekomendasi,
                                'tgl_anggota'=>date('Y-m-d'),
                            ]);

                            if($tiket['kode_aktivitas']=='03'){
                                echo'ok';
                            }else{
                                // $data=Tiket::create([
                                //     'nik'=>Auth::user()['nik'],
                                //     'kode_sumber'=>$request->kode_laporan,
                                //     'aktivitas_id'=>cek_aktivitas($request->kode_laporan),
                                //     'nomorinformasi'=>$nomorlaporan,
                                //     'judul'=>$request->judul,
                                //     'bulan'=>date('m'),
                                //     'tahun'=>date('Y'),
                                //     'keterangan'=>$request->keterangan,
                                //     'kodifikasi'=>$request->kodifikasi,
                                //     'lampiran'=>$filePath,
                                //     'tanggal_create_sumber'=>date('Y-m-d'),
                                //     'sts'=>0,
                                // ]);

                                echo'ok';
                            }
                        }
                    }else{
                        echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Format File Harus PDF</p>';
                    }
                    
            }
        }
    }

    public function simpan_tiket_lama(request $request){
        error_reporting(0);
        $count=count($request->nik);
        for($x=0;$x<$count;$x++){
            if($request->role[$x]==''){$role=3;}else{$role=$request->role[$x];}
            echo $request->nik[$x].'-'.$role.'<br>';
        }
    }

    public function simpan_tiket(request $request){
        error_reporting(0);
        if (trim($request->tiket_id) == '') {$error[] = '-Pilih Sumber';}
        if (trim($request->lokasi_id) == '') {$error[] = '-Pilih Lokasi';}
        if (trim($request->judul) == '') {$error[] = '- Isi Judul';}
        if (trim($request->lampiran) == '') {$error[] = '- Upload file Lampiran';}
        if (trim($request->kode_aktivitas) == '') {$error[] = '- Pilih Aktivitas';}
        if (trim($request->keterangan) == '') {$error[] = '- Isi Keterangan';}
        if (trim($request->name) == '') {$error[] = '- Isi Obyek Audit';}
        if (trim($request->kode_unit) == '') {$error[] = '- Pilih Unit Kerja';}
        if (trim($request->kode) == '') {$error[] = '- Pilih Kategori Audit';}
        if (trim($request->mulai) == '') {$error[] = '- Isi Tanggal mulai audit';}
        if (trim($request->sampai) == '') {$error[] = '- Isi Tanggal Selesai audit';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $count=Surattugas::where('kode_aktivitas',$request->kode_aktivitas)->count();
            
            if($count>0){
                $cek=Surattugas::orderBy('nomortiket','Desc')->where('kode_aktivitas',$request->kode_aktivitas)->firstOrfail();
                $urutan = (int) substr($cek['nomortiket'], 9, 2);
                $urutan++;
                $nomortiket='STIA'.$request->kode_aktivitas.date('y').kode_bulan(date('m')).sprintf("%02s", $urutan);
            }else{
                $nomortiket='STIA'.$request->kode_aktivitas.date('y').kode_bulan(date('m')).sprintf("%02s", 1);
                
            }
            $cektiket=Surattugas::where('nomortiket',$nomortiket)->count();
            if($cektiket>0){
                echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Terjadi Proses pembuatan tiket bersamaan</p>';
            }else{
                $counttim=count($request->nik);
                if($counttim>3){
                        $image = $request->file('lampiran');
                        $size = $image->getSize();
                        $imageFileName =$nomortiket.'.'. $image->getClientOriginalExtension();
                        $filePath =$imageFileName;
                        $file = \Storage::disk('public_uploads');
                        if($image->getClientOriginalExtension()=='pdf'){
                            if($file->put($filePath, file_get_contents($image))){
                                if($request->kode_aktivitas=='04' || $request->kode_aktivitas=='05' || $request->kode_aktivitas=='05' ){
                                    $sts1=3;
                                    $sts2=1;
                                }else{
                                    $sts1=3;
                                    $sts2=1;
                                }
                                    $tiket=Tiket::where('id',$request->tiket_id)->first();
                                    $nomorsurat=nomorsurat($request->kode,$request->kode_unit,$request->kode_aktivitas);
                                    $surat=Surattugas::create([
                                        'name'=>$request->name,
                                        'nomorinformasi'=>$tiket['nomorinformasi'],
                                        'tiket_id'=>$tiket['id'],
                                        'nomortiket'=>$nomortiket,
                                        'kode_sumber'=>$tiket['kode_sumber'],
                                        'lokasi_id'=>$request->lokasi_id,
                                        'kode_aktivitas'=>$request->kode_aktivitas,
                                        'kode_unit'=>$request->kode_unit,
                                        'mulai'=>$request->mulai,
                                        'sampai'=>$request->sampai,
                                        'kode'=>$request->kode,
                                        'nomorsurat'=>$nomorsurat,
                                        'bulan'=>date('m'),
                                        'tahun'=>date('Y'),
                                        'tanggal'=>date('Y-m-d'),
                                        'sts'=>$sts2,
                                    ]);
                                    if($surat){
                                        $data=Tiket::where('id',$request->tiket_id)->update([
                                            'nomortiket'=>$nomortiket,
                                            'judul_tiket'=>$request->judul,
                                            'kode_aktivitas'=>$request->kode_aktivitas,
                                            'bulan_tiket'=>date('m'),
                                            'tahun_tiket'=>date('Y'),
                                            'lokasi_id'=>$request->lokasi_id,
                                            'keterangan_tiket'=>$request->keterangan,
                                            'lampiran_tiket'=>$filePath,
                                            'sts'=>$sts1,
                                        ]);
                                        
                                        if($data){
                                            
                                            for($x=0;$x<$counttim;$x++){
                                                if($request->role[$x]==''){$role=3;}else{$role=$request->role[$x];}
                                                $tim=Timaudit::create([
                                                    'tiket_id'=>$tiket['id'],
                                                    'nik'=>$request->nik[$x],
                                                    'role_id'=>$role,
                                                    'nomortiket'=>$surat['nomortiket']
                                                ]);
                                            }
                                            echo'ok';
                                        }else{
                                            echo'ok';
                                        }
                                    }
                            }else{
                                echo'gagal upload';
                            }
                        }else{
                            echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Format File Harus PDF</p>';
                        }
                }else{
                    echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Struktur Tim Terdiri dari 1 (Pengawas dan Ketua Tim) dan minimal 1 Anggota</p>';
                }
            }
                
        }
    }

    public function edit_tiket(request $request){
        error_reporting(0);
        if (trim($request->judul) == '') {$error[] = '- Isi Judul';}
        if (trim($request->keterangan) == '') {$error[] = '- Isi Keterangan';}
        if (trim($request->name) == '') {$error[] = '- Isi Obyek Audit';}
        if (trim($request->mulai) == '') {$error[] = '- Isi Tanggal mulai audit';}
        if (trim($request->sampai) == '') {$error[] = '- Isi Tanggal Selesai audit';}
        if (trim($request->catatan) == '') {$error[] = '- Isi Catatan Penting';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
                $counttim=count($request->nik);
                if($counttim>2){
                        
                    $data=Tiket::where('id',$request->tiket_id)->update([
                        'judul_tiket'=>$request->judul,
                        'keterangan_tiket'=>$request->keterangan,
                        'lampiran_tiket'=>$filePath,
                    ]);
                    $surat=Surattugas::where('tiket_id',$request->tiket_id)->update([
                        'name'=>$request->name,
                        'mulai'=>$request->mulai,
                        'sampai'=>$request->sampai,
                        'catatan'=>$request->catatan,
                        
                    ]);
                    
                    if($surat=='0'){
                        $datasurat=Surattugas::where('tiket_id',$request->tiket_id)->first();
                        $hapus=Timaudit::where('tiket_id',$request->tiket_id)->delete();
                        if($hapus){
                            for($x=0;$x<$counttim;$x++){
                                if($request->role[$x]==''){$role=3;}else{$role=$request->role[$x];}
                                $tim=Timaudit::create([
                                    'tiket_id'=>$datasurat['tiket_id'],
                                    'nik'=>$request->nik[$x],
                                    'role_id'=>$role,
                                    'nomortiket'=>$datasurat['nomortiket']
                                ]);
                            }
                        }
                        echo'ok';
                    }else{
                        echo'ok';
                    }
                           
                }else{
                    echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Struktur Tim Terdiri dari 1 (Pengawas dan Ketua Tim) dan minimal 1 Anggota</p>';
                }
             
        }
    }

    public function simpan_ubah(request $request){
        if (trim($request->judul) == '') {$error[] = '- Isi Judul';}
        if (trim($request->keterangan) == '') {$error[] = '- Isi Keterangan';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data=Tiket::where('id',$request->id)->update([
                'judul'=>$request->judul,
                'keterangan'=>$request->keterangan,
                'sts'=>0,
                'tanggal_create_sumber'=>date('Y-m-d'),
            ]);

            if($data){
                echo'ok';
            }
        }
    }

    public function edit_lampiran_tiket(request $request){
        if (trim($request->lampiran) == '') {$error[] = '- Upload file lampiran ".pdf"';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:11px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $image = $request->file('lampiran');
            $size = $image->getSize();
            $imageFileName =$request->nomortiket.'.'. $image->getClientOriginalExtension();
            $filePath =$imageFileName;
            $file = \Storage::disk('public_uploads');
            if($image->getClientOriginalExtension()=='pdf'){
                if($file->put($filePath, file_get_contents($image))){
                    $data=Tiket::where('id',$request->id)->update([
                        'lampiran_tiket'=>$filePath,
                    ]);
                    if (env('APP_DEBUG') || env('APP_ENV') === 'local')
                    Artisan::call('view:clear');
                    echo'ok';
                }else{
                    echo'Gagal Upload';
                }
                
            }else{
                echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Format File Harus PDF</p>';
            }
        }
    }

    public function simpan_ubah_tiket(request $request){
        if (trim($request->judul) == '') {$error[] = '- Isi Judul';}
        if (trim($request->keterangan) == '') {$error[] = '- Isi Keterangan';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            if($request->lampiran==''){
                $data=Tiket::where('id',$request->id)->update([
                    'judul_tiket'=>$request->judul,
                    'keterangan_tiket'=>$request->keterangan,
                ]);

                
                    echo'ok';
                
            }else{
                $cekrec=Tiket::where('id',$request->id)->first();
                $nomortiket=$cekrec['nomortiket'];
                $image = $request->file('lampiran');
                $size = $image->getSize();
                $imageFileName =$nomortiket.'.'. $image->getClientOriginalExtension();
                $filePath =$imageFileName;
                $file = \Storage::disk('public_uploads');
                if($image->getClientOriginalExtension()=='pdf'){
                    if($file->put($filePath, file_get_contents($image))){
                        $data=Tiket::where('id',$request->tiket_id)->update([
                            'judul_tiket'=>$request->judul,
                            'keterangan_tiket'=>$request->keterangan,
                            'lampiran_tiket'=>$filePath,
                        ]);

                        
                            echo'ok';
                        
                    }
                }else{
                    echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br /> Format File Harus PDF</p>';
                }
            }
        }
    }

    public function setujui(request $request){
        if (trim($request->sts) == '') {$error[] = '- Pilih Status';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            if($request->sts==1){
                if (trim($request->alasan) == '') {$error[] = '- Isi alasan dikembalikan Status';}
                if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
                else{
                    $data=Tiket::where('id',$request->id)->update([
                        'sts'=>10,
                        'alasan'=>$request->alasan,
                        'tanggal_create_approve'=>date('Y-m-d'),
                    ]);

                    if($data){
                        echo'ok';
                    }
                }
            }else{
                $data=Tiket::where('id',$request->id)->update([
                    'sts'=>1,
                    'tanggal_create_approve'=>date('Y-m-d'),
                ]);
    
                if($data){
                    echo'ok';
                }
            }
            
        }
    }

    public function setujui_head(request $request){
        
            $data=Tiket::where('id',$request->id)->update([
                'sts'=>2,
                'tanggal_create_approve_head'=>date('Y-m-d'),
            ]);

            if($data){
                echo'ok';
            }
        
    }

    public function approve_tiket_pengawas(request $request){
        $data=Tiket::where('id',$request->tiket_id)->update([
            'sts'=>4,
            'catatan_tiket'=>$request->catatan_tiket,
            'tanggal_tiket_approve_head'=>date('Y-m-d'),
        ]);
        
        if($data){
            echo'ok';
        }
    }

    public function approve_tiket(request $request){
        if(Auth::user()['posisi_id']==1){
                $surat=Surattugas::where('tiket_id',$request->tiket_id)->first();
                if($surat['kode_aktivitas']=='04' || $surat['kode_aktivitas']=='05' || $surat['kode_aktivitas']=='06' ){
                    $sts1=5;
                }else{
                    $sts1=2;
                }
                $data=Surattugas::where('tiket_id',$request->tiket_id)->where('sts',1)->update([
                    'sts'=>$sts1,
                    'catatan'=>$request->catatan,
                    'tanggal_tiket_approve_head'=>date('Y-m-d'),
                    'tgl_head'=>date('Y-m-d'),
                ]);
                
                echo'ok';
           
        }
        if(Auth::user()['posisi_id']==13){
            $data=Surattugas::where('tiket_id',$request->tiket_id)->where('sts',4)->update([
                'sts'=>5,
                'tanggal_tiket_approve_head'=>date('Y-m-d'),
            ]);
            echo'ok';
            
        }
        
        
    }

    public function hapus(request $request){
        error_reporting(0);
        $count=count($request->id);
        if (trim($count) == 0) {$error[] = '- Pilih Tiket';}
        if (isset($error)) {echo implode('<br />', $error);} 
        else{
            for($x=0;$x<$count;$x++){
                $data=Tiket::where('nik',$request->id)->delete();
            }
            echo'ok';
        }
    }

    public function hapus_tiket(request $request){
        error_reporting(0);
        $count=count($request->id);
        if (trim($count) == 0) {$error[] = '- Pilih Tiket';}
        if (isset($error)) {echo implode('<br />', $error);} 
        else{
            for($x=0;$x<$count;$x++){
                $data=Tiket::where('id',$request->id)->update([
                    'sts'=>2,
                ]);
            }
            echo'ok';
        }
    }

    public function surattugas (request $request){
        $data=Tiket::where('id',$request->id)->first();
        $tim=Timaudit::where('tiket_id',$request->id)->orderBy('id','Asc')->get();
        $pdf = PDF::loadView('pdf.surattugas', compact('data','tim'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
    }
}
