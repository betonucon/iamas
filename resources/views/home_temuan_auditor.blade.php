@extends('layouts.web')

@push('style')
<link href="{{url('assets/assets/plugins/nvd3/build/nv.d3.css')}}" rel="stylesheet" />
<style>
	.progress.progress-xs {
    	height: 7px;
	}
	.ttdd{
		padding:0px !important;
		color:#fff;
		border:solid 0px #000 !important;
	}
</style>
@endpush
@section('contex')
			<div class="d-sm-flex align-items-center mb-3" style="padding: 1%;background: #8195a9;">
				<select onchange="pilih_tahun(this.value)" style="width:15%;display:inline" class="form-control">
					@for($x=2020;$x<=date('Y');$x++)
						<option value="{{$x}}" @if($tahun==$x) selected @endif>Tahun {{$x}}</option>
					@endfor
				</select>
				<!-- <select onchange="pilih_kode(this.value)" style="width:30%;display:inline" class="form-control">
					@foreach(get_unit_audite() as $getunit)
						<option value="{{$getunit->kode}}" @if($getunit->kode=="") selected @endif> {{$getunit->name}}</option>
					@endforeach
				</select> -->
			</div>
			
			<div class="row">
				@foreach(headtemuan_auditee_get(0,$tahun) as $det)
					<div class="col-xl-12 col-lg-12">
						<div class="card border-0 mb-3 bg-dark-darker text-white">
							<div class="card-body" style="background: no-repeat bottom right; background-image: url(../assets/img/svg/img-4.svg); background-size: auto 60%;">
								<div class="row">
									<!-- <div class="col-xl-12 col-lg-12">

									</div> -->
									<div class="col-xl-3 col-lg-12">
										<div class="text-grey">
											<b>TEMUAN {{$det->kode_sumber}}</b>
											<span class="text-grey ml-2"><i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Sales by social source" data-placement="top" data-content="Total online store sales that came from a social referrer source." data-original-title="" title=""></i></span>
														
											<h3 class="m-b-10"><span data-animation="number" data-value="{{total_temuan(0,$tahun,$det->kode_sumber)}}">{{total_temuan(0,$tahun,$det->kode_sumber)}}</span></h3>
											<img src="{{url('assets/assets/img/svg/img-1.svg')}}" width="70%" class="d-none d-lg-block" />
											
										</div>
									</div>
									<div class="col-xl-6 col-lg-12">
									


										<div class="m-b-2 text-truncate">Belum Tindak Lanjut</div>
										<div class="d-flex align-items-center m-b-2">
											<div class="flex-grow-1">
												<div class="progress progress-xs rounded-corner bg-white-transparent-1">
													<div class="progress-bar  bg-red" data-animation="width" data-value="{{round(total_temuan_nol(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber)))}}%" style="width: {{total_temuan_nol(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}%" style="width: {{total_temuan_nol(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}%"></div>
												</div>
											</div>
											<div class="ml-2 f-s-11 width-30 text-center"><span data-animation="number" data-value="{{round(total_temuan_nol(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber)))}}" style="width: {{total_temuan_nol(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}">{{total_temuan_nol(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}</span>%</div>
										</div>

										<div class="m-b-2 text-truncate">Dalam Progres</div>
										<div class="d-flex align-items-center m-b-2">
											<div class="flex-grow-1">
												<div class="progress progress-xs rounded-corner bg-white-transparent-1">
													<div class="progress-bar  bg-yellow" data-animation="width" data-value="{{round(total_temuan_progres(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber)))}}%" style="width: {{total_temuan_progres(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}%" style="width: {{total_temuan_progres(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}%"></div>
												</div>
											</div>
											<div class="ml-2 f-s-11 width-30 text-center"><span data-animation="number" data-value="{{round(total_temuan_progres(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber)))}}" style="width: {{total_temuan_progres(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}">{{total_temuan_progres(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}</span>%</div>
										</div>

										<div class="m-b-2 text-truncate">Selesai</div>
										<div class="d-flex align-items-center m-b-2">
											<div class="flex-grow-1">
												<div class="progress progress-xs rounded-corner bg-white-transparent-1">
													<div class="progress-bar  bg-green" data-animation="width" data-value="{{round(total_temuan_selesai(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber)))}}%" style="width: {{total_temuan_selesai(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}%;"></div>
												</div>
											</div>
											<div class="ml-2 f-s-11 width-30 text-center"><span data-animation="number" data-value="{{round(total_temuan_selesai(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber)))}}">{{total_temuan_selesai(0,$tahun,$det->kode_sumber)*(100/total_temuan(0,$tahun,$det->kode_sumber))}}</span>%</div>
										</div>
										<a href="#" class="btn btn-xs btn-indigo f-s-10 pl-2 pr-2" data-toggle="collapse" data-target="#collapse{{$det->kode_sumber}}" aria-expanded="false">View campaign</a>
									




									</div>
									<div class="col-xl-3 col-lg-12">
										<div class="table-responsive">
											<h4 class="widget-chart-info-title" style="text-transform:uppercase">DESKRIPSI {{$det->kode_sumber}}</h4>
											<hr style="margin: 0px 0px 10px 0px; border-top: double 3px #fff;">
											<table class="table table-valign-middle table-panel mb-0">
												<tbody>
													<!-- <tr>
														<td><label class="label label-danger">Unique Visitor</label></td>
														<td>13,203 <span class="text-success"><i class="fa fa-arrow-up"></i></span></td>
														<td><div id="sparkline-unique-visitor"><canvas width="118" height="23" style="display: inline-block; width: 118.703px; height: 23px; vertical-align: top;"></canvas></div></td>
													</tr> -->
													<tr>
														<td class="ttdd" width="40%">Total Temuan</td>
														<td class="ttdd" width="5%">:</td>
														<td class="ttdd">{{total_temuan(0,$tahun,$det->kode_sumber)}}</td>
													</tr>
													<tr>
														<td class="ttdd">Belum TL</td>
														<td class="ttdd">:</td>
														<td class="ttdd">{{total_temuan_nol(0,$tahun,$det->kode_sumber)}}</td>
													</tr>
													<tr>
														<td class="ttdd">Progres</td>
														<td class="ttdd">:</td>
														<td class="ttdd">{{total_temuan_progres(0,$tahun,$det->kode_sumber)}}</td>
													</tr>
													<tr>
														<td class="ttdd">Selesai</td>
														<td class="ttdd">:</td>
														<td class="ttdd">{{total_temuan_selesai(0,$tahun,$det->kode_sumber)}}</td>
													</tr>
													<tr>
														<td class="ttdd">Indikator</td>
														<td class="ttdd">:</td>
														<td class="ttdd">
															@if(total_temuan(0,$tahun,$det->kode_sumber)==total_temuan_selesai(0,$tahun,$det->kode_sumber))
																<span class="btn btn-sm btn-blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
															@else
																<span class="btn btn-sm btn-grey" style="background:grey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
															@endif
													</tr>
													
												</tbody>
											</table>
										</div>
									</div>
								</div>		
									
							</div>
							<div class="widget-list widget-list-rounded inverse-mode">
								<div id="accordion" class="accordion" style="width: 100%;">
									<div id="collapse{{$det->kode_sumber}}" class="collapse" data-parent="#accordion" style="">
										<div class="card-body" style="background:#fff">
											<div class="table-responsive">
												<table class="table table-bordered m-b-0">
													<thead>
														<tr>
															<th>No</th>
															<th>Unit Kerja</th>
															<th>Nomor Temuan</th>
															<th>Nomor</th>
															<th>Risiko</th>
															<th>Status</th>
															<th>U.Temuan</th>
															<th>U.Progres</th>
															<th>Aging</th>
															<!-- <th>Nil Rv</th> -->
														</tr>
													</thead>
													<tbody>
														@foreach(detail_temuan_get(0,$tahun,$det->kode_sumber) as $no=>$get)
															<tr>
																<td>{{$no+1}}</td>
																<td>{{$get->unit_name}}</td>
																<td>{{$get->nomorkode}}</td>
																<td>{{$get->nomor}}.{{$get->urutan}}</td>
																<td>{{$get->ket_risiko}}</td>
																<td>
																	@if($get->sts==1)
																		@if($get->sts_tl=='B')
																			<b>(B)</b> Pengisian Tindak Lanjut
																		@else
																			<b>({{$get->sts_tl}})</b> {{track_temuan_auditee($get->sts)}}
																		@endif
																	@else
																		@if($get->sts_tl=='S')
																			@if($get->sts_release!=3)
																				<b>({{$get->sts_tl_sebelumnya}})</b> Review AI
																			@else
																				<b>(S)</b> Selesai
																			@endif
																			
																		@else
																			@if($get->sts_tl=='B')
																				<b>(B)</b> Pengisian Tindak Lanjut
																			@else
																				<b>({{$get->sts_tl}}</b> Review AI
																			@endif
																			
																		@endif
																	@endif
																</td>
																<td>
																	@if($get->sts_tl=='B')
																		<font style="font-weight:bold" color="red">{{selisih_all($get->terbit,date('Y-m-d H:i:s'))}} Hari</font>
																	@elseif($get->sts_tl=='S')
																		<font style="font-weight:bold" color="green">{{selisih_all($get->terbit,$get->tgl_mulai)}} Hari</font>
																	@else
																		@if($get->sts==1)
																			<font style="font-weight:bold" color="#f9aa1b">{{selisih_all($get->terbit,date('Y-m-d H:i:s'))}} Hari</font>
																		@else
																			<font style="font-weight:bold" color="#f9aa1b">{{selisih_all($get->terbit,$get->tgl_mulai)}} Hari</font>
																		@endif
																			
																	@endif
																</td>
																<td>
																	@if($get->sts_tl=='B')
																		<font style="font-weight:bold" color="red">{{selisih_all($get->terbit,date('Y-m-d H:i:s'))}} Hari</font>
																	@elseif($get->sts_tl=='S')
																		<font style="font-weight:bold" color="green">{{selisih_all($get->terbit_p,$get->tgl_mulai)}} Hari</font>
																	@else
																		@if($get->sts==1)
																			<font style="font-weight:bold" color="#f9aa1b">{{selisih_all($get->terbit_p,date('Y-m-d H:i:s'))}} Hari</font>
																		@else
																			<font style="font-weight:bold" color="#f9aa1b">{{selisih_all($get->terbit_p,$get->tgl_mulai)}} Hari</font>
																		@endif
																			
																	@endif
																</td>
																<td>
																	@if($get->sts_tl=='B')
																		<font style="font-weight:bold" color="red">{{(selisih_all($get->terbit,date('Y-m-d H:i:s'))-45)}} Hari</font>
																	@elseif($get->sts_tl=='S')
																		<font style="font-weight:bold" color="green">{{(selisih_all($get->terbit,$get->tgl_mulai)-45)}} Hari</font>
																	@else
																		@if($get->sts==1)
																			<font style="font-weight:bold" color="#f9aa1b">{{(selisih_all($get->terbit_p,date('Y-m-d H:i:s'))-45)}} Hari</font>
																		@else
																			<font style="font-weight:bold" color="#f9aa1b">{{(selisih_all($get->terbit_p,$get->tgl_mulai)-45)}} Hari</font>
																		@endif
																			
																	@endif
																</td>
																<!-- <td>
																	@if($get->sts_tl=='B')
																		
																	@elseif($get->sts_tl=='S')
																		<font style="font-weight:bold" color="green">{{selisih_all($get->mulai,$get->tgl_progres)}} Hari</font>
																	@else
																		@if($get->sts==1)
																			
																		@else
																			<font style="font-weight:bold" color="green">{{selisih_all($get->mulai,$get->tgl_progres)}} Hari</font>
																		@endif
																			
																	@endif
																</td> -->
																
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
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
		location.assign("{{url('Dashboardtemuan')}}?tahun="+tahun);
	}
</script>
<script>

   
</script>
@endpush
