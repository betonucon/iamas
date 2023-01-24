<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewtemuan extends Model
{
    protected $table = 'view_temuan';
    public $timestamps = false;
    protected $guarded = ['id'];
}
