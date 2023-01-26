@extends('layouts.web')

@push('style')
<link href="{{url('assets/assets/plugins/nvd3/build/nv.d3.css')}}" rel="stylesheet" />
@endpush
@section('contex')
	<!-- begin row -->
	<div class="d-sm-flex align-items-center mb-3" style="padding: 1%;background: #8195a9;">
		<label style="color:#fff">PILIH TAHUN &nbsp;&nbsp;</label>
		<select onchange="pilih_tahun(this.value)" style="width:30%;display:inline" class="form-control">
			@for($x=2020;$x<=date('Y');$x++)
				<option value="{{$x}}" @if($tahun==$x) selected @endif> Dashboard Tahun {{$x}}</option>
			@endfor
		</select>
	</div>
	<div class="row">
		
		<!-- begin col-6 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Dashboard Kodifikasi</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<div class="panel-body" style="background: #bfbfd3">
					<div id="nv-bar-chart" class="height-sm"></div>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Dashboard Kodifikasi Rekomendasi</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<div class="panel-body" style="background:#bfbfd3">
					<div id="nv-bar-chart-rekomendasi" class="height-sm"></div>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-6 -->
	</div>
	<!-- end row -->
	
@endsection
@push('ajax')
<script src="{{url('assets/assets/plugins/d3/d3.min.js')}}"></script>
<script src="{{url('assets/assets/plugins/nvd3/build/nv.d3.min.js')}}"></script>

<script>
function pilih_tahun(tahun){
		location.assign("{{url('DashboardKodifikasi')}}?tahun="+tahun);
	}
var handleBarChart = function() {
	"use strict";

	var barChartData = [{
		key: 'Cumulative Return',
		values: [
			@foreach(kodefikasi_get() as $kodefikasi_get)
			{ 'label' : '{{$kodefikasi_get->kodifikasi}}', 'value' : {{total_kodifikasi($kodefikasi_get->kodifikasi,$tahun)}}, 'color' : COLOR_PURPLE }, 
			// { 'label' : 'A', 'value' : 29, 'color' : COLOR_RED }, 
			// { 'label' : 'B', 'value' : 15, 'color' : COLOR_ORANGE }, 
			// { 'label' : 'C', 'value' : 32, 'color' : COLOR_GREEN }, 
			// { 'label' : 'D', 'value' : 196, 'color' : COLOR_AQUA },  
			// { 'label' : 'E', 'value' : 44, 'color' : COLOR_BLUE },  
			// { 'label' : 'F', 'value' : 98, 'color' : COLOR_PURPLE },  
			// { 'label' : 'G', 'value' : 13, 'color' : COLOR_GREY },  
			// { 'label' : 'H', 'value' : 5, 'color' : COLOR_BLACK }
			@endforeach
		]
	}];

	nv.addGraph(function() {
		var barChart = nv.models.discreteBarChart()
		  .x(function(d) { return d.label })
		  .y(function(d) { return d.value })
		  .showValues(true)
		  .duration(250);

		barChart.yAxis.axisLabel("Jumlah Kodifikasi");
		barChart.xAxis.axisLabel('Kodifikasi');

		d3.select('#nv-bar-chart').append('svg').datum(barChartData).call(barChart);
		nv.utils.windowResize(barChart.update);

		return barChart;
	});
}

var handleBarChartrekomendasi = function() {
	"use strict";

	var barChartDatarekomendasi = [{
		key: 'Cumulative Return',
		values: [
			@foreach(kodefikasi_get() as $kodefikasi_get)
			{ 'label' : '{{$kodefikasi_get->kodifikasi}}', 'value' : {{total_kodifikasi_rekomendasi($kodefikasi_get->kodifikasi,$tahun)}}, 'color' : COLOR_ORANGE }, 
			// { 'label' : 'A', 'value' : 29, 'color' : COLOR_RED }, 
			// { 'label' : 'B', 'value' : 15, 'color' : COLOR_ORANGE }, 
			// { 'label' : 'C', 'value' : 32, 'color' : COLOR_GREEN }, 
			// { 'label' : 'D', 'value' : 196, 'color' : COLOR_AQUA },  
			// { 'label' : 'E', 'value' : 44, 'color' : COLOR_BLUE },  
			// { 'label' : 'F', 'value' : 98, 'color' : COLOR_PURPLE },  
			// { 'label' : 'G', 'value' : 13, 'color' : COLOR_GREY },  
			// { 'label' : 'H', 'value' : 5, 'color' : COLOR_BLACK }
			@endforeach
		]
	}];

	nv.addGraph(function() {
		var barChartrekomendasi = nv.models.discreteBarChart()
		  .x(function(d) { return d.label })
		  .y(function(d) { return d.value })
		  .showValues(true)
		  .duration(250);

		barChartrekomendasi.yAxis.axisLabel("Jumlah Kodifikasi");
		barChartrekomendasi.xAxis.axisLabel('Kodifikasi');

		d3.select('#nv-bar-chart-rekomendasi').append('svg').datum(barChartDatarekomendasi).call(barChartrekomendasi);
		nv.utils.windowResize(barChartrekomendasi.update);

		return barChartrekomendasi;
	});
}




var ChartNvd3 = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleBarChart();
			handleBarChartrekomendasi();
		}
	};
}();

$(document).ready(function() {
	ChartNvd3.init();
});
</script>
@endpush
