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
								<span class="d-sm-none">DESKAUDIT CATATAN</span>
								<span class="d-sm-block d-none">DESKAUDIT CATATAN</span>
							</a>
						</li>
					</ul>
					<div class="tab-content" style="margin-bottom:0px;padding:1%">

						<div class="tab-pane fade active show" id="default-tab-1">
								{!! $label !!}
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
																	<th width="3%">File</th>
																	<th width="55%">Catatan</th>
																	<th width="17%" class="text-nowrap">Tanggal</th>
																	
																</tr>
															</thead>
															<tbody>
																@foreach(langkah_deskaudit($prog->id) as $la=>$langkah)
																	<tr>
																		<td>{{$la+1}}</td>
																		<td>{{$langkah->name}}</td>
																		<td><span class="btn btn-green btn-xs" onclick="lihat_file(`{{$langkah->file}}`)"><i class="fas fa-file fa-fw"></i></span></td>
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
						<!-- <div class="modal-footer">
							@if($data->sts_deskaudit==1)
							<a href="javascript:;" class="btn btn-blue" onclick="approve()">Approve</a>
							@endif
							<a href="javascript:;" class="btn btn-red" onclick="sebelumnya()">Kembali</a>
						</div> -->
						
					</div>
					
						

				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
			
		</div>
		
	</div>
	<div class="row">

		<div class="modal" id="modalcatatan" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-lg" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Catatan</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubah"></div>
						<form id="ubah-data" enctype="multipart/form-data">
							@csrf
							<input type="hidden"  name="id" id="kode">
							<div id="isi-catatan"></div>
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
				url: "{{url('Deskaudit/tampil_langkah_kerja')}}",
				data: "id={{$data->id}}",
				success: function(msg){
					$('#tampil-langkah').html(msg);
				}
			}); 
        });
		function lihat_file(file){
			window.open("{{url('_file_lampiran')}}/"+file,"_blank");
		}

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

		function isi_catatan(a){
			$('#kode').val(a);
			$.ajax({
				type: 'GET',
				url: "{{url('Deskaudit/Isicatatan')}}",
				data: "id="+a,
				success: function(msg){
					$('#isi-catatan').html(msg);
					$('#modalcatatan').modal('show');
				}
			}); 
			
		}

		$("#textareatiket2").wysihtml5({
			locale: 'zh-TW',
			name: 't-iframe',
			events: {
				load: function(){
					var $body = $(this.composer.element);
					var $iframe = $(this.composer.iframe);
					iframeh = Math.max($body[0].scrollHeight, $body.height()) + 300;
					document.getElementsByClassName('wysihtml5-sandbox')[0].setAttribute('style','height: ' + iframeh +'px !important');
				},change: function(){
					var $abody = $(this.composer.element);
					var $aiframe = $(this.composer.iframe);
					aiframeh = Math.max($abody[0].scrollHeight, $abody.height()) + 300;
					document.getElementsByClassName('wysihtml5-sandbox')[0].setAttribute('style','height: ' + aiframeh +'px !important');
				}
			}
		});
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
                    url: "{{url('/Deskaudit/proses_catatan')}}",
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
		
		
	</script>

@endpush
	
