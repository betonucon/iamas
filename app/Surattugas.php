<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surattugas extends Model
{
    protected $table = 'surat_tugas';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'nomorinformasi',
        'tiket_id',
        'nomortiket',
        'kode_sumber',
        'aktivitas_id',
        'kodifikasi',
        'kode_aktivitas',
        'kode_laporan',
        'nomorlaporan',
        'mulai',
        'sampai',
        'kodifikasi_laporan',
        'kode_audit',
        'catatan',
        'kode',
        'nomorsurat',
        'bulan',
        'tahun',
        'tanggal',
        'kode_unit',
        'sts',
        'kodifikasi_rekomendasi',
        'rekomendasi',
        

        

    ];

    function unitkerja(){
        return $this->belongsTo('App\Unitkerja','kode_unit','kode_unit');
    }
    function tiket(){
        return $this->belongsTo('App\Tiket','tiket_id','id');
    }
    
}
