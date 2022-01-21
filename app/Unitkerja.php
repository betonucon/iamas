<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unitkerja extends Model
{
    protected $table = 'unit_kerja';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'kode',
        'name',
        'pimpinan',
        'unit_id',
        'kode_unit',
        'nik',
        'nama_pic',
        'nik_atasan',
        'nama_atasan',
        'as',
    ];

}
