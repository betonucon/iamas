<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewcountcomplianceprogram extends Model
{
    protected $table = 'view_count_compliance_program';
    public $timestamps = false;
    protected $guarded = ['id'];
}
