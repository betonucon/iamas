<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Audit;
use App\Timaudit;
use App\Compliance;
use App\Viewcountcomplianceprogram;
use App\Complangkahkerja;
use Artisan;
use PDF;
use Illuminate\Support\Facades\Hash;
class ComplianceController extends Controller
{
    public function index(request $request){
        if(akses_tiket_ketua()>0){
            $menu='Compliance';
            $side="auditketua";
            return view('Compliance.index',compact('menu','side'));
        }else{
            return view('error');
        }
    }

    public function index_pengawas(request $request){
        if(akses_tiket_pengawas()>0){
            $menu='Compliance';
            $side="auditpengawas";
            return view('Compliance.index_pengawas',compact('menu','side'));
        }else{
            return view('error');
        }
    }
    public function index_head(request $request){
        if(akses_tiket_head()>0){
            $menu='Compliance';
            $side="audithead";
            return view('Compliance.index_head',compact('menu','side'));
        }else{
            return view('error');
        }
    }
    
    public function view_catatan_head(request $request){
        $data=Audit::where('id',encoder($request->id))->first();
        
        if(Auth::user()['role_id']==7){
            $menu=' Review Compliance';
            $label='<div class="alert alert-warning fade show m-b-10">
                        <span class="close" data-dismiss="alert">×</span>
                        <b>NO SURAT : '.$data['nomorsurat'].'</b><br>Jika sudah melakukan review silahkan tentukan hasil review .
                    </div>';
        }else{
            $menu=' Compliance Catatan';
            $label='';
        }
        $side="audithead";
        $program=Compliance::where('audit_id',encoder($request->id))->get();
        return view('Compliance.view_catatan',compact('menu','data','program','side','label'));
        
    }
    public function index_catatanpengawas(request $request){
        if(akses_tiket_pengawas()>0){
            $menu='Compliance Catatan';
            $side="auditpengawas";
            return view('Compliance.index_catatanpengawas',compact('menu','side'));
        }else{
            return view('error');
        }
    }

    public function index_anggota(request $request){
        if(akses_tiket_anggota()>0){
            $menu='Compliance';
            $side="auditanggota";
            return view('Compliance.index_anggota',compact('menu','side'));
        }else{
            return view('error');
        }
    }

    public function index_catatan(request $request){
        if(akses_tiket_ketua()>0){
            $menu='Compliance Catatan';
            $side="auditketua";
            return view('Compliance.index_catatan',compact('menu','side'));
        }else{
            return view('error');
        }
    }

    

    public function create(request $request){
        error_reporting(0);
        $cek=Audit::where('id',encoder($request->id))->count();
        $act=$request->act;
        if(akses_tiket_ketua()>0 && $cek>0){
            
            if($act=='revisi'){
                $menu='Perbaikan Compliance Program';
            }else{
                $menu='Compliance Program';
            }
            $side="auditketua";
            $data=Audit::where('id',encoder($request->id))->first();
            $program=Compliance::where('audit_id',encoder($request->id))->get();
            
            if($data['sts_compliance']==null || $data['sts_compliance']==0){
                return view('Compliance.create',compact('menu','data','program','side','act'));
            }else{
                
                if($data['sts_revisi_compliance_langkah']==2){
                    return view('Compliance.create',compact('menu','data','program','side','act'));
                }else{
                    return view('Compliance.view',compact('menu','data','program','side'));
                }
            }
            
        }else{
            return view('error');
        }
    }

    public function approve_pengawas(request $request){
        error_reporting(0);
        $cek=Audit::where('id',encoder($request->id))->count();
        
        if(akses_tiket_pengawas()>0 && $cek>0){
            $menu='Approve Compliance Program';
            $side="auditpengawas";
            $data=Audit::where('id',encoder($request->id))->first();
            $program=Compliance::where('audit_id',encoder($request->id))->get();
            return view('Compliance.view_pengawas',compact('menu','data','program','side'));
            
        }else{
            return view('error');
        }
    }

    public function approve_catatanpengawas(request $request){
        error_reporting(0);
        if(akses_tiket_pengawas()>0){
            $menu='Approve Compliance Catatan';
            $side="auditpengawas";
            $data=Audit::where('id',encoder($request->id))->first();
            $program=Compliance::where('audit_id',encoder($request->id))->get();
            return view('Compliance.view_catatan_pengawas',compact('menu','data','program','side'));
            
        }else{
            return view('error');
        }
    }

