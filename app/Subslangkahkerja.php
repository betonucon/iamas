<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subslangkahkerja extends Model
{
    protected $table = 'substantivelangkahkerja';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'tanggal',
        'substantive_id',
        'sts',
    ];

    function substantive(){
        return $this->belongsTo('App\Substantive','substantive_id','id');
    }
    
}
