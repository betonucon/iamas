@extends('layouts.web')

@section('contex')
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse" data-sortable-id="form-plugins-1">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Unit Kerja</h4>
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
						<a class="btn btn-primary" onclick="tambah()">Tambah </a>
						<a class="btn btn-danger" onclick="hapus()">Hapus</a>
					</div>
					<form id="data-all" enctype="multipart/form-data">
						@csrf
						<table id="myTable" class="table table-striped table-bordered table-td-valign-middle">
							<thead>
								<tr>
									<th width="1%"></th>
									<th width="1%" data-orderable="false"></th>
									<th width="15%" class="text-nowrap">Kode Unit</th>
									<th class="text-nowrap">Nama</th>
									<th width="30%" class="text-nowrap">Pimpinan Unit</th>
									<th width="3%" class="text-nowrap"></th>
								</tr>
							</thead>
							<tbody>
								@foreach(unitkerja_get('0') as $no=>$data)
									<tr class="odd gradeX">
										<td width="1%" class="f-s-600 text-inverse">{{$no+1}}</td>
										<td width="1%" class="with-img"><input value="{{$data->kode}}" type="checkbox" name="id[]"></td>
										<td>{{$data->kode}}</td>
										<td>{{$data->name}}</td>
										<td>{{$data->nik}} {{$data->nama_atasan}}</td>
										<td>
											<span onclick="ubah({{$data->id}})" class="btn btn-purple active btn-icon btn-circle btn-sm"><i class="fas fa-edit fa-sm"></i></span> 
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
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tambah Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasi"></div>
						<form id="tambah-data" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label for="exampleInputEmail1">Kode Unit Kerja</label>
								<input type="text" class="form-control" name="kode"  placeholder="Enter..">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Nama Unit Kerja</label>
								<input type="text" class="form-control" name="name"  placeholder="Enter..">
							</div>
							<div class="form-group">
            					<label for="exampleInputEmail1">Pimpinan</label>
								<div class="row">
									<div class="col-3">
										<div class="input-group m-b-10">
											<input type="text" class="form-control" name="nik" id="nik" value="" placeholder="Enter..">
											<div class="input-group-append"><span class="input-group-text" onclick="add_cari_nik()"><i class="fa fa-search"></i></span></div>
										</div>
									</div>
									<div class="col-4">
										<input type="text" class="form-control" readonly name="nama_atasan" id="add_nama_atasan" value="" placeholder="Enter..">
									</div>
									<div class="col-5">
										<input type="text" class="form-control" readonly name="position_name" id="add_position_name"  value="" placeholder="Enter..">
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
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ubah Data</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubah"></div>
						<form id="ubah-data" method="post" action="{{url('Unitkerja/ubah_data')}}" enctype="multipart/form-data">
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
	</div>
@endsection
@push('ajax')
	<script>
		$('#myTable').DataTable( {
			responsive: true,
			paging: true,
			info: true,
			lengthChange: false,
		} );

		function tambah(){
			$('#modaltambah').modal('show');
		}

		function ubah(a){
			
			$.ajax({
				type: 'GET',
				url: "{{url('Unitkerja/ubah')}}",
				data: "id="+a,
				success: function(msg){
					$('#modalubah').modal('show');
					$('#tampilubah').html(msg);
					
				}
			}); 
		}
		function add_cari_nik(){
			var nik=$('#nik').val();
			$.ajax({
				type: 'GET',
				url: "{{url('get_nik')}}",
				data: "nik="+nik,
				beforeSend: function() {
					document.getElementById("loadnya").style.width = "100%";
				},
				success: function(msg){
					var data=msg.split('@');
					document.getElementById("loadnya").style.width = "0px";
					$('#add_nama_atasan').val(data[0]);
					$('#add_position_name').val(data[1]);
					
				}
			}); 
		}
		function cari_nik(){
			var nik=$('#nik_ubah').val();
			$.ajax({
				type: 'GET',
				url: "{{url('get_nik')}}",
				data: "nik="+nik,
				beforeSend: function() {
					document.getElementById("loadnya").style.width = "100%";
				},
				success: function(msg){
					var data=msg.split('@');
					document.getElementById("loadnya").style.width = "0px";
					$('#nama_atasan').val(data[0]);
					$('#position_name').val(data[1]);
					
				}
			}); 
		}

		function tambah_data(){
            var form=document.getElementById('tambah-data');
            
                $.ajax({
                    type: 'POST',
                    url: "{{url('/Unitkerja')}}",
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
                    url: "{{url('/Unitkerja/ubah_data')}}",
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
                    url: "{{url('/Unitkerja/hapus')}}",
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
	
