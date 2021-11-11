<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Judul extends Model
{
    protected $table = 'judul';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'tiket_id', 
        'judul', 
        'tujuan',
        'risiko',
        'kodifikasi',
        'kode_unit',
        'as',
    ];

    function unitkerja(){
        return $this->belongsTo('App\Unitkerja','kode_unit','kode_unit');
    }
}
