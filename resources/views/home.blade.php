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
			<div class="row">
					
				@foreach(pertama_aktivitas_get() as $aktv)
					<div class="col-xl-4">
						<div class="card border-0 mb-3 overflow-hidden bg-dark text-white">
							<div class="card-body">
								<div class="row">
									<div class="col-xl-7 col-lg-8">
										<div class="mb-3 text-grey">
											<b>Pemanfaatan Hari Penugasan STIA{{$aktv->kode}}</b>
											
										</div>
										<div class="d-flex mb-1">
											<h2 class="mb-0"><span data-animation="number" data-value="{{dashboard_nilai_persen($aktv->kode,$tahun)}}">0.00</span>%</h2>
											<div class="ml-auto mt-n1 mb-n1"><div id="total-sales-sparkline"></div></div>
										</div>
										<div class="mb-3 text-grey">
											<i class="fa fa-caret-up"></i> <span data-animation="number" data-value="{{dashboard_nilai_persen($aktv->kode,$tahun)}}">0.00</span>
										</div>
										<hr class="bg-white-transparent-2" />
										<div class="row text-truncate">
											<div class="col-6">
												<div class="f-s-12 text-grey">PLAN</div>
												<div class="f-s-18 m-b-5 f-w-600 p-b-1"><span data-animation="number" data-value="{{dashboard_nilai_plan($aktv->kode,$tahun)}}">0.00</span>Hari</div>
											</div>
											<div class="col-6">
												<div class="f-s-12 text-grey">REAL</div>
												<div class="f-s-18 m-b-5 f-w-600 p-b-1"><span data-animation="number" data-value="{{dashboard_nilai_real($aktv->kode,$tahun)}}">0.00</span>Hari</div>
												
											</div>
										</div>
										<a href="#" class="btn btn-xs btn-indigo f-s-10 pl-2 pr-2" data-toggle="collapse" data-target="#collapse{{$aktv->kode}}" aria-expanded="false">View Detail</a>
									</div>
									<div class="col-xl-5 col-lg-4 align-items-center d-flex justify-content-center">
										@if(dashboard_nilai_persen($aktv->kode,$tahun)>100)
										<img src="{{url('img/down.png')}}" height="50%" style="position: absolute;" class="d-none d-lg-block" />
										@else
										<img src="{{url('img/up.png')}}" height="50%" style="position: absolute;" class="d-none d-lg-block" />
										@endif
										
									</div>
								</div>
							</div>
						</div>
						<div class="widget-list widget-list-rounded inverse-mode">
							<div id="accordion" class="accordion" style="width: 100%;">
								<div id="collapse{{$aktv->kode}}" class="collapse" data-parent="#accordion" style="">
									<div class="card border-0 text-truncate mb-3 bg-dark text-white">	
										<div class="card-body" style="background:#00000021">
										
											<div class="d-flex mb-2">
												<div class="d-flex align-items-center">
													<i class="fa fa-circle text-warning f-s-8 mr-2"></i>
													Total Dokumen STIA{{$aktv->kode}} ({{total_aktivitas_get_dashboard($aktv->kode,$tahun)}}) Dokumen
												</div>
												<div class="d-flex align-items-center ml-auto">
													<div class="width-50 text-right pl-2 f-w-600"><span data-animation="number" data-value="{{dashboard_nilai_plan($aktv->kode,$tahun)}}">3.85</span>%</div>
												</div>
											</div>
											@foreach(aktivitas_get_dashboard($aktv->kode,$tahun) as $do=>$dok)
												<div class="col-12">
													<div class="m-b-2 text-truncate">{{$do+1}}. {{$dok->nomortiket}} </div>
												</div>
												<div class="col-12" style="padding-left:3%">
													<div class="m-b-2 text-truncate" style="color:yellow;font-weight:bold">PLAN</div>
													<div class="d-flex align-items-center m-b-2">
														<div class="flex-grow-1">
															<div class="progress progress-xs rounded-corner bg-white-transparent-1">
																<div class="progress-bar progress-bar-striped bg-yellow" data-animation="width" data-value="{{nilai_plan($dok->id,$tahun)}}%" style="width: 80%;"></div>
															</div>
														</div>
														<div class="ml-2 f-s-11 width-30 text-center"><span data-animation="number" data-value="{{nilai_plan($dok->id,$tahun)}}">{{nilai_plan($dok->id,$tahun)}}</span>%</div>
													</div>
													<div class="m-b-2 text-truncate" style="color:{{color_nilai_real($dok->id,$tahun)}};font-weight:bold">REAL</div>
													<div class="d-flex align-items-center m-b-2">
														<div class="flex-grow-1">
															<div class="progress progress-xs rounded-corner bg-white-transparent-1">
																<div class="progress-bar progress-bar-striped bg-{{color_nilai_real($dok->id,$tahun)}}" data-animation="width" data-value="{{nilai_real($dok->id,$tahun)}}%" style="width: {{nilai_real($dok->id,$tahun)}}%;"></div>
															</div>
														</div>
														<div class="ml-2 f-s-11 width-30 text-center"><span data-animation="number" data-value="{{nilai_real($dok->id,$tahun)}}">{{nilai_real($dok->id,$tahun)}}</span>%</div>
													</div>
												</div>
											@endforeach



										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
	
@endsection
@push('ajax')
<script src="{{url('assets/assets/plugins/d3/d3.min.js')}}"></script>
<script src="{{url('assets/assets/plugins/nvd3/build/nv.d3.min.js')}}"></script>

<script>
	function pilih_tahun(tahun){
		location.assign("{{url('DashboardStia')}}?tahun="+tahun);
	}
</script>
<script>

   
</script>
@endpush
