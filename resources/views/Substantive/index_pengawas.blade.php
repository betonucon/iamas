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
					<h4 class="panel-title">LIST DATA</h4>
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
						<a class="btn btn-primary btn-sm active" onclick="create()"><i class="fa fa-plus"></i> Tambah </a>
						<a class="btn btn-danger btn-sm active" onclick="hapus()"><i class="fa fa-trash"></i> Hapus</a>
					</div> -->
					<form id="data-all" enctype="multipart/form-data">
						@csrf
						<table id="myTable" class="table table-striped table-bordered table-td-valign-middle">
							<thead>
								<tr>
									<th width="1%"></th>
									<th width="10%" class="text-nowrap">No. Surat</th>
									<th width="18%" class="text-nowrap">Unit Kerja</th>
									<th class="text-nowrap">Obyek</th>
									<th width="7%" class="text-nowrap">Penerbitan</th>
									<th width="13%" class="text-nowrap">Status</th>
									<th width="5%" class="text-nowrap">Print</th>
									<th width="5%" class="text-nowrap">File</th>
									
									<th width="8%" class="text-nowrap">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach(substantive_pengawas_get() as $no=>$data)
									<tr class="odd gradeX">
										<td width="1%" class="f-s-600 text-inverse">{{$no+1}}</td>
										<td class="boldtd">{{$data->nomorsurat}}</td>
										<td>{{$data->unitkerja['name']}}</td>
										<td>{{$data->name}}</td>
										<td>{{$data->tgl_penerbitan}}</td>
										<td style="text-align:center">
											{{$data->stsaudit['name']}}	
										</td>
										<td><span onclick="cetak({{$data->id}})" class="btn btn-yellow btn-sm"><i class="fa fa-print"></i></span></td>
										
										<td><span onclick="cek_file_audit({{$data->id}})" class="btn btn-yellow btn-sm"><i class="fa fa-clone"></i></span></td>
										<td>
											
											@if($data->sts_substantive>1)
												<span onclick="approve(`{{coder($data->id)}}`)" class="btn btn-yellow active btn-xs">View</span> 
											@else
												<span onclick="approve(`{{coder($data->id)}}`)" class="btn btn-blue active btn-xs">Approve</span> 
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
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Approve</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div id="notifikasiubah"></div>
						<form id="ubah-data" enctype="multipart/form-data">
							@csrf
							<input type="hidden" id="audit_id" name="id">
							<div class="form-group">
								<label for="exampleInputEmail1">Status</label>
								<select class="form-control" name="sts"  onchange="cek_status(this.value)">
									<option value="">Pilih Status</option>
									<option value="3">Setujui</option>
									<option value="2">Kembalikan</option>
								</select>
							</div>
							<div class="form-group" id="alasan">
								<label for="exampleInputEmail1">Alasan</label>
								<textarea class="form-control" name="alasan"></textarea>
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
		$('#myTable').DataTable( {
			responsive: true,
			paging: true,
			info: true,
			ordering:false,
			lengthChange: false,
		} );
		function cetak(id){
			window.open("{{url('Substantive/Cetak')}}?id="+id, '_blank');
		}
		$('#alasan').hide();

		function tutup_notif(){
			$('#modalnotif').modal('toggle');
		}
		
		function cek_status(a){
			if(a=='2'){
				$('#alasan').show();
			}else if(a=='3'){
				$('#alasan').hide();
			}else{
				$('#alasan').hide();
			}
		}


		function approve(a){
			location.assign("{{url('/Substantive/Approvepengawas')}}?id="+a);
		}

		function cek_file_audit(a){
			$('#modalfile').modal('show');
			$('#tampilfile').html("<iframe src='{{url('Auditplan/file')}}?id="+a+"' width='100%' height='600px'></iframe>");
		}

	</script>

@endpush
	
