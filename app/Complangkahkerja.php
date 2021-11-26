<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complangkahkerja extends Model
{
    protected $table = 'compliancelangkahkerja';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'tanggal',
        'compliance_id',
        'sts',
    ];

    function compliance(){
        return $this->belongsTo('App\Compliance','compliance_id','id');
    }
    
}
