@extends('layouts.web')
@push('style')
	<link href="{{url('assets/assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />
@endpush
@section('contex')
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="form-plugins-1">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Daftar Informasi</h4>
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

					<!-- <div class="btn-group btn-group-justified">
						<a class="btn btn-blue" onclick="approve()">Approve</a>
					</div> -->
					<form id="data-all" enctype="multipart/form-data">
						@csrf
						<table id="myTable" class="table table-striped table-bordered table-td-valign-middle">
							<thead>
								<tr>
									<th width="1%"></th>
									<th width="1%" data-orderable="false"></th>
									<th width="10%" class="text-nowrap">Kode Informasi</th>
									<th class="text-nowrap">Judul</th>
									<th class="text-nowrap">Sumber</th>
									<th width="3%" class="text-nowrap">file</th>
									<th width="3%" class="text-nowrap">Detail</th>
									<th width="9%" class="text-nowrap">Status</th>
									<th width="3%" class="text-nowrap">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach(tiket_get_hd('0') as $no=>$data)
									<tr class="odd gradeX">
										<td width="1%" class="f-s-600 text-inverse">{{$no+1}}</td>
										<td width="1%" class="with-img"><input value="{{$data->nik}}" type="checkbox" name="id[]"></td>
										<td>{{$data->nomorinformasi}}</td>
										<td>{{$data->judul}}</td>
										<td>[{{$data->kode_sumber}}] {{$data->sumber['name']}}</td>
										<td><span onclick="cek_file(`{{$data->lampiran}}`,`{{$data->keterangan}}`)" class="btn btn-yellow btn-sm"><i class="fa fa-clone"></i></span></td>
										<td><span onclick="view_data(`{{$data->id}}`)" class="btn btn-blue btn-sm"><i class="fa fa-search"></i></span></td>
										<td>
											@if($data->sts==1)
												<font color="#000">On Proses</font>
											@else
												<font color="blue">Selesai</font>
											@endif
											
										</td>
										<td>
											

											@if($data->sts==1)
												<span onclick="ubah({{$data->id}},`{{$data->keterangan}}`,`{{$data->kodifikasi}}`,`{{$data->kodif['kategori']}}`)" class="btn btn-purple btn-sm">Approve</span> 
											@else
												<i class="fa fa-check"></i>
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

		<div class="modal" id="modalubah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-lg" id="modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Approve</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubah"></div>
						<form id="ubah-data" enctype="multipart/form-data">
							@csrf
							<input type="hidden" id="id_sumber" name="id">
							<div class="alert alert-yellow fade show m-b-10">
								<span class="close" data-dismiss="alert">×</span>
								<strong>Notifikasi!</strong>
								Yakin menyetuji data dan melajutkan ke tahap berikutnya?
							</div>
							<div class="col-xl-10 offset-xl-1">
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label">Kodifikasi </label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" class="form-control" disabled id="namakodifikasi"  placeholder="Ketik...">
									</div>
								</div>
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label">Keterangan </label>
									<div class="col-lg-9 col-xl-9">
										<div style="width:100%;padding:1%" id="isinya"></div>
									</div>
								</div>
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
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">File Lampiran</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
							<label for="exampleInputEmail1">KETERANGAN</label>
							<div id="keterangan" style="padding: 1%;background: #f3f3ff;margin-bottom: 1%;"></div>
							<div id="tampilfile"></div>
						
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
			responsive: true,
			paging: true,
			info: true,
			ordering:false,
			lengthChange: false,
		});
		$("#textareacatatan").wysihtml5();
		
		$('#alasan').hide();
		
		function cek_status(a){
			if(a=='1'){
				$('#alasan').show();
			}else if(a=='2'){
				$('#alasan').hide();
			}else{
				$('#alasan').hide();
			}
		}

		function ubah(a,isi,kodifikasi,nama){
			$('#id_sumber').val(a);
			$('#kodifikasi').val(kodifikasi);
			$('#namakodifikasi').val('['+kodifikasi+'] '+nama);
			$('#id_sumber').val(a);
			$('#isinya').html(isi);
			$('#modalubah').modal('show');
		}

		function cek_file(a,keterangan){
			$('#modalfile').modal('show');
			$('#keterangan').html(keterangan);
			$('#tampilfile').html("<iframe src='{{url('_file_lampiran')}}/"+a+"' width='100%' height='600px'></iframe>");
		}
		function view_data(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Tiket/view')}}",
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
                    url: "{{url('/Tiket/setujui_head')}}",
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

		function hapus(){
            var form=document.getElementById('data-all');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Tiket/hapus')}}",
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
	
