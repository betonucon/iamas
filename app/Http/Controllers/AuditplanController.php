<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Audit;
use App\Timaudit;
use App\Surattugas;
use Artisan;
use PDF;
use Illuminate\Support\Facades\Hash;
class AuditplanController extends Controller
{
    public function index(request $request){
        error_reporting(0);
        $menu='AuditPlan';
        $side="auditpengawas";
        return view('Auditplan.index',compact('menu','side'));
    }

    public function index_acc(request $request){
        error_reporting(0);
        $menu='AuditPlan';
        $side="audithead";
        return view('Auditplan.index_acc',compact('menu','side'));
    }

    public function create(request $request){
        error_reporting(0);
        $menu='Buat AuditPlan';
        $side="auditpengawas";
        return view('Auditplan.create',compact('menu','side'));
    }

    public function edit(request $request){
        error_reporting(0);
        $side="auditpengawas";
        $data=Audit::where('tiket_id',$request->id)->first();
        
        if($data['sts_audit']==1){
            $menu='View AuditPlan';
            return view('Auditplan.edit',compact('menu','data','side'));
        }else{
            $menu='View ';
            return view('Auditplan.view',compact('menu','data','side'));
        }
        
    }

    public function acc(request $request){
        error_reporting(0);
        
        $data=Audit::where('tiket_id',$request->id)->first();
        $side="audithead";
        if($data['sts_audit']==1){
            $menu='Approve ';
            return view('Auditplan.acc_head',compact('menu','data','side'));
        }else{
            $menu='View ';
            return view('Auditplan.view',compact('menu','data','side'));
        }
        
        
    }

