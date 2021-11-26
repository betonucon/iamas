<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Audit;
use App\Timaudit;
use App\Compliance;
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
            return view('Compliance.index',compact('menu','ketua','side'));
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
        
        if(akses_tiket_ketua()>0 && $cek>0){
            $menu='Compliance Program';
            $side="auditketua";
            $data=Audit::where('id',encoder($request->id))->first();
            $program=Compliance::where('audit_id',encoder($request->id))->get();
            
            if($data['sts_compliance']==null || $data['sts_compliance']==0){
                return view('Compliance.create',compact('menu','data','program','side'));
            }else{
                return view('Compliance.view',compact('menu','data','program','side'));
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
        if(akses_tiket_anggota()>0 || akses_tiket_ketua()>0){
            if(akses_tiket_ketua()>0){
                $menu=' Compliance Catatan';
                $side="auditketua";
                $data=Audit::where('id',encoder($request->id))->first();
                $program=Compliance::where('audit_id',encoder($request->id))->get();
                if($data['sts_compliance']==2){
                    return view('Compliance.view_anggota',compact('menu','data','program','side'));
                }else{
                    return view('Compliance.view_catatan',compact('menu','data','program','side'));
                }
            }else{
                $menu=' Compliance Catatan';
                $side="auditketua";
                $data=Audit::where('id',encoder($request->id))->first();
                $program=Compliance::where('audit_id',encoder($request->id))->get();
                if($data['sts_compliance']==2){
                    return view('Compliance.view_anggota',compact('menu','data','program','side'));
                }else{
                    return view('Compliance.view_catatan',compact('menu','data','program','side'));
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
                <label>Tanggal</label>
                <input type="text" placeholder="yyyy-mm-dd" class="form-control" name="tanggal_aktual" value="'.$data['tanggal_aktual'].'" style="width:20%" id="tgl_langkahkerja" />
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <textarea class="form-control" rows="8" name="catatan" placeholder="Ketik disini...." id="textareatiket">'.$data['catatan'].'</textarea>
            </div>

        ';
        echo'
            <script>
                $(document).ready(function() {
                    $("#tgl_langkahkerja").datepicker({format: "yyyy-mm-dd",autoclose: true});
                });

                $("#textareatiket").wysihtml5({
                    locale: "zh-TW",
                    name: "t-iframe",
                    events: {
                        load: function(){
                            var $body = $(this.composer.element);
                            var $iframe = $(this.composer.iframe);
                            iframeh = Math.max($body[0].scrollHeight, $body.height()) + 200;
                            document.getElementsByClassName("wysihtml5-sandbox")[0].setAttribute("style","height: " + iframeh +"px !important");
                        },change: function(){
                            var $abody = $(this.composer.element);
                            var $aiframe = $(this.composer.iframe);
                            aiframeh = Math.max($abody[0].scrollHeight, $abody.height()) + 200;
                            document.getElementsByClassName("wysihtml5-sandbox")[0].setAttribute("style","height: " + aiframeh +"px !important");
                        }
                    }
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
        $cekdata=$data=Compliance::where('audit_id',$request->id)->count();
        
        if (trim($cekdata) =='0') {$error[] = '- Isi Pokok Materi dan Langkah kerja';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
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
        if (trim($request->tanggal_aktual) =='') {$error[] = '- Isi Tanggal aktual';}
        if (trim($request->catatan) =='') {$error[] = '- Isi Catatan';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data=Complangkahkerja::where('id',$request->id)->update([
                'catatan'=>$request->catatan,
                'tanggal_aktual'=>$request->tanggal_aktual,
            ]);
            echo 'ok';
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
                ]);
            }else{
                $data=Audit::where('id',$request->id)->update([
                    'sts_compliance'=>0,
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
                ]);
            }else{
                $data=Audit::where('id',$request->id)->update([
                    'sts_compliance'=>2,
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

    
}