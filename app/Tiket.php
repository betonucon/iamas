<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tiket';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'kode_sumber',
        'bulan',
        'tahun',
        'tanggal',
        'nomorinformasi',
        'aktivitas_id',
        'judul',
        'keterangan',
        'lampiran',
        'nik',
        'sts',
        'alasan',
        'judul_tiket',
        'keterangan_tiket',
        'lampiran_tiket',
        'bulan_tiket',
        'tahun_tiket',
        'nomortiket',
        'kodifikasi',
        'rekomendasi',
        'tanggal_create_sumber',
        'tanggal_create_approve',
        'kode_aktivitas',
        'kodifikasi_rekomendasi',
        'kode_laporan',
        'tanggal_tiket_approve_head',
        'catatan_tiket',
        'kode_unit',
        

    ];

    function sumber(){
		  return $this->belongsTo('App\Sumber','kode_sumber','kode');
    }
    function surattugas(){
		  return $this->belongsTo('App\Surattugas','id','tiket_id');
    }
    function kodif(){
      return $this->belongsTo('App\Kodefikasi','kodifikasi','kodifikasi');
    }
    function aktifitas(){
      return $this->belongsTo('App\Aktivitas','kode_aktivitas','kode');
    }
    function unitkerja(){
      return $this->belongsTo('App\Unitkerja','kode_unit','kode');
    }
}