    public function pilih_surat_tugas(request $request){
        error_reporting(0);
        
        $data=Surattugas::where('tiket_id',$request->id)->first();
        $pengawas=Timaudit::where('tiket_id',$data['tiket_id'])->where('role_id',2)->first();
        $ketua=Timaudit::where('tiket_id',$data['tiket_id'])->where('role_id',1)->first();
        $agt=Timaudit::where('tiket_id',$data['tiket_id'])->where('role_id',3)->get();
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
        error_reporting(0);
        $data=Audit::where('id',$request->id)->update([
            'sts'=>2,
            'tgl_sts2'=>date('Y-m-d'),
        ]);
    }
    public function save(request $request){
        error_reporting(0);

        if (trim($request->tiket_id) == '') {$error[] = '- Pilih Surat Tugas';}
        if (trim($request->tujuan) == '') {$error[] = '- Isi Tujuan';}
        if (trim($request->sasaran) == '') {$error[] = '- Isi Sasaran';}
        if (trim($request->risiko) == '') {$error[] = '- Isi Risiko';}
        if (trim($request->tgl_penerbitan) == '') {$error[] = '- Isi Tanggal Penerbitan';}
        if (trim($request->tgl_plan) == '') {$error[] = '- Isi Tanggal Persetujuan Auditplan';}
        if (trim($request->tgl_deskaudit_program_start) == '') {$error[] = '- Isi Tanggal Mulai Program Deskaudit';}
        if (trim($request->tgl_deskaudit_program_end) == '') {$error[] = '- Isi Tanggal Sampai Program Deskaudit';}
        if (trim($request->tgl_deskaudit_hasil_start) == '') {$error[] = '- Isi Tanggal Mulai hasil Deskaudit';}
        if (trim($request->tgl_deskaudit_hasil_end) == '') {$error[] = '- Isi Tanggal Sampai hasil Deskaudit';}
        if (trim($request->tgl_compliance_program_start) == '') {$error[] = '- Isi Tanggal Mulai Program compliance';}
        if (trim($request->tgl_compliance_program_end) == '') {$error[] = '- Isi Tanggal Sampai Program compliance';}
        if (trim($request->tgl_compliance_hasil_start) == '') {$error[] = '- Isi Tanggal Mulai hasil compliance';}
        if (trim($request->tgl_compliance_hasil_end) == '') {$error[] = '- Isi Tanggal Sampai hasil compliance';}
        if (trim($request->tgl_substantive_program_start) == '') {$error[] = '- Isi Tanggal Mulai Program substantive';}
        if (trim($request->tgl_substantive_program_end) == '') {$error[] = '- Isi Tanggal Sampai Program substantive';}
        if (trim($request->tgl_substantive_hasil_start) == '') {$error[] = '- Isi Tanggal Mulai hasil substantive';}
        if (trim($request->tgl_substantive_hasil_end) == '') {$error[] = '- Isi Tanggal Sampai hasil substantive';}
        if (trim($request->tgl_lha_start) == '') {$error[] = '- Isi Tanggal Mulai penyusunan LHA';}
        if (trim($request->tgl_lha_end) == '') {$error[] = '- Isi Tanggal Sampai penyusunan LHA';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=Audit::where('tiket_id',$request->tiket_id)->count();
            if($cek>0){
                echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />- Surat Tugas Sudah diproses</p>';
            }else{
                $surat=Surattugas::where('tiket_id',$request->tiket_id)->first();
                $acc=Surattugas::where('tiket_id',$request->tiket_id)->update([
                    'sts'=>4,
                ]);
                $data=Audit::create([
                    'name'=>$request->name,
                    'kodifikasi'=>$surat['kodifikasi'],
                    'kode_aktivitas'=>$surat['kode_aktivitas'],
                    'kodifikasi_laporan'=>$surat['kodifikasi_laporan'],
                    'nomorsurat'=>$surat['nomorsurat'],
                    'kode'=>$surat['kode'],
                    'bulan'=>date('m'),
                    'tahun'=>date('Y'),
                    'tanggal'=>date('Y-m-d'),
                    'tgl_sts1'=>date('Y-m-d'),
                    'kode_unit'=>$surat['kode_unit'],
                    'sts'=>1,
                    'sts_audit'=>1,
                    'tiket_id'=>$request->tiket_id,
                    'tujuan'=>$request->tujuan,
                    'sasaran'=>$request->sasaran,
                    'risiko'=>$request->risiko,
                    'tgl_penerbitan'=>$request->tgl_penerbitan,
                    'tgl_plan'=>$request->tgl_plan,
                    'tgl_deskaudit_program_start'=>$request->tgl_deskaudit_program_start,
                    'tgl_deskaudit_program_end'=>$request->tgl_deskaudit_program_end,
                    'tgl_deskaudit_hasil_start'=>$request->tgl_deskaudit_hasil_start,
                    'tgl_deskaudit_hasil_end'=>$request->tgl_deskaudit_hasil_end,
                    'tgl_compliance_program_start'=>$request->tgl_compliance_program_start,
                    'tgl_compliance_program_end'=>$request->tgl_compliance_program_end,
                    'tgl_compliance_hasil_start'=>$request->tgl_compliance_hasil_start,
                    'tgl_compliance_hasil_end'=>$request->tgl_compliance_hasil_end,
                    'tgl_substantive_program_start'=>$request->tgl_substantive_program_start,
                    'tgl_substantive_program_end'=>$request->tgl_substantive_program_end,
                    'tgl_substantive_hasil_start'=>$request->tgl_substantive_hasil_start,
                    'tgl_substantive_hasil_end'=>$request->tgl_substantive_hasil_end,
                    'tgl_lha_start'=>$request->tgl_lha_start,
                    'tgl_lha_end'=>$request->tgl_lha_end,
                    'tgl_lha_draf_start'=>$request->tgl_lha_draf_start,
                    'tgl_lha_draf_end'=>$request->tgl_lha_draf_end,
                    'tgl_lha_finis_start'=>$request->tgl_lha_finis_start,
                    'tgl_lha_finis_end'=>$request->tgl_lha_finis_end,
                    
                ]);
                echo'ok';
            }
        }
    }

