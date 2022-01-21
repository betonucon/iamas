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
								<span class="d-sm-none">DRAFT PEMERIKAAN</span>
								<span class="d-sm-block d-none">DRAFT PEMERIKAAN</span>
							</a>
						</li>
					</ul>
					<div class="tab-content" style="margin-bottom:0px;padding:1%">

						<div class="tab-pane fade active show" id="default-tab-1">
							
								<div class="panel-body" style="overflow: auto;">
									<div class="col-xl-12 col-lg-6">
								
										<div class="m-b-10 m-t-10 f-s-10">
											<a href="#modal-widget-list" class="pull-right text-grey-darker m-r-3 f-w-700" data-toggle="modal">source code</a>
											<b class="text-inverse">WIDGET LIST</b>
										</div>
										<div class="widget-list widget-list-rounded m-b-30" data-id="widget">
											<!-- begin widget-list-item -->
											<div class="widget-list-item">
												<div class="widget-list-media">
													<img src="{{url('img/file.png')}}" alt="" class="rounded">
												</div>
												<div class="widget-list-content">
													<h4 class="widget-list-title">DESKAUDIT</h4>
													<p class="widget-list-desc">Deskaudit Langkah Kerja dan Catatan</p>
												</div>
												<div class="widget-list-content">
													<h4 class="widget-list-title">DESKAUDIT</h4>
													<p class="widget-list-desc">Deskaudit Langkah Kerja dan Catatan</p>
												</div>
												<div class="widget-list-action">
													<a href="{{url('/Deskaudit/Catatanhead?id='.coder($data->id))}}"  class="text-muted pull-right"><i class="fa fa-ellipsis-h f-s-14"></i></a>
												</div>
												
											</div>
											
										</div>
									</div>
								</div>	
						</div>
						<!-- <div class="modal-footer">
							@if($data->sts_compliance==1)
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
				url: "{{url('compliance/tampil_langkah_kerja')}}",
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
				url: "{{url('compliance/Isicatatan')}}",
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
                    url: "{{url('/compliance/proses_catatan')}}",
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
	
