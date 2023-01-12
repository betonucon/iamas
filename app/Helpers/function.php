<?php

function bulan($bulan)
{
   Switch ($bulan){
      case '01' : $bulan="Januari";
         Break;
      case '02' : $bulan="Februari";
         Break;
      case '03' : $bulan="Maret";
         Break;
      case '04' : $bulan="April";
         Break;
      case '05' : $bulan="Mei";
         Break;
      case '06' : $bulan="Juni";
         Break;
      case '07' : $bulan="Juli";
         Break;
      case '08' : $bulan="Agustus";
         Break;
      case '09' : $bulan="September";
         Break;
      case 10 : $bulan="Oktober";
         Break;
      case 11 : $bulan="November";
         Break;
      case 12 : $bulan="Desember";
         Break;
      }
   return $bulan;
}
function tgl_simple($tgl){
   $data=date('d/m/y',strtotime($tgl));
   return $data;
}
function coder($id){
   return base64_encode(base64_encode($id));
}
function encoder($id){
   return base64_decode(base64_decode($id));
}

function bulan_indo(){
   $data=date('d').' '.bulan(date('m')).' '.date('Y');
   return $data;
}
function uang($id){
   $data=number_format($id,2);
   return $data;
}
function triwulan($id){
   if($id>8){
      return 'III';
   }
   if($id>4){
      return 'II';
   }
   if($id>=1){
      return 'I';
   }
}


function selisih_all($mulai,$sampai){
   $begin = new DateTime($mulai);
   $end = new DateTime($sampai);
   
   $daterange     = new DatePeriod($begin, new DateInterval('P1D'), $end);
   $i=0;
   $x     =    0;
   $end     =    1;
   
   foreach($daterange as $date){
      $daterange     = $date->format("Y-m-d");
      $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);
      $day         = $datetime->format('D');
      
           $x    +=    $end-$i;
           
      
       $end++;
       $i++;
   }  
   if($x==0){
      return ($x+1);
   }else{
      return $x;
   }
   
}
function selisih_hari($mulai,$sampai){
   $begin = new DateTime($mulai);
   $end = new DateTime($sampai);
   
   $daterange     = new DatePeriod($begin, new DateInterval('P1D'), $end);
   $i=0;
   $x     =    0;
   $end     =    1;
   
   foreach($daterange as $date){
      $daterange     = $date->format("Y-m-d");
      $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);
      $day         = $datetime->format('D');
      if($day!="Sun" && $day!="Sat") {
           $x    +=    $end-$i;
           
       }
       $end++;
       $i++;
   }  
   return ($x+1);
}
function selisihnya($mulai,$sampai){
   
   if($mulai>$sampai){
      $begin = new DateTime($sampai);
      $end = new DateTime($mulai);
      
      $daterange     = new DatePeriod($begin, new DateInterval('P1D'), $end);
      $i=0;
      $x     =    0;
      $end     =    1;
      
      foreach($daterange as $date){
         $daterange     = $date->format("Y-m-d");
         $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);
         $day         = $datetime->format('D');
         if($day!="Sun" && $day!="Sat") {
            $x    +=    $end-$i;
            
         }
         $end++;
         $i++;
      }  
      return '-'.($x+1);
   }else{
      $begin = new DateTime($mulai);
      $end = new DateTime($sampai);
      
      $daterange     = new DatePeriod($begin, new DateInterval('P1D'), $end);
      $i=0;
      $x     =    0;
      $end     =    1;
      
      foreach($daterange as $date){
         $daterange     = $date->format("Y-m-d");
         $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);
         $day         = $datetime->format('D');
         if($day!="Sun" && $day!="Sat") {
            $x    +=    $end-$i;
            
         }
         $end++;
         $i++;
      }  
      return ($x+1);
   }
   
}

function rekapan_aktivitas_get_dashboard($id,$tahun){
   $total=dashboard_nilai_plan($id,$tahun);
   return $total;

}

