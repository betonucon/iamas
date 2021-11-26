<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Substantive extends Model
{
    protected $table = 'substantive';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'tiket_id',
        'nomortiket',
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
