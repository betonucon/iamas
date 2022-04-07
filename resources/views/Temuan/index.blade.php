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
									<th width="18%" class="text-nowrap">Unit Kerja</th>
									<th width="10%" class="text-nowrap">Kode Temuan</th>
									<th width="6%" class="text-nowrap">Nomor</th>
									<th width="10%" class="text-nowrap">Risiko</th>
									<th class="text-nowrap">Judul</th>
									<th width="17%" class="text-nowrap">Traking Status</th>
									<th width="5%" class="text-nowrap">Act</th>
								</tr>
							</thead>
							<tbody>
								@foreach(temuan_auditee_get() as $no=>$data)
									<tr class="odd gradeX">
										<td  width="1%">{{$no+1}}</td>
										<td>{{$data->unitkerja['name']}}</td>
										<td class="boldtd">{{$data->kesimpulan['nomorkode']}}</td>
										<td>{{$data->nomor}}.{{$data->urutan}}</td>
										<td>{{$data->ket_risiko}}</td>
										<td>{{$data->kesimpulan['name']}}</td>
										<td style="text-align:center"><b>({{$data->sts_tl}})</b> {{track_temuan_auditee($data->sts)}}</td>
										<td>
											@if($data->sts==1)
												<span class="btn btn-blue btn-xs" onclick="proses(`{{coder($data->id)}}`)"><i class="fa fa-pencil-alt"></i></span>
											@else
												@if($data->sts==6)
													<span class="btn btn-success btn-xs" title="Selesai" onclick="proses(`{{coder($data->id)}}`)"><i class="fa fa-check"></i></span>
												@else
													<span class="btn btn-white btn-xs"  title="Proses Pemeriksaan" onclick="proses(`{{coder($data->id)}}`)"><i class="fa fa-clipboard"></i></span>
												@endif
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

		
		function proses(id){
			location.assign("{{url('/Temuan/proses')}}?id="+id);
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
				location.assign("{{url('/Lha/Createrekomendasi')}}?id="+id);
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
	
