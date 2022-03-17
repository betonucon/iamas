<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $table = 'audit';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'kodifikasi',
        'kode_aktivitas',
        'kodifikasi_laporan',
        'kode',
        'bulan',
        'tahun',
        'tanggal',
        'kode_unit',
        'sts',
        'tiket_id',
        'tujuan',
        'sasaran',
        'nomorsurat',
        'risiko',
        'tgl_penerbitan',
        'tgl_deskaudit_program_start',
        'tgl_deskaudit_program_end',
        'tgl_deskaudit_hasil_start',
        'tgl_deskaudit_hasil_end',
        'tgl_compliance_program_start',
        'tgl_compliance_program_end',
        'tgl_compliance_hasil_start',
        'tgl_compliance_hasil_end',
        'tgl_substantive_program_start',
        'tgl_substantive_program_end',
        'tgl_substantive_hasil_start',
        'tgl_substantive_hasil_end',
        'tgl_lha_start',
        'tgl_lha_end',
        'tgl_lha_draf_start',
        'tgl_lha_draf_end',
        'tgl_lha_finis_start',
        'tgl_lha_finis_end',
        'sts_audit',
        'sts_deskaudit',
        'sts_compliance',
        'sts_substantive',
        'sts_lha',
        'tgl_sts1',
        'tgl_plan',

    ];
    function unitkerja(){
        return $this->belongsTo('App\Unitkerja','kode_unit','kode');
    }
    function surattugas(){
        return $this->belongsTo('App\Surattugas','tiket_id','tiket_id');
    }
    function stsaudit(){
        return $this->belongsTo('App\Stsaudit','sts','id');
    }
}
