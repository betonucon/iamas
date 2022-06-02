    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{url('assets/assets/css/default/app.min.css')}}" rel="stylesheet" />
    <div>
    {{cek_kurva($data->id,'desk_prog',1)}}
        <div id="apex-line-chart"></div>
    </div>

    <script src="{{url('assets/assets/js/app.min.js')}}"></script>
	<script src="{{url('assets/assets/js/theme/default.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
	<script src="{{url('assets/assets/plugins/apexcharts/dist/apexcharts.min.js')}}"></script>
    <script>
                /*
            Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
            Version: 4.6.0
            Author: Sean Ngu
            Website: http://www.seantheme.com/color-admin/admin/
            */

            var handleLineChart = function() {
                "use strict";
                
                var options = {
                    chart: {
                        height: 650,
                        type: 'line',
                        shadow: {
                            enabled: true,
                            color: COLOR_DARK,
                            top: 18,
                            left: 1,
                            blur: 10,
                            opacity: 1
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    title: {
                        text: 'Average High & Low Temperature',
                        align: 'center'
                    },
                    colors: [COLOR_BLUE, COLOR_TEAL],
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 1
                    },
                    series: [{
                        name: 'High - 2020',
                        data: [ 0,
                                1,
                                {{cek_kurva($data->id,'desk_prog',1)}},
                                {{cek_kurva($data->id,'desk_catatan',1)}},
                                {{cek_kurva($data->id,'com_prog',1)}},
                                {{cek_kurva($data->id,'com_catatan',1)}},
                                {{cek_kurva($data->id,'subs_prog',1)}},
                                {{cek_kurva($data->id,'subs_catatan',1)}},
                                {{cek_kurva($data->id,'draf',1)}},
                                
                            ]
                    }, {
                        name: 'Low - 2020',
                        data: [ 0,
                                1,
                                {{cek_kurva($data->id,'desk_prog',2)}},
                                {{cek_kurva($data->id,'desk_catatan',2)}},
                                {{cek_kurva($data->id,'com_prog',2)}},
                                {{cek_kurva($data->id,'com_catatan',2)}},
                                {{cek_kurva($data->id,'subs_prog',2)}},
                                {{cek_kurva($data->id,'subs_catatan',2)}},
                                {{cek_kurva($data->id,'draf',2)}},
                                
                            ],
                    }],
                    grid: {
                        row: {
                            colors: [COLOR_SILVER_TRANSPARENT_1, 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    markers: {
                        size: 4
                    },
                    xaxis: {
                        categories: ['',
                                    'Audit(Plan={{tgl_smp($data->tgl_plan)}})',
                                    'Audit(Real={{tgl_smp($data->tgl_sts3)}})',
                                    'Desk Prog(Plan={{tgl_smp($data->tgl_deskaudit_program_start)}})',
                                    'Desk Prog(Real={{tgl_smp($data->tgl_sts4)}})',
                                    'Desk Cat(Plan={{tgl_smp($data->tgl_deskaudit_hasil_start)}})',
                                    'Desk Cat(Real={{tgl_smp($data->tgl_sts6)}})',
                                    'Comp Prog(Plan={{tgl_smp($data->tgl_complianace_program_start)}})',
                                    'Comp Prog(Real={{tgl_smp($data->tgl_sts4)}})',
                                    'Comp Cat(Plan={{tgl_smp($data->tgl_complianace_hasil_start)}})',
                                    'Comp Cat(Real={{tgl_smp($data->tgl_sts6)}})',
                                    'Subs Prog(Plan={{tgl_smp($data->tgl_substantive_program_start)}})',
                                    'Subs Prog(Real={{tgl_smp($data->tgl_sts4)}})',
                                    'Subs Cat(Plan={{tgl_smp($data->tgl_substantive_hasil_start)}})',
                                    'Subs Cat(Real={{tgl_smp($data->tgl_sts6)}})',
                                    'Lha Prog(Plan={{tgl_smp($data->tgl_substantive_program_start)}})',
                                    'Lha Prog(Real={{tgl_smp($data->tgl_sts4)}})',
                                ],
                        // categories: ['Audit(Plan={{tgl_smp($data->tgl_plan)}})','Audit(Real={{tgl_smp($data->tgl_plan)}})','Desk Prog(Plan)','Desk Prog(Real)','Desk Cat(Plan)','Desk Cat(Real)','Comp Prog(Plan)','Comp Prog(Real)','Comp Cat(Plan)','Comp Cat(Real)','Subs Prog(Plan)','Subs Prog(Real)','Subs Cat(Plan)','Subs Cat(Real)','Draf LHA(Plan)','Draf LHA(Real)'],
                        axisBorder: {
                            show: true,
                            color: COLOR_SILVER_TRANSPARENT_5,
                            height: 1,
                            width: '100%',
                            offsetX: 0,
                            offsetY: -1
                        },
                        axisTicks: {
                            show: true,
                            borderType: 'solid',
                            color: COLOR_SILVER,
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 100
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        offsetY: -1,
                        horizontalAlign: 'right',
                floating: true,
                    }
                };

                var chart = new ApexCharts(
                    document.querySelector('#apex-line-chart'),
                    options
                );

                chart.render();
            };

            

            var ChartApex = function () {
                "use strict";
                return {
                    //main function
                    init: function () {
                        handleLineChart();
                        
                    }
                };
            }();

            $(document).ready(function() {
                ChartApex.init();
            });
    </script>