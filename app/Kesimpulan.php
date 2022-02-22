<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kesimpulan extends Model
{
    protected $table = 'kesimpulan';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'audit_id',
        'name',
        'isi',
        'kodifikasi',
        'nomor',
        'keterangan',
        'risiko',
        'ket_risiko',
        'nomorkode',
        'kode',
        'kode_sumber',
        'tanggal',
        'bulan',
        'tahun',
        'sts',
   ];
    

    function kodifikasi(){
        return $this->belongsTo('App\kodifikasi','kodifikasi','kodifikasi');
    }
    function getkodifikasi(){
        return $this->belongsTo('App\Kodefikasi','kodifikasi','kodifikasi');
  }
}
