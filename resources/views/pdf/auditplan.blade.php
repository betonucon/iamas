<html>
    <head>
        <title>SURAT TUGAS</title>
        <style>
            .ttdhead-h1{
                text-align:center;
                font-size:20px;
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
            .td{
                font-size:15px;
                border:solid 1px #000;
                padding-left:4px;
                
            }
            .ttd{
                font-size:15px;
                font-weigth:bold;
                padding-top:5px;
            }
            .ttds{
                font-size:14px;
                padding-left:4px;
            }
            hr{
                margin:10px 0px 10px 0px;
            }
            p{
                margin:2px;
            }
        </style>
    </head>
    <body>
        <table width="100%" style="margin-bottom:2%">
            <tr>
                <td width="100%" class="ttdhead-h1" ><img src="{{public_path('img/logoks.png')}}" width="30%" ></td>
            </tr>
            <tr>
                <td width="100%" class="ttdhead-h1" >AUDIT PLAN</td>
            </tr>
           
        </table>
        <table width="100%" >
            <tr>
                <td colspan="2"  class="ttd" ><hr></td>
            </tr>
            <tr>
                <td width="20%"  class="ttd" >Unit Organisasi</td>
                <td width="80%"  class="ttd" >: {{$data->unitkerja['name']}}</td>
            </tr>
            <tr>
                <td class="ttd" >Obyek Audit</td>
                <td class="ttd" >: {{$data->name}}</td>
            </tr>
            <tr>
                <td class="ttd" >Periode Audit</td>
                <td class="ttd" >:</td>
            </tr>
            <tr>
                <td colspan="2"  class="ttd" ><hr></td>
            </tr>
        </table>
        <table width="100%" >
            <tr>
                <td  width="4%" class="ttd" ><b>I.</b></td>
                <td width="92%" class="ttd" ><b>TUJUAN AUDIT</b></td>
            </tr>
            <tr>
                <td  class="ttd" ></td>
                <td class="ttds" >{!!$data->tujuan!!}</td>
            </tr>
            <tr>
                <td  class="ttd" ><b>II.</b></td>
                <td class="ttd" ><b>SASARAN</b></td>
            </tr>
            <tr>
                <td  class="ttd" ></td>
                <td class="ttds" >{!!$data->sasaran!!}</td>
            </tr>
            <tr>
                <td  class="ttd" ><b>III.</b></td>
                <td class="ttd" ><b>RESIKO POTENSIAL</b></td>
            </tr>
            <tr>
                <td  class="ttd" ></td>
                <td class="ttds" >{!!$data->risiko!!}</td>
            </tr>
            <tr>
                <td  class="ttd" ><b>IV.</b></td>
                <td class="ttd" ><b>RUANG LINGKUP</b></td>
            </tr>
            <tr>
                <td  class="ttd" ></td>
                <td class="ttds" >{!!$data->risiko!!}</td>
            </tr>
            <tr>
                <td  class="ttd" ><b>V.</b></td>
                <td class="ttd" ><b>TIM AUDIT</b></td>
            </tr>
            <tr>
                <td class="ttd" ></td>
                <td class="ttds" >
                    @foreach($tim as $no=>$ot)
                        <p>{{$no+1}}.&nbsp;&nbsp;{{$ot->user['name']}}  &nbsp;&nbsp;(&nbsp;{{$ot->role['name']}}&nbsp;)</p>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td  class="ttd" ><b>VI.</b></td>
                <td class="ttd" ><b>RENCANA PENERBITAN LAPORAN</b></td>
            </tr>
            <tr>
                <td class="ttd" ></td>
                <td class="ttds" >Laporan hasil pemeriksaan akan diterbitkan tanggal {{$data->tgl_penerbitan}}</td>
            </tr>
            <tr>
                <td  class="ttd" ><b>VII.</b></td>
                <td class="ttd" ><b>JADWAL PELAKSANAAN AUDIT</b></td>
            </tr>
            <tr>
                <td class="ttd" ></td>
                <td class="ttds" >
                    <table width="100%" border="1">
                        <tr>
                            <td class="ttds" align="center" rowspan="2" width="5%">NO</td>
                            <td class="ttds"  align="center" rowspan="2" >TAHAPAN AUDIT</td>
                            <td class="ttds"  align="center" colspan="2" width="26%">RENCANA AUDIT</td>
                            <td class="ttds"  align="center" rowspan="2" width="8%">KET</td>
                        </tr>
                        <tr>
                            <td class="ttds" align="center"  width="13%">MULAI</td>
                            <td class="ttds" align="center"  width="13%">SAMPAI</td>
                        </tr>
                        <tr>
                            <td class="ttds">1.</td>
                            <td class="ttds">PELAKSANAAN DESK AUDIT</td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">1. Desk Audit Program.</td>
                            <td align="center" class="ttds">{{$data->tgl_deskaudit_program_start}}</td>
                            <td align="center" class="ttds">{{$data->tgl_deskaudit_program_end}}</td>
                            <td align="center" class="ttds">{{selisih_hari($data->tgl_deskaudit_program_start,$data->tgl_deskaudit_program_end)}}</td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">2. Catatan Hasil Desk Audit. </td>
                            <td align="center" class="ttds">{{$data->tgl_deskaudit_hasil_start}}</td>
                            <td align="center" class="ttds">{{$data->tgl_deskaudit_hasil_end}}</td>
                            <td align="center" class="ttds">{{selisih_hari($data->tgl_deskaudit_hasil_start,$data->tgl_deskaudit_hasil_end)}}</td>
                        </tr>
                        <tr>
                            <td class="ttds">2.</td>
                            <td class="ttds">FIELD AUDIT</td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">PELAKSANAAN COMPLIANCE TEST</td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">1. Compliance Test Program.</td>
                            <td align="center" class="ttds">{{$data->tgl_compliance_program_start}}</td>
                            <td align="center" class="ttds">{{$data->tgl_compliance_program_end}}</td>
                            <td align="center" class="ttds">{{selisih_hari($data->tgl_compliance_program_start,$data->tgl_compliance_program_end)}}</td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">2. Catatan Hasil Compliance Test.</td>
                            <td align="center" class="ttds">{{$data->tgl_compliance_hasil_start}}</td>
                            <td align="center" class="ttds">{{$data->tgl_compliance_hasil_end}}</td>
                            <td align="center" class="ttds">{{selisih_hari($data->tgl_compliance_hasil_start,$data->tgl_compliance_hasil_end)}}</td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">PELAKSANAAN SUBSTANTIVE TEST</td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">1. Substantive Test Program.</td>
                            <td align="center" class="ttds">{{$data->tgl_substantive_program_start}}</td>
                            <td align="center" class="ttds">{{$data->tgl_substantive_program_end}}</td>
                            <td align="center" class="ttds">{{selisih_hari($data->tgl_substantive_program_start,$data->tgl_substantive_program_end)}}</td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">2. Catatan Hasil Substantive Test.</td>
                            <td align="center" class="ttds">{{$data->tgl_substantive_hasil_start}}</td>
                            <td align="center" class="ttds">{{$data->tgl_substantive_hasil_end}}</td>
                            <td align="center" class="ttds">{{selisih_hari($data->tgl_substantive_hasil_start,$data->tgl_substantive_hasil_end)}}</td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">3. Penyusunan Draft LHA & KKA Lengkap.</td>
                            <td align="center" class="ttds">{{$data->tgl_lha_start}}</td>
                            <td align="center" class="ttds">{{$data->tgl_lha_end}}</td>
                            <td align="center" class="ttds">{{selisih_hari($data->tgl_lha_start,$data->tgl_lha_end)}}</td>
                        </tr>
                        <tr>
                            <td class="ttds">3.</td>
                            <td class="ttds">REPORTING AUDIT</td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                            <td class="ttds"></td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">1. Presentasi dan Pembahasan Draf LHA.</td>
                            <td align="center" class="ttds">{{$data->tgl_lha_draf_start}}</td>
                            <td align="center" class="ttds">{{$data->tgl_lha_draf_end}}</td>
                            <td align="center" class="ttds">{{selisih_hari($data->tgl_lha_draf_start,$data->tgl_lha_draf_end)}}</td>
                        </tr>
                        <tr>
                            <td class="ttds"></td>
                            <td class="ttds">2. Finalisasi dan Penerbitan LHA.</td>
                            <td align="center" class="ttds">{{$data->tgl_lha_finis_start}}</td>
                            <td align="center" class="ttds">{{$data->tgl_lha_finis_end}}</td>
                            <td align="center" class="ttds">{{selisih_hari($data->tgl_lha_finis_start,$data->tgl_lha_finis_end)}}</td>
                        </tr>
                        
                    </table>

                </td>
            </tr>
            
            
        </table>
    </body>
</html>