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
   return $x;
}

function nilai_plan($id){
   $data=App\Surattugas::where('id',$id)->first();
   $begin = new DateTime($data['mulai']);
   $end = new DateTime($data['sampai']);
   
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
   return $x;
}

function nilai_real($id){
   $data=App\Surattugas::where('id',$id)->first();
   if($data['sts']==5){
      $begin = new DateTime($data['tgl_head']);
      $end = new DateTime($data['tgl_approval']);
      
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
      return $x;
   }else{
      return '0';
   }
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

function head_of(){
   $data=App\User::where('posisi_id',1)->first();
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

function judul_get($tiket){
    $data=App\Judul::where('tiket_id',$tiket)->orderBy('id','Asc')->get();
    return $data;
}

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
      $data=App\Tiket::whereIn('sts',array('2'))->whereIn('kode_sumber',array('RAN','QA2'))->orderBy('id','Desc')->get();  
   }
   if($id=='06'){
      $data=App\Tiket::whereIn('sts',array('2'))->whereIn('kode_sumber',array('RAN','QA2'))->orderBy('id','Desc')->get();  
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

function aktivitas_get_dashboard($kode){
    $data=App\Surattugas::where('kode_aktivitas',$kode)->orderBy('kode_aktivitas','Asc')->get();
    return $data;
}

function unit_as($kode){
    $data=App\Unitkerja::where('kode',$kode)->first();
    return $data['as'];
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
function aproval_get(){
    $data=App\User::whereIn('posisi_id',array('1','13'))->orderBy('name','Asc')->get();
    return $data;
}
function unitkerja_get(){
    $data=App\Unitkerja::whereIn('unit_id',array('1','3','5'))->orderBy('name','Asc')->get();
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

function tiket_get_anggota(){
   $data=App\Surattugas::whereIn('sts',array('2','3','4','5'))->whereIn('kode_aktivitas',array('01','02','03'))->whereIn('tiket_id',array_tiket_anggota())->orderBy('id','Desc')->get();
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

function sumber_get(){
   
   $data=App\Sumber::whereBetween('id',[1,15])->orderBy('urut','Asc')->get();
    
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

function audit_head_get(){
   
   $data=App\Audit::whereIn('tiket_id',array_tiket_head())->where('sts','>',1)->orderBy('id','Desc')->get();
    
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