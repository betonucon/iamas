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
					<h4 class="panel-title">View </h4>
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

						<form id="tambah-data" action="{{url('/Lha/Update')}}" method="post" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="id" value="{{$lha->id}}">
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a href="#default-tab-1" data-toggle="tab" class="nav-link active">
										<span class="d-sm-none">LATAR BELAKANG</span>
										<span class="d-sm-block d-none">LATAR BELAKANG</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="#default-tab-2" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">SASARAN</span>
										<span class="d-sm-block d-none">SASARAN</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="#default-tab-3" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">RUANG LINGKUP</span>
										<span class="d-sm-block d-none">RUANG LINGKUP</span>
									</a>
								</li> 
								<li class="nav-item">
									<a href="#default-tab-4" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">PELAKSANAAN</span>
										<span class="d-sm-block d-none">PELAKSANAAN</span>
									</a>
								</li> 
								<li class="nav-item">
									<a href="#default-tab-5" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">KESIMPULAN</span>
										<span class="d-sm-block d-none">KESIMPULAN</span>
									</a>
								</li> 
								<li class="nav-item">
									<a href="#default-tab-6" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">PENJELASAN</span>
										<span class="d-sm-block d-none">PENJELASAN</span>
									</a>
								</li> 
								<li class="nav-item">
									<a href="#default-tab-7" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">PENUTUP</span>
										<span class="d-sm-block d-none">PENUTUP</span>
									</a>
								</li> 
								
							</ul>
							<div class="tab-content" style="margin-bottom:0px;padding:1%">
						
								<div class="tab-pane fade active show" id="default-tab-1">
									<div class="col-xl-10 offset-xl-1">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label"> Audit</label>
											<div class="col-lg-9 col-xl-9">
												<select class="default-select2 form-control" name="audit_id"  >
													<option value="">Pilih Audit</option>
													@foreach(audit_lha_get() as $audit_lha_get)
														
														<option value="{{$audit_lha_get['id']}}" @if($lha->audit_id==$audit_lha_get['id']) selected @endif>[{{$audit_lha_get['nomorsurat']}}] {{$audit_lha_get['name']}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label"> Latar Belakang</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" name="latar_belakang" id="textarealatarbelakang" placeholder="Enter text ..." rows="8">{!!$lha->latar_belakang!!}</textarea>
											</div>
										</div>
										
									</div>
								</div>
								
								<div class="tab-pane fade" id="default-tab-2">
									<div class="col-xl-10">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label"> Sasaran</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" name="sasaran" id="textareasasaran" placeholder="Enter text ..." rows="8">{!!$lha->sasaran!!}</textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-3">
									<div class="col-xl-10">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Ruang Lingkup</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" name="ruang_lingkup" id="textareatujuan" placeholder="Enter text ..." rows="8">{!!$lha->ruang_lingkup!!}</textarea>
											</div>
											
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-4">
									<div class="col-xl-10">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Pelaksanaan</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" name="pelaksanaan" id="textareapelaksanaan" placeholder="Enter text ..." rows="8">{!!$lha->pelaksanaan!!}</textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-5">
									<div class="col-xl-10">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Kesimpulan</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" name="kesimpulan" id="textareakesimpulan" placeholder="Enter text ..." rows="8">{!!$lha->kesimpulan!!}</textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-6">
									<div class="col-xl-10">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Penjelasan</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" name="penjelasan" id="textareapenjelasan" placeholder="Enter text ..." rows="8">{!!$lha->penjelasan!!}</textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-7">
									<div class="col-xl-10">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Penutup</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" name="penutup" id="textareapenutup" placeholder="Enter text ..." rows="8">{!!$lha->penutup!!}</textarea>
											</div>
										</div>
									</div>
								</div>
								
								<div class="modal-footer">
									<a href="javascript:;" class="btn btn-blue" onclick="simpan_data()">Simpan</a>
									<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
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
            $('#tanggalpicker').datepicker({
                format: 'yyyy-mm-dd',
                
            });
            $('#tangal_penerbitan').datepicker({
                format: 'yyyy-mm-dd',
                
            });
            
        });

		function tutup_notif(){
			$('#modalnotif').modal('toggle');
		}

		$("#textarealatarbelakang").wysihtml5();
		$("#textareatiket").wysihtml5();
		$("#textareasasaran").wysihtml5();
		$("#textareapelaksanaan").wysihtml5();
		$("#textareakesimpulan").wysihtml5();
		$("#textareapenjelasan").wysihtml5();
		$("#textareapenutup").wysihtml5();
		$("#textareatujuan").wysihtml5({
			"rows":"2",
		});
		$("#textareacatatan").wysihtml5();
		$('#myTable').DataTable( {
			responsive: true,
			paging: true,
			info: true,
			lengthChange: false,
		} );

		function simpan_data(){
            var form=document.getElementById('tambah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Lha/Update')}}",
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
	
