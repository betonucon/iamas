@extends('layouts.web')
@push('style')
	<link href="{{url('assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />
	<style>
		.colom-px{
			padding:0px;
			vertical-align:top;
		}
		#modal-baca{
			max-width:90%;
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
					<h4 class="panel-title">List Data</h4>
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

					<div class="btn-group btn-group-justified"></div>
					<form id="data-all" enctype="multipart/form-data">
						@csrf
						<table id="myTable" class="table table-striped table-bordered table-td-valign-top">
							<thead>
								<tr>
									<th width="3%"></th>
									<th width="10%" class="text-nowrap">No. Surat</th>
									<th width="18%" class="text-nowrap">Unit Kerja</th>
									<th class="text-nowrap">Obyek</th>
									<th width="7%" class="text-nowrap">Status</th>
									<th width="8%">Kesimpulan</th>
									
									<th width="8%">Rekomendasi</th>
									<th width="9%">Act</th>
									<th width="8%">File</th>
								</tr>
							</thead>
							<tbody>
								@foreach(lha_ketua_get() as $no=>$data)
									<tr class="odd gradeX">
										<td  width="1%">{{$no+1}}</td>
										<td class="boldtd">{{$data->surattugas['nomortiket']}}</td>
										<td>{{$data->unitkerja['name']}}</td>
										<td>{{$data->name}}</td>
										<td style="text-align:center">
											{{$data->stsaudit['name']}}	
										</td>
										@if($data->sts_lha=='0' || $data->sts_lha=='')
											<td><span onclick="proses_kesimpulan(`{{coder($data->id)}}`)" class="btn btn-green btn-xs"><i class="fas fa-pencil-alt"></i> Proses</span></td>
											<td><span onclick="proses_rekomendasi(`{{coder($data->id)}}`,{{kesimpulan_count($data->id)}})" class="btn btn-aqua btn-xs"><i class="fas fa-pencil-alt"></i>  Proses</span></td>
											<td>
												@if($data->sts_file_lha>0)
													<a href="{{url('_file_lampiran/'.$data->file_lha)}}"><span title="Download" class="btn btn-aqua btn-xs"><i class="fa fa-file-word"></i></span></a> |
                                                    <span onclick="sand_lha({{$data->id}})" title="Kirim" class="btn btn-blue btn-xs"><i class="fa fa-share"></i></span>
												@else
													<span onclick="upload_lha({{$data->id}})" title="Upload File LHA" class="btn btn-green btn-xs"><i class="fa fa-upload"></i></span>
												@endif
												@if($data->alasan_lha==null)

												@else
													<span onclick="alasan_revisi(`{{$data->alasan_lha}}`)" title="Alasan Revisi" class="btn btn-yellow btn-xs" style="margin-top:1%"><i class="fa fa-comment"></i></span>
												@endif
											</td>
										@else
											<td><span onclick="proses_kesimpulan(`{{coder($data->id)}}`)" class="btn btn-green btn-xs"><i class="fas fa-pencil-alt"></i> View</span></td>
											<td><span onclick="proses_rekomendasi(`{{coder($data->id)}}`,{{kesimpulan_count($data->id)}})" class="btn btn-aqua btn-xs"><i class="fas fa-pencil-alt"></i>  View</span></td>
											<td>
                                                @if($data->sts_file_lha>0)
													<a href="{{url('_file_lampiran/'.$data->file_lha)}}"><span title="Download" class="btn btn-aqua btn-xs"><i class="fa fa-file-word"></i></span></a>
												@else
													<span onclick="upload_lha({{$data->id}})" title="Upload File LHA" class="btn btn-green btn-xs"><i class="fa fa-upload"></i></span>
												@endif
                                                <span  title="Terkirim" class="btn btn-default btn-xs"><i class="fa fa-check"></i></span>
                                            </td>
										@endif
										<td><span onclick="cek_file_lha({{$data->id}})" class="btn btn-green btn-xs"><i class="fa fa-clone"></i> View</span></td>
										
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

		
		<div class="modal" id="modalsend" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">&nbsp;</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<form id="kirim-data" method="post" enctype="multipart/form-data">
        					@csrf
							<input type="hidden" name="audit_id" id="audit_id">
							<div class="note note-warning note-with-right-icon m-b-15">
								<div class="note-content text-right">
									<h4><b>Notifikasi</b></h4>
									<p>
									  Jika melakukan proses kirim kepengawas, ketua dan anggota tidak dapat merubah atau menambahkan kesimpulan dan rekomendasi
									</p>
								</div>
								<div class="note-icon"><i class="fa fa-lightbulb"></i></div>
							</div>
						</form>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="send_data()" >Kirim</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalupload" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">&nbsp;</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<form id="upload-data" method="post" action="{{url('/Lha/upload_data')}}" enctype="multipart/form-data">
        					@csrf
							<input type="hidden" name="audit_id" id="audit_ide">
							<div class="form-grup">
								<label>Upload File LHA</label>
								<input type="file" name="file" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-control">
							</div>
							<!-- <input type="submit"> -->
						</form>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="upload_data()" >Upload</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalalasan" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">&nbsp;</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						
							<div class="note note-warning note-with-right-icon m-b-15">
								<div class="note-content">
									<h4><b>Alasan</b></h4>
									<p id="alasan_revisi"></p>
								</div>
								
							</div>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" data-dismiss="modal" >Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalview" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">view Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="tampilview"></div>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal" id="modalfile" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" id="modal-baca">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Laporan LHA</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body" >
						
							<div id="tampilfile" style="height:420px;overflow-y:scroll"></div>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
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
			responsive: false,
			paging: true,
			info: true,
			ordering:false,
			lengthChange: false,
		} );

		
		function proses_kesimpulan(id){
			location.assign("{{url('/Lha/Create')}}?id="+id+"&halaman=Lhaketua");
		}
		function sand_lha(id){
			$('#audit_id').val(id);
			$('#modalsend').modal('show');
		}
		function upload_lha(id){
			$('#audit_ide').val(id);
			$('#modalupload').modal('show');
		}
		function alasan_revisi(id){
			$('#alasan_revisi').html(id);
			$('#modalalasan').modal('show');
		}
		function proses_rekomendasi(id,nilai){
			if(nilai==0){
				alert('Buat Kesimpulan terlebih dahulu');
			}else{
				location.assign("{{url('/Lha/Createrekomendasi')}}?id="+id+"&halaman=Lhaketua");
			}
		}

		function edit(a){
			location.assign("{{url('/Lha/Edit')}}?id="+a);
		}

		
		function cek_file_lha(a){
			$('#modalfile').modal('show');
			$('#tampilfile').html("<iframe src='{{url('Lha/view')}}?id="+a+"' width='100%' height='600px'></iframe>");
		}

		function send_to(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Lha/send_to_head')}}",
				data: "id="+a,
				success: function(msg){
					location.reload();
				}
			}); 
		}

		
		function view_data(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Lha/view')}}",
				data: "id="+a,
				success: function(msg){
					$('#modalview').modal('show');
					$('#tampilview').html(msg);
					
				}
			}); 
		}

		

		function hapus(){
            var form=document.getElementById('data-all');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Lha/hapus')}}",
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
		function send_data(){
            var form=document.getElementById('kirim-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Lha/send_data')}}",
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
		function upload_data(){
            var form=document.getElementById('upload-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Lha/upload_data')}}",
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
	
