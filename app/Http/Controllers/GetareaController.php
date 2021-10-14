<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetareaController extends Controller
{
    public function cari_kota(request $request)
    {
        $kode=$request->kode_provinsi;
        echo'<option value="">Pilih kota---</option>';
        foreach (kota_get($kode) as $kota_get) {
            echo '<option value="' . $kota_get['kode'] . '">' . $kota_get['name'] . ' </option>';
        }
        
    }

    public function cari_kecamatan(request $request)
    {
        $kode=$request->kode_kota;
        echo'<option value="">Pilih kecamatan---</option>';
        foreach (kecamatan_get($kode) as $kecamatan_get) {
            echo '<option value="' . $kecamatan_get['kode'] . '">' . $kecamatan_get['name'] . ' </option>';
        }
        
    }

    public function cari_kelurahan(request $request)
    {
        $kode=$request->kode_kecamatan;
        echo'<option value="">Pilih Kelurahan---</option>';
        foreach (kelurahan_get($kode) as $kelurahan_get) {
            echo '<option value="' . $kelurahan_get['kode'] . '">' . $kelurahan_get['name'] . ' </option>';
        }
        
    }

    public function isi_warga(request $request){
        error_reporting(0);
            if($request->id==1){
                echo'
                <div class="col-md-12" style="padding: 2% ;">
                    <div class="row m-b-15">
                        <div class="col-md-12">
                            <label class="control-label">NIK/ Nomor Induk Kependudukan </label>
                            <input type="text" name="username" onkeypress="return hanyaAngka(event)" class="form-control is-valid" value="'.old('username').'" placeholder="NIK/ Nomor Induk Kependudukan" required />
                            <span class="text-danger" id="error-username">
                    
                        </div>
                        
                    </div>
                </div>';
            }
            if($request->id==2){
                echo'
                <div class="col-md-12" style="padding: 2% ;">
                    <div class="row m-b-15">
                        <div class="col-md-12">
                            <label class="control-label">NIK/ Nomor Passport</label>
                            <input type="text" name="username" onkeypress="return hanyaAngka(event)" class="form-control is-valid" value="'.old('username').'" placeholder="NIK/ Nomor Passport" required />
                            <span class="text-danger" id="error-username">
                    
                        </div>
                        
                    </div>
                </div>';
            }
            echo'
            <div class="col-md-12" style="padding: 2% 6%;border: solid 1px #efe6e6;">
                <div class="row m-b-15">
                    <b style="display:block"><i class="fa fa-user"></i> SESUAI KTP</b>
                </div>
                <div class="row m-b-15">
                    <div class="col-md-6">
                        <label class="control-label">Provinsi <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control" onchange="cari_kota(this.value)" name="kode_provinsi">
                                <option value="">Pilih Provinsi---</option>';
                                foreach(provinsi_get() as $provinsi_get){
                                    echo'<option value="'.$provinsi_get->kode.'">'.$provinsi_get->name.'</option>';
                                }
                            echo'
                            </select>
                        </div>
                        <span class="text-danger" id="error-kode_provinsi">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control" id="tampilkota" onchange="cari_kecamatan(this.value)"  name="kode_kota">
                                <option value="">Pilih Kota/Kab---</option>
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-kode_kota">
                    </div>
                </div>
                <div class="row m-b-15">
                    <div class="col-md-6">
                        <label class="control-label">Kecamatan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control" id="tampilkecamatan" onchange="cari_kelurahan(this.value)" name="kode_kecamatan">
                                <option value="">Pilih Kecamatan---</option>
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-kode_kecamatan">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Kelurahan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control" id="tampilkelurahan" name="kode_kelurahan">
                                <option value="">Pilih Kelurahan---</option>
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-kode_kelurahan">
                    </div>
                </div>
                <div class="row m-b-15">
                    <div class="col-md-6">
                        <label class="control-label">RW <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control"  name="rw">
                                <option value="">Pilih RW---</option>
                                '.get_rw().'
                           
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-rw">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">RT <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control"  name="rt">
                                <option value="">Pilih RW---</option>
                                '.get_rt().'
                            
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-rt">
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="padding: 2% 6%;border: solid 1px #efe6e6;">
                <div class="row m-b-15">
                    <b style="display:block"><i class="fa fa-user"></i> SESUAI DOMISILI</b>
                </div>
                <div class="row m-b-15">
                    <div class="col-md-6">
                        <label class="control-label">Provinsi <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control" readonly name="kode_provinsi_tinggal">';
                                foreach(provinsi_aktif() as $provinsi_aktif){
                                    echo'<option value="'.$provinsi_aktif->kode.'">'.$provinsi_aktif->name.'</option>';
                                }
                            echo'
                            </select>
                        </div>
                        <span class="text-danger" id="error-kode_provinsi_tinggal">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control" readonly name="kode_kota_tinggal">';
                                foreach(kota_aktif() as $kota_aktif){
                                    echo'<option value="'.$kota_aktif->kode.'">'.$kota_aktif->name.'</option>';
                                }
                            echo'
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-kode_kota_tinggal">
                    </div>
                </div>
                <div class="row m-b-15">
                    <div class="col-md-6">
                        <label class="control-label">Kecamatan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control" onchange="cari_kelurahan_tinggal(this.value)" name="kode_kecamatan_tinggal">
                                <option value="">Pilih Kecamatan---</option>';	
                                foreach(kecamatan_aktif() as $kecamatan_aktif){
                                    echo'<option value="'.$kecamatan_aktif->kode.'">'.$kecamatan_aktif->name.'</option>';
                                }
                            echo'
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-kode_kecamatan_tinggal">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Kelurahan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control" id="tampilkelurahantinggal" name="kode_kelurahan_tinggal">
                                <option value="">Pilih Kelurahan---</option>
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-kode_kelurahan_tinggal">
                    </div>
                </div>
                <div class="row m-b-15">
                    <div class="col-md-6">
                        <label class="control-label">RW <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control"  name="rw_tinggal">
                                <option value="">Pilih RW---</option>
                                 '.get_rw().'
                                
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-rw_tinggal">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">RT <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
                            <select class="form-control"  name="rt_tinggal">
                                <option value="">Pilih RT---</option>
                                '.get_rt().'
                            </select>
                            
                        </div>
                        <span class="text-danger" id="error-rt_tinggal">
                    </div>
                </div>
            </div>

        ';
    }
}
