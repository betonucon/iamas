<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewnotifikasitemuanketua extends Model
{
    protected $table = 'view_notif_temuan_ketua';
    public $timestamps = false;
    protected $guarded = ['id'];
}
