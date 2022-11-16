<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tiket';
    public $timestamps = false;
    protected $guarded = ['id'];

    function sumber(){
		  return $this->belongsTo('App\Sumber','kode_sumber','kode');
    }
    function lokasi(){
		  return $this->belongsTo('App\Lokasi','lokasi_id','id');
    }
    function surattugas(){
		  return $this->belongsTo('App\Surattugas','id','tiket_id');
    }
    function kodif(){
      return $this->belongsTo('App\Kodefikasi','kodifikasi','kodifikasi');
    }
    function aktifitas(){
      return $this->belongsTo('App\Aktivitas','kode_aktivitas','kode');
    }
    function unitkerja(){
      return $this->belongsTo('App\Unitkerja','kode_unit','kode');
    }
}
