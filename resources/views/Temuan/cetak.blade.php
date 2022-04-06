<html>
    <head>
        <title></title>
        <style>
            th{
                font-size:14px;
                text-align:left;
            }
            td{
                font-size:12px;
                vertical-align:top;
            }
        </style>
    </head>
    <body>
        <table width="100%" border="0">
            <tr>
                <th colspan="4"><b><u>NOMOR TEMUAN {{$data->kesimpulan['nomorkode']}} {{$data->nomor}}{{$data->urutan}}</u></b><br><br></th>
            </tr>
            <tr>
                <td width="3%"></td>
                <td width="17%"><b>PIC</b></td>
                <td width="3%"><b>:</b></td>
                <td>{{$data->unitkerja['pimpinan']}} {{$data->unitkerja['name']}}</td>
            </tr>
            <tr>
                <td></td>
                <td><b>Kodifikasi</b></td>
                <td><b>:</b></td>
                <td><b>{{$data->kodifikasi}}</b> {{$data->getkodifikasi['kategori']}}</td>
            </tr>
            <tr>
                <td></td>
                <td><b>Isi Rekomendasi</b></td>
                <td><b>:</b></td>
                <td>{!! $data->isi !!}</td>
            </tr>
            <tr>
                <td></td>
                <td><b>Risiko</b></td>
                <td><b>:</b></td>
                <td>{{$data->risiko}} ({{$data->ket_risiko}})</td>
            </tr>
            <tr>
                <td></td>
                <td><b>No Tindak Lanjut</b></td>
                <td><b>:</b></td>
                <td>{{ $data->nomortl }}</td>
            </tr>
            <tr>
                <td></td>
                <td><b>Status</b></td>
                <td><b>:</b></td>
                <td>{{ $data->sts_tl }}</td>
            </tr>
            @if($data->sts==1)
            <tr>
                <td></td>
                <td><b>Hasil Review Auditor</b></td>
                <td><b>:</b></td>
                <td>[{{ $data->nomormtl }}]<br>{!! review_team($data->id,$data->sts_tl) !!}</td>
            </tr>
            @endif
            <tr>
                <td></td>
                <td colspan="3"><b><u>Hasil Tindak Lanjut</u></b></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3">{!! $data->catatan !!}</td>
            </tr>
        </table>
    </body>
</html>