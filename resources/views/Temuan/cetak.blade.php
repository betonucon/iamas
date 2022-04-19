<html>
    <head>
        <title></title>
        <style>
            th{
                font-size:14px;
                text-align:left;
            }
            td{
                font-size:15px;
                vertical-align:top;
                text-align:justify;
            }
        </style>
    </head>
    <body>
        <table width="100%" border="0">
            <tr>
                <th colspan="4"></th>
            </tr>
            <tr>
                <td width="3%"></td>
                <td width="17%">Dari</td>
                <td width="3%">:</td>
                <td>{{$data->unitkerja['pimpinan']}} {{$data->unitkerja['name']}}</td>
            </tr>
            <tr>
                <td></td>
                <td>No Tindak Lanjut</td>
                <td>:</td>
                <td>{{$data->nomortl}}</td>
            </tr>
            <tr>
                <td></td>
                <td>Status</td>
                <td>:</td>
                <td>"{{$data->sts_tl}}"</td>
            </tr>
            @if($data->sts_tl!='P0')
            <tr>
                <td></td>
                <td>No Review</td>
                <td>:</td>
                <td>{{$data->nomormtl}}</td>
            </tr>
            @endif
            <tr>
                <td></td>
                <td>Tanggal TLP</td>
                <td>:</td>
                <td>{{tanggal_tl($data->nomortl)}}</td>
            </tr>
            <tr>
                <td></td>
                <td>Tanggal Cetak</td>
                <td>:</td>
                <td>{{date('d F Y')}}</td>
            </tr>
            <tr>
                <td width="3%"></td>
                
                <td colspan="3"><br><br>
                    <b>DENGAN HORMAT,</b><br>
                    Menindaklanjuti Temuan atas LHA No. {{$data->kesimpulan['nomorkode']}}  Temuan No. {{$data->nomor}}{{$data->urutan}} berikut tindak lanjut yang 
                    disampaikan:<br>
                </td>
            </tr>
            
            <!-- <tr>
                <td colspan="4" style="text-align:center"><br><u>Catatan Tindak Lanjut</u></td>
            </tr> -->
            <tr>
                <td width="3%"></td>
                <td colspan="3" ><br>{!! $data->catatan !!}</td>
            </tr>
        </table>
    </body>
</html>