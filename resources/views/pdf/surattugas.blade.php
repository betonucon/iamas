<html>
    <head>
        <title>SURAT TUGAS</title>
        <style>
            .ttdhead-h1{
                text-align:center;
                font-size:22px;
                text-decoration: underline;
            }
            table{
                border-collapse:collapse;
            }
            .ttdhead-h2{
                text-align:center;
                font-size:15px;
            }
            .th{
                font-size:15px;
                border:solid 1px #000;
                text-align:center;
            }
            .thb{
                font-size:15px;
                /* border:solid 1px #fff; */
                text-align:center;
            }
            .td{
                font-size:15px;
                border:solid 1px #000;
                padding-left:4px;
            }
            .ttd{
                font-size:15px;
            }
        </style>
    </head>
    <body>
        <table width="100%" style="margin-bottom:2%">
            <tr>
                <td width="100%" class="ttdhead-h1" ><img src="{{public_path('img/logoks.png')}}" width="30%" ></td>
            </tr>
            <tr>
                <td width="100%" class="ttdhead-h1" >SURAT TUGAS INTERNAL AUDIT (STIA)</td>
            </tr>
            <tr>
                <td width="100%" class="ttdhead-h2">Nomor : {{$data->surattugas['nomortiket']}}</td>
            </tr>
        </table>
        <table width="100%" >
            <tr>
                <td width="100%" colspan="2" class="ttd" >Head of Internal Audit memberi tugas kepada :</td>
            </tr>
            <tr>
                <td class="ttd" width="6%"></td>
                <td class="ttd">
                    <table width="80%">
                        <tr>
                            <td class="th" width="5%">No</td>
                            <td class="th">Nama</td>
                            <td class="th" width="15%">NIK</td>
                            <td class="th" width="15%">Posisi</td>
                        </tr>
                        @foreach($tim as $no=>$timo)
                        <tr>
                            <td class="td">{{$no+1}}</td>
                            <td class="td">{{$timo->user['name']}}</td>
                            <td class="td">{{$timo->nik}}</td>
                            <td class="td">{{$timo->role['name']}}</td>
                        </tr>
                        @endforeach
                    </table><br>
                </td>
            </tr>
            <tr>
                <td width="100%" colspan="2" class="ttd" >Untuk melaksanakan tugas <font color="blue"> {{$data->aktifitas['name']}}</font> Audit terhadap :</td>
            </tr>
            <tr>
                <td class="ttd" width="6%"></td>
                <td class="ttd">
                    <table width="80%">
                        <tr>
                            <td class="td" width="25%">Obyek Audit </td>
                            <td class="td">{{$data->judul_tiket}}</td>
                        </tr>
                        <tr>
                            <td class="td">Lokasi</td>
                            <td class="td">{{$data->lokasi['name']}}</td>
                        </tr>
                        <tr>
                            <td class="td">Kode Audit</td>
                            <td class="td">{{$data->surattugas['nomorsurat']}}</td>
                        </tr>
                        <tr>
                            <td class="td">Jumlah Hari Audit</td>
                            <td class="td">{{selisih_hari($data->surattugas['mulai'],$data->surattugas['sampai'])}} Hari</td>
                        </tr>
                        <tr>
                            <td class="td">Tanggal mulai</td>
                            <td class="td">{{tgl_indo($data->surattugas['mulai'])}}</td>
                        </tr>
                        <tr>
                            <td class="td">Tanggal selesai</td>
                            <td class="td">{{tgl_indo($data->surattugas['sampai'])}}</td>
                        </tr>
                        <tr>
                            <td class="td">Catatan</td>
                            <td class="td">{!!$data->surattugas['catatan']!!}</td>
                        </tr>
                    </table><br>
                </td>
                
            </tr>
            <tr>
                <td class="ttd" colspan="2">
                    Demikian untuk dilaksanakan dengan sebaik-baiknya.
                </td>
            </tr>
            <tr>
                <td class="ttd" colspan="2" style="text-align:right;height:200px">
                    <table width="100%"  align="right">
                        <tr>
                            <td class="ttd" width="50%"></td>
                        
                            <td class="thb" >
                                Cilegon, {{bulan_indo()}}<br>
                                INTERNAL AUDIT<br><br><br><br><br>
                                <u style="display:block">{{head_of()['name']}}</u>
                                Head of Internal Audit
                            </td>
                        
                            <td class="ttd" width="19%"></td>
                        </tr>
                    </table><br><br>
                </td>
            </tr>
            
            <tr>
                <td class="ttd" colspan="2">Tembusan :</td>
            </tr>
            <tr>
                <td class="ttd" colspan="2">1. Yth. {{pengawas($data->id)->user->posisi['name']}}</td>
            </tr>
            <tr>
                <!-- <td class="ttd" colspan="2">2. Yth. {{unit_pimpinan($data->kode_unit)}} {{$data->unitkerja['name']}}</td> -->
                <td class="ttd" colspan="2">2. Arsip</td>
            </tr>
        </table>
    </body>
</html>