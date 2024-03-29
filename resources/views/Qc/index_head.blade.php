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
						<table  class="table table-striped table-bordered table-td-valign-top">
							<thead>
								<tr>
									<th width="3%"></th>
									<th class="text-nowrap">Obyek</th>
								</tr>
							</thead>
							<tbody>
								@foreach(lha_qchead_get() as $no=>$data)
									
									@if($data->sts_lha==4)
									<tr class="odd gradeX">
										<td  width="4%">{{$no+1}}</td>
										<td >
											<b>No Surat Tugas :</b> {{$data->surattugas['nomortiket']}}<br>
											<b>Unit Kerja : </b> {{$data->unitkerja['name']}}<br>
											<b>Obyek : </b> {{$data->name}}	<br>
											@if($data->sts_lha>4)
											<b>Daftar Temuan : </b> <a href="{{url('Temuan/view?id='.coder($data->id))}}">Lihat Temuan</a>
											@endif
										</td>
										
									</tr>
									<tr class="odd gradeX">
										<td></td>
										<td>
											
											@if(cek_total_setujui($data->id)==9)
												<span class="btn btn-blue btn-sm" onclick="proses_revisi({{$data->id}})"><i class="fas fa-arrow-alt-circle-right"></i> Penerbitan LHA</span>
											@endif
											<div id="hasil"></div>
											
											<table width="100%">
												<tr>
													<th>Keterangan</th>
													<th width="13%">Deskaudit</th>
													<th width="13%">Compliance</th>
													<th width="13%">Substantive</th>
													<th width="13%">LHA</th>
													<th width="7%">File LHA</th>
												</tr>
												
												<tr>
													<td class="text-center">Hasil Review QC</td>
													<td class="text-center" style="background:#f2f4f5"><a href="{{url('/Deskaudit/Catatanhead?id='.coder($data->id))}}" target="_blank"><img src="{{url('img/file.png')}}" alt="" style="width:18px" class="rounded"> Deskaudit</td>
													<td class="text-center" style="background:#f2f4f5"><a href="{{url('/Compliance/Catatanhead?id='.coder($data->id))}}" target="_blank"><img src="{{url('img/file.png')}}" alt="" style="width:18px" class="rounded"> Compliance</td>
													<td class="text-center" style="background:#f2f4f5"><a href="{{url('/Substantive/Catatanhead?id='.coder($data->id))}}" target="_blank"><img src="{{url('img/file.png')}}" alt="" style="width:18px" class="rounded"> Substantive</td>
													<td class="text-center" style="background:#f2f4f5"><a href="{{url('/Lha/Catatanhead?id='.coder($data->id))}}" target="_blank"><img src="{{url('img/file.png')}}" alt="" style="width:18px" class="rounded"> LHA</td>
													<td class="text-center" style="background:#f2f4f5"><a href="{{url('/_file_lampiran/'.$data->file_lha)}}" target="_blank"><img src="{{url('img/file.png')}}" alt="" style="width:18px" class="rounded"> File</td>
												</tr>
												
											</table>
										</td>
									</tr>
									@else
										<tr class="odd gradeX">
											<td  width="4%">{{$no+1}}</td>
											<td >
											<b>No Surat Tugas :</b> {{$data->surattugas['nomortiket']}}<br>
												<b>Unit Kerja : </b> {{$data->unitkerja['name']}}<br>
												<b>Obyek : </b> {{$data->name}}	<br>
												@if($data->sts_lha>4)
												<b>Daftar Temuan : </b> <a href="{{url('Temuan/view?id='.coder($data->id))}}">Lihat Temuan</a>
												@endif
											</td>
											
										</tr>
										
									@endif
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

		
	<div class="modal" id="modalrevisi" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="labelrevisi"></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubah"></div>
						<form id="ubah-data" method="post" action="{{url('/Qc/penerbitan_lha')}}" enctype="multipart/form-data">
							@csrf
							<input type="hidden"  name="id" id="audit_id">
							<div class="form-grup">
								<label>Status</label>
								<select name="sts" onchange="pilih_status(this.value)" class="form-control">
									<option value="">Pilih Status</option>
									<option value="2">Revisi</option>
									<option value="12">Disetujui</option>
								</select>
							</div>
							<div class="form-grup" id="keterangan">
								<label>Keterangan</label>
								<textarea class="form-control" name="keterangan" id="textareaketerangan"></textarea>
							</div>
							<div class="form-grup" id="laporan">
								<label>File Laporan (.pdf)</label>
								<input type="file" class="form-control" name="file">
							</div>
							<!-- <input type="submit"> -->
						</form>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="ubah_data()">Simpan</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
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
		$('#keterangan').hide();
		$('#laporan').hide();
		$("#textareaketerangan").wysihtml5();

		function pilih_status(id){
			if(id==2){
				$('#keterangan').show();
				$('#laporan').hide();
			}
			else if(id==12){
				$('#keterangan').hide();
				$('#laporan').show();
			}
			else{
				$('#keterangan').hide();
				$('#laporan').hide();
			}
		}
		function proses_revisi(id){
			$('#audit_id').val(id);
			$('#modalrevisi').modal('show');
		}
		function proses_qc(id){
			location.assign("{{url('/Qcview')}}?id="+id);
		}
		function sand_lha(id){
			$('#audit_id').val(id);
			$('#modalsend').modal('show');
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

		
		function proses_kirim(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Qc/penerbitan_lha')}}",
				data: "id="+a,
				success: function(msg){
					alert('sss')
					$('#hasil').html(msg)
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

		

		function ubah_data(){
            var form=document.getElementById('ubah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Qc/penerbitan_lha')}}",
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
	</script>

@endpush
	
