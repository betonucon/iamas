<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unitkerja extends Model
{
    protected $table = 'unit_kerja';
    public $timestamps = false;

    // function poli(){
	// 	return $this->belongsTo('App\Poli','kode_poli','kode_poli');
    // }
}
