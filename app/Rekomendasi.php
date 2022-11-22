<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    protected $table = 'rekomendasi';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'kesimpulan_id',
        'name',
        'kodifikasi',
        'kode_unit',
        'isi',
        'keterangan',
        'estimasi',
        'nomor',
        'risiko',
        'ket_risiko',
        'nomorkode',
        'kode',
        'urutan',
        'kode_sumber',
        'tanggal',
        'bulan',
        'tahun',
        'sts',

   ];
   function unitkerja(){
         return $this->belongsTo('App\Unitkerja','kode_unit','kode');
   }
   function getkodifikasi(){
         return $this->belongsTo('App\Kodefikasi','kodifikasi','kodifikasi');
   }
   function kesimpulan(){
         return $this->belongsTo('App\Kesimpulan','kesimpulan_id','id');
   }
   function audit(){
         return $this->belongsTo('App\Audit','audit_id','id');
   }
}
