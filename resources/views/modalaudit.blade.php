<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{url('assets/assets/css/default/app.min.css')}}" rel="stylesheet" />
    <?php
        $akmdesk=(cek_kurva($data->id,'desk_prog',1)+0);
        $akmdeskcatatan=$akmdesk+cek_kurva($data->id,'desk_catatan',1);
        $akmcomp=$akmdeskcatatan+cek_kurva($data->id,'com_prog',1);
        $akmcompcatatan=$akmcomp+cek_kurva($data->id,'com_catatan',1);
        $akmsubs=$akmcompcatatan+cek_kurva($data->id,'subs_prog',1);
        $akmsubscatatan=$akmsubs+cek_kurva($data->id,'subs_catatan',1);
        $akmlha=$akmsubscatatan+cek_kurva($data->id,'draf',1);
        $total=cek_kurva($data->id,'desk_prog',1)
                +cek_kurva($data->id,'desk_catatan',1)
                +cek_kurva($data->id,'com_prog',1)
                +cek_kurva($data->id,'com_catatan',1)
                +cek_kurva($data->id,'subs_prog',1)
                +cek_kurva($data->id,'subs_catatan',1)
                +cek_kurva($data->id,'draf',1);
        
        $akmdesk2=(cek_kurva($data->id,'desk_prog',2)+0);
        $akmdeskcatatan2=$akmdesk2+cek_kurva($data->id,'desk_catatan',2);
        $akmcomp2=$akmdeskcatatan2+cek_kurva($data->id,'com_prog',2);
        $akmcompcatatan2=$akmcomp2+cek_kurva($data->id,'com_catatan',2);
        $akmsubs2=$akmcompcatatan2+cek_kurva($data->id,'subs_prog',2);
        $akmsubscatatan2=$akmsubs2+cek_kurva($data->id,'subs_catatan',2);
        $akmlha2=$akmsubscatatan2+cek_kurva($data->id,'draf',2);
        $total2=cek_kurva($data->id,'desk_prog',2)
                +cek_kurva($data->id,'desk_catatan',2)
                +cek_kurva($data->id,'com_prog',2)
                +cek_kurva($data->id,'com_catatan',2)
                +cek_kurva($data->id,'subs_prog',2)
                +cek_kurva($data->id,'subs_catatan',2)
                +cek_kurva($data->id,'draf',2);
    ?>
    <div class="row">
        <div class="col-md-8">
            <center>S-Curve / Line Graphics Progres per Surat Tugas <br>{{$data->surattugas['nomortiket']}}</center>
            <canvas id="line-chart" data-render="chart-js"></canvas>
        </div>
        <div class="col-md-4">
            <div class="vertical-box-column p-15" style="width: 30%;">
                <div class="widget-chart-info">
                    <h4 class="widget-chart-info-title">Detail Progres</h4>
                    <p class="widget-chart-info-desc">Detail progres audit nomor surat {{$data->surattugas['nomortiket']}}.</p>
                    <span class="btn btn-xs btn-green" onclick="tampil_plan()">Tampil Plan</span>
                    <span class="btn btn-xs btn-blue" onclick="tampil_real()">Tampil Real</span>
                    <div id="plannya">   
                        <table width="100%" class="table table-bordered ">
                            <tr>
                                <td>Tahap</td>
                                <td>Tanggal</td>
                                <td>JML</td>
                                <td>AKM</td>
                                <td>Prog</td>
                            </tr>
                            <tr>
                                <td>Audit Plan</td>
                                <td>{{$data->tgl_plan}}</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0%</td>
                            </tr>
                            <tr>
                                <td>Desk Prog</td>
                                <td>{{$data->tgl_deskaudit_program_start}}</td>
                                <td>{{cek_kurva($data->id,'desk_prog',1)}}</td>
                                <td>{{$akmdesk}}</td>
                                <td>{{round(($akmdesk/$total)*100)}}%</td>
                            </tr>
                            <tr>
                                <td>Desk Catatan</td>
                                <td>{{$data->tgl_deskaudit_hasil_start}}</td>
                                <td>{{cek_kurva($data->id,'desk_catatan',1)}}</td>
                                <td>{{$akmdeskcatatan}}</td>
                                <td>{{round(($akmdeskcatatan/$total)*100)}}%</td>
                            </tr>
                            <tr>
                                <td>Comp Prog</td>
                                <td>{{$data->tgl_compliance_program_start}}</td>
                                <td>{{cek_kurva($data->id,'com_prog',1)}}</td>
                                <td>{{$akmcomp}}</td>
                                <td>{{round(($akmcomp/$total)*100)}}%</td>
                            </tr>
                            <tr>
                                <td>Comp Catatan</td>
                                <td>{{$data->tgl_compliance_hasil_start}}</td>
                                <td>{{cek_kurva($data->id,'com_catatan',1)}}</td>
                                <td>{{$akmcompcatatan}}</td>
                                <td>{{round(($akmcompcatatan/$total)*100)}}%</td>
                            </tr>
                            <tr>
                                <td>Subs Prog</td>
                                <td>{{$data->tgl_substantive_program_start}}</td>
                                <td>{{cek_kurva($data->id,'subs_prog',1)}}</td>
                                <td>{{$akmsubs}}</td>
                                <td>{{round(($akmsubs/$total)*100)}}%</td>
                            </tr>
                            <tr>
                                <td>Subs Catatan</td>
                                <td>{{$data->tgl_substantive_hasil_start}}</td>
                                <td>{{cek_kurva($data->id,'subs_catatan',1)}}</td>
                                <td>{{$akmsubscatatan}}</td>
                                <td>{{round(($akmsubscatatan/$total)*100)}}%</td>
                            </tr>
                            <tr>
                                <td>Draf LHA</td>
                                <td>{{$data->tgl_lha_start}}</td>
                                <td>{{cek_kurva($data->id,'draf',1)}}</td>
                                <td>{{$akmlha}}</td>
                                <td>{{round(($akmlha/$total)*100)}}%</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td>{{$total}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div id="realnya">   
                        <table width="100%" class="table table-bordered ">
                            <tr>
                                <td>Tahap</td>
                                <td>Tanggal</td>
                                <td>JML</td>
                                <td>AKM</td>
                                <td>Prog</td>
                            </tr>
                            <tr>
                                <td>Audit Plan</td>
                                <td>{{$data->tgl_sts3}}</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0%</td>
                            </tr>
                            <tr>
                                <td>Desk Prog</td>
                                <td>{{$data->tgl_sts4}}</td>
                                <td>{{cek_kurva($data->id,'desk_prog',2)}}</td>
                                <td>{{$akmdesk2}}</td>
                                <td>{{hitung_progres($akmdesk2,$total)}}%</td>
                            </tr>
                            <tr>
                                <td>Desk Catatan</td>
                                <td>{{$data->tgl_sts5}}</td>
                                <td>{{cek_kurva($data->id,'desk_catatan',2)}}</td>
                                <td>{{$akmdeskcatatan2}}</td>
                                <td>{{hitung_progres($akmdeskcatatan2,$total)}}%</td>
                            </tr>
                            <tr>
                                <td>Comp Prog</td>
                                <td>{{$data->tgl_sts6}}</td>
                                <td>{{cek_kurva($data->id,'com_prog',2)}}</td>
                                <td>{{$akmcomp2}}</td>
                                <td>{{hitung_progres($akmcomp2,$total)}}%</td>
                            </tr>
                            <tr>
                                <td>Comp Catatan</td>
                                <td>{{$data->tgl_sts7}}</td>
                                <td>{{cek_kurva($data->id,'com_catatan',2)}}</td>
                                <td>{{$akmcompcatatan2}}</td>
                                <td>{{hitung_progres($akmcompcatatan2,$total)}}%</td>
                            </tr>
                            <tr>
                                <td>Subs Prog</td>
                                <td>{{$data->tgl_sts8}}</td>
                                <td>{{cek_kurva($data->id,'subs_prog',2)}}</td>
                                <td>{{$akmsubs2}}</td>
                                <td>{{hitung_progres($akmsubs2,$total)}}%</td>
                            </tr>
                            <tr>
                                <td>Subs Catatan</td>
                                <td>{{$data->tgl_sts9}}</td>
                                <td>{{cek_kurva($data->id,'subs_catatan',2)}}</td>
                                <td>{{$akmsubscatatan2}}</td>
                                <td>{{hitung_progres($akmsubscatatan2,$total)}}%</td>
                            </tr>
                            <tr>
                                <td>Draf LHA</td>
                                <td>{{$data->tgl_sts10}}</td>
                                <td>{{cek_kurva($data->id,'draf',2)}}</td>
                                <td>{{$akmlha2}}</td>
                                <td>{{hitung_progres($akmlha2,$total)}}%</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td>{{$total2}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>

            </div>
        </div>
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
        $('#realnya').hide();
        function tampil_plan(){
            $('#realnya').hide();
            $('#plannya').show();
        }
        function tampil_real(){
            $('#realnya').show();
            $('#plannya').hide();
        }
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
                label: 'PLAN',
                borderColor: COLOR_BLUE,
                pointBackgroundColor: COLOR_BLUE,
                pointRadius: 2,
                borderWidth: 2,
                backgroundColor: "green",
                data: [
                    0,
                    {{round(($akmdesk/$total)*100)}},
                    {{round(($akmdeskcatatan/$total)*100)}},
                    {{round(($akmcomp/$total)*100)}},
                    {{round(($akmcompcatatan/$total)*100)}},
                    {{round(($akmsubs/$total)*100)}},
                    {{round(($akmsubscatatan/$total)*100)}},
                    {{round(($akmlha/$total)*100)}},
                ]
            }, {
                label: 'REAL',
                borderColor: COLOR_DARK_LIGHTER,
                pointBackgroundColor: COLOR_DARK,
                pointRadius: 2,
                borderWidth: 2,
                backgroundColor: "blue",
                data: [
                    0,
                    {{hitung_progres($akmdesk2,$total)}},
                    {{hitung_progres($akmdeskcatatan2,$total)}},
                    {{hitung_progres($akmcomp2,$total)}},
                    {{hitung_progres($akmcompcatatan2,$total)}},
                    {{hitung_progres($akmsubs2,$total)}},
                    {{hitung_progres($akmsubscatatan2,$total)}},
                    {{hitung_progres($akmlha2,$total)}},
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