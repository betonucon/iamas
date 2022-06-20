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

					<div class="btn-group btn-group-justified">
						<a class="btn btn-primary active" onclick="tambah()">Tambah </a>
						<a class="btn btn-danger active" onclick="hapus()">Hapus</a>
					</div>
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
									<th width="4%" class="text-nowrap">Detail</th>
									<th width="9%" class="text-nowrap">Status</th>
									<th width="3%" class="text-nowrap">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach(tiket_get('0') as $no=>$data)
									<tr class="odd gradeX">
										<td width="1%" class="f-s-600 text-inverse">{{$no+1}}</td>
										<td width="1%" class="with-img"><input value="{{$data->nik}}" type="checkbox" name="id[]"></td>
										<td>{{$data->nomorinformasi}}</td>
										<td>{{$data->judul}}</td>
										<td>[{{$data->kode_sumber}}] {{$data->sumber['name']}}</td>
										<td><span onclick="cek_file(`{{$data->lampiran}}`)" class="btn btn-yellow btn-sm"><i class="fa fa-clone"></i></span></td>
										<td><span onclick="view_data(`{{$data->id}}`)" class="btn btn-blue btn-sm"><i class="fa fa-search"></i></span></td>
										<td>
											@if($data->sts==0 || $data->sts==1)
												<font color="red">On Proses</font>
											
											@elseif($data->sts==10)
											<span onclick="cek_revisi(`{{$data->alasan}}`)" class="btn btn-purple btn-sm">Revisi</span> 
											
											@else
												<font color="blue">Tercatat</font>
											@endif
											
										</td>
										<td>
											@if($data->sts=='0' || $data->sts=='10')
												<span onclick="ubah({{$data->id}})" class="btn btn-purple active btn-icon btn-circle btn-sm"><i class="fas fa-edit fa-sm"></i></span> 
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

		<div class="modal" id="modaltambah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tambah Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasi"></div>
						<form id="tambah-data" action="{{url('Tiket')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="col-xl-10 offset-xl-1">
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label">Sumber Infomasi </label>
									<div class="col-lg-9 col-xl-9">
										<select class="form-control" name="kode_sumber" id="sumber-informasi" onchange="cek_nomor_tiket(this.value)">
											<option value="">Pilih Sumber Infomasi</option>
											@foreach(sumber_get(0) as $sumber)
												
												<option value="{{$sumber['kode']}}" >[{{$sumber['kode']}}] {{$sumber['name']}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label">Kode Informasi & Lampiran</label>
									<div class="col-lg-9 col-xl-5">
										<input type="text" class="form-control" id="nomorinformasi" name="nomorinformasi" >
									</div>
									<div class="col-lg-9 col-xl-4">
										<input type="file" class="form-control"  name="lampiran" >
									</div>
								</div>
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label">Judul</label>
									<div class="col-lg-9 col-xl-9">
										<input type="text" class="form-control" name="judul" placeholder="Enter text ...">
									</div>
								</div>
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label">Kodifikasi</label>
									<div class="col-lg-9 col-xl-9">
										<select class="form-control" name="kodifikasi" >
											<option value="">Pilih Kodefikasi</option>
											@foreach(kodefikasi_get() as $kodefikasi)
												
												<option value="{{$kodefikasi['kodifikasi']}}" >[{{$kodefikasi['kodifikasi']}}] {{$kodefikasi['kategori']}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row m-b-10" >
									<label class="col-lg-3 text-lg-right col-form-label">Isi / Keterangan</label>
									<div class="col-lg-9 col-xl-9">
										<textarea class="textarea form-control" name="keterangan" id="wysihtml5" placeholder="Enter text ..." rows="12"></textarea>
									</div>
								</div>
							</div>
							
						</form>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-blue" onclick="tambah_data()">Simpan</a>
						<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		

		<div class="modal" id="modalubah" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" id="modal-sedeng">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubah"></div>
						<form id="ubah-data" enctype="multipart/form-data">
							@csrf
							<div id="tampilubah"></div>
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
		<div class="modal" id="modalrevisi" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Alasan</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						
							<div id="tampilrevisi"></div>
						
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
		} );

		
		function tambah(){
			$('#modaltambah').modal('show');
		}

		function cek_revisi(a){
			$('#modalrevisi').modal('show');
			$('#tampilrevisi').html(a);
		}

		function cek_file(a){
			$('#modalfile').modal('show');
			$('#tampilfile').html("<iframe src='{{url('_file_lampiran')}}/"+a+"?v={{date('ymdhis')}}' width='100%' height='600px'></iframe>");
		}

		function cek_sumber(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Tiket/cek_sumber')}}",
				data: "id="+a,
				success: function(msg){
					$('#sumber-informasi').html(msg);
					$('#nomorinformasi').val('');
				}
			}); 
		}

		function cek_nomor_tiket(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Tiket/cek_nomor_tiket')}}",
				data: "id="+a,
				success: function(msg){
					$('#nomorinformasi').val(msg);
					
				}
			}); 
		}

		function ubah(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Tiket/ubah')}}",
				data: "id="+a,
				success: function(msg){
					$('#modalubah').modal('show');
					$('#tampilubah').html(msg);
					
				}
			}); 
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

		function tambah_data(){
            var form=document.getElementById('tambah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Tiket')}}",
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
							document.getElementById("notifikasi").style.width = "100%";
							$('#notifikasi').html(msg);
                        }
                        
                        
                    }
                });

        } 

		function ubah_data(){
            var form=document.getElementById('ubah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Tiket/ubah_data')}}",
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
	
