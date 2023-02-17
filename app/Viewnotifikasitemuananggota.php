<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewnotifikasitemuananggota extends Model
{
    protected $table = 'view_notif_temuan_anggota';
    public $timestamps = false;
    protected $guarded = ['id'];
}