function dashboard_nilai_real($id,$tahun){
   $cek=App\Surattugas::where('kode_aktivitas',$id)->where('tahun',$tahun)->count();
   if($cek>0){
      $data=App\Surattugas::where('kode_aktivitas',$id)->where('tahun',$tahun)->get();
      $nilai=0;
      foreach($data as $o){
         $first=App\Surattugas::where('id',$o['id'])->first();
         $nilai+=selisih_hari($first['tgl_head'],$first['tgl_approval']);
      }
      $nil=uang($nilai/$cek);
   }else{
      $nil=0;
   }
   return $nil;
}
function rekap_stia($id,$tahun){
   $cek=App\Surattugas::where('id',$id)->where('tahun',$tahun)->count();
   if($cek>0){
     $nilai=nilai_plan($id,$tahun)-nilai_real($id,$tahun);
     return $nilai;
   }else{
      return 0;
   }
      
   
}
function nilai_plan($id,$tahun){
   $cek=App\Surattugas::where('id',$id)->where('tahun',$tahun)->count();
   if($cek>0){
      $data=App\Surattugas::where('id',$id)->where('tahun',$tahun)->first();
      $sel=(100/selisih_hari($data['mulai'],$data['sampai']));
      $nilai=($sel*selisih_hari($data['mulai'],$data['sampai']));
      return $nilai;
   }else{
      return 0;
   }
      
   
}
function nilai_real($id,$tahun){
   $cek=App\Surattugas::where('id',$id)->where('tahun',$tahun)->count();
   if($cek>0){
      $data=App\Surattugas::where('id',$id)->where('tahun',$tahun)->first();
      $plan=selisih_hari($data['mulai'],$data['sampai']);
      $real=selisih_hari($data['tgl_head'],$data['sampai']);
      $tot=$plan-$real;
      $sel=(100/selisih_hari($data['mulai'],$data['tgl_approval']));
      $nilai=round($sel*$tot);
      return $nilai;
   }else{
      return 0;
   }
      
   
}
function aksi_proses($id,$kategori){
   $cek=App\Revisi::where('audit_id',$id)->where('kategori',$kategori)->count();
   if($cek>0){
      $get=App\Revisi::where('audit_id',$id)->where('kategori',$kategori)->orderBy('id','Desc')->firstOrfail();
      $aksi=$get['sts'];
   }else{
      $aksi='0';
   }

   return $aksi;

}
function tombol_proses($id,$kategori){
   $cek=App\Revisi::where('audit_id',$id)->where('kategori',$kategori)->count();
   if($kategori=='file_lha'){
      if($cek>0){
         $get=App\Revisi::where('audit_id',$id)->where('kategori',$kategori)->orderBy('id','Desc')->firstOrfail();
         if($get['sts']=='0'){
            echo'<span class="btn btn-primary btn-xs" onclick="proses_revisi_file('.$id.',`'.$kategori.'`,`Pemeriksaan '.$kategori.'`)"><i class="fa fa-cog"></i></span>';
         }
         if($get['sts']==1){
            echo'<i class="fa fa-clock text-aqua"></i>';
         }
         if($get['sts']==3 || $get['sts']==2){
            echo'<i class="fa fa-check-square"></i>';
         }
         if($get['sts']==4){
            echo'<i class="fa fa-clock text-aqua"></i>';
         }
      }else{
         echo'<span class="btn btn-primary btn-xs" onclick="proses_revisi_file('.$id.',`'.$kategori.'`,`Pemeriksaan '.$kategori.'`)"><i class="fa fa-cog"></i></span>';
      }
   }else{
      if($cek>0){
         $get=App\Revisi::where('audit_id',$id)->where('kategori',$kategori)->orderBy('id','Desc')->firstOrfail();
         if($get['sts']=='0'){
            echo'<span class="btn btn-primary btn-xs" onclick="proses_revisi('.$id.',`'.$kategori.'`,`Pemeriksaan '.$kategori.'`)"><i class="fa fa-cog"></i></span>';
         }
         if($get['sts']==1){
            echo'<i class="fa fa-clock text-aqua"></i>';
         }
         if($get['sts']==3 || $get['sts']==2){
            echo'<i class="fa fa-check-square"></i>';
         }
         if($get['sts']==4){
            echo'<i class="fa fa-clock text-aqua"></i>';
         }
      }else{
         echo'<span class="btn btn-primary btn-xs" onclick="proses_revisi('.$id.',`'.$kategori.'`,`Pemeriksaan '.$kategori.'`)"><i class="fa fa-cog"></i></span>';
      }
   }
   
}
function ket_risiko($nilai){
   if($nilai>50000000000){
     $data='TINGGI';
     
   }else if($nilai>25000000000){
     $data='TINGGI';
     
   }else if($nilai>2500000000){
     $data='TINGGI';
     
   }else if($nilai>125000000){
     $data='MODERAT';
     
   }else{
     $data='RENDAH';
    
   }
   return $data;
}
function kodesumber($risiko,$kode,$kd){
   if($kode=='06'){
      if($risiko=='RENDAH'){
         $data='LHA';
      }else{
         if($kd=='07.X.02'){
            $data='LHK';
         }else{
            $data='LHP';
         }
         
      }
      
   }else{
      if($risiko=='RENDAH'){
         $data='LHA';
      }else{
         $data='LHP';
      }
   }

   return $data;
}
function cek_hasil($id,$ket){
   if($ket=='plan'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts']>2){
         $data=selisihnya($cek['tgl_sts3'],$cek['tgl_plan']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='desk_prog'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_deskaudit']>1){
         $data=selisihnya($cek['tgl_sts4'],$cek['tgl_deskaudit_program_end']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='desk_catatan'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_deskaudit']>3){
         $data=selisihnya($cek['tgl_sts5'],$cek['tgl_deskaudit_hasil_end']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='com_prog'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_compliance']>1){
         $data=selisihnya($cek['tgl_sts6'],$cek['tgl_compliance_program_end']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='com_catatan'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_compliance']>3){
         $data=selisihnya($cek['tgl_sts7'],$cek['tgl_compliance_hasil_end']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='subs_prog'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_substantive']>1){
         $data=selisihnya($cek['tgl_sts8'],$cek['tgl_substantive_program_end']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='subs_catatan'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_substantive']>3){
         $data=selisihnya($cek['tgl_sts9'],$cek['tgl_substantive_hasil_end']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='draf'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_lha']>2){
         $data=selisihnya($cek['tgl_sts10'],$cek['tgl_lha_end']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='qc'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_lha']>3){
         $data=selisihnya($cek['tgl_sts11'],$cek['tgl_lha_draf_end']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='pen'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_lha']>4){
         $data=selisihnya($cek['tgl_sts12'],$cek['tgl_lha_finis_end']);
      }else{
         $data='0';
      }
      
   }
   if($data=='0'){
      $color="#fff";
   }else{
      if($data>0){
         $color="green";
      }else{
         $color="red";
      }
   }
   return $color;
}

function tgl_smp($tgl){
   return date('d/m',strtotime($tgl));
}
function cek_kurva($id,$ket,$act){
   if($ket=='plan'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts']>2){
         $data=selisihnya($cek['tgl_sts3'],$cek['tgl_plan']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='desk_prog'){
      $cek=App\Audit::where('id',$id)->first();
      if($act==1){
        
            $data=selisihnya($cek['tgl_plan'],$cek['tgl_deskaudit_program_start']);
         
      }else{
         if($cek['sts_deskaudit']>1){
            $data=selisihnya($cek['tgl_sts3'],$cek['tgl_sts4']);
         }else{
            $data='0';
         }
      }
         
      
   }
   if($ket=='desk_catatan'){
      $cek=App\Audit::where('id',$id)->first();
      if($act==1){
        
            $data=selisihnya($cek['tgl_deskaudit_program_start'],$cek['tgl_deskaudit_hasil_start']);
         
      }else{
         if($cek['sts_deskaudit']>3){
            $data=selisihnya($cek['tgl_sts4'],$cek['tgl_sts6']);
         }else{
            $data='0';
         }
      }
      
   }
   if($ket=='com_prog'){
      $cek=App\Audit::where('id',$id)->first();
      if($act==1){
        
            $data=selisihnya($cek['tgl_deskaudit_hasil_start'],$cek['tgl_compliance_program_start']);
         
      }else{
         if($cek['sts_compliance']>1){
            $data=selisihnya($cek['tgl_sts6'],$cek['tgl_sts10']);
         }else{
            $data='0';
         }
      }
      
      
   }
   if($ket=='com_catatan'){
      $cek=App\Audit::where('id',$id)->first();
      if($act==1){
        
            $data=selisihnya($cek['tgl_compliance_program_start'],$cek['tgl_compliance_hasil_start']);
         
      }else{
         if($cek['sts_compliance']>3){
            $data=selisihnya($cek['tgl_sts10'],$cek['tgl_sts12']);
         }else{
            $data='0';
         }
      }
      
      
   }
   if($ket=='subs_prog'){
      $cek=App\Audit::where('id',$id)->first();
      if($act==1){
        
            $data=selisihnya($cek['tgl_compliance_hasil_start'],$cek['tgl_substantive_program_start']);
         
      }else{
         if($cek['sts_substantive']>1){
            $data=selisihnya($cek['tgl_sts12'],$cek['tgl_sts14']);
         }else{
            $data='0';
         }
      }
      
      
   }
   if($ket=='subs_catatan'){
      $cek=App\Audit::where('id',$id)->first();
      if($act==1){
        
            $data=selisihnya($cek['tgl_substantive_program_start'],$cek['tgl_substantive_hasil_start']);
         
      }else{
         if($cek['sts_substantive']>3){
            $data=selisihnya($cek['tgl_sts14'],$cek['tgl_sts16']);
         }else{
            $data='0';
         }
      }
      
      
   }
   if($ket=='draf'){
      $cek=App\Audit::where('id',$id)->first();
      if($act==1){
        
            $data=selisihnya($cek['tgl_substantive_hasil_start'],$cek['tgl_lha_start']);
         
      }else{
         if($cek['sts_lha']>2){
            $data=selisihnya($cek['tgl_sts16'],$cek['tgl_sts18']);
         }else{
            $data='0';
         }
      }
      
      
   }
   if($ket=='qc'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_lha']>3){
         $data=selisihnya($cek['tgl_sts11'],$cek['tgl_lha_draf_end']);
      }else{
         $data='0';
      }
      
   }
   if($ket=='pen'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_lha']>4){
         $data=selisihnya($cek['tgl_sts12'],$cek['tgl_lha_finis_end']);
      }else{
         $data='0';
      }
      
   }
   
   return $data;
}
function cek_hasil_nilai($id,$ket){
   if($ket=='plan'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts']>2){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   if($ket=='desk_prog'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_deskaudit']>1){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   if($ket=='desk_catatan'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_deskaudit']>3){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   if($ket=='com_prog'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_compliance']>1){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   if($ket=='com_catatan'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_compliance']>3){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   if($ket=='subs_prog'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_substantive']>1){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   if($ket=='subs_catatan'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_substantive']>3){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   if($ket=='draf'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_lha']>2){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   if($ket=='qc'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_lha']>3){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   if($ket=='pen'){
      $cek=App\Audit::where('id',$id)->first();
      if($cek['sts_lha']>4){
         $data=1;
      }else{
         $data='0';
      }
      
   }
   return $data;
}
function cek_total_setujui($id){
   $cek=App\Revisi::where('audit_id',$id)->where('sts',2)->count();
   return $cek;
}
function text_revisi($id,$kategori){
   $cek=App\Revisi::where('audit_id',$id)->where('kategori',$kategori)->count();
   if($cek>0){
      $get=App\Revisi::where('audit_id',$id)->where('kategori',$kategori)->orderBy('id','Desc')->firstOrfail();
      if($get['sts']==1){
         if($kategori=='file_lha'){
            $text='<b>14 Hari Kerja ('.$get['mulai'].' s/d '.$get['sampai'].')</b><br>'.$get['keterangan'].'<br>
                 <a href="'.url('_file_lampiran/'.$get['file']).'"><i class="fa fa-file-word"></i> Download</a>';
         }else{
            $text='<b>14 Hari Kerja ('.$get['mulai'].' s/d '.$get['sampai'].')</b><br>'.$get['keterangan'];
         }
         
         return $text;
      }else{
         if($get['sts']==4){
            return '<b><i class="fa fa-pencil-alt"></i> Dalam Proses Pengerjaan</b>';
         }
         elseif($get['sts']=='0'){
            return '<b><i class="fa fa-search"></i> Silahkan review ulang</b>';
         }
         else{
            return '<b><i class="fa fa-check"></i> Selesai Penyelesaian ('.selisih_hari($get['mulai'],$get['sampai']).') Hari</b>';
         }
         
      }
         
   }else{
      return "<i>Belum diproses</i>";
   }
      
   
}
function get_text_revisi(){
   $get=App\Revisi::select('audit_id','tiket_id')->whereIn('tiket_id',array_tiket_anggota_ketua())->groupBy('audit_id','tiket_id')->get();
  
   return $get;
      
   
}
function alasan_temuan($id,$ststl){
   $cek=App\Disposisi::where('sts_tl',$ststl)->where('rekomendasi_id',$id)->count();
   if($cek>0){
      
      $get=App\Disposisi::where('sts_tl',$ststl)->where('rekomendasi_id',$id)->first();
      if($get->sts==1){
         return $get['catatan'];
      }else{
         return "";
      }
         
   }else{
      return "";
   }
      
   
}
function tanggal_tl($nomortl){
   $cek=App\Disposisi::where('nomortl',$nomortl)->count();
   if($cek>0){
      $get=App\Disposisi::where('nomortl',$nomortl)->orderBy('id','Asc')->firstOrfail();
   
      return $get['tanggal'];
   }else{
      return "";
   }
      
   
}
function sts_tl_auditee($sts){
   $tot=strlen($sts);
   if($tot>1){
      $exp=substr($sts,1);
      return 'P'.($exp-1);
   }else{
      return $sts;
   }
}
function cek_disposisi($id){
   $cek=App\Disposisi::where('rekomendasi_id',$id)->count();
   return $cek;
   
}
function get_detail_text_revisi($id){
   $get=App\Revisi::where('audit_id',$id)->get();
  
   return $get;
      
   
}
function laporan_text_revisi(){
   $get=App\Vrevisiaudit::where('id',$id)->first();
  
   $text="";
   $text.="Deskaudit : ";
      if($get['sts_revisi_deskaudit_langkah']==1){
         $text.='<font color="#000">Selesai</font>';
      }
      if($get['sts_revisi_deskaudit_langkah']==2){
         $text.='<font color="red">Revisi</font><p style="margin-left:2%">'. text_revisi($get['id'],$get['kategori']).'';
      }
      if($get['sts_revisi_deskaudit_langkah']==1){
         $text.='<font color="#000">Selesai</font>';
      }
   
   return $text;
      
   
}



function tgl_indo($tgl){
   $tg=explode('-',$tgl);
   $data=$tg[2].' '.bulan($tg[1]).' '.$tg[0];
   return $data;
}
function kode_bulan($bulan)
{
   Switch ($bulan){
      case '01' : $bulan="A";
         Break;
      case '02' : $bulan="B";
         Break;
      case '03' : $bulan="C";
         Break;
      case '04' : $bulan="D";
         Break;
      case '05' : $bulan="E";
         Break;
      case '06' : $bulan="F";
         Break;
      case '07' : $bulan="G";
         Break;
      case '08' : $bulan="H";
         Break;
      case '09' : $bulan="I";
         Break;
      case 10 : $bulan="J";
         Break;
      case 11 : $bulan="K";
         Break;
      case 12 : $bulan="L";
         Break;
      }
   return $bulan;
}

function tgl_kedepan($tanggal,$lama)
{
   $tgl=explode(' ',$tanggal);
   $hari=$lama;
   
   $kedepan = date('Y-m-27', strtotime("$hari Weekday", strtotime($tgl[0])));
   return  $kedepan;
}

function tgl_berikutnya($tanggal,$lama)
{
   $tgl=$tanggal;
   $hari=$lama;
   
   $kedepan = date('Y-m-d', strtotime("$hari day", strtotime($tgl)));
   return  $kedepan;
}

function nama_audit($nik){
   $cek=App\User::where('nik',$nik)->count();
   if($cek>0){
      $data=App\User::where('nik',$nik)->first();
      return $data['name'];
   }else{
      return 'No Name';
   }
   
   
}
function head_of(){
   $data=App\User::where('posisi_id',1)->first();
   return $data;
}
function lokasi_get(){
   $data=App\Lokasi::orderBy('name','Asc')->get();
   return $data;
}
function nik_pengawas($id){
   if($id=='01'){
      $data=App\User::where('posisi_id',12)->firstOrfail();
   }
   if($id=='02'){
         $data=App\User::where('posisi_id',12)->firstOrfail();
   }
   if($id=='03'){
         $data=App\User::where('posisi_id',12)->firstOrfail();
   }
   if($id=='04'){
         $data=App\User::where('posisi_id',12)->firstOrfail();
   }
   if($id=='05'){
         $data=App\User::where('posisi_id',1)->firstOrfail();
   }
   if($id=='06'){
         $data=App\User::where('posisi_id',1)->firstOrfail();
   }
   return $data['nik'];
}
function name_app(){
    return '  (E-IAMAS  Krakatau Steel)';
}

function posisi_get(){
    $data=App\Posisi::where('id','!=',3)->orderBy('name','Asc')->get();
    return $data;
}

function pengawas($id){
    $data=App\Timaudit::where('role_id',2)->where('tiket_id',$id)->first();
    return $data;
}
function ketua($id){
    $data=App\Timaudit::where('role_id',1)->where('tiket_id',$id)->first();
    return $data;
}
function anggota($id,$nik){
    $data=App\Timaudit::where('role_id',3)->where('nik',$nik)->where('tiket_id',$id)->count();
    return $data;
}
function tim_anggota($id){
    $data=App\Timaudit::where('role_id',3)->where('tiket_id',$id)->get();
    return $data;
}

function kodifikasilaporan_get($id){
   if($id=='01'){
      $data=App\Sumber::whereIn('id',array('16','18','19'))->orderBy('name','Asc')->get();
   }
   if($id=='02'){
      $data=App\Sumber::whereIn('id',array('20','25'))->orderBy('name','Asc')->get();
   }
   if($id=='03'){
      $data=App\Sumber::whereIn('id',array('17','21','22'))->orderBy('name','Asc')->get();
   }
   if($id=='04'){
      $data=App\Sumber::whereIn('id',array('26'))->orderBy('name','Asc')->get();
   }
   if($id=='05'){
      $data=App\Sumber::whereIn('id',array('26'))->orderBy('name','Asc')->get();
   }
   if($id=='06'){
      $data=App\Sumber::whereIn('id',array('26'))->orderBy('name','Asc')->get();
   }
   if($id=='07'){
      $data=App\Sumber::whereIn('id',array('27'))->orderBy('name','Asc')->get();
   }
    
    return $data;
}

function tiket_get(){
    $data=App\Tiket::where('nik',Auth::user()['nik'])->orderBy('id','Desc')->get();
    return $data;
}

function tiket_get_gl(){
    $data=App\Tiket::whereIn('sts',array('0','1','2','3','4'))->where('sts','!=',10)->orderBy('id','Desc')->get();
    return $data;
}

function tiket_get_hd(){
    $data=App\Tiket::whereIn('sts',array('1','2','3','4'))->where('sts','!=',10)->orderBy('id','Desc')->get();
    return $data;
}

function new_(){
    $data=App\Tiket::whereIn('sts',array('2','3','4'))->orderBy('id','Desc')->get();
    return $data;
}
function deskaudit_program($id){
    $data=App\Deskaudit::where('audit_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function view_deskaudit_catatan($id){
    $data=App\Viewcatatandeskaudit::where('audit_id',$id)->orderBy('id','Asc')->get();
    return $data;
}

function deskaudit_catatan($id){
    $data=App\Desklangkahkerja::where('deskaudit_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function compliance_program($id){
    $data=App\Compliance::where('audit_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function view_compliance_catatan($id){
   $data=App\Viewcatatancompliance::where('audit_id',$id)->orderBy('id','Asc')->get();
   return $data;
}
function compliance_catatan($id){
    $data=App\Complangkahkerja::where('compliance_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function substantive_program($id){
    $data=App\Substantive::where('audit_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function view_substantive_catatan($id){
   $data=App\Viewcatatansubstantive::where('audit_id',$id)->orderBy('id','Asc')->get();
   return $data;
}
function substantive_catatan($id){
    $data=App\Subslangkahkerja::where('substantive_id',$id)->orderBy('id','Asc')->get();
    return $data;
}

function judul_get($tiket){
    $data=App\Judul::where('tiket_id',$tiket)->orderBy('id','Asc')->get();
    return $data;
}
//--notif-----------------------------------

function notif_tiket_gl(){
   $data=App\Tiket::whereIn('sts',array('2'))->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_sumber_gl(){
   $data=App\Tiket::where('sts',0)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_sumber_head(){
   $data=App\Tiket::where('sts',1)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}

function notif_tiket_head(){
   $data=App\Surattugas::whereIn('tiket_id',array_tiket_head())->where('sts',1)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}

function notif_auditplan_pengawas(){
   $data=App\Surattugas::whereIn('tiket_id',array_tiket_pengawas())->whereIn('kode_aktivitas',array('04','05','06'))->where('sts',5)->count();
    
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}

function notif_auditplan_head(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_head())->where('sts',2)->count();
    
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_lha_pengawas(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts_lha',1)->count();
    
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_lha_head(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_head())->where('sts_lha',2)->count();
    
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_qc_head(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_head())->where('sts_lha',3)->count();
    
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}

function notif_deskaudit_program_ketua(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',2)->where('sts_deskaudit',null)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_compliance_program_ketua(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',3)->where('sts_compliance',null)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_substantive_program_ketua(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',6)->where('sts_substantive',null)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}

function notif_deskaudit_catatan_ketua(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',2)->where('sts_deskaudit',2)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_compliance_catatan_ketua(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',3)->where('sts_compliance',2)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_substantive_catatan_ketua(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',6)->where('sts_substantive',2)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_deskaudit_catatan_anggota(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_anggota())->where('sts','>',2)->where('sts_deskaudit',2)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_compliance_catatan_anggota(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_anggota())->where('sts','>',3)->where('sts_compliance',2)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_substantive_catatan_anggota(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_anggota())->where('sts','>',7)->where('sts_substantive',2)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_deskaudit_program_pengawas(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts','>',2)->where('sts_deskaudit',1)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_compliance_program_pengawas(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts','>',3)->where('sts_compliance',1)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_substantive_program_pengawas(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts','>',6)->where('sts_substantive',1)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_deskaudit_catatan_pengawas(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts','>',2)->where('sts_deskaudit',3)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_compliance_catatan_pengawas(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts','>',3)->where('sts_compliance',3)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}
function notif_substantive_catatan_pengawas(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts','>',6)->where('sts_substantive',3)->count();
   if($data>0){
      return '<span class="badge pull-right" style="background: white;color: #000;">'.$data.'</span>';
   }else{
      return '';
   }
}

//--end notif-----------------------------------

function sumbertiket_get($id){
   if($id=='01'){
      $data=App\Tiket::whereIn('sts',array('2'))->whereIn('kode_sumber',array('W1','W2','R1','R2','I1','I2','P1','P2','P3','A1','A2'))->orderBy('id','Desc')->get();  
   }
   if($id=='02'){
      $data=App\Tiket::whereIn('sts',array('2'))->whereIn('kode_sumber',array('AS','KS'))->orderBy('id','Desc')->get();  
   }
   if($id=='03'){
      $data=App\Tiket::whereIn('sts',array('2'))->whereIn('kode_sumber',array('AP','RIM','LMI','AR'))->orderBy('id','Desc')->get();  
   }
   if($id=='04'){
      $data=App\Tiket::whereIn('sts',array('2'))->whereIn('kode_sumber',array('LPK'))->orderBy('id','Desc')->get();  
   }
   if($id=='05'){
      $data=App\Tiket::whereIn('sts',array('2'))->whereIn('kode_sumber',array('RAN','QA2','I1'))->orderBy('id','Desc')->get();  
   }
   if($id=='06'){
      $data=App\Tiket::whereIn('sts',array('2'))->whereIn('kode_sumber',array('RAN','QA2','I1'))->orderBy('id','Desc')->get();  
   }
   if($id=='07'){
      $data=App\Tiket::whereIn('sts',array('2'))->whereIn('kode_sumber',array('PA2'))->orderBy('id','Desc')->get();  
   }
    return $data;
}

function tiket_get_tiket(){
    $data=App\Surattugas::orderBy('id','Desc')->get();
    return $data;
}

function tiket_get_tiket_acc_pengawas(){
    $data=App\Surattugas::where('sts','>',2)->whereIn('tiket_id',array_tiket_pengawas())->orderBy('id','Desc')->get();
    return $data;
}
function tiket_get_tiket_acc_head(){
    $data=App\Surattugas::whereIn('sts',array('4','5'))->orderBy('id','Desc')->get();
    return $data;
}

function aktivitas_get(){
    $data=App\Aktivitas::orderBy('kode','Asc')->get();
    return $data;
}
function pertama_aktivitas_get(){
    $data=App\Aktivitas::whereIn('kode',array('01','02','03'))->orderBy('kode','Asc')->get();
    return $data;
}
function pertama_aktivitas_02get(){
    $data=App\Aktivitas::whereIn('kode',array('02'))->orderBy('kode','Asc')->get();
    return $data;
}
function kedua_aktivitas_get(){
    $data=App\Aktivitas::whereIn('kode',array('04','05','06'))->orderBy('kode','Asc')->get();
    return $data;
}

function aktivitas_get_dashboard($kode,$tahun){
    $data=App\Surattugas::where('kode_aktivitas',$kode)->where('tahun',$tahun)->orderBy('kode_aktivitas','Asc')->get();
    return $data;
}
function total_aktivitas_get_dashboard($kode,$tahun){
    $data=App\Surattugas::where('kode_aktivitas',$kode)->where('tahun',$tahun)->count();
    return $data;
}
function dashboard_nilai_plan($kode,$tahun){
   $count=App\Surattugas::where('kode_aktivitas',$kode)->where('tahun',$tahun)->count();
   if($count>0){
      $pembagi=$count;
   }else{
      $pembagi=1;
   }
   $data=App\Surattugas::where('kode_aktivitas',$kode)->where('tahun',$tahun)->get();
   $nilai=0;
   foreach($data as $o){
        $nilai+=rekap_stia($o['id'],$tahun);
   }
   $rek=$nilai;
   
   return round($rek/$pembagi);
}

function ubah_uang($uang){
   $xpl=explode('.',$uang);
   $patr='/([^0-9]+)/';
   $data=preg_replace($patr,'',$xpl[0]);
   return $data.'.'.$xpl[1];
}

function unit_as($kode){
    $data=App\Unitkerja::where('kode',$kode)->first();
    return $data['as'];
}
function unit_pimpinan($kode){
    $data=App\Unitkerja::where('kode',$kode)->first();
    $view=$data['pimpinan'];
    return $view;
}
function name_jabatan($kode){
   if($kode==1){
     return 'Direktur'; 
   }
   if($kode==2){
     return 'General Manager'; 
   }
   if($kode==3){
     return 'Manager'; 
   }
}
function nama_unit($kode){
    $cek=App\Unitkerja::where('kode',$kode)->count();
    if($cek>0){
      $data=App\Unitkerja::where('kode',$kode)->first();
      return $data['name'];
    }else{
       return "Tidak ada";
    }
}
function unit_get(){
    $data=App\Unitkerja::whereIn('unit_id',array('5','1','3','6'))->orderBy('name','Asc')->get();
    return $data;
}

function surattugas_unit($tahun){
    $data=App\Surattugas::select('kode_unit')->where('tahun',$tahun)->whereIn('kode_aktivitas',array('01','02','03'))->groupBy('kode_unit')->get();
    return $data;
}
function surattugas_perunit($tahun,$kode_unit){
    $data=App\Surattugas::where('kode_unit',$kode_unit)->where('tahun',$tahun)->whereIn('kode_aktivitas',array('01','02','03'))->get();
    return $data;
}
function progres_surattugas_perunit($tahun,$id){
    $data=App\Surattugas::where('id',$id)->where('tahun',$tahun)->first();
    if($data['sts']==1){
       $persn=30;
    }
    if($data['sts']==2){
       $persn=40;
    }
    if($data['sts']==3){
       $persn=60;
    }
    if($data['sts']==4){
       $persn=80;
    }
    if($data['sts']==5){
       $persn=100;
    }
    return $persn;
}

function src_get(){
    $data=App\User::whereIn('posisi_id',array('1','2','12','7'))->orderBy('name','Asc')->get();
    return $data;
}
function get_tiket_auditee($tahun){
    $data=App\Tiket::where('nik',Auth::user()['nik'])->where('tahun',$tahun)->orderBy('id','Asc')->get();
    return $data;
}
function get_subdit($kode){
    $data=App\Unitkerja::where('unit_atasan',$kode)->where('unit_id','!=',5)->orderBy('id','Asc')->get();
    return $data;
}
function get_divisi($kode){
    $data=App\Unitkerja::where('unit_atasan',$kode)->where('unit_id','!=',5)->orderBy('id','Asc')->get();
    return $data;
}
function total_infromasi($tahun,$id){
   if($id==1){
      $data=App\Tiket::where('nik',Auth::user()['nik'])->where('sts','>',1)->where('tahun',$tahun)->count();
   }
   if($id==2){
      $data=App\Tiket::where('nik',Auth::user()['nik'])->where('sts','>',2)->where('tahun',$tahun)->where('sts','>',1)->count();
   }
   if($id==3){
      $data=App\Tiket::where('nik',Auth::user()['nik'])->where('sts','>',4)->where('tahun',$tahun)->count();
   }
   if($id==4){
      $data=App\Tiket::where('nik',Auth::user()['nik'])->where('sts','>',5)->where('tahun',$tahun)->count();
   }
   if($id==5){
      $data=App\Tiket::where('nik',Auth::user()['nik'])->where('sts','>',6)->where('tahun',$tahun)->count();
   }
   if($id==6){
      $data=App\Tiket::where('nik',Auth::user()['nik'])->where('tahun',$tahun)->count();
   }
    
    return $data;
}
function aproval_get(){
    $data=App\User::whereIn('posisi_id',array('1','13'))->orderBy('name','Asc')->get();
    return $data;
}
function unitkerja_get(){
    $data=App\Unitkerja::whereIn('unit_id',array(1,2,3,6))->orderBy('name','Asc')->get();
    return $data;
}
function unitkerja_all_get(){
    $data=App\Unitkerja::whereIn('unit_id',array(1,2,3,6))->orderBy('name','Asc')->get();
    return $data;
}
function katua_get(){
    $data=App\User::whereIn('posisi_id',array('2','7','12','3','4','5','6'))->orderBy('name','Asc')->get();
    return $data;
}
function anggota_get(){
    $data=App\User::whereIn('posisi_id',array('10','11','3','4','5','6'))->orderBy('name','Asc')->get();
    return $data;
}
function hitung_progres($nilai1,$nilai2){
    if($nilai2==0 || $nilai2==null){
       return '0';
    }else{
       return round(($nilai1/$nilai2)*100);
    }
}
function tim_audit($id){
    $data=App\Timaudit::where('tiket_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function tim_audit_cetak($id){
    $data=App\Timaudit::where('tiket_id',$id)->whereIn('role_id',array(1,3))->orderBy('id','Asc')->get();
    return $data;
}
function tim_audit_ketua($id){
    $data=App\Timaudit::where('tiket_id',$id)->where('role_id',1)->orderBy('id','Asc')->get();
    return $data;
}
function tim_audit_pengawas($id){
    $data=App\Timaudit::where('tiket_id',$id)->where('role_id',2)->orderBy('id','Asc')->get();
    return $data;
}
function tim_audit_approval($id){
    $data=App\Timaudit::where('tiket_id',$id)->where('role_id',6)->orderBy('id','Asc')->get();
    return $data;
}
function nomorsurat($kode,$unit,$aktifitas){
      if($kode=='NA'){
         $nomor='NA'.$aktifitas.'/'.$unit.'/'.date('m').'/'.date('Y');
      }else{
         $nomor=$kode.'/'.$unit.'/'.date('m').'/'.date('Y');
      }
   
      return $nomor;
}

function array_tiket_anggota(){
   $data  = array_column(
      App\Timaudit::where('nik',Auth::user()['nik'])->where('role_id',3)
      ->get()
      ->toArray(),'tiket_id'
   );
    return $data;
}
function array_tiket_anggota_ketua(){
   $data  = array_column(
      App\Timaudit::where('nik',Auth::user()['nik'])->whereIn('role_id',array(3,1))
      ->get()
      ->toArray(),'tiket_id'
   );
    return $data;
}
function cek_unit(){
   $data=App\Unitkerja::where('nik_atasan',Auth::user()['nik'])->count();
   return $data;
}

function get_unit_switch(){
   $data=App\Unitkerja::where('nik_atasan',Auth::user()['nik'])->get();
   return $data;
}
function array_audite(){
   $data="";
   if(Auth::user()['jabatan']==1){
      
      $dir=App\Unitkerja::where('kode',Auth::user()['kode_unit'])->first();
      $subdit=App\Unitkerja::where('unit_atasan',$dir['kode'])->get();
      $data.='<option value="'.$dir['kode'].'">'.$dir['name'].'</option>';
      foreach($subdit as $sub){
         $data.='<option value="'.$sub['kode'].'">&nbsp;&nbsp;-'.$sub['name'].'</option>';
         $divisi=App\Unitkerja::where('unit_atasan',$sub['kode'])->get();
         foreach($divisi as $div){
            $data.='<option value="'.$div['kode'].'">&nbsp;&nbsp;&nbsp;&nbsp;-'.$div['name'].'</option>';
         }
      }

      
   }
   if(Auth::user()['jabatan']==2){
      
      $subdit=App\Unitkerja::where('kode',Auth::user()['kode_unit'])->first();
      $data.='<option value="'.$subdit['kode'].'">'.$subdit['name'].'</option>';
      $divisi=App\Unitkerja::where('unit_atasan',$subdit['kode'])->get();
      foreach($divisi as $div){
         $data.='<option value="'.$div['kode'].'">&nbsp;&nbsp;-'.$div['name'].'</option>';
      }
     

   }
   if(Auth::user()['jabatan']==3){
      $cek=App\Unitkerja::where('kode',Auth::user()['kode_unit'])->count();
      if($cek>0){
         $subdit=App\Unitkerja::where('kode',Auth::user()['kode_unit'])->first();
         $data.='<option value="'.$subdit['kode'].'">'.$subdit['name'].'</option>';
      }else{
         $data.='';
      }
      


   }
   
    return $data;
}

function array_tiket_ketua(){
   $data  = array_column(
      App\Timaudit::where('nik',Auth::user()['nik'])->where('role_id',1)
      ->get()
      ->toArray(),'tiket_id'
   );
    return $data;
}

function array_tiket_pengawas(){
   $data  = array_column(
      App\Timaudit::where('nik',Auth::user()['nik'])->where('role_id',2)
      ->get()
      ->toArray(),'tiket_id'
   );
    return $data;
}

function array_tiket_head(){
   $data  = array_column(
      App\Timaudit::where('nik',Auth::user()['nik'])->where('role_id',6)
      ->get()
      ->toArray(),'tiket_id'
   );
   return $data;
}

function array_audit_anggota(){
   
      $data  = array_column(
         App\Audit::whereIn('tiket_id',array_tiket_anggota())
         ->get()
         ->toArray(),'id'
      );
       return $data;
   
}
function array_audit_ketua(){
   
      $data  = array_column(
         App\Audit::whereIn('tiket_id',array_tiket_ketua())
         ->get()
         ->toArray(),'id'
      );
       return $data;
   
}
function array_audit_pengawas(){
   
      $data  = array_column(
         App\Audit::whereIn('tiket_id',array_tiket_pengawas())
         ->get()
         ->toArray(),'id'
      );
       return $data;
   
}
function array_temuan_auditee(){
   $data  = array_column(
      App\Unitkerja::where('nik',Auth::user()['nik'])
      ->get()
      ->toArray(),'kode'
   );
   return $data;
   
}
function cek_unit_audite(){
   $data  =App\Unitkerja::where('nik',Auth::user()['nik'])
      ->count();
   return $data;
   
}
function get_unit_audite(){
   $data  =App\Unitkerja::where('nik',Auth::user()['nik'])
      ->get();
   return $data;
   
}
function sts_temuan($id){
   $data=App\Ststemuan::where('id',$id)->first();
   return $data['name'];
}
function track_temuan($id){
   if($id==1){
      $data='Pengisian Tindak Lanjut';
   }
   if($id==2){
      $data='Review RCD';
   }
   if($id==3){
      $data='Review Anggota';
   }
   if($id==4){
      $data='Review Pengawas';
   }
   if($id==5){
      $data='Review HOIA';
   }
   if($id==6){
      $data='Selesai';
   }

   return $data;
}
function track_temuan_auditee($id){
   if($id==1){
      $data='Review Tindak Lanjut';
   }
   if($id==2){
      $data='Review IA';
   }
   if($id==3){
      $data='Review IA';
   }
   if($id==4){
      $data='Review IA';
   }
   if($id==5){
      $data='Review IA';
   }
   if($id==6){
      $data='Selesai';
   }

   return $data;
}
function review_pengawas($id,$sts_tl){
   $cek=App\Disposisi::where('rekomendasi_id',$id)->where('sts_tl',$sts_tl)->count();
   if($cek>0){
      $data=App\Disposisi::where('rekomendasi_id',$id)->where('sts_tl',$sts_tl)->first();
      return $data['catatan_pengawas'];
   }else{
      return "";
   }
   
}
function review_head($id,$sts_tl){
   $cek=App\Disposisi::where('rekomendasi_id',$id)->where('sts_tl',$sts_tl)->count();
   if($cek>0){
      $data=App\Disposisi::where('rekomendasi_id',$id)->where('sts_tl',$sts_tl)->first();
      return $data['catatan_head'];
   }else{
      return "";
   }
   
}
function review_team($id,$sts_tl){
   $cek=App\Disposisi::where('rekomendasi_id',$id)->where('sts_tl',$sts_tl)->count();
   if($cek>0){
      $data=App\Disposisi::where('rekomendasi_id',$id)->where('sts_tl',$sts_tl)->first();
      return $data['catatan'];
   }else{
      return "";
   }
   
}
function temuan_auditee_get(){
   $data=App\Rekomendasi::whereIn('kode_unit',array_temuan_auditee())->where('sts','>',0)->get();
   return $data;
}
function total_lhk($kode,$tahun,$act){
   if($act==1){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHK')->count();
   }
   if($act==2){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHK')->wherenotIn('sts_tl',array('B','S'))->count();
   }
   if($act==3){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHK')->where('sts_tl','S')->count();
   }
   if($act==4){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHK')->where('sts_tl','B')->count();
   }
   
   return $data;
}
function total_lhp($kode,$tahun,$act){
   if($act==1){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHP')->count();
   }
   if($act==2){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHP')->wherenotIn('sts_tl',array('B','S'))->count();
   }
   if($act==3){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHP')->where('sts_tl','S')->count();
   }
   if($act==4){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHP')->where('sts_tl','B')->count();
   }
   return $data;
}
function total_lha($kode,$tahun,$act){
   if($act==1){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHA')->count();
   }
   if($act==2){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHA')->wherenotIn('sts_tl',array('B','S'))->count();
   }
   if($act==3){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHA')->where('sts_tl','S')->count();
   }
   if($act==4){
      $data=App\Rekomendasi::where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('kode_sumber','LHA')->where('sts_tl','B')->count();
   }
   return $data;
}

function detail_unit($id){
   if($id==1){
      return 'Direktorat';
   }
   if($id==2){
      return 'Division';
   }
   if($id==3){
      return 'Department';
   }
}
function total_temuan($kode,$tahun,$kode_sumber){
   if($kode==1){
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->whereIn('kode_unit',array_temuan_auditee())->where('sts','>',0)->count();
   }else{
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->where('sts','>',0)->count();
   }
   
   return $data;
}
function total_temuan_kode($kode,$tahun,$kode_sumber){
  
   $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('sts','>',0)->count();
   
   return $data;
}
function total_temuan_progres($kode,$tahun,$kode_sumber){
   if($kode==1){
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->whereIn('kode_unit',array_temuan_auditee())->whereNotIn('sts_tl',array('B','S'))->count();
   }else{
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->whereNotIn('sts_tl',array('B','S'))->count();
   }
   
   return $data;
}
function total_temuan_progres_kode($kode,$tahun,$kode_sumber){
  
   $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->where('kode_unit',$kode)->whereNotIn('sts_tl',array('B','S'))->count();
   
   
   return $data;
}
function detail_temuan_get($kode,$tahun,$kode_sumber){
   if($kode==1){
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->whereIn('kode_unit',array_temuan_auditee())->where('sts','>',0)->get();
   }else{
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->where('sts','>',0)->get();
   }
   
   return $data;
}
function detail_temuan_get_kode($kode,$tahun,$kode_sumber){
   $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('sts','>',0)->get();
   return $data;
}
function total_temuan_selesai($kode,$tahun,$kode_sumber){
   if($kode==1){
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->whereIn('kode_unit',array_temuan_auditee())->where('sts_tl','S')->count();
   }else{
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->where('sts_tl','S')->count();
   }
   
   return $data;
}
function total_temuan_nol($kode,$tahun,$kode_sumber){
   if($kode==1){
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->whereIn('kode_unit',array_temuan_auditee())->where('sts_tl','B')->count();
   }else{
      $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->whereYear('terbit',$tahun)->where('sts_tl','B')->count();
   }
   
   return $data;
}
function total_temuan_selesai_kode($kode,$tahun,$kode_sumber){
   $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('sts_tl','S')->count();
   
   return $data;
}
function total_temuan_nol_kode($kode,$tahun,$kode_sumber){
   $data=App\Rekomendasi::where('kode_sumber',$kode_sumber)->where('kode_unit',$kode)->whereYear('terbit',$tahun)->where('sts_tl','B')->count();
   return $data;
}
function headtemuan_auditee_get($kode,$tahun){
   if($kode=='0'){
      $data=App\Rekomendasi::select('kode_sumber')->where('sts','>',0)->groupBy('kode_sumber')->get();
   }else{
      // $data=App\Rekomendasi::select('kode_sumber')->whereIn('kode_unit',array_temuan_auditee())->where('sts','>',0)->groupBy('kode_sumber')->get();
      $data=App\Rekomendasi::select('kode_sumber')->where('kode_unit',$kode)->where('sts','>',0)->groupBy('kode_sumber')->get();
   }
   
   return $data;
}
function headtemuan_auditee_get_kode($kode,$tahun){
   $data=App\Rekomendasi::select('kode_sumber')->where('kode_unit',$kode)->where('sts','>',0)->groupBy('kode_sumber')->get();
   return $data;
}
function temuan_rcd_get(){
   $data=App\Rekomendasi::where('sts','>',1)->get();
   return $data;
}
function temuan_anggota_get(){
   $det  = array_column(
      App\Audit::whereIn('tiket_id',array_tiket_anggota())
      ->get()
      ->toArray(),'id'
   );
   $data=App\Rekomendasi::whereIn('audit_id',$det)->where('sts','>',2)->get();
   return $data;
}
function temuan_ketua_get(){
   $det  = array_column(
      App\Audit::whereIn('tiket_id',array_tiket_ketua())
      ->get()
      ->toArray(),'id'
   );
   $data=App\Rekomendasi::whereIn('audit_id',$det)->where('sts','>',2)->get();
   return $data;
}
function temuan_pengawas_get(){
   $det  = array_column(
      App\Audit::whereIn('tiket_id',array_tiket_pengawas())
      ->get()
      ->toArray(),'id'
   );
   $data=App\Rekomendasi::whereIn('audit_id',$det)->where('sts','>',3)->get();
   return $data;
}
function temuan_head_get(){
   $det  = array_column(
      App\Audit::whereIn('tiket_id',array_tiket_head())
      ->get()
      ->toArray(),'id'
   );
   $data=App\Rekomendasi::whereIn('audit_id',$det)->where('sts','>',4)->get();
   return $data;
}
function tiket_get_anggota(){
   $data=App\Surattugas::whereIn('sts',array('2','3','4','5'))->whereIn('kode_aktivitas',array('01','02','03'))->whereIn('tiket_id',array_tiket_anggota())->orderBy('id','Desc')->get();
   return $data;
}
function tiket_get_ketua(){
   $data=App\Surattugas::whereIn('sts',array('2','3','4','5'))->whereIn('kode_aktivitas',array('01','02','03'))->whereIn('tiket_id',array_tiket_ketua())->orderBy('id','Desc')->get();
   return $data;
}

function tiket_get_head(){
   $data=App\Surattugas::whereIn('tiket_id',array_tiket_head())->orderBy('id','Desc')->get();
   return $data;
}



function tiket_get_pengawas(){
   $data=App\Tiket::whereIn('sts',array('3','4','5'))->whereIn('id',array_tiket_pengawas())->orderBy('id','Desc')->get();
   return $data;
}
function tiket_get_accpengawas(){
   $data=App\Tiket::whereIn('sts',array('3','4','5'))->whereIn('id',array_tiket_pengawas())->orderBy('id','Desc')->get();
   return $data;
}
function tiket_get_new_head(){
   $data=App\Tiket::whereIn('sts',array('3','4','5'))->orderBy('id','Desc')->get();
   return $data;
}

function akses_tiket_anggota(){
   $data=App\Timaudit::where('nik',Auth::user()['nik'])->where('role_id',3)->count();
   return $data;
}

function akses_tiket_pengawas(){
   $data=App\Timaudit::where('nik',Auth::user()['nik'])->where('role_id',2)->count();
   return $data;
}

function akses_tiket_head(){
   $data=App\Timaudit::where('nik',Auth::user()['nik'])->where('role_id',6)->count();
   return $data;
}

function akses_tiket_ketua(){
   $data=App\Timaudit::where('nik',Auth::user()['nik'])->where('role_id',1)->count();
   return $data;
}
function akses_temuan_auditee(){
   $data=App\Unitkerja::where('nik',Auth::user()['nik'])->count();
   return $data;
}

function sumber_get(){
   if(Auth::user()['role_id']==8){
      $data=App\Sumber::where('id',12)->orderBy('urut','Asc')->get();
   }else{
      $data=App\Sumber::whereBetween('id',[1,15])->orderBy('urut','Asc')->get();
   }
   
    
   return $data;
}

function surat_tugas_get(){
   
   $data=App\Surattugas::whereIn('tiket_id',array_tiket_pengawas())->whereIn('kode_aktivitas',array('04','05','06'))->where('sts',5)->orderBy('id','Desc')->get();
    
   return $data;
}

function audit_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->orderBy('id','Desc')->get();
    
   return $data;
}

function audit_lha_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts',9)->orderBy('id','Desc')->get();
    
   return $data;
}
// ===Lha
function lha_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_anggota())->where('sts','>',8)->orderBy('id','Desc')->get();
    
   return $data;
}
function lha_ketua_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',8)->orderBy('id','Desc')->get();
    
   return $data;
}
function index_temuan_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_anggota())->where('sts_lha','>',4)->orderBy('id','Desc')->get();
    
   return $data;
}
function index_temuanketua_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts_lha','>',4)->orderBy('id','Desc')->get();
    
   return $data;
}
function index_temuanhead_get(){
   
   $data=App\Audit::where('sts_lha','>',4)->orderBy('id','Desc')->get();
    
   return $data;
}
function index_temuanpengawas_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts_lha','>',4)->orderBy('id','Desc')->get();
    
   return $data;
}
function lha_pengawas_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts_lha','>','0')->orderBy('id','Desc')->get();
    
   return $data;
}
function lha_head_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_head())->where('sts_lha','>','1')->orderBy('id','Desc')->get();
    
   return $data;
}
function lha_qc_get(){
   
   $data=App\Audit::where('sts_lha','>','2')->orderBy('id','Desc')->get();
    
   return $data;
}
function lha_qchead_get(){
   
   $data=App\Audit::where('sts_lha','>','3')->orderBy('id','Desc')->get();
    
   return $data;
}

function audit_head_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_head())->where('sts','>',1)->orderBy('id','Desc')->get();
    
   return $data;
}

function kesimpulan_get($id){
   $data=App\Kesimpulan::where('audit_id',$id)->orderBy('id','Asc')->get();
   return $data;
}
function rekomendasi_get($kesimpulan){
   $data=App\Rekomendasi::where('kesimpulan_id',$kesimpulan)->orderBy('urutan','Asc')->get();
   return $data;
}
function temuan_get($kesimpulan){
   $data=App\Rekomendasi::where('kesimpulan_id',$kesimpulan)->orderBy('urutan','Asc')->get();
   return $data;
}
function kesimpulan_count($id){
   $data=App\Kesimpulan::where('audit_id',$id)->count();
   return $data;
}

//--deskaudit

function langkah_deskaudit($id){
   $data=App\Desklangkahkerja::where('deskaudit_id',$id)->orderBy('id','Asc')->get();
    return $data;
}

function deskaudit_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',2)->orderBy('id','Desc')->get();
    
   return $data;
}

