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
					
				@foreach(pertama_aktivitas_02get() as $aktv)
					<div class="col-xl-12">
						<div class="card border-0 mb-3 overflow-hidden bg-dark text-white">
							<div class="card-body">
								<div class="row">
									<div class="col-xl-7 col-lg-8">
										<div class="mb-3 text-grey">
											<b>STIA{{$aktv->kode}}</b>
											<span class="ml-2">
												<i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Total sales" data-placement="top" data-content="Net sales (gross sales minus discounts and returns) plus taxes and shipping. Includes orders from all sales channels."></i>
											</span>
										</div>
										<div class="d-flex mb-1">
											<h2 class="mb-0">%<span data-animation="number" data-value="{{rekapan_aktivitas_get_dashboard($aktv->kode,$tahun)}}">0.00</span></h2>
											<div class="ml-auto mt-n1 mb-n1"><div id="total-sales-sparkline"></div></div>
										</div>
										<div class="mb-3 text-grey">
											<i class="fa fa-caret-up"></i> <span data-animation="number" data-value="{{rekapan_aktivitas_get_dashboard($aktv->kode,$tahun)}}">0.00</span>
										</div>
										<hr class="bg-white-transparent-2" />
										<div class="row text-truncate">
											<div class="col-6">
												<div class="f-s-12 text-grey">PLAN</div>
												<div class="f-s-18 m-b-5 f-w-600 p-b-1">%<span data-animation="number" data-value="{{dashboard_nilai_plan($aktv->kode,$tahun)}}">0.00</span></div>
												<div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
													<div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="{{dashboard_nilai_plan($aktv->kode,$tahun)}}%" style="width: 0%"></div>
												</div>
											</div>
											<div class="col-6">
												<div class="f-s-12 text-grey">REAL</div>
												<div class="f-s-18 m-b-5 f-w-600 p-b-1">%<span data-animation="number" data-value="{{dashboard_nilai_real($aktv->kode,$tahun)}}">0.00</span></div>
												<div class="progress progress-xs rounded-lg bg-dark-darker m-b-5">
													<div class="progress-bar progress-bar-striped rounded-right" data-animation="width" data-value="{{dashboard_nilai_real($aktv->kode,$tahun)}}%" style="width: 0%"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-5 col-lg-4 align-items-center d-flex justify-content-center">
										<img src="{{url('assets/assets/img/svg/img-1.svg')}}" height="50%" class="d-none d-lg-block" />
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				<div class="col-xl-12">
					
						<div class="row">
							<div class="col-sm-12">
								<div class="card border-0 text-truncate mb-3 bg-dark text-white">
									<div class="card-body">
										<div class="mb-3 text-grey">
											<b class="mb-3">DETAIL DASHBOARD</b> 
											<span class="ml-2"><i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Conversion Rate" data-placement="top" data-content="Percentage of sessions that resulted in orders from total number of sessions." data-original-title="" title=""></i></span>
										</div>
										
										
										@foreach(pertama_aktivitas_02get() as $aktv)
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
													<div class="m-b-2 text-truncate">{{$do+1}}. {{$dok->nomortiket}} ({{rekap_stia($dok->id,$tahun)}}%)</div>
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
													<div class="m-b-2 text-truncate" style="color:#9dc8f5;font-weight:bold">REAL</div>
													<div class="d-flex align-items-center m-b-2">
														<div class="flex-grow-1">
															<div class="progress progress-xs rounded-corner bg-white-transparent-1">
																<div class="progress-bar progress-bar-striped bg-aqua" data-animation="width" data-value="{{nilai_real($dok->id,$tahun)}}%" style="width: {{nilai_real($dok->id,$tahun)}}%;"></div>
															</div>
														</div>
														<div class="ml-2 f-s-11 width-30 text-center"><span data-animation="number" data-value="{{nilai_real($dok->id,$tahun)}}">{{nilai_real($dok->id,$tahun)}}</span>%</div>
													</div>
												</div>
											@endforeach
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
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
