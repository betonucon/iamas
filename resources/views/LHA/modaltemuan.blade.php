    <form id="tambah-data" method="post" enctype="multipart/form-data">
        @csrf
        <div id="notifikasitambah"></div>
        <input type="hidden" value="{{$id}}" name="audit_id">
        <input type="hidden" value="{{$kesimpulan_id}}" name="kesimpulan_id">
        <input type="hidden" value="{{$act}}" name="act">
        <div class="form-group">
            <label for="exampleInputEmail1">Judul</label>
            <input type="text" name="name" placeholder="Ketik disini....." value="{{$data->name}}" class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Kodifikasi</label>
            <select class="form-control"   name="kodifikasi" style="width:60%" >
                <option value="" >Pilih Kodifikasi</option>';
                @foreach(kodefikasi_get() as $kodefikasi)
                    
                    <option value="{{$kodefikasi['kodifikasi']}}" @if($data->kodifikasi==$kodefikasi->kodifikasi) selected @endif >[{{$kodefikasi['kodifikasi']}}] {{$kodefikasi['kategori']}}</option>
                @endforeach
            
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Isi</label>
            <textarea class="form-control" id="isinya" placeholder="Ketik disini....." >{{$data->isi}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Risiko</label>
            <input type="text" name="risiko" value="{{$data->risiko}}" onkeypress="return hanyaAngka(event)" style="width:30%" placeholder="Ketik disini....." class="form-control">
        </div>
</form>

<script src="{{url('assets/assets/plugins/ckeditor/ckeditor.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#tanggalpicker').datepicker({
            format: 'yyyy-mm-dd',
            
        });
        
        $('#tangal_penerbitan').datepicker({
            format: 'yyyy-mm-dd',
            
        });

        CKEDITOR.replace( 'isinya' );
    });

    function simpan_data(){
        var form=document.getElementById('tambah-data');
        var data = new FormData(form);
            data.append('content', CKEDITOR.instances['isinya'].getData());
            $.ajax({
                type: 'POST',
                url: "{{url('Lha/simpan')}}",
                data: data,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function() {
                    document.getElementById("loadnya").style.width = "100%";
                },
                success: function(msg){
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        document.getElementById("loadnya").style.width = "0px";
                        $('#notifikasitambah').html(msg);
                    }
                    
                    
                }
            });

    }
    </script>