function deskaudit_pengawas_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts_deskaudit','>',0)->orderBy('id','Desc')->get();
    
   return $data;
}
function deskaudit_head_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_head())->where('sts_deskaudit','>',3)->orderBy('id','Desc')->get();
    
   return $data;
}

function deskaudit_anggota_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_anggota())->where('sts_deskaudit','>',1)->orderBy('id','Desc')->get();
    
   return $data;
}

function deskaudit_catatan_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts_deskaudit','>',1)->orderBy('id','Desc')->get();
    
   return $data;
}

function deskaudit_catatan_pengawas_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts_deskaudit','>',2)->orderBy('id','Desc')->get();
    
   return $data;
}

//--Compliance

function langkah_compliance($id){
   $data=App\Complangkahkerja::where('compliance_id',$id)->orderBy('id','Asc')->get();
    return $data;
}

function compliance_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',4)->orderBy('id','Desc')->get();
    
   return $data;
}

function compliance_pengawas_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts_compliance','>',0)->orderBy('id','Desc')->get();
    
   return $data;
}
function compliance_head_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_head())->where('sts_compliance','>',3)->orderBy('id','Desc')->get();
    
   return $data;
}

function compliance_anggota_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_anggota())->where('sts_compliance','>',1)->orderBy('id','Desc')->get();
    
   return $data;
}

