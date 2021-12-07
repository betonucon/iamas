<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lha extends Model
{
    protected $table = 'lha_audit';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'latar_belakang',
        'sasaran',
        'ruang_lingkup',
        'pelaksanaan',
        'kesimpulan',
        'penjelasan',
        'penutup',
        'tanggal',
        'tiket_id',
        
        'audit_id',
        'sts',

    ];

    function audit(){
        return $this->belongsTo('App\Audit','audit_id','id');
    }
    function tiket(){
        return $this->belongsTo('App\Tiket','tiket_id','id');
    }
}