    public function update(request $request){
        error_reporting(0);
        if (trim($request->name) == '') {$error[] = '- Isi Nama Obyek';}
        if (trim($request->tgl_penerbitan) == '') {$error[] = '- Isi Tanggal Penerbitan';}
        if (trim($request->tgl_plan) == '') {$error[] = '- Isi Tanggal Persetujuan Auditplan';}
        if (trim($request->tgl_deskaudit_program_start) == '') {$error[] = '- Isi Tanggal Mulai Program Deskaudit';}
        if (trim($request->tgl_deskaudit_program_end) == '') {$error[] = '- Isi Tanggal Sampai Program Deskaudit';}
        if (trim($request->tgl_deskaudit_hasil_start) == '') {$error[] = '- Isi Tanggal Mulai hasil Deskaudit';}
        if (trim($request->tgl_deskaudit_hasil_end) == '') {$error[] = '- Isi Tanggal Sampai hasil Deskaudit';}
        if (trim($request->tgl_compliance_program_start) == '') {$error[] = '- Isi Tanggal Mulai Program compliance';}
        if (trim($request->tgl_compliance_program_end) == '') {$error[] = '- Isi Tanggal Sampai Program compliance';}
        if (trim($request->tgl_compliance_hasil_start) == '') {$error[] = '- Isi Tanggal Mulai hasil compliance';}
        if (trim($request->tgl_compliance_hasil_end) == '') {$error[] = '- Isi Tanggal Sampai hasil compliance';}
        if (trim($request->tgl_substantive_program_start) == '') {$error[] = '- Isi Tanggal Mulai Program substantive';}
        if (trim($request->tgl_substantive_program_end) == '') {$error[] = '- Isi Tanggal Sampai Program substantive';}
        if (trim($request->tgl_substantive_hasil_start) == '') {$error[] = '- Isi Tanggal Mulai hasil substantive';}
        if (trim($request->tgl_substantive_hasil_end) == '') {$error[] = '- Isi Tanggal Sampai hasil substantive';}
        if (trim($request->tgl_lha_start) == '') {$error[] = '- Isi Tanggal Mulai penyusunan LHA';}
        if (trim($request->tgl_lha_end) == '') {$error[] = '- Isi Tanggal Sampai penyusunan LHA';}
        if (isset($error)) {echo '<p style="padding:5px;color:#000;font-size:13px"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
            $data=Audit::where('tiket_id',$request->tiket_id)->update([
                'name'=>$request->name,
                'tujuan'=>$request->tujuan,
                'sasaran'=>$request->sasaran,
                'risiko'=>$request->risiko,
                'tgl_penerbitan'=>$request->tgl_penerbitan,
                'tgl_plan'=>$request->tgl_plan,
                'tgl_deskaudit_program_start'=>$request->tgl_deskaudit_program_start,
                'tgl_deskaudit_program_end'=>$request->tgl_deskaudit_program_end,
                'tgl_deskaudit_hasil_start'=>$request->tgl_deskaudit_hasil_start,
                'tgl_deskaudit_hasil_end'=>$request->tgl_deskaudit_hasil_end,
                'tgl_compliance_program_start'=>$request->tgl_compliance_program_start,
                'tgl_compliance_program_end'=>$request->tgl_compliance_program_end,
                'tgl_compliance_hasil_start'=>$request->tgl_compliance_hasil_start,
                'tgl_compliance_hasil_end'=>$request->tgl_compliance_hasil_end,
                'tgl_substantive_program_start'=>$request->tgl_substantive_program_start,
                'tgl_substantive_program_end'=>$request->tgl_substantive_program_end,
                'tgl_substantive_hasil_start'=>$request->tgl_substantive_hasil_start,
                'tgl_substantive_hasil_end'=>$request->tgl_substantive_hasil_end,
                'tgl_lha_start'=>$request->tgl_lha_start,
                'tgl_lha_end'=>$request->tgl_lha_end,
                'tgl_lha_draf_start'=>$request->tgl_lha_draf_start,
                'tgl_lha_draf_end'=>$request->tgl_lha_draf_end,
                'tgl_lha_finis_start'=>$request->tgl_lha_finis_start,
                'tgl_lha_finis_end'=>$request->tgl_lha_finis_end,
                
            ]);
            echo'ok';
        }
    }

    public function acc_head(request $request){
        error_reporting(0);
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
        $data=Audit::where('id',$request->id)->first();
        $tim=Timaudit::where('tiket_id',$data['tiket_id'])->where('role_id','!=',6)->orderBy('id','Asc')->get();
        $pdf = PDF::loadView('pdf.auditplan', compact('data','tim'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
    }
}
