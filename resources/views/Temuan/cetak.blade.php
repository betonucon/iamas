<html>
    <head>
        <title>DOKUMEN-{{$data->nomortl}}</title>
        <style>
            th{
                font-size:14px;
                text-align:left;
            }
            table{
                border-collapse:collapse;
            }
            td{
                font-size:15px;
                vertical-align:top;
                text-align:justify;
            }
            .head{
                border:solid 1px #fff;
            }
            .h2-head{
                margin:0px;
                text-align:center;
            }
            .h3-head{
                margin:0px;
                font-size:15px;
                text-align:center;
            }
            .h22-head{
                margin:0px;
                font-size:16px;
                text-align:center;
            }
        </style>
    </head>
    <body>
        <table width="100%" border="0">
            <tr>
                <th class="head"  width="20%"><img src="{{public_path('img/logoks.png')}}" width="100%"></th>
                <th class="head" >
                    <h2 class="h2-head">PT KRAKATAU STEEL PERSERO Tbk</h2>
                    <h3 class="h3-head">Jl. Kawasan Industri Krakatau Steel No.285a, Warnasari, Kec. Citangkil, Kota Cilegon, Banten 42443</h3>
                    
                </th>
            </tr>
            <tr>
                <th class="head" colspan="2" >
                    <hr style="border:solid 1px #000;margin:0px">
                    <hr style="border:solid 1.5px #000;margin:0px;margin-top:1.5px">
                </th>
            </tr>
            <tr>
                <th class="head" colspan="2" ><br>
                    <h2 class="h22-head">DOKUMEN RIWAYAT TINDAK LANJUT</h2>
                </th>
            </tr>
        </table>
        <br>
        
        <table width="100%" border="0">
            <tr>
                <th colspan="4"></th>
            </tr>
            <tr>
                <td width="3%"></td>
                <td width="17%">Kepada Yth</td>
                <td width="3%">:</td>
                <td>Head Of Internal Audit</td>
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
                @if($data->sts==1)
                    <td>"{{$data->sts_tl}}"</td>
                @else
                    
                    @if(cek_disposisi($data->id)>1)
                        
                        <td>"{{sts_tl_auditee($data->sts_tl)}}"</td>
                    @else
                        <td>"P0"</td>
                    @endif
                @endif
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
                <td>Tanggal {{$data->kode_tl}}</td>
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
                    Berkenaan dengan adanya temuan atas LHA No. {{$data->kesimpulan['nomorkode']}}  rekomendasi No. {{$data->nomor}}{{$data->urutan}} maka dengan ini disampaikan tindak lanjut sebagai berikut 
                    :<br>
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