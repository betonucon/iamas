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
					<h4 class="panel-title">Create</h4>
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
							<a href="javascript:;"  onclick="tambah()" class="nav-link active">
								<span class="d-sm-none"><span class="btn btn-blue btn-sm">Tambah Pokok Materi</span></span>
								<span class="d-sm-block d-none"><span class="btn btn-blue btn-sm">Tambah Pokok Materi</span></span>
							</a>
						</li>
					</ul>
					<div class="tab-content" style="margin-bottom:0px;padding:1%">

						<div class="tab-pane fade active show" id="default-tab-1">
							
								<div class="panel-body">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th width="5%" class="text-nowrap">No</th>
												<th width="25%" class="text-nowrap">Pokok Materi</th>
												<th class="text-nowrap">Langkah Kerja</th>
												
											</tr>
											@foreach($program as $no=>$prog)
												<tr>
													<td>{{$no+1}}</td>
													<td>
														<p>
															<span class="btn btn-blue btn-xs" onclick="ubah_materi({{$prog->id}})"><i class="fas fa-pencil-alt fa-fw"></i></span>
															<span class="btn btn-red btn-xs" onclick="hapus_materi({{$prog->id}})"><i class="fa fa-times-circle"></i></span>
														</p>	
														{{$prog->name}}
													</td>
													<td>
														<table class="table table-bordered">
															<thead>
																<tr>
																	<th width="5%"><span class="btn btn-blue btn-xs" onclick="tambahlangkah({{$prog->id}})">Tambah</span></th>
																	<th width="3%" class="text-nowrap">No</th>
																	<th class="text-nowrap">Langkah Kerja</th>
																	<th width="15%" class="text-nowrap">Tanggal</th>
																	
																</tr>
															</thead>
															<tbody>
																@foreach(langkah_deskaudit($prog->id) as $la=>$langkah)
																	<tr>
																		<td><span class="btn btn-red btn-xs" onclick="hapus_langkah({{$langkah->id}})"><i class="fa fa-times-circle"></i></span></td>
																		<td>{{$la+1}}</td>
																		<td>{{$langkah->name}}</td>
																		<td>{{$langkah->tanggal}}</td>
																	</tr>
																@endforeach
															</tbody>
														</table>

													</td>
												</tr>
											@endforeach
										</thead>
									</table>
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
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tambah Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasi"></div>
						<form id="tambah-data" action="{{url('/Deskaudit')}}" method="post" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="audit_id" id="audit_id" value="{{$data->id}}">
							<div class="col-xl-10 offset-xl-1">
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label"> Pokok Materi</label>
									<div class="col-lg-9 col-xl-9">
										<textarea class="form-control" name="name" id="textareatiket" placeholder="Enter text ..." ></textarea>
									</div>
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
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasi-ubah"></div>
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

		<div class="modal" id="modaltambahlangkah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tambah Langkah Kerja</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasi-langkah" class="notifnya"></div>
						<form id="tambah-langkah" action="{{url('/Deskaudit/langkah')}}" method="post" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="deskaudit_id" id="deskaudit_id" >
							<div class="col-xl-10 offset-xl-1">
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label"> Langkah Kerja</label>
									<div class="col-lg-9 col-xl-9">
										<textarea class="form-control" name="name" id="name"  placeholder="Enter text ..." ></textarea>
									</div>
								</div>
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label">Tanggal</label>
									<div class="col-lg-9 col-xl-3">
										<input type="text" class="form-control" readonly name="tanggal"  id="tgl_langkahkerja" placeholder="Enter text ..." >
									</div>
									
								</div>
								
							</div>
							
						</form>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="tambah_langkah()">Simpan</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
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
	<script>
		$(document).ready(function() {
            $('#tgl_langkahkerja').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $.ajax({
				type: 'GET',
				url: "{{url('Deskaudit/tampil_langkah_kerja')}}",
				data: "id={{$data->id}}",
				success: function(msg){
					$('#tampil-langkah').html(msg);
				}
			}); 
        });

		function ubah_materi(a){
			$.ajax({
				type: 'GET',
				url: "{{url('Deskaudit/ubah_pokok')}}",
				data: "id="+a,
				success: function(msg){
					$('#modalubah').modal('show');
					$('#tampilubah').html(msg);
				}
			});
		}

		function hapus_materi(a){
			$.ajax({
				type: 'GET',
				url: "{{url('Deskaudit/hapus_pokok')}}",
				data: "id="+a,
				success: function(msg){
					location.reload();
				}
			});
		}

		function hapus_langkah(a){
			$.ajax({
				type: 'GET',
				url: "{{url('Deskaudit/hapus_langkah')}}",
				data: "id="+a,
				success: function(msg){
					location.reload();
				}
			});
		}

		function tambah(){
			$('#modaltambah').modal('show');
		}
		function tambahlangkah(a){
			$('#deskaudit_id').val(a);
			$('#modaltambahlangkah').modal('show');
		}

		$("#textareatiket").wysihtml5();
		$('#myTable').DataTable( {
			responsive: true,
			paging: true,
			info: true,
			lengthChange: false,
		} );

		
		function tambah_data(){
            var form=document.getElementById('tambah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Deskaudit')}}",
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

		function tambah_langkah(){
			
            var form=document.getElementById('tambah-langkah');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Deskaudit/langkah')}}",
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
							document.getElementById("notifikasi-langkah").style.width = "100%";
							$('#notifikasi-langkah').html(msg);
                        }
                        
                        
                    }
                });

        } 

		function ubah_data(){
			
            var form=document.getElementById('ubah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Deskaudit/Update')}}",
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
							document.getElementById("notifikasi-ubah").style.width = "100%";
							$('#notifikasi-ubah').html(msg);
                        }
                        
                        
                    }
                });

        }
		
		
		
	</script>

@endpush
	
