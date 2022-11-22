<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surattugas extends Model
{
    protected $table = 'surat_tugas';
    public $timestamps = false;
    protected $guarded = ['id'];

    function unitkerja(){
        return $this->belongsTo('App\Unitkerja','kode_unit','kode');
    }
    function tiket(){
        return $this->belongsTo('App\Tiket','tiket_id','id');
    }
    function lokasi(){
        return $this->belongsTo('App\Lokasi','lokasi_id','id');
    }
    
}
