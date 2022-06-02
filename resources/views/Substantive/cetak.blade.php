<html>
    <head>
        <title>SUBSTANTIVE PROGRAM</title>
        <style>
            table{
                border-collapse:collapse;
            }
            html{
                margin:3%;
            }
            td{
               font-size:14px; 
               vertical-align:top;
            }
            .thd{
                border-bottom:solid 1px #000;
                font-weight:bold;
                text-align:center;
                font-size:16px; 
            }
            .ttd{
                border:solid 1px #000;
                font-size:12px; 
                padding-left:5px;
            }
            .ttdcol{
                font-size:12px; 
                padding-left:5px;
            }
            .bold{
                font-weight:bold;
            }
            
        </style>
    </head>
    <body>
        <table width="100%">
            <tr>
                <td class="thd" width="16%"><img src="{{public_path('img/logoks.png')}}" width="100%"></td>
                <td class="thd" style="vertical-align:middle;">PT. KRAKATAU STEEL (Persero) Tbk <br>INTERNAL AUDIT</td>
            </tr>
            <tr>
                <td class="thd" colspan="2">SUBSTANTIVE PROGRAM</td>
            </tr>
        </table><br>
        <table width="100%">
            <tr>
                <td width="20%">Unit Organisasi</td>
                <td   class="bold" width="3%">:</td>
                <td  class="bold" >{{$data->unitkerja['name']}}</td>
                <td width="10%" ></td>
            </tr>
            <tr>
                <td>Obyek Audit</td>
                <td class="bold">:</td>
                <td class="bold" >{{$data->name}}</td>
                <td></td>
            </tr>
            <tr>
                <td>Priode Audit</td>
                <td class="bold">:</td>
                <td class="bold" >Triwulan {{triwulan($data->bulan)}}</td>
                <td></td>
            </tr>
        </table><br>
        <table width="100%">
            <tr>
                <td  class="bold" colspan="2" >TUJUAN AUDIT</td>
            </tr>
            <tr>
                <td width="2%"></td>
                <td  class="bold" >{!! $data->tujuan !!}</td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td style="vertical-align:middle;text-align:center;" rowspan="2" width="5%" class="ttd">NO</td>
                <td style="vertical-align:middle;text-align:center;" rowspan="2" class="ttd">SASARAN</td>
                <td style="vertical-align:middle;text-align:center;" rowspan="2" width="30%" class="ttd">LANGKAH KERJA</td>
                <td style="vertical-align:middle;text-align:center;" rowspan="2" width="15%" class="ttd">DILAKSANAKAN</td>
                <td class="ttd" style="text-align:center;" colspan="2">JANGKA WAKTU</td>
            </tr>
            <tr>
                <td width="9%" style="text-align:center;" class="ttd">RENC</td>
                <td width="9%" style="text-align:center;"  class="ttd">AKTUAL</td>
            </tr>
            @foreach(substantive_program($data->id) as $no=>$desk)
                <tr>
                    <td class="ttd">{{$no+1}}</td>
                    <td class="ttd">{!! $desk->name !!}</td>
                    <td class="ttd">
                        @foreach(substantive_catatan($desk->id) as $x=>$cat)
                            <table width="100%">
                                <tr>
                                    <td class="ttdcol" width="5%">{{$x+1}}.</td>
                                    <td class="ttdcol">{{$cat->name}}</td>
                                </tr>
                            </table>
                        @endforeach
                    </td>
                    <td class="ttd">
                        @foreach(tim_audit_cetak($desk->tiket_id) as $tim)
                            <table width="100%">
                                <tr>
                                    <td class="ttdcol" width="5%">- </td>
                                    <td class="ttdcol">{{$tim->user['name']}}</td>
                                </tr>
                            </table>
                        @endforeach
                    </td>
                    <td class="ttd">{{$data->tgl_substantive_program_start}}</td>
                    <td class="ttd">{{$data->tgl_sts8}}</td>
                </tr>
            @endforeach
        </table>
        <br>
        <table width="100%">
            <tr>
                <td   class="bold" width="68%">Approve By</td>
                
                <td  class="bold" colspan="2">CreateBy<br>
                      
                </td>
            </tr>
            <tr>
                <td valign="top">
                    
                        @foreach(tim_audit_ketua($desk->tiket_id) as $tim)
                            &nbsp;&nbsp;{{$tim->user['name']}}<br>
                        @endforeach
                        &nbsp;&nbsp;({{$data->tgl_sts4}})
                </td>
                <td width="2%"></td>
                <td >
                        @foreach(tim_audit_cetak($desk->tiket_id) as $tim)
                            -{{$tim->user['name']}}<br>
                        @endforeach
                        
                </td>
            </tr>
        </table>
    </body>
</html>