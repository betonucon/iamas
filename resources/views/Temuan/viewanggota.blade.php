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
		.text-toop{
			vertical-align:top;
			padding:0.3%;
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

					<div class="btn-group btn-group-justified" style="margin-bottom:2%">
					
					@if(akses_tiket_anggota()>0)
						@if($data->sts==3 )
							<span class="btn btn-blue btn-sm" onclick="approve_acc({{$data->id}},`Anggota`)"><i class="fas fa-paper-plane"></i> Kirim ke Pengawas</span>
						@endif
							<span class="btn btn-green btn-sm" onclick="kembali(`anggota`)"><i class="fas fa-reply"></i> Kembali</span>
						
					@endif
						
					</div>
					<form id="data-all" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="id" value="{{$data->id}}">
						<div class="row">
							
							
							<div class="col-md-12">
								<div class="alert alert-blue fade show m-b-10" style="background-color: #f2f8fd;">
									<table style="margin-left:0%" width="100%">
										<tr>
											<td class="text-toop" width="15%"><b>Nomor</b></td>
											<td class="text-toop" width="2%"><b>:</b></td>
											<td class="text-toop">{{$data->kesimpulan['nomorkode']}} {{$data->nomor}}.{{$data->urutan}}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>No Tindak Lanjut</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{{$data->nomortl}}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Waktu Pengerjaan</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{{$data->tgl_mulai}} s/d {{$data->tgl_sampai}}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Status</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{{$data->sts_tl}}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Traking</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{{track_temuan($data->sts)}}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>File Tindak Lanjut</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop"><a href="{{url('_file_lampiran')}}/{{$data->file}}" target="_blank"><span class="btn btn-white btn-xs"><i class="fas fa-clone"></i> File Tindak Lanjut</span></a></td>
										</tr>
										@if($data->revisi==3)
										<tr>
											<td class="text-toop"><b>Review Perbaikan</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{!! review_pengawas($data->id,$data->sts_tl) !!}</td>
										</tr>
										@endif
										<tr>
											<td class="text-toop"><b>Hasil Tindak Lanjut</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop"></td>
										</tr>
									</table>
									<div style="padding:2% 2%">{!! $data->catatan !!}</div>
								</div>
							</div>
							<div class="col-md-12">
								@if(Auth::user()->role_id==8)
									@if($data->sts==1)
										<span class="btn btn-blue" onclick="simpan(0)" >Simpan</span>
										<span class="btn btn-green" onclick="simpan(1)" >Simpan & Kirim</span>
									@else
										<div class="alert alert-success fade show m-b-0">
											<span class="close" data-dismiss="alert">×</span>
											<strong>Notifikasi !</strong>
											Dalam proses pemeriksaan tim audit ,<a href="{{url('Temuan')}}" class="alert-link">Klik disini untuk kembali</a>.
										</div>
									@endif
								@endif
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

		
		<div class="modal" id="modal-anggota" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">&nbsp;</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasi-errorapprove"></div>
						<form id="head" method="post" enctype="multipart/form-data">
        					@csrf
							<input type="hidden" name="id" id="temuan_id">
							<input type="hidden" name="name" id="name">
							<!-- <div class="note note-warning note-with-right-icon m-b-15">
								<div class="note-content text-right">
									<h4><b>Notifikasi</b></h4>
									<p>
									  Jika melakukan proses kirim kepengawas, ketua dan anggota tidak dapat merubah atau menambahkan kesimpulan dan rekomendasi
									</p>
								</div>
								<div class="note-icon"><i class="fa fa-lightbulb"></i></div>
							</div> -->
							<div class="form-grup">
								<label>Tentukan Status</label>
								<select class="form-control" name="status" onchange="pilih_status(this.value)">
									<option value="">--Pilih Status</option>
									<option value="1">- Selesai</option>
									<option value="2">- Perbaiki Ulang</option>
								</select>
							</div>
							<div class="form-grup">
								<label>Catatan</label>
								<textarea class="form-control" name="catatan"></textarea>
								
							</div>
							<div class="form-grup" id="tampilalasan">
								<label>Tentukan Penilaian</label>
								<select class="form-control" name="nilai" >
									<option value="">--Pilih Penilaian</option>
									<option value="A">- Baik</option>
									<option value="B">- Buruk</option>
								</select>
								
							</div>
						</form>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="send_data()" >Proses</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modal-head" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">&nbsp;</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasi-errorapprovehead"></div>
						<form id="kirim-datahead" method="post" enctype="multipart/form-data">
        					@csrf
							<input type="hidden" name="id" id="headtemuan_id">
							<input type="hidden" name="name" id="headname">
							<!-- <div class="note note-warning note-with-right-icon m-b-15">
								<div class="note-content text-right">
									<h4><b>Notifikasi</b></h4>
									<p>
									  Jika melakukan proses kirim kepengawas, ketua dan anggota tidak dapat merubah atau menambahkan kesimpulan dan rekomendasi
									</p>
								</div>
								<div class="note-icon"><i class="fa fa-lightbulb"></i></div>
							</div> -->
							<div class="form-grup">
								<label>Tentukan Status</label>
								<select class="form-control" name="status">
									<option value="">--Pilih Status</option>
									<option value="1">- Selesai</option>
									<option value="2">- Perbaiki Ulang</option>
								</select>
							</div>
						</form>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="send_data_head()" >Proses</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalerror" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Notifikasi</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body" >
						
							<div id="notiferror"></div>
						
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

		$('#tampilalasan').hide();
		
		function kembali(name){
			location.assign("{{url('Temuan')}}"+name)
		}
		function pilih_status(sts){
			if(sts==2){
				$('#tampilalasan').show();
			}else{
				$('#tampilalasan').hide();
			}
		}
		function approve_acc(id,name){
			// alert(name)
			if(name=='RCD'){
				$.ajax({
					type: 'GET',
					url: "{{url('Temuan/approve')}}",
					data: "id="+id+"&name="+name,
					beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
					success: function(msg){
						location.reload();
					}
				}); 
			}
			if(name=='Pengawas'){
				$.ajax({
					type: 'GET',
					url: "{{url('Temuan/approve')}}",
					data: "id="+id+"&name="+name,
					beforeSend: function() {
						document.getElementById("loadnya").style.width = "100%";
					},
					success: function(msg){
						location.reload();
					}
				}); 
			}

			if(name=='Anggota'){
				$('#modal-anggota').modal('show');
				$('#name').val(name);
				$('#temuan_id').val(id);
			}
			if(name=='Ketua'){
				$('#modal-anggota').modal('show');
				$('#name').val(name);
				$('#temuan_id').val(id);
			}
			if(name=='Head'){
				$('#modal-head').modal('show');
				$('#headname').val(name);
				$('#headtemuan_id').val(id);
			}
		}

		

		
		function send_data(){
            var form=document.getElementById('head');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Temuan/send_data')}}",
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
							$('#notifikasi-errorapprove').html(msg);
                        }
                        
                        
                    }
                });

        } 
		function send_data_head(){
			
            var form=document.getElementById('kirim-datahead');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Temuan/send_data_head')}}",
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
							$('#notifikasi-errorapprovehead').html(msg);
                        }
                        
                        
                    }
                });

        } 
		
	</script>

@endpush
	
