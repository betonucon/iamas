<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desklangkahkerja extends Model
{
    protected $table = 'deskauditlangkahkerja';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'tanggal',
        'deskaudit_id',
        'sts',
    ];

    function deskaudit(){
        return $this->belongsTo('App\deskaudit','deskaudit_id','id');
    }
    
}
