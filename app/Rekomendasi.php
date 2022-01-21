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
        'nomor',
        'nilai',
        'urutan',

   ];
   function unitkerja(){
         return $this->belongsTo('App\Unitkerja','kode_unit','kode');
   }
   function getkodifikasi(){
         return $this->belongsTo('App\Kodefikasi','kodifikasi','kodifikasi');
   }
}