    public function catatan(request $request){
        error_reporting(0);
        $act=$request->act;
        if(akses_tiket_anggota()>0 || akses_tiket_ketua()>0){
            if(akses_tiket_ketua()>0){
                if($act=='revisi'){
                    $menu='Perbaikan Compliance Catatan';
                }else{
                    $menu='Compliance Catatan';
                }
                $side="auditketua";
                $label='';
                $data=Audit::where('id',encoder($request->id))->first();
                $program=Compliance::where('audit_id',encoder($request->id))->get();
                if($data['sts_compliance']==2){
                    return view('Compliance.view_anggota',compact('menu','data','program','side','act'));
                }else{
                    if($data['sts_revisi_compliance_catatan']==2){
                        return view('Compliance.view_anggota',compact('menu','data','program','side','act'));
                    }else{
                        return view('Compliance.view_catatan',compact('menu','data','program','side','label'));
                    }
                }
            }else{
                if($act=='revisi'){
                    $menu='Perbaikan Compliance Catatan';
                }else{
                    $menu='Compliance Catatan';
                }
                $side="auditketua";
                $data=Audit::where('id',encoder($request->id))->first();
                $label='';
                $program=Compliance::where('audit_id',encoder($request->id))->get();
                if($data['sts_compliance']==2){
                    return view('Compliance.view_anggota',compact('menu','data','program','side','act'));
                }else{
                    if($data['sts_revisi_compliance_catatan']==2){
                        return view('Compliance.view_anggota',compact('menu','data','program','side','act'));
                    }else{
                        if($data['sts_revisi_compliance_catatan']==2){
                            return view('Compliance.view_anggota',compact('menu','data','program','side','act'));
                        }else{
                            return view('Compliance.view_catatan',compact('menu','data','program','side','label'));
                        }
                    }
                }
            }
           
            
            
        }else{
            return view('error');
        }
    }

    

    public function ubah_pokok(request $request){
        $data=Compliance::where('id',$request->id)->first();
        echo'
            <input type="hidden" name="id" value="'.$data['id'].'">
            <div class="col-xl-10 offset-xl-1">
                <div class="form-group row m-b-10" >
                    <label class="col-lg-3 text-lg-right col-form-label"> Pokok Materi</label>
                    <div class="col-lg-9 col-xl-9">
                        <textarea class="form-control" name="name" id="textareatiket22" placeholder="Ketik disini...." >'.$data['name'].'</textarea>
                    </div>
                </div>
                
            </div>
        ';
        echo'
            <script>
                $("#textareatiket22").wysihtml5({
                    locale: "zh-TW",
                    name: "t-iframe",
                    events: {
                        load: function(){
                            var $body = $(this.composer.element);
                            var $iframe = $(this.composer.iframe);
                            iframeh = Math.max($body[0].scrollHeight, $body.height()) + 100;
                            document.getElementsByClassName("wysihtml5-sandbox")[0].setAttribute("style","height: " + iframeh +"px !important");
                        },change: function(){
                            var $abody = $(this.composer.element);
                            var $aiframe = $(this.composer.iframe);
                            aiframeh = Math.max($abody[0].scrollHeight, $abody.height()) + 100;
                            document.getElementsByClassName("wysihtml5-sandbox")[0].setAttribute("style","height: " + aiframeh +"px !important");
                        }
                    }
                });
            </script>

        ';
    }

    public function isi_catatan(request $request){
        $data=Complangkahkerja::where('id',$request->id)->first();
        echo'
            <div class="form-group">
                <label>Lampiran</label>
                <input type="file" placeholder="yyyy-mm-dd" class="form-control" name="file" style="width:40%"  />
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <textarea class="form-control" rows="8"  placeholder="Ketik disini...." id="isinya">'.$data['catatan'].'</textarea>
            </div>

        ';
        echo'
        <script>
                $(document).ready(function() {
                    CKEDITOR.replace( "isinya" );
                });

        
        </script>

        ';
    }
    public function tampil_langkah_kerja(request $request){
        error_reporting(0);
        $data=Complangkahkerja::where('audit_id',$request->id)->orderBy('id','Asc')->get();
        echo'
            <table id="myTable" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="3%" class="text-nowrap"></th>
                        <th class="text-nowrap">Langkah Kerja</th>
                        <th width="10%" class="text-nowrap">Tanggal</th>
                        
                    </tr>
                </thead>
                <tbody>';
                    foreach($data as $no=>$o){
                        echo'
                            <tr>
                                <td>'.($no+1).'</td>
                                <td><input type="checkbox" name="langkah_id[]" value="'.$o['id'].'"></td>
                                <td>'.$o['name'].'</td>
                                <td>'.$o['tanggal'].'</td>
                                
                            </tr>

                        ';
                    }

                echo'
                </tbody>
            </table>
        ';
    }

    
    public function send_to_pengawas(request $request){
        $cekdata=Viewcountcomplianceprogram::where('audit_id',$request->id)->where('total_langkah',0)->count();
        
        if ($cekdata>0) {
            echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />Lengkapi langkah kerja</p>';
        }else{
            $data=Audit::where('id',$request->id)->update([
                'sts_compliance'=>1,
            ]);
            echo 'ok';
        }
    }

