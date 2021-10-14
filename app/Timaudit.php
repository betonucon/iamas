<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timaudit extends Model
{
    protected $table = 'tim_audit';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'tiket_id',
        'nik',
        'role_id',
        'nomortiket',
    ];
    function user(){
        return $this->belongsTo('App\User','nik','nik');
    }
    function role(){
        return $this->belongsTo('App\Role','role_id','id');
    }
}
