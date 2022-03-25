<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    protected $table = 'disposisi';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'tanggal',
        'nomortl',
        'rekomendasi_id',
        'sts_tl',
        'alasan',
    ];
    function rekomendasi(){
        return $this->belongsTo('App\Rekomendasi','rekomendasi_id','id');
    }
}
