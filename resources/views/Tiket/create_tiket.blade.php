@extends('layouts.web')
@push('style')
	<link href="{{url('assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />
	<style>
		label {
			display: inline-block;
			margin-bottom: 0px !important;
			font-weight: bold;
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
					<h4 class="panel-title">Daftar Tiket</h4>
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

						<form id="tambah-data" action="{{url('/TiketNew')}}" method="post" enctype="multipart/form-data">
							@csrf
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a href="#default-tab-1" data-toggle="tab" class="nav-link active">
										<span class="d-sm-none">Tab 1</span>
										<span class="d-sm-block d-none">Tiket</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="#default-tab-2" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">Tab 2</span>
										<span class="d-sm-block d-none">Audit</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="#default-tab-3" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">Tab 3</span>
										<span class="d-sm-block d-none">Tim Audit</span>
									</a>
								</li>
								
							</ul>
							<div class="tab-content" style="margin-bottom:0px;padding:1%">
						
								<div class="tab-pane fade active show" id="default-tab-1">
									<div class="col-xl-12">
										<div class="form-group">
											<label for="exampleInputEmail1">Aktivitas</label>
											<select class="form-control" name="kode_aktivitas" onchange="pilih_aktivitas()" id="kode_aktivitas">
												<option value="">Pilih Aktivitas</option>
												@foreach(aktivitas_get() as $aktifitas)
													
													<option value="{{$aktifitas['kode']}}" >[{{$aktifitas['kode']}}] {{$aktifitas['name']}}</option>
												@endforeach
											</select>
										</div>
										<table width="100%">
											<tr>
												<td>
													<div class="form-group">
														<label for="exampleInputEmail1">Sumber Infomasi</label>
														<div class="input-group">
															<div class="input-group-prepend"><span class="input-group-text" style="cursor: pointer;" onclick="pilih_sumber()">Plih Sumber</span></div>
															<input type="text" disabled id="sumbernya" class="form-control">
														</div>
														<input type="hidden" name="tiket_id" id="tiket_id">
													</div>
												</td>
												<td width="30%">
													<div class="form-group">
														<label for="exampleInputEmail1">Lampiran</label>
														<input type="file" class="form-control"  name="lampiran" >
													</div>
												</td>
											</tr>
										</table>
									</div>
									
										
									
									<div class="col-xl-12">
										<div class="form-group">
											<label for="exampleInputEmail1">Judul</label>
											<input type="text" class="form-control" name="judul" id="judul_1"placeholder="Enter text ...">
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Lokasi</label>
											<select class="form-control" name="lokasi_id"  style="width:30%">
												<option value="">Pilih Lokasi</option>
												@foreach(lokasi_get() as $lokasi)
													
													<option value="{{$lokasi->id}}" >{{$lokasi->name}}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Isi</label>
											<textarea class="textarea form-control" name="keterangan" id="textareatiket" placeholder="Enter text ..." rows="8"></textarea>
										</div>
									</div>
								</div>
								
								<div class="tab-pane fade" id="default-tab-2">
									<div class="col-xl-10 offset-xl-1">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Obyek Audit /Non Audit</label>
											<div class="col-lg-9 col-xl-9">
												<input type="text" class="form-control" id="judul_2" name="name"  placeholder="Ketik...">
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Unit Kerja</label>
											<div class="col-lg-9 col-xl-6">
												<select class="default-select2 form-control" id="kode_unit" name="kode_unit" placeholder="Pilih Unit Kerja">
													<option value="">--Pilih Unit Kerja</option>
													@foreach(unitkerja_get() as $no=>$unitkerja_get)
														<option value="{{$unitkerja_get->kode}}">{{ucwords($unitkerja_get->name)}}</option>
													@endforeach
													
												</select>
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Katagori Audit</label>
											<div class="col-lg-9 col-xl-9">
												<select class="default-select2 form-control" name="kode" placeholder="Pilih Unit Kerja">
													<option value="NA">--Pilih Katagori Audit</option>
													@foreach(kodesurat_get() as $no=>$kodesurat_get)
														<option value="{{$kodesurat_get->kode}}">[{{$kodesurat_get->kode}}] {{ucwords($kodesurat_get->keterangan)}}</option>
													@endforeach
													
												</select>
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Tanggal (Mulai & Sampai)</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control"  name="mulai" id="tanggalpicker" placeholder="Ketik...">
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control"  name="sampai"  id="tanggalpicker2" placeholder="Ketik...">
											</div>
										</div>
										
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-3">
									<div class="col-xl-10 offset-xl-1">
										<div class="form-group row m-b-10">
											<label class="col-lg-3 text-lg-right col-form-label">Approval</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group m-b-10">
													<div class="input-group-prepend" onclick="cari_approval(1)"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
													<input type="text" class="form-control" disabled id="approval" placeholder="Ketik...">
													<input type="hidden" class="form-control" name="nik[]" id="nik_approval" placeholder="Username">
													<input type="hidden" class="form-control" name="role[]" value="6" placeholder="Username">
												</div>
											</div>
											
										</div>
										<div class="form-group row m-b-10">
											<label class="col-lg-3 text-lg-right col-form-label">Pengawas</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group m-b-10">
													<div class="input-group-prepend" onclick="cari_pengawas(1)"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
													<input type="text" class="form-control" disabled id="pengawas" placeholder="Ketik...">
													<input type="hidden" class="form-control" name="nik[]" id="nik_pengawas" placeholder="Username">
													<input type="hidden" class="form-control" name="role[]" value="2" placeholder="Username">
												</div>
											</div>
											
										</div>
										<div class="form-group row m-b-10">
											<label class="col-lg-3 text-lg-right col-form-label">Ketua TIM</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group m-b-10">
													<div class="input-group-prepend" onclick="cari_ketua(1)"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
													<input type="text" class="form-control" disabled id="ketua" placeholder="Ketik...">
													<input type="hidden" class="form-control" name="nik[]" id="nik_ketua" placeholder="Username">
													<input type="hidden" class="form-control" name="role[]" value="1" placeholder="Username">
												</div>
											</div>
											
										</div>
										<div class="form-group row m-b-10">
											<label class="col-lg-3 text-lg-right col-form-label">Anggota</label>
											<div class="col-lg-9 col-xl-9">
												<select class="multiple-select2 form-control" name="nik[]" multiple="multiple">
													<optgroup label="Pilih Anggota">
													@foreach(anggota_get() as $no=>$src_get)
														<option value="{{$src_get->nik}}">{{ucwords($src_get->name)}}</option>
													@endforeach
													</optgroup>
												</select>
											</div>
										</div>
										
									</div>
									
								</div>
								<div class="modal-footer">
									<a href="javascript:;" class="btn btn-blue" onclick="tambah_data()">Simpan</a>
									<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
								</div>
								
							</div>
							<input type="submit">
						</form>

				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
			
		</div>
		
	</div>
	<div class="row">

		<div class="modal" id="modaltambah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tambah Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body" style="background: #b5b5d330;">
						
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="tambah_data()">Simpan</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" id="modalubah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubah"></div>
						<form id="ubah-data" enctype="multipart/form-data">
							@csrf
							<div id="tampilubah"></div>
						</form>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="ubah_data()">Simpan</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalcektimaudit" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						
							<div id="tampilcektim"></div>
						
					</div>
					<div class="modal-footer">
						
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal" id="modalfile" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">File Lampiran</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						
							<div id="tampilfile"></div>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalketua" aria-hidden="true" style="display: none;background: rgb(53 26 88 / 49%);">
			<div class="modal-dialog" style="max-width:50%">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ketua Tim Audit</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
					    
							<table class="table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline collapsed" border="1">
								<tr>
									<th>No</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Jabatan</th>
								</tr>
								@foreach(katua_get() as $no=>$src_get)
									<tr onclick="pilih_ketua({{$src_get->nik}},'{{$src_get->name}}')">
										<td><input type="checkbox" name="nik[]" value="{{$src_get->nik}}"></td>
										<td>{{$src_get->nik}}</td>
										<td>{{$src_get->name}}</td>
										<td>{{$src_get->posisi['name']}}</td>
									</tr>
								@endforeach
							</table>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" onclick="tutup_modal_ketua()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modaltimaudit" aria-hidden="true" style="display: none;background: rgb(53 26 88 / 49%);">
			<div class="modal-dialog" style="max-width:50%">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Pengawas</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
					   
							<table class="table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline collapsed" border="1">
								<tr>
									<th>No</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Jabatan</th>
								</tr>
								@foreach(src_get() as $no=>$src_get)
									<tr onclick="pilih_pengawas({{$src_get->nik}},'{{$src_get->name}}')">
										<td><input type="checkbox" name="nik[]" value="{{$src_get->nik}}"></td>
										<td>{{$src_get->nik}}</td>
										<td>{{$src_get->name}}</td>
										<td>{{$src_get->posisi['name']}}</td>
									</tr>
								@endforeach
							</table>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" onclick="tutup_modal_tim()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalapprovalaudit" aria-hidden="true" style="display: none;background: rgb(53 26 88 / 49%);">
			<div class="modal-dialog" style="max-width:50%">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Aproval</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
					   
							<table class="table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline collapsed" border="1">
								<tr>
									<th>No</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Jabatan</th>
								</tr>
								@foreach(aproval_get() as $no=>$aproval_get)
									<tr onclick="pilih_aproval({{$aproval_get->nik}},'{{$aproval_get->name}}')">
										<td><input type="checkbox" name="nik[]" value="{{$aproval_get->nik}}"></td>
										<td>{{$aproval_get->nik}}</td>
										<td>{{$aproval_get->name}}</td>
										<td>{{$aproval_get->posisi['name']}}</td>
									</tr>
								@endforeach
							</table>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" onclick="tutup_modal_tim()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalsumber" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog modal-lg" style="margin-top:0px">
				<div class="modal-content">
					<div class="modal-header">
						<h5>Pilih sumber informasi dibawah ini</h5>
						
					</div>
					<div class="modal-body" id="tampil_pilihan_sumber" style="height: 450px;overflow-y: scroll;padding: 0px;">
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" onclick="tutup_sumber()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalnotif" aria-hidden="true" style="display: none;background: #ea59597d;">
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
	<script>
		$(document).ready(function() {
            $('#tanggalpicker').datepicker({
                format: 'yyyy-mm-dd',
                
            });
            $('#tanggalpicker2').datepicker({
                format: 'yyyy-mm-dd',
                
            });
        });
		$("#textareatiket").wysihtml5();
		$("#textareacatatan").wysihtml5();
		$('#myTable').DataTable( {
			responsive: true,
			paging: true,
			info: true,
			lengthChange: false,
		} );

		
		

		function pilih_aktivitas(){
			$('#tampiltim').html('');
		}

		function cari_timaudit(a,role){
			
			$.ajax({
				type: 'GET',
				url: "{{url('TiketNew/tampil_tim')}}",
				data: "id="+a,
				success: function(msg){
					$('#modaltimaudit').modal({backdrop: 'static',keyboard: false});
					$('#tim_id').val(a);
					$('#role_id').val(role);
				}
			}); 
		}
		function pilih_sumber(){
			var kode_aktivitas=$('#kode_aktivitas').val();
			$.ajax({
				type: 'GET',
				url: "{{url('TiketNew/tampil_pilihan_sumber')}}",
				data: "kode_aktivitas="+kode_aktivitas,
				success: function(msg){
					$('#modalsumber').modal('show');
					$('#tampil_pilihan_sumber').html(msg);
				}
			});
			
		}
		function tutup_notif(){
			$('#modalnotif').modal('toggle');
		}
		function tutup_sumber(){
			$('#modalsumber').modal('toggle');
		}

		function cek_pilih_sumber(a,id,kode_unit,nama_unit,judul){
			var kode_aktivitas=$('#kode_aktivitas').val();
			$('#sumbernya').val(a);
			$('#tiket_id').val(id);
			if(kode_aktivitas=='04' || kode_aktivitas=='05' || kode_aktivitas=='06'){
				$('#kode_unit').html('<option value="'+kode_unit+'">'+nama_unit+'</option>');
				$('#judul_1').val(judul);
				$('#judul_2').val(judul);
				
			}
			
			$.ajax({
				type: 'GET',
				url: "{{url('TiketNew/tampil_tim')}}",
				data: "act=2&id="+id+"&kode_aktivitas="+kode_aktivitas,
				success: function(msg){
					$('#tampiltim').html(msg);
				}
			});
			$('#modalsumber').modal('toggle');
		}

		function cek_revisi(a){
			$('#modalrevisi').modal('show');
			$('#tampilrevisi').html(a);
		}

		function cek_file(a){
			$('#modalfile').modal('show');
			$('#tampilfile').html("<iframe src='{{url('_file_lampiran')}}/"+a+"' width='100%' height='600px'></iframe>");
		}

		function cari_approval(a){
			$('#modalapprovalaudit').modal({backdrop: 'static',keyboard: false});
					
		}
		function cari_pengawas(a){
			$('#modaltimaudit').modal({backdrop: 'static',keyboard: false});
					
		}
		function cari_ketua(a){
			$('#modalketua').modal({backdrop: 'static',keyboard: false});
					
		}

		function cek_tim(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('TiketNew/cek_tim')}}",
				data: "id="+a,
				success: function(msg){
					$('#modalcektimaudit').modal({backdrop: 'static',keyboard: false});
					$('#tampilcektim').html(msg);
				}
			}); 
		}

		function hapus_tim(id,tiket){
			
			$.ajax({
				type: 'GET',
				url: "{{url('TiketNew/hapus_tim')}}",
				data: "id="+id+"&tiket="+tiket,
				success: function(act){
					$.ajax({
						type: 'GET',
						url: "{{url('TiketNew/tampil_tim')}}",
						data: "id="+act,
						success: function(msg){
							document.getElementById("loadnya").style.width = "0px";
							$('#tampiltim').html(msg);
						}
					});

					$.ajax({
						type: 'GET',
						url: "{{url('TiketNew/cek_tim')}}",
						data: "id="+act,
						success: function(msg){
							$('#tampilcektim').html(msg);
						}
					}); 
				}
			}); 
		}

		function cek_nomor_tiket(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Tiket/cek_nomor_tiket')}}",
				data: "id="+a,
				success: function(msg){
					$('#nomorinformasi').val(msg);
					
				}
			}); 
		}

		function pilih_pengawas(nik,name){
			$('#modaltimaudit').modal('hide');
			$('#pengawas').val('['+nik+']'+name);
			$('#nik_pengawas').val(nik);
		}
		function pilih_aproval(nik,name){
			$('#modalapprovalaudit').modal('hide');
			$('#approval').val('['+nik+']'+name);
			$('#nik_approval').val(nik);
		}
		function tutup_modal_tim(){
			$('#modaltimaudit').modal('hide');
		}
		function pilih_ketua(nik,name){
			$('#modalketua').modal('hide');
			$('#ketua').val('['+nik+']'+name);
			$('#nik_ketua').val(nik);
		}
		function tutup_modal_ketua(){
			$('#modalketua').modal('hide');
		}
		function ubah(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('TiketNew/ubah')}}",
				data: "id="+a,
				success: function(msg){
					$('#modalubah').modal('show');
					$('#tampilubah').html(msg);
					
				}
			}); 
		}

		function tambah_data(){
            var form=document.getElementById('tambah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/TiketNew')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
                    success: function(msg){
                        if(msg=='ok'){
                            location.assign("{{url('/TiketNew')}}");
                               
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
							$('#modalnotif').modal('show');
							document.getElementById("notifikasi").style.width = "100%";
							$('#notifikasi').html(msg);
                        }
                        
                        
                    }
                });

        } 
		function simpan_tim(){
            var form=document.getElementById('tim-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/TiketNew/tim')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
                    success: function(act){
						
                        $.ajax({
							type: 'GET',
							url: "{{url('TiketNew/tampil_tim')}}",
							data: "id="+act,
							success: function(msg){
								document.getElementById("loadnya").style.width = "0px";
								$('#tampiltim').html(msg);
								
								$('#modaltimaudit').modal('hide');
							}
						});

						$.ajax({
							type: 'GET',
							url: "{{url('TiketNew/cek_tim')}}",
							data: "id="+act,
							success: function(msg){
								$('#tampilcektim').html(msg);
								$('#modaltimaudit').modal('hide');
							}
						}); 
                        
                        
                    }
                });

        } 

		function ubah_data(){
            var form=document.getElementById('ubah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/TiketNew/ubah_data')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
                    success: function(msg){
                        if(msg=='ok'){
                            location.reload();
                               
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
							document.getElementById("notifikasiubah").style.width = "100%";
							$('#notifikasiubah').html(msg);
                        }
                        
                        
                    }
                });

        } 

		function hapus(){
            var form=document.getElementById('data-all');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/TiketNew/hapus')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
                    success: function(msg){
                        if(msg=='ok'){
                            location.reload();
                               
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
							alert(msg);
                        }
                        
                        
                    }
                });

        } 
	</script>

@endpush
	
