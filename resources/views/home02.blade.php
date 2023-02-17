@extends('layouts.web')

@push('style')
<link href="{{url('assets/assets/plugins/nvd3/build/nv.d3.css')}}" rel="stylesheet" />
<style>
	.progress.progress-xs {
    	height: 7px;
	}
</style>
@endpush
@section('contex')
			<div class="d-sm-flex align-items-center mb-3" style="padding: 1%;background: #8195a9;">
				<label style="color:#fff">PILIH TAHUN &nbsp;&nbsp;</label>
				<select onchange="pilih_tahun(this.value)" style="width:30%;display:inline" class="form-control">
					@for($x=2020;$x<=date('Y');$x++)
						<option value="{{$x}}" @if($tahun==$x) selected @endif> Dashboard Tahun {{$x}}</option>
					@endfor
				</select>
			</div>
			
				<div class="panel panel-inverse" data-sortable-id="table-basic-5">
					<!-- begin panel-heading -->
					<div class="panel-heading ui-sortable-handle">
						<h4 class="panel-title">PROGRES INFORMASI</h4>
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
						<!-- begin table-responsive -->
						<div class="row">
				<!-- begin col-3 -->
							<div class="col-xl-2 col-md-2">
								<div class="widget widget-stats bg-red">
									<div class="stats-icon"><i class="fa fa-desktop"></i></div>
									<div class="stats-info">
										<h4>PROGRES 1</h4>
										<p>{{total_infromasi($tahun,1)-total_infromasi($tahun,2)}}</p>	
									</div>
									<div class="stats-link">
										<a href="javascript:;">PERIODE {{$tahun}} </a>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-md-2">
								<div class="widget widget-stats bg-yellow">
									<div class="stats-icon"><i class="fa fa-desktop"></i></div>
									<div class="stats-info">
										<h4>PROGRES 2</h4>
										<p>{{total_infromasi($tahun,2)-total_infromasi($tahun,3)}}</p>	
									</div>
									<div class="stats-link">
										<a href="javascript:;">PERIODE {{$tahun}} </a>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-md-2">
								<div class="widget widget-stats bg-orange">
									<div class="stats-icon"><i class="fa fa-desktop"></i></div>
									<div class="stats-info">
										<h4>PROGRES 3</h4>
										<p>{{total_infromasi($tahun,3)-total_infromasi($tahun,4)}}</p>	
									</div>
									<div class="stats-link">
										<a href="javascript:;">PERIODE {{$tahun}} </a>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-md-2">
								<div class="widget widget-stats bg-green">
									<div class="stats-icon"><i class="fa fa-desktop"></i></div>
									<div class="stats-info">
										<h4>PROGRES 4</h4>
										<p>{{total_infromasi($tahun,4)-total_infromasi($tahun,5)}}</p>	
									</div>
									<div class="stats-link">
										<a href="javascript:;">PERIODE {{$tahun}} </a>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-md-2">
								<div class="widget widget-stats bg-blue">
									<div class="stats-icon"><i class="fa fa-desktop"></i></div>
									<div class="stats-info">
										<h4>PROGRES 5</h4>
										<p>{{total_infromasi($tahun,5)}}</p>	
									</div>
									<div class="stats-link">
										<a href="javascript:;">PERIODE {{$tahun}} </a>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-md-2">
								<div class="widget widget-stats bg-grey">
									<div class="stats-icon"><i class="fa fa-desktop"></i></div>
									<div class="stats-info">
										<h4>TOTAL INFO</h4>
										<p>{{total_infromasi($tahun,6)}}</p>	
									</div>
									<div class="stats-link">
										<a href="javascript:;">PERIODE {{$tahun}} </a>
									</div>
								</div>
							</div>
							
							
						</div>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width="5%">NO</th>
										<th>NOMOR INFORMASI</th>
										<th width="10%">PROGRES 1</th>
										<th width="10%">PROGRES 2</th>
										<th width="10%">PROGRES 3</th>
										<th width="10%">PROGRES 4</th>
										<th width="10%">PROGRES 5</th>
										<th width="3%">FILE</th>
									</tr>
								</thead>
								<tbody>
									@foreach(get_tiket_auditee($tahun) as $no=>$get)
										<tr>
											<td>{{$no+1}}</td>
											<td>{{$get->nomorinformasi}}</td>
											<td>
												@if($get->sts>1 || $get->sts!=10)
													<button type="button" class="btn btn-red btn-xs">Tercatat</button>
												@else
													
												@endif
											</td>
											<td>
												@if($get->sts>2 || $get->sts!=10)
													<button type="button" class="btn btn-yellow btn-xs">Assignment</button>
												@else
													
												@endif
											</td>
											<td>
												@if($get->sts>4 || $get->sts!=10)
													<button type="button" class="btn btn-orange btn-xs">Analisa</button>
												@else
													
												@endif
											</td>
											<td>
												@if($get->sts>5 || $get->sts!=10)
													<button type="button" class="btn btn-success btn-xs">Draft Hasil</button>
												@else
													
												@endif
											</td>
											<td>
												@if($get->sts>6 || $get->sts!=10)
													<button type="button" class="btn btn-blue btn-xs">Selesai</button>
												@else
													
												@endif
											</td>
											<td>
												@if($get->sts>6  || $get->sts!=10)
													<button type="button" class="btn btn-grey btn-xs" title="Lampiran {{$get->lampiran_tiket}}" onclick="location.assign(`{{url('_file_lampiran/'.$get->lampiran_tiket)}}`)"><i class="fas fa-clone"></i></button>
												@else
													
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<!-- end table-responsive -->
					</div>
				</div>
		
	
@endsection
@push('ajax')
<script src="{{url('assets/assets/plugins/d3/d3.min.js')}}"></script>
<script src="{{url('assets/assets/plugins/nvd3/build/nv.d3.min.js')}}"></script>

<script>
	function pilih_tahun(tahun){
		location.assign("{{url('/')}}?tahun="+tahun);
	}
</script>
<script>

   
</script>
@endpush
