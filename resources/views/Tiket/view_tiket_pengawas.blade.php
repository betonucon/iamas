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
					<h4 class="panel-title">Approve Tiket</h4>
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

						<form id="tambah-data" action="{{url('/TiketNew/Edit')}}" method="post" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="id" value="{{$data->id}}">
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a href="#default-tab-0" data-toggle="tab" class="nav-link active">
										<span class="d-sm-none">Tab 0</span>
										<span class="d-sm-block d-none">Penyelesaian</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="#default-tab-1" data-toggle="tab" class="nav-link">
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
						
								<div class="tab-pane fade active show" id="default-tab-0">
								@if($data->kode_aktivitas=='03')
									@if($data->kode_sumber=='AR')	

									@else
											<table class="table table-bordered m-b-0">
												<thead>
													<tr>
														<th class="tth" width="5%">No</th>
														<th class="tth"  width="30%">Judul</th>
														<th class="tth" >Tujuan</th>
														<th  class="tth" width="15%">Tingkat</th>
														<th  class="tth" width="20%">Kodifikasi</th>
													</tr>
												</thead>
												<tbody>
												@foreach(judul_get($data->id) as $no=>$o)
													
													<tr>
														<td style="vertical-align:top">{{($no+1)}}</td>
														<td style="vertical-align:top">{{$o['judul']}}</td>
														<td style="vertical-align:top">{!!$o['tujuan']!!}</td>
														<td style="vertical-align:top">{{$o['risiko']}}</td>
														<td style="vertical-align:top">
															<select name="kodifikasi[{{$o->id}}]" >
																<option value="">Pilih Kodifikasi</option>';
																@foreach(kodefikasi_get() as $kodefikasi)
																	
																	<option value="{{$kodefikasi['kodifikasi']}}">[{{$kodefikasi['kodifikasi']}}] {{$kodefikasi['kategori']}}</option>
																@endforeach
															
															</select>
														</td>
													</tr>
												@endforeach   
												</tbody>
											</table>
									@endif
								@else
										<div class="col-xl-10 offset-xl-1">
											<div class="form-group row m-b-10" >
												<label class="col-lg-3 text-lg-right col-form-label">Kode Laporan & Lampiran</label>
												<div class="col-lg-9 col-xl-8">
												<select class="form-control" name="kode_laporan" >
													<option value="">Pilih Kode Laporan </option>';
													@foreach(kodifikasilaporan_get($data->kode_aktivitas) as $kodifikasilaporan_get)
														
													<option value="{{$kodifikasilaporan_get['kode']}}" >[{{$kodifikasilaporan_get['kode']}}] {{$kodifikasilaporan_get['name']}}</option>
													@endforeach
												</select>
												</div>
												
											</div>
											<div class="form-group row m-b-10" >
												<label class="col-lg-3 text-lg-right col-form-label">Kodifikasi</label>
												<div class="col-lg-9 col-xl-6">
													<select class="form-control" name="kodifikasi" >
														<option value="">Pilih Kodifikasi</option>';
														@foreach(kodefikasi_get() as $kodefikasi)
															
															<option value="{{$kodefikasi['kodifikasi']}}">[{{$kodefikasi['kodifikasi']}}] {{$kodefikasi['kategori']}}</option>
														@endforeach
													
													</select>
												</div>
											</div>
											<div class="form-group row m-b-10" >
												<label class="col-lg-3 text-lg-right col-form-label">Judul</label>
												<div class="col-lg-9 col-xl-9">
													<input type="text" class="form-control"  disabled name="judul" value="{{$data->judul_laporan}}"  placeholder="Enter text ...">
												</div>
											</div>
											<div class="form-group row m-b-10" >
												<label class="col-lg-3 text-lg-right col-form-label">Isi</label>
												<div class="col-lg-9 col-xl-9">
													<textarea class="textarea form-control" name="keterangan" disabled id="textareatiket" placeholder="Enter text ..." rows="12">{!!$data->keterangan_laporan!!}</textarea>
												</div>
											</div>
											
										</div>

								@endif
								</div>
								<div class="tab-pane fade" id="default-tab-1">
									<div class="col-xl-12">
										<div class="form-group">
											<label for="exampleInputEmail1">Aktivitas</label>
											<select class="form-control" disabled  onchange="pilih_aktivitas()" id="kode_aktivitas">
												<option value="">Pilih Aktivitas</option>
												@foreach(aktivitas_get() as $aktifitas)
													
													<option value="{{$aktifitas['kode']}}" @if($data->kode_aktivitas==$aktifitas['kode']) selected @endif >[{{$aktifitas['kode']}}] {{$aktifitas['name']}}</option>
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
															<input type="text" disabled   value="[{{$data->nomorinformasi}}] {{$data->judul}}" class="form-control">
														</div>
														
													</div>
												</td>
												<td width="30%">
													
												</td>
											</tr>
										</table>
									</div>
									
										
									
									<div class="col-xl-12">
										<div class="form-group">
											<label for="exampleInputEmail1">Judul</label>
											<input type="text" class="form-control" disabled value="{{$data->judul_tiket}}" name="judul" placeholder="Enter text ...">
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1">Isi</label>
											<textarea class="textarea form-control" disabled name="keterangan" id="textareatiket" placeholder="Enter text ..." rows="8">{!!$data->keterangan_tiket!!}</textarea>
										</div>
									</div>
								</div>
								
								<div class="tab-pane fade" id="default-tab-2">
									<div class="col-xl-10 offset-xl-1">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Obyek Audit /Non Audit</label>
											<div class="col-lg-9 col-xl-9">
												<input type="text" class="form-control" disabled value="{{$data->surattugas['name']}}" name="name"  placeholder="Ketik...">
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Unit Kerja</label>
											<div class="col-lg-9 col-xl-6">
												<select class="default-select2 form-control" disabled placeholder="Pilih Unit Kerja">
													<option value="">--Pilih Unit Kerja</option>
													@foreach(unitkerja_get() as $no=>$unitkerja_get)
														<option value="{{$unitkerja_get->kode_unit}}" @if($data->surattugas['kode_unit']==$unitkerja_get->kode_unit) selected @endif>{{ucwords($unitkerja_get->name)}}</option>
													@endforeach
													
												</select>
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Katagori Audit</label>
											<div class="col-lg-9 col-xl-9">
												<select class="default-select2 form-control" disabled  placeholder="Pilih Unit Kerja">
													<option value="">--Pilih Katagori Audit</option>
													@foreach(kodesurat_get() as $no=>$kodesurat_get)
														<option value="{{$kodesurat_get->kode}}" @if($data->surattugas['kode']==$kodesurat_get->kode) selected @endif>[{{$kodesurat_get->kode}}] {{ucwords($kodesurat_get->keterangan)}}</option>
													@endforeach
													
												</select>
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Tanggal (Mulai & Sampai)</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" disabled name="mulai" value="{{$data->surattugas['mulai']}}" id="tanggalpicker" placeholder="Ketik...">
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" disabled name="sampai"  value="{{$data->surattugas['sampai']}}" id="tanggalpicker2" placeholder="Ketik...">
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Catatan Penting</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" disabled name="catatan" id="textareacatatan" placeholder="Enter text ..." rows="8">{!!$data->surattugas['catatan']!!}</textarea>
											</div>
											
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-3">
									<div class="col-xl-10 offset-xl-1">
										<div class="form-group row m-b-10">
											<label class="col-lg-3 text-lg-right col-form-label">Pengawas</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group m-b-10">
													<div class="input-group-prepend" ><span class="input-group-text"><i class="fa fa-user"></i></span></div>
													<input type="text" class="form-control" disabled id="pengawas" value="{{pengawas($data->id)->user['name']}}" placeholder="Ketik...">
													<input type="hidden" class="form-control" name="nik[]" value="{{pengawas($data->id)['nik']}}" id="nik_pengawas"  placeholder="Username">
													<input type="hidden" class="form-control" name="role[]" value="2" placeholder="Username">
												</div>
											</div>
											
										</div>
										<div class="form-group row m-b-10">
											<label class="col-lg-3 text-lg-right col-form-label">Ketua TIM</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group m-b-10">
													<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
													<input type="text" class="form-control" disabled id="ketua" value="{{ketua($data->id)->user['name']}}" placeholder="Ketik...">
													<input type="hidden" class="form-control" name="nik[]" value="{{ketua($data->id)['nik']}}" id="nik_ketua" placeholder="Username">
													<input type="hidden" class="form-control" name="role[]" value="1" placeholder="Username">
												</div>
											</div>
											
										</div>
										<div class="form-group row m-b-10">
											<label class="col-lg-3 text-lg-right col-form-label">Anggota</label>
											<div class="col-lg-9 col-xl-9">
												<select class="multiple-select2 form-control" disabled name="nik[]" multiple="multiple">
													<optgroup label="Pilih Anggota">
													
														@foreach(katua_get() as $no=>$src_get)
															<option value="{{$src_get->nik}}" @if(anggota($data->id,$src_get->nik)>0) selected @endif > {{ucwords($src_get->name)}}</option>
														@endforeach
													
													
													</optgroup>
												</select>
											</div>
										</div>
										
									</div>
									
								</div>
								
								<div class="modal-footer">
									@if($data->surattugas['sts']==3)
									<a href="javascript:;" class="btn btn-blue" onclick="approve()">Approve</a>
									@endif
									<a href="javascript:;" class="btn btn-red" onclick="sebelumnya()">Kembali</a>
								</div>
							</div>
							
						</form>

				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
			
		</div>
		
	</div>
	<div class="row">

		<div class="modal" id="modalapprove" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Approve Tiket</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="alert alert-success fade show m-b-0">
							<span class="close" data-dismiss="alert">×</span>
							<strong>Notifikasi!</strong>
							 Yakin menyetuji data dan melajutkan ke tahap berikutnya?
						</div>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="tambah_data()">Approve</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" id="modallampiran" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Lampiran</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubah"></div>
						<form id="ubah-data" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="id" value="{{$data->id}}">
							<input type="hidden" name="nomortiket" value="{{$data->nomortiket}}">
							<div class="form-group">
								<label>File Lampiran</label>
								<input type="file" name="lampiran" class="form-control">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="ubah_data()">Simpan</a>
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
		
		<div class="modal" id="modallampiran" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog" style="margin-top:0px">
				<div class="modal-content">
					<div class="modal-header">
						<h5>Ubah Lampiran</h5>
						
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

		
		

		function approve(){
			$('#modalapprove').modal('show');
		}
		function ceklis_judul(a,no){
			if(a==''){

			}else{
				alert(a)
				$(".ceklisnya"+no).prop('checked');
			}
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

		

		function cek_revisi(a){
			$('#modalrevisi').modal('show');
			$('#tampilrevisi').html(a);
		}

		function cek_file(a){
			$('#modalfile').modal('show');
			$('#tampilfile').html("<iframe src='{{url('_file_lampiran')}}/"+a+"' width='100%' height='600px'></iframe>");
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

		

		function tambah_data(){
            var form=document.getElementById('tambah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/AccTiketPengawas')}}",
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
							$('#modalnotif').modal('show');
							document.getElementById("notifikasi").style.width = "100%";
							$('#notifikasi').html(msg);
                        }
                        
                        
                    }
                });

        } 

		function ubah_data(){
            var form=document.getElementById('ubah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/TiketNew/Editlampiran')}}",
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
							$('#modalnotif').modal('show');
							document.getElementById("notifikasi").style.width = "100%";
							$('#notifikasi').html(msg);
                        }
                        
                        
                    }
                });

        } 
		
	</script>

@endpush
	
