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
						
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th rowspan="2" width="5%">NO</th>
										<th rowspan="2">UNIT KERJA</th>
										<th colspan="4">LHK</th>
										<th colspan="4">LHA</th>
										<th colspan="4">LHP</th>
									</tr>
									<tr>
										<th width="4%">B</th>
										<th width="4%">P</th>
										<th width="4%">S</th>
										<th width="4%">TOTAL</th>
										<th width="4%">B</th>
										<th width="4%">P</th>
										<th width="4%">S</th>
										<th width="4%">TOTAL</th>
										<th width="4%">B</th>
										<th width="4%">P</th>
										<th width="4%">S</th>
										<th width="4%">TOTAL</th>
										
									</tr>
								</thead>
								<tbody>
									@if(Auth::user()->jabatan==1)
										@foreach(get_subdit(Auth::user()->kode_unit) as $no=>$get)
											<tr>
												<td>{{$no+1}}</td>
												<td>{{detail_unit($get->unit_id)}} {{$get->name}}</td>
												<td>{{total_lhk($get->kode,$tahun,4)}}</td>
												<td>{{total_lhk($get->kode,$tahun,2)}}</td>
												<td>{{total_lhk($get->kode,$tahun,3)}}</td>
												<td>{{total_lhk($get->kode,$tahun,1)}}</td>
												
												<td>{{total_lha($get->kode,$tahun,4)}}</td>
												<td>{{total_lha($get->kode,$tahun,2)}}</td>
												<td>{{total_lha($get->kode,$tahun,3)}}</td>
												<td>{{total_lha($get->kode,$tahun,1)}}</td>
												<td>{{total_lhp($get->kode,$tahun,4)}}</td>
												<td>{{total_lhp($get->kode,$tahun,2)}}</td>
												<td>{{total_lhp($get->kode,$tahun,3)}}</td>
												<td>{{total_lhp($get->kode,$tahun,1)}}</td>
											</tr>
											@foreach(get_divisi($get->kode) as $no=>$div)
												<tr>
													<td></td>
													<td>&nbsp;&nbsp;&nbsp;{{$no+1}}. {{detail_unit($div->unit_id)}} {{$div->name}}</td>
													<td>{{total_lhk($div->kode,$tahun,4)}}</td>
													<td>{{total_lhk($div->kode,$tahun,2)}}</td>
													<td>{{total_lhk($div->kode,$tahun,3)}}</td>
													<td>{{total_lhk($div->kode,$tahun,1)}}</td>
													
													<td>{{total_lha($div->kode,$tahun,4)}}</td>
													<td>{{total_lha($div->kode,$tahun,2)}}</td>
													<td>{{total_lha($div->kode,$tahun,3)}}</td>
													<td>{{total_lha($div->kode,$tahun,1)}}</td>
													<td>{{total_lhp($div->kode,$tahun,4)}}</td>
													<td>{{total_lhp($div->kode,$tahun,2)}}</td>
													<td>{{total_lhp($div->kode,$tahun,3)}}</td>
													<td>{{total_lhp($div->kode,$tahun,1)}}</td>
												</tr>
											@endforeach
										@endforeach
									@else
										@foreach(get_divisi(Auth::user()->kode_unit) as $no=>$get)
											<tr>
												<td>{{$no+1}}</td>
												<td>{{detail_unit($get->unit_id)}} {{$get->name}}</td>
												<td>{{total_lhk($get->kode,$tahun,4)}}</td>
												<td>{{total_lhk($get->kode,$tahun,2)}}</td>
												<td>{{total_lhk($get->kode,$tahun,3)}}</td>
												<td>{{total_lhk($get->kode,$tahun,1)}}</td>
												
												<td>{{total_lha($get->kode,$tahun,4)}}</td>
												<td>{{total_lha($get->kode,$tahun,2)}}</td>
												<td>{{total_lha($get->kode,$tahun,3)}}</td>
												<td>{{total_lha($get->kode,$tahun,1)}}</td>
												<td>{{total_lhp($get->kode,$tahun,4)}}</td>
												<td>{{total_lhp($get->kode,$tahun,2)}}</td>
												<td>{{total_lhp($get->kode,$tahun,3)}}</td>
												<td>{{total_lhp($get->kode,$tahun,1)}}</td>
											</tr>
											
										@endforeach
									@endif
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
		location.assign("{{url('/Dashboardall')}}?tahun="+tahun);
	}
</script>
<script>

   
</script>
@endpush
