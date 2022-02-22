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
										<span class="d-sm-block d-none">SURAT TUGAS</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="#default-tab-2" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">Tab 2</span>
										<span class="d-sm-block d-none">TUJUAN</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="#default-tab-3" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">Tab 3</span>
										<span class="d-sm-block d-none">SASARAN</span>
									</a>
								</li> 
								<li class="nav-item">
									<a href="#default-tab-4" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">Tab 4</span>
										<span class="d-sm-block d-none">RISIKO POTENSIAL</span>
									</a>
								</li> 
								<li class="nav-item">
									<a href="#default-tab-5" data-toggle="tab" class="nav-link">
										<span class="d-sm-none">Tab 5</span>
										<span class="d-sm-block d-none">JADWAL PELAKSANAAN</span>
									</a>
								</li> 
								
							</ul>
							<div class="tab-content" style="margin-bottom:0px;padding:1%">
						
								<div class="tab-pane fade active show" id="default-tab-1">
									<div class="col-xl-10 offset-xl-1">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label"> Surat Tugas</label>
											<div class="col-lg-9 col-xl-9">
												<select class="default-select2 form-control" name="tiket_id" onchange="pilih_surat_tugas(this.value)" >
													<option value="">Pilih Surat Tugas</option>
													@foreach(surat_tugas_get() as $surat_tugas_get)
														
														<option value="{{$surat_tugas_get['tiket_id']}}" >[{{$surat_tugas_get['nomortiket']}}]</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label"> Nama Obyek</label>
											<div class="col-lg-9 col-xl-9">
												<input type="text" class="form-control" name="name" id="nama_obyek" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label"> Unit Kerja</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="kode_unit" id="kode_unit" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" disabled  id="nama_unit" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label"> Pengawas & Ketua TIM</label>
											<div class="col-lg-9 col-xl-4">
												<input type="text" class="form-control" disabled  id="pengawas" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-4">
												<input type="text" class="form-control" disabled  id="ketua_tim" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label"> Anggota</label>
											<div class="col-lg-9 col-xl-9">
												<div id="anggota">
												<input type="text" class="form-control" disabled   placeholder="Enter text ..." >
												</div>
											</div>
										</div>
										
										
										
									</div>
								</div>
								
								<div class="tab-pane fade" id="default-tab-2">
									<div class="col-xl-10">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label"> Tujuan Audit</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" name="tujuan" id="textareatujuan" placeholder="Enter text ..." rows="8"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-3">
									<div class="col-xl-10">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Sasaran</label>
											<div class="col-lg-9 col-xl-9">
												<textarea class="textarea form-control" name="sasaran" id="textareasasaran" placeholder="Enter text ..." rows="8"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-4">
									<div class="col-xl-10">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Risiko Potensial</label>
											<div class="col-lg-9 col-xl-9">
											<textarea class="textarea form-control" name="risiko" id="textarearisiko" placeholder="Enter text ..." rows="8"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="default-tab-5">
									<div class="col-xl-10 offset-xl-1">
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">Tanggal Surat Tugas</label>
											<div class="col-lg-9 col-xl-4">
												<input type="text" class="form-control" name="tgl_penerbitan"  id="tangal_penerbitan" placeholder="Enter text ..." >
											</div>
										</div>
									
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">1. DeskAudit (Program)</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="tgl_deskaudit_program_start"  id="tgl_deskaudit_program_start" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly  name="tgl_deskaudit_program_end"  id="tgl_deskaudit_program_end" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">(Catatan)</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="tgl_deskaudit_hasil_start"  id="tgl_deskaudit_hasil_start" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly  name="tgl_deskaudit_hasil_end"  id="tgl_deskaudit_hasil_end" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">2. Compliance Test (Program)</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="tgl_compliance_program_start"  id="tgl_compliance_program_start" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly  name="tgl_compliance_program_end"  id="tgl_compliance_program_end" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">(Catatan)</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="tgl_compliance_hasil_start"  id="tgl_compliance_hasil_start" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly  name="tgl_compliance_hasil_end"  id="tgl_compliance_hasil_end" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">3. Substantive (Program)</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="tgl_substantive_program_start"  id="tgl_substantive_program_start" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly  name="tgl_substantive_program_end"  id="tgl_substantive_program_end" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">(Catatan)</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="tgl_substantive_hasil_start"  id="tgl_substantive_hasil_start" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly  name="tgl_substantive_hasil_end"  id="tgl_substantive_hasil_end" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">4. Penyusunan Draft LHA</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="tgl_lha_start"  id="tgl_lha_start" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly  name="tgl_lha_end"  id="tgl_lha_end" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">5. QC Audit</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="tgl_lha_draf_start"  id="tgl_lha_draf_start" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly  name="tgl_lha_draf_end"  id="tgl_lha_draf_end" placeholder="Enter text ..." >
											</div>
										</div>
										<div class="form-group row m-b-10" >
											<label class="col-lg-3 text-lg-right col-form-label">6. Penerbitan LHA</label>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly name="tgl_lha_finis_start"  id="tgl_lha_finis_start" placeholder="Enter text ..." >
											</div>
											<div class="col-lg-9 col-xl-3">
												<input type="text" class="form-control" readonly  name="tgl_lha_finis_end"  id="tgl_lha_finis_end" placeholder="Enter text ..." >
											</div>
										</div>
										
									</div>
								</div>
								<div class="modal-footer">
									<a href="javascript:;" class="btn btn-blue" onclick="tambah_data()">Simpan</a>
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
            $('#tgl_deskaudit_program_start').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_deskaudit_program_end').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_deskaudit_hasil_start').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_deskaudit_hasil_end').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_compliance_program_start').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_compliance_program_end').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_compliance_hasil_start').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_compliance_hasil_end').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_substantive_program_start').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_substantive_program_end').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_substantive_hasil_start').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_substantive_hasil_end').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_lha_start').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_lha_end').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_lha_draf_start').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_lha_draf_end').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_lha_finis_start').datepicker({format: 'yyyy-mm-dd',autoclose: true});
            $('#tgl_lha_finis_end').datepicker({format: 'yyyy-mm-dd',autoclose: true});
        });

		function tutup_notif(){
			$('#modalnotif').modal('toggle');
		}

		$("#textareatiket").wysihtml5();
		$("#textareasasaran").wysihtml5();
		$("#textarearisiko").wysihtml5();
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

		function pilih_surat_tugas(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Auditplan/pilih_surat_tugas')}}",
				data: "id="+a,
				beforeSend: function() {
					document.getElementById("loadnya").style.width = "100%";
				},
				success: function(msg){
					var data=msg.split('@');
					document.getElementById("loadnya").style.width = "0px";
					$('#nama_obyek').val(data[0]);
					$('#kode_unit').val(data[1]);
					$('#nama_unit').val(data[2]);
					$('#pengawas').val(data[3]);
					$('#ketua_tim').val(data[4]);
					$('#anggota').html(data[5]);
					$('#tangal_penerbitan').val(data[6]);

					
				}
			});
		}
		function cek_file(a){
			$('#modalfile').modal('show');
			$('#tampilfile').html("<iframe src='{{url('_file_lampiran')}}/"+a+"' width='100%' height='600px'></iframe>");
		}

		function tambah_data(){
            var form=document.getElementById('tambah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Auditplan')}}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
                    success: function(msg){
                        if(msg=='ok'){
                            location.assign("{{url('/Auditplan')}}");
                               
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
	
