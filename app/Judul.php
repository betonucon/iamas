<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Judul extends Model
{
    protected $table = 'judul';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'tiket_id', 
        'judul', 
        'tujuan',
        'risiko',
    ];
}
