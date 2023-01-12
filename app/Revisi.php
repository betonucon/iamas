<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    protected $table = 'revisi';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'audit_id',
        'keterangan',
        'mulai',
        'sampai',
        'tiket_id',
        'kategori',
        'sts',
        'role_id',
        'file',

        

        

    ];
    function audit(){
        return $this->belongsTo('App\Audit','audit_id','id');
    }
    function surattugas(){
            return $this->belongsTo('App\Surattugas','id','tiket_id');
    }
}
