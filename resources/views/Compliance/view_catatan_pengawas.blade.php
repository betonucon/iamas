@extends('layouts.web')
@push('style')
	<link href="{{url('assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />
	<style>
		label {
			display: inline-block;
			margin-bottom: 0px !important;
			font-weight: bold;
		}
		th{
			background:aqua;
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
					<h4 class="panel-title">Catatan</h4>
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
							<a href="javascript:;"  class="nav-link active">
								<span class="d-sm-none">COMPLIANCE CATATAN</span>
								<span class="d-sm-block d-none">COMPLIANCE CATATAN</span>
							</a>
						</li>
					</ul>
					<div class="tab-content" style="margin-bottom:0px;padding:1%">

						<div class="tab-pane fade active show" id="default-tab-1">
							
								<div class="panel-body" style="overflow: auto;">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th width="3%" class="text-nowrap">No</th>
												<th width="10%" class="text-nowrap">Pokok Materi</th>
												<th class="text-nowrap">Langkah Kerja</th>
												
											</tr>
											@foreach($program as $no=>$prog)
												<tr>
													<td>{{$no+1}}</td>
													<td>{{$prog->name}}</td>
													<td>
														<table class="table table-bordered">
															<thead>
																<tr>
																	<th width="3%" class="text-nowrap">No</th>
																	<th width="22%" class="text-nowrap">Langkah Kerja</th>
																	<th width="55%">Catatan</th>
																	<th width="17%" class="text-nowrap">Tanggal</th>
																	
																</tr>
															</thead>
															<tbody>
																@foreach(langkah_compliance($prog->id) as $la=>$langkah)
																	<tr>
																		<td>{{$la+1}}</td>
																		<td>{{$langkah->name}}</td>
																		<td style="width:300px">
																			@if($langkah->catatan=='')
																				<font color="aqua">Belum diisi</font>
																			@else
																				{!!$langkah->catatan!!}
																			@endif
																		</td>
																		<td><b><u>RENCANA</u></b><br>{{$langkah->tanggal}}<br><b><u>AKTUAL</u></b><br>{{$langkah->tanggal_aktual}}</td>
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
						<div class="modal-footer">
							@if($data->sts_compliance==3)
							<a href="javascript:;" class="btn btn-blue" onclick="approve()">Approve</a>
							@endif
							<a href="javascript:;" class="btn btn-red" onclick="sebelumnya()">Kembali</a>
						</div>
						
					</div>
					
						

				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
			
		</div>
		
	</div>
	<div class="row">

		<div class="modal" id="modalubah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Approve</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubah"></div>
						<form id="ubah-data" enctype="multipart/form-data">
							@csrf
							<input type="hidden"  name="id" value="{{$data->id}}">
							<div class="form-group">
								<label for="exampleInputEmail1">Status</label>
								<select class="form-control" name="sts"  onchange="cek_status(this.value)">
									<option value="">Pilih Status</option>
									<option value="1">Setujui</option>
									<option value="2">Kembalikan</option>
								</select>
							</div>
							<div class="form-group" id="alasan">
								<label for="exampleInputEmail1">Alasan</label>
								<textarea class="form-control" name="alasan"></textarea>
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
            $('#tgl_langkahkerja2').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $.ajax({
				type: 'GET',
				url: "{{url('Compliance/tampil_langkah_kerja')}}",
				data: "id={{$data->id}}",
				success: function(msg){
					$('#tampil-langkah').html(msg);
				}
			}); 
        });

		$('#alasan').hide();
		
		function cek_status(a){
			if(a=='2'){
				$('#alasan').show();
			}else if(a=='3'){
				$('#alasan').hide();
			}else{
				$('#alasan').hide();
			}
		}

		function approve(a){
			$('#audit_id').val(a);
			$('#modalubah').modal('show');
		}

		
		$('#myTable').DataTable( {
			responsive: true,
			paging: true,
			info: true,
			lengthChange: false,
		} );

		function ubah_data(){
            var form=document.getElementById('ubah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Compliance/proses_approve_catatan_pengawas')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
                    success: function(msg){
                        if(msg=='ok'){
                            location.assign("{{url('/Compliancecatatanpengawas')}}");
                               
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
							document.getElementById("notifikasiubah").style.width = "100%";
							$('#notifikasiubah').html(msg);
                        }
                        
                        
                    }
                });

        }
		
		
	</script>

@endpush
	
