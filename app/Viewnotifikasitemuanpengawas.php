<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewnotifikasitemuanpengawas extends Model
{
    protected $table = 'view_notif_temuan_pengawas';
    public $timestamps = false;
    protected $guarded = ['id'];
}
