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
				<div class="panel-body">

					<div class="btn-group btn-group-justified text-with">
						<!-- <a class="btn btn-primary active" onclick="tambah()">Tambah </a> -->
						<!-- <a class="btn btn-danger active" onclick="hapus()">Hapus</a> -->
					</div>
					<form id="data-all" enctype="multipart/form-data">
						@csrf
						<table id="myTable" class="table table-striped table-bordered table-td-valign-middle">
							<thead>
								<tr>
									<th width="1%"></th>
									<th width="1%" data-orderable="false"></th>
									<th width="10%" class="text-nowrap">No Tiket</th>
									<th class="text-nowrap">Judul</th>
									<th class="text-nowrap">Sumber</th>
									<th width="3%" class="text-nowrap">file</th>
									<th width="3%" class="text-nowrap">Tim</th>
									<th width="9%" class="text-nowrap">Status</th>
									<th width="3%" class="text-nowrap">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach(tiket_get_pengawas() as $no=>$data)
									<tr class="odd gradeX">
										<td width="1%" class="f-s-600 text-inverse">{{$no+1}}</td>
										<td width="1%" class="with-img"><input value="{{$data->id}}" type="checkbox" name="id[]"></td>
										<td>{{$data->nomortiket}}</td>
										<td>{{$data->judul_tiket}}</td>
										<td>[{{$data->nomorinformasi}}] {{$data->sumber['name']}}</td>
										<td><span onclick="cek_file(`{{$data->lampiran_tiket}}`)" class="btn btn-yellow btn-xs"><i class="fa fa-clone"></i></span></td>
										<td><span onclick="cek_tim({{$data->id}})" class="btn btn-blue btn-xs"><i class="fa fa-user"></i></span></td>
										<td>
											@if($data->sts==3)
												<font color="red">On Proses</font>
											@endif
											@if($data->sts==4)
												<font color="blue">Selesai</font>
											@endif
											
										</td>
										<td>
											@if($data->sts==4)
											<font color="blue">Ok</font>
											@else
												<span onclick="ubah({{$data->id}})" class="btn btn-purple active btn-xs"><i class="fas fa-edit fa-sm"></i></span> 
											@endif
											
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
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
					<div class="modal-body">
						
						<form id="tambah-data" action="{{url('Tiket')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="col-xl-12">
								<table width="100%">
									<tr>
										<td>
											<div class="form-group">
												<label for="exampleInputEmail1">Sumber Infomasi</label>
												<div class="input-group">
													<div class="input-group-prepend"><span class="input-group-text" onclick="pilih_sumber()">Plih Sumber</span></div>
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
							<div class="col-xl-12" style="margin-top:1%"">	
								<div class="hljs-wrapper" id="tampiltim">
									
						    	</div>	
						    </div>	
							
							<div class="col-xl-12">
								<div class="form-group">
									<label for="exampleInputEmail1">Judul</label>
									<input type="text" class="form-control" name="judul" placeholder="Enter text ...">
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">Isi</label>
									<textarea class="textarea form-control" name="keterangan" id="wysihtml5" placeholder="Enter text ..." rows="8"></textarea>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="tambah_data()">Simpan</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" id="modalubah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
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
		<div class="modal" id="modaltimaudit" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog" style="max-width:50%">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tim Audit</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
					    <form id="tim-data" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="tim_id" id="tim_id">
							<input type="hidden" name="role_id" id="role_id">
							<table class="table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline collapsed" border="1">
								<tr>
									<th>No</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Jabatan</th>
								</tr>
								@foreach(src_get() as $no=>$src_get)
									<tr>
										<td><input type="checkbox" name="nik[]" value="{{$src_get->nik}}"></td>
										<td>{{$src_get->nik}}</td>
										<td>{{$src_get->name}}</td>
										<td>{{$src_get->posisi['name']}}</td>
									</tr>
								@endforeach
							</table>
						</form>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-primary" onclick="simpan_tim()">Simpan</a>
						<a href="javascript:;" class="btn btn-white" onclick="tutup_modal_tim()">Tutup</a>
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
		$('#myTable').DataTable( {
			responsive: true,
			paging: true,
			info: true,
			lengthChange: false,
		} );

		
		function tambah(){
			$('#modaltambah').modal({backdrop: 'static',keyboard: false});
		}

		function pilih_sumber(){
			$('#modalsumber').modal('show');
		}
		function tutup_notif(){
			$('#modalnotif').modal('toggle');
		}
		function tutup_sumber(){
			$('#modalsumber').modal('toggle');
		}

		function cek_pilih_sumber(a,id){
			$('#sumbernya').val(a);
			$('#tiket_id').val(id);
			$.ajax({
				type: 'GET',
				url: "{{url('TiketNew/tampil_tim')}}",
				data: "id="+id,
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

		function tutup_modal_tim(){
			$('#modaltimaudit').modal('hide');
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
                    url: "{{url('/Tiket/ubah_data')}}",
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
	
