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
        $menu='AuditPlan';
        return view('Auditplan.index',compact('menu'));
    }

    public function index_acc(request $request){
        $menu='AuditPlan';
        return view('Auditplan.index_acc',compact('menu'));
    }

    public function create(request $request){
        $menu='Buat AuditPlan';
        return view('Auditplan.create',compact('menu'));
    }

    public function edit(request $request){
        
        $data=Audit::where('tiket_id',$request->id)->first();
        
        if($data['sts_audit']==1){
            $menu='View AuditPlan';
            return view('Auditplan.edit',compact('menu','data'));
        }else{
            $menu='View ';
            return view('Auditplan.view',compact('menu','data'));
        }
        
    }

    public function acc(request $request){
        
        $data=Audit::where('tiket_id',$request->id)->first();
        if($data['sts_audit']==1){
            $menu='Approve ';
            return view('Auditplan.acc_head',compact('menu','data'));
        }else{
            $menu='View ';
            return view('Auditplan.view',compact('menu','data'));
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
        
        echo $data['name'].'@'.$data['kode_unit'].'@'.$data->unitkerja['name'].'@'.$pengawas->user['name'].'@'.$ketua->user['name'].'@'.$anggota;
        
        echo'
            <script>
                $("#mySelect2").select2();
            </script>

        ';
    }

    
    public function save(request $request){

        if (trim($request->tiket_id) == '') {$error[] = '- Pilih Surat Tugas';}
        if (trim($request->tujuan) == '') {$error[] = '- Isi Tujuan';}
        if (trim($request->sasaran) == '') {$error[] = '- Isi Sasaran';}
        if (trim($request->risiko) == '') {$error[] = '- Isi Risiko';}
        if (trim($request->tgl_penerbitan) == '') {$error[] = '- Isi Tanggal Penerbitan';}
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
                    'kode_unit'=>$surat['kode_unit'],
                    'sts'=>1,
                    'sts_audit'=>1,
                    'tiket_id'=>$request->tiket_id,
                    'tujuan'=>$request->tujuan,
                    'sasaran'=>$request->sasaran,
                    'risiko'=>$request->risiko,
                    'tgl_penerbitan'=>$request->tgl_penerbitan,
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
        if (trim($request->name) == '') {$error[] = '- Isi Nama Obyek';}
        if (trim($request->tgl_penerbitan) == '') {$error[] = '- Isi Tanggal Penerbitan';}
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
        $acc=Audit::where('tiket_id',$request->tiket_id)->update([
            'sts_audit'=>2,
        ]);
        echo'ok';
    }

    public function hapus(request $request){
        error_reporting(0);
        $count=count($request->id);
        if (trim($count) == 0) {$error[] = '- Pilih Unit Kerja';}
        if (isset($error)) {echo implode('<br />', $error);} 
        else{
            
        }
    }
}