    public function send_catatan_to_pengawas(request $request){
        
            $data=Audit::where('id',$request->id)->update([
                'sts_compliance'=>3,
            ]);
            echo 'ok';
       
    }

    public function proses_catatan(request $request){
        if (trim($request->file) =='') {$error[] = '- Upload file lampiran';}
        if (trim($request->content) =='') {$error[] = '- Isi Catatan';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $image = $request->file('file');
            $size = $image->getSize();
            $imageFileName ='catatanlangkahcom'.$request->id.'.'. $image->getClientOriginalExtension();
            $filePath =$imageFileName;
            $file = \Storage::disk('public_uploads');
           
            if($file->put($filePath, file_get_contents($image))){
                $data=Complangkahkerja::where('id',$request->id)->update([
                    'catatan'=>$request->content,
                    'tanggal_aktual'=>date('Y-m-d'),
                    'file'=>$filePath,
                ]);
                echo 'ok';
            }
        }
    }

    public function proses_approve_pengawas(request $request){
        if (trim($request->sts) == '') {$error[] = '- Pilih Status';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            if($request->sts==1){
                $data=Audit::where('id',$request->id)->update([
                    'sts_compliance'=>2,
                    'tgl_sts6'=>date('Y-m-d'),
                    'sts'=>6,
                    'sts_revisi_compliance_langkah'=>1,
                ]);
            }else{
                $data=Audit::where('id',$request->id)->update([
                    'sts_compliance'=>0,
                    'alasan_pengawas_compliance_program'=>$request->alasan,
                ]);
            }

            echo'ok';
        }
            
           
    }

    public function proses_approve_catatan_pengawas(request $request){
        if (trim($request->sts) == '') {$error[] = '- Pilih Status';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            if($request->sts==1){
                $data=Audit::where('id',$request->id)->update([
                    'sts_compliance'=>4,
                    'tgl_sts7'=>date('Y-m-d'),
                    'sts'=>7,
                    'sts_revisi_compliance_catatan'=>1,
                ]);
            }else{
                $data=Audit::where('id',$request->id)->update([
                    'sts_compliance'=>2,
                    'alasan_pengawas_compliance_catatan'=>$request->alasan,
                ]);
            }

            echo'ok';
        }
            
           
    }

    public function hapus_pokok(request $request){
        $data=Compliance::where('id',$request->id)->delete();
        if($data){
            $data=Complangkahkerja::where('compliance_id',$request->id)->delete();
        }
    }

    public function save(request $request){

        if (trim($request->name) == '') {$error[] = '- Isi Pokok Materi';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
                $desk=Audit::where('id',$request->audit_id)->first();
                $data=Compliance::create([
                    'name'=>$request->name,
                    'audit_id'=>$request->audit_id,
                    'tiket_id'=>$desk['tiket_id'],
                    'nomortiket'=>$desk['nomortiket'],
                    
                ]);
                if($data){
                    echo'ok';
                }
                    
                
        }
    }

    public function update(request $request){

        if (trim($request->name) == '') {$error[] = '- Isi Pokok Materi';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
                $data=Compliance::where('id',$request->id)->update([
                    'name'=>$request->name,
                ]);
                if($data){
                    echo'ok';
                }
                    
                
        }
    }

    public function save_langkah(request $request){

        if (trim($request->compliance_id) == '') {$error[] = '- Audit Harus diisi';}
        if (trim($request->name) == '') {$error[] = '- Isi Langhkah Kerja';}
        if (trim($request->tanggal) == '') {$error[] = '- Isi tanggal';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data=Complangkahkerja::create([
                'name'=>$request->name,
                'tanggal'=>$request->tanggal,
                'sts'=>0,
                'compliance_id'=>$request->compliance_id
            ]);
            echo'ok';
        }
    }

    public function hapus_langkah(request $request){
        error_reporting(0);
        $hapus=Complangkahkerja::where('id',$request->id)->delete();
            
    }

    
    public function acc_head(request $request){
        if (trim($request->sts) == '') {$error[] = '- Pilih Status';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            if($request->sts==2){
                $acc=Audit::where('id',$request->id)->update([
                    'sts'=>1,
                    'alasan_head'=>$request->alasan,
                ]);
                echo'ok';
            }else{
                $acc=Audit::where('id',$request->id)->update([
                    'sts'=>$request->sts,
                    'tgl_sts3'=>date('Y-m-d'),
                ]);
                echo'ok';
            }
        }
        
    }

    public function cetak(request $request){
        $data=Audit::where('id',$request->id)->first();
        $pdf = PDF::loadView('Compliance.cetak', compact('data'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
    }
    public function cetakcatatan(request $request){
        $data=Audit::where('id',$request->id)->first();
        $pdf = PDF::loadView('Compliance.cetak_catatan', compact('data'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
    }

    
}
