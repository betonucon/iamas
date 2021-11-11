@extends('layouts.web')

@push('style')
<link href="{{url('assets/assets/plugins/nvd3/build/nv.d3.css')}}" rel="stylesheet" />
@endpush
@section('contex')
            <div class="row">
				
				<!-- begin col-6 -->
				<div class="col-xl-1">
                </div>
				<div class="col-xl-10">
					<!-- begin panel -->
					<div class="panel panel-inverse" data-sortable-id="chart-js-2">
						<div class="panel-heading">
							<h4 class="panel-title">Dashboard</h4>
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
							</div>
						</div>
						<div class="panel-body">
							<p>
                                Histogram Progres Total  Surat Tugas (STIA 1,2,3)
                            </p>
							<div>
								<canvas id="bar-chart" data-render="chart-js"></canvas>
							</div>
						</div>
					</div>
					<!-- end panel -->
				</div>
				<div class="col-xl-1">
                </div>
			</div>
			<!-- end row -->
			
			
@endsection
@push('ajax')
<script>
Chart.defaults.global.defaultFontColor = COLOR_DARK;
Chart.defaults.global.defaultFontFamily = FONT_FAMILY;
Chart.defaults.global.defaultFontStyle = FONT_WEIGHT;

var randomScalingFactor = function() { 
	return Math.round(Math.random()*100)
};

var lineChartData = {
	labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
	datasets: [{
		label: 'Dataset 1',
		borderColor: COLOR_BLUE,
		pointBackgroundColor: COLOR_BLUE,
		pointRadius: 2,
		borderWidth: 2,
		backgroundColor: COLOR_BLUE_TRANSPARENT_3,
		data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
	}, {
		label: 'Dataset 2',
		borderColor: COLOR_DARK_LIGHTER,
		pointBackgroundColor: COLOR_DARK,
		pointRadius: 2,
		borderWidth: 2,
		backgroundColor: COLOR_DARK_TRANSPARENT_3,
		data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
	}]
};

var barChartData = {
	labels: [
            @foreach(aktivitas_get_dashboard() as $gte)
                '{{$gte->nomortiket}}',
            @endforeach
        ],
	datasets: [{
		label: 'PLAN',
		borderWidth: 2,
		borderColor: COLOR_DARK,
		backgroundColor: "blue",
		data: [
            @foreach(aktivitas_get_dashboard() as $gte)
                {{$gte->id}},
            @endforeach
        ]
	}, {
		label: 'REAL',
		borderWidth: 2,
		borderColor: COLOR_DARK,
		backgroundColor: "yellow",
		data: [
            @foreach(aktivitas_get_dashboard() as $gte)
                {{($gte->id+2)}},
            @endforeach
        ]
	}]
};

var radarChartData = {
	labels: ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'],
	datasets: [{
		label: 'Dataset 1',
		borderWidth: 2,
		borderColor: COLOR_RED,
		pointBackgroundColor: COLOR_RED,
		pointRadius: 2,
		backgroundColor: COLOR_RED_TRANSPARENT_2,
		data: [65,59,90,81,56,55,40]
	}, {
		label: 'Dataset 2',
		borderWidth: 2,
		borderColor: COLOR_DARK,
		pointBackgroundColor: COLOR_DARK,
		pointRadius: 2,
		backgroundColor: COLOR_DARK_TRANSPARENT_2,
		data: [28,48,40,19,96,27,100]
	}]
};

var polarAreaData = {
	labels: ['Dataset 1', 'Dataset 2', 'Dataset 3', 'Dataset 4', 'Dataset 5'],
	datasets: [{
		data: [300, 160, 100, 200, 120],
		backgroundColor: [COLOR_INDIGO_TRANSPARENT_7, COLOR_BLUE_TRANSPARENT_7, COLOR_GREEN_TRANSPARENT_7, COLOR_GREY_TRANSPARENT_7, COLOR_DARK_TRANSPARENT_7],
		borderColor: [COLOR_INDIGO, COLOR_BLUE, COLOR_GREEN, COLOR_GREY, COLOR_DARK],
		borderWidth: 2,
		label: 'My dataset'
	}]
};

var pieChartData = {
	labels: ['Dataset 1', 'Dataset 2', 'Dataset 3', 'Dataset 4', 'Dataset 5'],
	datasets: [{
		data: [300, 50, 100, 40, 120],
		backgroundColor: [COLOR_RED_TRANSPARENT_7, COLOR_ORANGE_TRANSPARENT_7, COLOR_MUTED_TRANSPARENT_7, COLOR_GREY_TRANSPARENT_7, COLOR_DARK_TRANSPARENT_7],
		borderColor: [COLOR_RED, COLOR_ORANGE, COLOR_MUTED, COLOR_GREY, COLOR_DARK],
		borderWidth: 2,
		label: 'My dataset'
	}]
};

var doughnutChartData = {
	labels: ['Dataset 1', 'Dataset 2', 'Dataset 3', 'Dataset 4', 'Dataset 5'],
	datasets: [{
		data: [300, 50, 100, 40, 120],
		backgroundColor: [COLOR_INDIGO_TRANSPARENT_7, COLOR_BLUE_TRANSPARENT_7, COLOR_GREEN_TRANSPARENT_7, COLOR_GREY_TRANSPARENT_7, COLOR_DARK_TRANSPARENT_7],
		borderColor: [COLOR_INDIGO, COLOR_BLUE, COLOR_GREEN, COLOR_GREY, COLOR_DARK],
		borderWidth: 2,
		label: 'My dataset'
  }]
};

var handleChartJs = function() {
	

	var ctx2 = document.getElementById('bar-chart').getContext('2d');
	var barChart = new Chart(ctx2, {
		type: 'bar',
		data: barChartData
	});

	var ctx3 = document.getElementById('radar-chart').getContext('2d');
	var radarChart = new Chart(ctx3, {
		type: 'radar',
		data: radarChartData
	});

	var ctx4 = document.getElementById('polar-area-chart').getContext('2d');
	var polarAreaChart = new Chart(ctx4, {
		type: 'polarArea',
		data: polarAreaData
	});

	var ctx5 = document.getElementById('pie-chart').getContext('2d');
	window.myPie = new Chart(ctx5, {
		type: 'pie',
		data: pieChartData
	});

	var ctx6 = document.getElementById('doughnut-chart').getContext('2d');
	window.myDoughnut = new Chart(ctx6, {
		type: 'doughnut',
		data: doughnutChartData
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
