@extends('layouts.web')
@push('style')
	<link href="{{url('assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />
	<style>
		label {
			display: inline-block;
			margin-bottom: 0px !important;
			font-weight: bold;
		}
		.text-toop{
			vertical-align:top;
		}
	</style>
@endpush
@section('contex')
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="form-plugins-1">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">&nbsp;</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body" style="background: #b5b5d330;">
					<ul class="nav nav-tabs">
						<li class="nav-item">
							<a href="{{url('Lha/Catatanhead?id='.coder($id))}}"   class="nav-link">
								<span class="d-sm-none">TEMUAN</span>
								<span class="d-sm-block d-none">TEMUAN</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="#default-tab-2" data-toggle="tab" class="nav-link active">
								<span class="d-sm-none">REKOMENDASI</span>
								<span class="d-sm-block d-none">REKOMENDASI</span>
							</a>
						</li>
					</ul>
					<div class="tab-content" style="margin-bottom:0px;padding:1%">
						<div class="tab-pane fade active show" id="default-tab-1">
							<div class="col-md-12" style="margin-bottom: 2%;padding: 1%;background: #e3e3e9;">
								<div class="form-group">
									<label>PILIH TEMUAN</label>
									<select onchange="pilih_temuan(this.value)" style="width:50%" class="form-control">
										@foreach(kesimpulan_get($id) as $kesim)
											<option value="{{$kesim->id}}" @if($kesimpulan_id==$kesim->id) selected @endif >Temuan {{$kesim->nomor}} </option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-12" style="margin-bottom:2%">
								<!-- <div class="btn-group">
									<button class="btn btn-red btn-sm" onclick="kembali()"><i class="fas fa-chevron-left"></i> Kembali</button>
								</div> -->
							</div>
							<div class="col-md-12" style="margin-bottom: 2%;padding: 1%;background: #ecf1dc;">
								<b>KESIMPULAN</b><hr>
								{!! $namakesimpulan !!}
							</div>
							<div class="col-md-12">
								@foreach(rekomendasi_get($kesimpulan_id) as $no=>$kes)
								<?php
								if(($no+1)%2==0){
									$warna='lime';
								}else{
									$warna='info';
								}

								?>
								<div class="alert alert-{{$warna}} fade show m-b-10">
									<b style="font-size:14px"><u>Nomor :  {{$kes->nomor}}.{{$kes->urutan}}</u></b></br>
									<table style="margin-left:2%" width="100%">
										<tr>
											<td class="text-toop" width="15%"><b>PIC</b></td>
											<td class="text-toop" width="2%"><b>:</b></td>
											<td class="text-toop">{{$kes->unitkerja['pimpinan']}} {{$kes->unitkerja['name']}}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Kodifikasi</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop"><b>{{$kes->kodifikasi}}</b> {{$kes->getkodifikasi['kategori']}}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Isi Rekomendasi</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{!! $kes->isi !!}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Risiko</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{{$kes->risiko}} ({{$kes->ket_risiko}})</td>
										</tr>
									</table>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
			
		</div>
		
	</div>
	<div class="row">

		<div class="modal" id="modaltambah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" style="max-width:80%">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tambah Data</h4>
						<button type="button" class="close" onclick="batal()" >×</button>
					</div>
					<div class="modal-body">
						
						<div id="tampil-tambah"></div>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="simpan_data()">Simpan</a>
						<a href="javascript:;" class="btn btn-white"  onclick="batal()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalubah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Data</h4>
						<button type="button" class="close" onclick="batal_ubah()" >×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubahdata"></div>
						<form id="ubah-data" enctype="multipart/form-data">
							@csrf
							<div id="tampil-ubah"></div>
						</form>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="ubah_data()">Simpan</a>
						<a href="javascript:;" class="btn btn-white"  onclick="batal_ubah()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalnotif" aria-hidden="true" style="display: none;background: rgb(56 48 48 / 49%);">
			<div class="modal-dialog" >
				<div class="modal-content">
					<div class="modal-header">
						<h5>Notifikasi</h5>
						
					</div>
					<div class="modal-body" style="">
						<div id="notifikasi"></div>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white"onclick="tutup_notif()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('ajax')
	<script src="{{url('assets/assets/plugins/ckeditor/ckeditor.js')}}"></script>
	<script src="{{url('assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>
	<script src="{{url('assets/assets/js/demo/form-wysiwyg.demo.js')}}"></script>
	<link href="{{url('assets/assets/plugins/summernote/dist/summernote.css')}}" rel="stylesheet" />
	<script src="{{url('assets/assets/plugins/summernote/dist/summernote.min.js')}}"></script>
	<script>
		$(document).ready(function() {
            $('#tanggalpicker').datepicker({
                format: 'yyyy-mm-dd',
                
            });
            $('#tangal_penerbitan').datepicker({
                format: 'yyyy-mm-dd',
                
            });
        });
		function pilih_temuan(nomor){
			location.assign("{{url('/Lha/Catatanhead?id='.coder($id))}}&aksi=rekomendasi&nomor="+nomor);
		}
		function tambah_data(){
			$.ajax({
				type: 'GET',
				url: "{{url('Lha/tampiltambahtemuan')}}",
				data: "id={{$id}}",
				beforeSend: function() {
					document.getElementById("loadnya").style.width = "100%";
				},
				success: function(msg){
					document.getElementById("loadnya").style.width = "0px";
					$('#modaltambah').modal({
						backdrop: 'static',
						keyboard: true, 
						show: true
					});
					$('#tampil-tambah').html(msg);
				}
			});
			
		}
		function ubah(id){
			$.ajax({
				type: 'GET',
				url: "{{url('Lha/tampiltambahtemuan')}}",
				data: "id={{$id}}&kesimpulan_id="+id,
				beforeSend: function() {
					document.getElementById("loadnya").style.width = "100%";
				},
				success: function(msg){
					document.getElementById("loadnya").style.width = "0px";
					$('#modaltambah').modal({
						backdrop: 'static',
						keyboard: true, 
						show: true
					});
					$('#tampil-tambah').html(msg);
				}
			});
			
		}
		function batal(){
			$('#modaltambah').modal('toggle');
		}
		function batal_ubah(){
			$('#modalubah').modal('toggle');
		}
		function tutup_notif(){
			$('#modalnotif').modal('toggle');
		}

		$("#textareaisi").wysihtml5();
		
		function kembali(){
			location.assign("{{url('/Qc/')}}");
		}
		$('#myTable').DataTable( {
			responsive: true,
			paging: true,
			info: true,
			lengthChange: false,
		} );

		
		function hapus(id){
			$.ajax({
				type: 'GET',
				url: "{{url('Lha/hapus')}}",
				data: "id="+id,
				beforeSend: function() {
					document.getElementById("loadnya").style.width = "100%";
				},
				success: function(msg){
					location.reload();
				}
			});
		}
		 
		
		
		
	</script>

@endpush
	
