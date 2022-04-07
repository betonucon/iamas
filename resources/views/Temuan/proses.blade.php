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
					<form id="data-all" method="post" action="{{url('/Temuan')}}?act=0" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="id" value="{{$data->id}}">
						<div class="row">
							
							<div class="col-md-12">
								@if(alasan_temuan($data['id'],$data['sts_tl'])!='')
								<div class="alert alert-blue fade show m-b-10" style="background-color: #ffeac3;">
									<b>PESAN PERBAIKAN</b>
									<p style="margin:1%">{!!alasan_temuan($data['id'],$data['sts_tl'])!!}</p>
								</div>
								@endif
								<div class="alert alert-blue fade show m-b-10" style="background-color: #ebf1f7;">
									<b style="font-size:14px"><u>Nomor :  {{$data->nomor}}.{{$data->urutan}}</u></b></br>
									<table style="margin-left:2%" width="100%">
										<tr>
											<td class="text-toop" width="15%"><b>PIC</b></td>
											<td class="text-toop" width="2%"><b>:</b></td>
											<td class="text-toop">{{$data->unitkerja['pimpinan']}} {{$data->unitkerja['name']}}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Kodifikasi</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop"><b>{{$data->kodifikasi}}</b> {{$data->getkodifikasi['kategori']}}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Isi Rekomendasi</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{!! $data->isi !!}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Risiko</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{{$data->risiko}} ({{$data->ket_risiko}})</td>
										</tr>
										<tr>
											<td class="text-toop"><b>No Tindak Lanjut</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{{ $data->nomortl }}</td>
										</tr>
										<tr>
											<td class="text-toop"><b>Status</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">{{ $data->sts_tl }}</td>
										</tr>
										@if($data->sts==1 && $data->sts_tl!='B')
										<tr>
											<td class="text-toop"><b>Hasil Review Auditor</b></td>
											<td class="text-toop"><b>:</b></td>
											<td class="text-toop">[{{ $data->nomormtl }}]<br>{!! review_team($data->id,$data->sts_tl) !!}</td>
										</tr>
										@endif
									</table>
								</div>
							</div>
							<div class="col-md-12">
								<label>File</label>
								<input type="file" name="file" class="form-control"><br>
								<label>Catatan</label>
								<textarea class="ckeditor" id="editor1" name="catatan" rows="20">{!! $data->catatan !!}</textarea>
							</div>
							<div class="col-md-12">
								@if($data->sts==1)
									<span class="btn btn-blue" onclick="simpan(0)" >Simpan</span>
									<span class="btn btn-green" onclick="simpan(1)" >Simpan & Kirim</span>
								@else
									<div class="alert alert-success fade show m-b-0">
										<span class="btn btn-blue btn-xs close" onclick="cetak({{$data->id}})">Cetak</span>
										<strong>Notifikasi !</strong>
										Dalam proses pemeriksaan tim audit ,<a href="{{url('Temuan')}}" class="alert-link">Klik disini untuk kembali</a>.
									</div>
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
		<div class="modal" id="modalcetak" aria-hidden="true" style="display: none;background:#77779394">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Cetak</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body" >
						
							<div id="tampil-cetak" ></div>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
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
		function cetak(a){
			$('#modalcetak').modal('show');
			$('#tampil-cetak').html("<iframe src='{{url('Temuan/cetak')}}?id="+a+"' width='100%' height='600px'></iframe>");
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

		

		function simpan(act){
            var form=document.getElementById('data-all');
            var data = new FormData(form);
            	data.append('content', CKEDITOR.instances['editor1'].getData());
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Temuan')}}?act="+act,
                    data: data,
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
							$('#modalerror').modal('show');
							$('#notiferror').html(msg);
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
	
