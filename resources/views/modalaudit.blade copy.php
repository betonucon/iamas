<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{url('assets/assets/css/default/app.min.css')}}" rel="stylesheet" />
    <div>
        <canvas id="line-chart" data-render="chart-js"></canvas>
    </div>

    <script src="{{url('assets/assets/js/app.min.js')}}"></script>
	<script src="{{url('assets/assets/js/theme/default.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{url('assets/assets/plugins/chart.js/dist/Chart.min.js')}}"></script>
    <script>

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

        
        var lineChartData = {
            labels: [
                'Audit Plan',
                'Deskaudit Program',
                'DeskAudit Catatan',
                'Compliance Program',
                'Compliance Catatan',
                'Substantive Program',
                'Substantive Catatan',
                'Lha Program',
            ],
            datasets: [{
                label: 'Dataset 1',
                borderColor: COLOR_BLUE,
                pointBackgroundColor: COLOR_BLUE,
                pointRadius: 2,
                borderWidth: 2,
                backgroundColor: COLOR_BLUE_TRANSPARENT_3,
                data: [
                    0,
                    {{cek_kurva($data->id,'desk_prog',1)}},
                    {{cek_kurva($data->id,'desk_catatan',1)}},
                    {{cek_kurva($data->id,'com_prog',1)}},
                    {{cek_kurva($data->id,'com_catatan',1)}},
                    {{cek_kurva($data->id,'subs_prog',1)}},
                    {{cek_kurva($data->id,'subs_catatan',1)}},
                    {{cek_kurva($data->id,'draf',1)}},
                ]
            }, {
                label: 'Dataset 2',
                borderColor: COLOR_DARK_LIGHTER,
                pointBackgroundColor: COLOR_DARK,
                pointRadius: 2,
                borderWidth: 2,
                backgroundColor: COLOR_DARK_TRANSPARENT_3,
                data: [
                    0,
                    {{cek_kurva($data->id,'desk_prog',2)}},
                    {{cek_kurva($data->id,'desk_catatan',2)}},
                    {{cek_kurva($data->id,'com_prog',2)}},
                    {{cek_kurva($data->id,'com_catatan',2)}},
                    {{cek_kurva($data->id,'subs_prog',2)}},
                    {{cek_kurva($data->id,'subs_catatan',2)}},
                    {{cek_kurva($data->id,'draf',2)}},
                ]
            }]
        };

        
       

        var handleChartJs = function() {
            var ctx = document.getElementById('line-chart').getContext('2d');
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: lineChartData
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