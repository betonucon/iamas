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
				<div class="panel-body">

					<div class="btn-group btn-group-justified text-with">
						<a class="btn btn-blue active" onclick="tambah()"><i class="fas fa-edit fa-sm"></i> Tambah </a>
						<!-- <a class="btn btn-danger active" onclick="hapus()">Hapus</a> -->
					</div>
					<form id="data-all" enctype="multipart/form-data">
						@csrf
						<table id="myTable" class="table table-striped table-bordered table-td-valign-middle">
							<thead>
								<tr>
									<th width="1%"></th>
									<th width="1%" data-orderable="false"></th>
									<th width="10%" class="text-nowrap">No Tiket</th>
									<th class="text-nowrap">Judul</th>
									<th class="text-nowrap">Sumber</th>
									<th width="3%" class="text-nowrap">file</th>
									<th width="3%" class="text-nowrap">surat</th>
									<th width="9%" class="text-nowrap">Status</th>
									<th width="3%" class="text-nowrap">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach(tiket_get_tiket() as $no=>$data)
									<tr class="odd gradeX">
										<td width="1%" class="f-s-600 text-inverse">{{$no+1}}</td>
										<td width="1%" class="with-img"><input value="{{$data->tiket['id']}}" type="checkbox" name="id[]"></td>
										<td>{{$data->nomortiket}}</td>
										<td>{{$data->tiket['judul_tiket']}}</td>
										<td>[{{$data->nomorinformasi}}] {{$data->tiket->sumber['name']}}</td>
										<td><span onclick="cek_file(`{{$data->tiket['lampiran_tiket']}}`)" class="btn btn-yellow btn-xs"><i class="fa fa-clone"></i></span></td>
										<td><span onclick="cek_surat_tugas({{$data->tiket['id']}})" title="surat tugas" class="btn btn-yellow btn-xs"><i class="fa fa-clone"></i></span></td>
										<td>
											@if($data->sts==1)
												<font color="red">On Proses</font>
											@endif
											@if($data->sts>1)
												<font color="blue">Selesai</font>
											@endif
											
										</td>
										<td>
											<span onclick="ubah({{$data->tiket['id']}})" class="btn btn-green active btn-xs"><i class="fas fa-edit fa-sm"></i> View</span> 
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
		<div class="modal" id="modalketua" aria-hidden="true" style="display: none;background: rgb(53 26 88 / 49%);">
			<div class="modal-dialog" style="max-width:50%">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Ketua Tim Audit</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
					    
							<table class="table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline collapsed" border="1">
								<tr>
									<th>No</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Jabatan</th>
								</tr>
								@foreach(katua_get() as $no=>$src_get)
									<tr onclick="pilih_ketua({{$src_get->nik}},'{{$src_get->name}}')">
										<td><input type="checkbox" name="nik[]" value="{{$src_get->nik}}"></td>
										<td>{{$src_get->nik}}</td>
										<td>{{$src_get->name}}</td>
										<td>{{$src_get->posisi['name']}}</td>
									</tr>
								@endforeach
							</table>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" onclick="tutup_modal_ketua()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modaltimaudit" aria-hidden="true" style="display: none;background: rgb(53 26 88 / 49%);">
			<div class="modal-dialog" style="max-width:50%">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Pengawas</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
					   
							<table class="table table-striped table-bordered table-td-valign-middle dataTable no-footer dtr-inline collapsed" border="1">
								<tr>
									<th>No</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Jabatan</th>
								</tr>
								@foreach(katua_get() as $no=>$src_get)
									<tr onclick="pilih_pengawas({{$src_get->nik}},'{{$src_get->name}}')">
										<td><input type="checkbox" name="nik[]" value="{{$src_get->nik}}"></td>
										<td>{{$src_get->nik}}</td>
										<td>{{$src_get->name}}</td>
										<td>{{$src_get->posisi['name']}}</td>
									</tr>
								@endforeach
							</table>
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" onclick="tutup_modal_tim()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalsumber" aria-hidden="true" style="display: none;background: #1717198a;">
			<div class="modal-dialog" style="margin-top:0px">
				<div class="modal-content">
					<div class="modal-header">
						<h5>Pilih sumber informasi dibawah ini</h5>
						
					</div>
					<div class="modal-body" id="tampil_pilihan_sumber" style="height: 450px;overflow-y: scroll;padding: 0px;">
						
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-white" onclick="tutup_sumber()">Tutup</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="modalnotif" aria-hidden="true" style="display: none;background: #ea59597d;">
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
            $('#tanggalpicker2').datepicker({
                format: 'yyyy-mm-dd',
                
            });
        });
		
		$('#myTable').DataTable( {
			responsive: true,
			paging: true,
			info: true,
			lengthChange: false,
		} );

		
		function tambah(){
			location.assign("{{url('TiketNew/Create')}}");
		}

		function ubah(id){
			location.assign("{{url('TiketNew/Update')}}?id="+id);
		}

		
		function cek_file(a){
			$('#modalfile').modal('show');
			$('#tampilfile').html("<iframe src='{{url('_file_lampiran')}}/"+a+"?v={{date('ymdhis')}}' width='100%' height='600px'></iframe>");
		}
		function cek_surat_tugas(a){
			$('#modalfile').modal('show');
			$('#tampilfile').html("<iframe src='{{url('Surattugas')}}?id="+a+"' width='100%' height='600px'></iframe>");
		}

		
	</script>

@endpush
	