function compliance_catatan_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts_compliance','>',1)->orderBy('id','Desc')->get();
    
   return $data;
}

function compliance_catatan_pengawas_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts_compliance','>',2)->orderBy('id','Desc')->get();
    
   return $data;
}

//--Substantive

function langkah_substantive($id){
   $data=App\Subslangkahkerja::where('substantive_id',$id)->orderBy('id','Asc')->get();
    return $data;
}

function substantive_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts','>',6)->orderBy('id','Desc')->get();
    
   return $data;
}

function substantive_pengawas_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts_substantive','>',0)->orderBy('id','Desc')->get();
    
   return $data;
}
function substantive_head_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_head())->where('sts_substantive','>',3)->orderBy('id','Desc')->get();
    
   return $data;
}

function substantive_anggota_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_anggota())->where('sts_substantive','>',1)->orderBy('id','Desc')->get();
    
   return $data;
}

function substantive_catatan_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_ketua())->where('sts_substantive','>',1)->orderBy('id','Desc')->get();
    
   return $data;
}

function substantive_catatan_pengawas_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_pengawas())->where('sts_substantive','>',2)->orderBy('id','Desc')->get();
    
   return $data;
}


//---

function cek_aktivitas($id){
   
   $data=App\Sumber::where('kode',$id)->first();
    
   return $data['aktivitas_id'];
}

function role_get(){
    
    $data=App\Role::orderBy('name','Asc')->get();
    return $data;
}

function kodefikasi_get(){
    
    $data=App\Kodefikasi::orderBy('kodifikasi','Asc')->get();
    return $data;
}

function total_kodifikasi($kodifikasi){
    
    $data=App\Surattugas::where('kodifikasi_laporan',$kodifikasi)->count();
    return $data;
}

function total_kodifikasi_rekomendasi($kodifikasi){
    
    $data=App\Surattugas::where('kodifikasi_rekomendasi',$kodifikasi)->count();
    return $data;
}

function kodesurat_get(){
    
    $data=App\Kodesurat::orderBy('kode','Asc')->get();
    return $data;
}

function user_get($peg){
    if($peg=='0'){
        $data=App\User::where('name','!=',"")->orderBy('posisi_id','Asc')->get();
    }else{
        $data=App\User::where('name','!=',"")->orderBy('posisi_id','Asc')->paginate($peg);
    }
    
    return $data;
}





?>