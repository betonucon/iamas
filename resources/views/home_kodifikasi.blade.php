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
					<h4 class="panel-title">Dashboard Kodifikasi Temuan</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<div class="panel-body" style="background: #bfbfd3">
				<canvas id="bar-chart" data-render="chart-js"></canvas>
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
				<canvas id="bar2-chart" data-render="chart-js"></canvas>
				</div>
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-6 -->
	</div>
	<!-- end row -->
	
@endsection
@push('ajax')
<script>
function pilih_tahun(tahun){
		location.assign("{{url('DashboardKodifikasi')}}?tahun="+tahun);
	}
/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Version: 4.6.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin/admin/
*/

Chart.defaults.global.defaultFontColor = COLOR_DARK;
Chart.defaults.global.defaultFontFamily = FONT_FAMILY;
Chart.defaults.global.defaultFontStyle = FONT_WEIGHT;

var randomScalingFactor = function() { 
	return Math.round(Math.random()*100)
};


var barChartData = {
	labels: [@foreach(kodefikasi_get() as $kodefikasi_get)
			'{{$kodefikasi_get->kodifikasi}} {{$kodefikasi_get->kategori}}',
			@endforeach],
	datasets: [{
		label: 'Cumulative Return',
		borderWidth: 2,
		borderColor: "red",
		backgroundColor: "red",
		data: [@foreach(kodefikasi_get() as $kodefikasi_get)
				{{total_kodifikasi($kodefikasi_get->kodifikasi,$tahun)}},
			@endforeach],
			

	}]
};
var barChartData2 = {
	labels: [@foreach(kodefikasi_get() as $kodefikasi_get)
			'{{$kodefikasi_get->kodifikasi}} {{$kodefikasi_get->kategori}}',
			@endforeach],
	datasets: [{
		label: 'Cumulative Return',
		borderWidth: 2,
		borderColor: "orange",
		backgroundColor: "orange",
		data: [@foreach(kodefikasi_get() as $kodefikasi_get)
				{{total_kodifikasi_rekomendasi($kodefikasi_get->kodifikasi,$tahun)}},
			@endforeach],
			

	}]
};


var handleChartJs = function() {
	
	var ctx2 = document.getElementById('bar-chart').getContext('2d');
	var barChart = new Chart(ctx2, {
		type: 'bar',
		data: barChartData
	});

	var ctx3 = document.getElementById('bar2-chart').getContext('2d');
	var barChart = new Chart(ctx3, {
		type: 'bar',
		data: barChartData2
	});

	
};

var ChartJs = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleChartJs();
		}
	};
}();

$(document).ready(function() {
	ChartJs.init();
});
</script>
@endpush
