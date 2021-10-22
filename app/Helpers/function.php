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
    $data=App\Surattugas::whereIn('sts',array('3','4','5'))->whereIn('tiket_id',array_tiket_pengawas())->orderBy('id','Desc')->get();
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

function src_get(){
    $data=App\User::whereIn('posisi_id',array('1','2'))->orderBy('name','Asc')->get();
    return $data;
}
function unitkerja_get(){
    $data=App\Unitkerja::orderBy('name','Asc')->get();
    return $data;
}
function katua_get(){
    $data=App\User::whereIn('posisi_id',array('3','11','12'))->orderBy('name','Asc')->get();
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

function array_tiket_pengawas(){
   $data  = array_column(
      App\Timaudit::where('nik',Auth::user()['nik'])->where('role_id',2)
      ->get()
      ->toArray(),'tiket_id'
   );
    return $data;
}

function tiket_get_anggota(){
   $data=App\Surattugas::whereIn('sts',array('2','3'))->whereIn('kode_aktivitas',array('01','02','03'))->whereIn('tiket_id',array_tiket_anggota())->orderBy('id','Desc')->get();
   return $data;
}

function tiket_get_head(){
   $data=App\Surattugas::orderBy('id','Desc')->get();
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