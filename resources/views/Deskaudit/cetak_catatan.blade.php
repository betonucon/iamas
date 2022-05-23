<html>
    <head>
        <title>DESKAUDIT PROGRAM</title>
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
                <td class="thd" colspan="2">CATATAN HASIL AUDIT<br>TAHAPAN AUDIT : DESK AUDIT</td>
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
                <td style="vertical-align:middle;text-align:center;" width="5%" class="ttd">NO</td>
                <td style="vertical-align:middle;text-align:center;" class="ttd">POKOK MATERI</td>
                <td style="vertical-align:middle;text-align:center;" width="45%" class="ttd">KETERANGAN</td>
            </tr>
            
            @foreach(view_deskaudit_catatan($data->id) as $no=>$desk)
                <tr>
                    <td class="ttd">{{$no+1}}</td>
                    <td class="ttd">{!! $desk->name !!}</td>
                    <td class="ttd">{!! $desk->catatan !!}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>