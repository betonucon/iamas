
<form id="tambah-data" enctype="multipart/form-data">
    <div id="notifikasitambah"></div>
    @csrf
    <input type="hidden" value="{{$kesimpulan_id}}" name="kesimpulan_id">
    <input type="hidden" value="{{$rekomendasi_id}}" name="rekomendasi_id">
    <input type="hidden" value="{{$act}}" name="act">
    <input type="hidden" value="{{$nomor}}" name="nomor">
    <div class="form-group">
        <label for="exampleInputEmail1">Kodifikasi</label>
        <select class="default-select2 form-control"   name="kode_unit" style="width:70%" >
            <option value="" >Pilih PIC</option>';
            @foreach(unit_get() as $unit)
                
                <option value="{{$unit['kode']}}"  @if($data->kode_unit==$unit['kode']) selected @endif  >{{$unit['pimpinan']}} {{$unit['name']}}</option>
            @endforeach
        
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Kodifikasi</label>
        <select class="form-control"   name="kodifikasi" style="width:40%" >
            <option value="" >Pilih Kodifikasi</option>';
            @foreach(kodefikasi_get() as $kodefikasi)
                
                <option value="{{$kodefikasi['kodifikasi']}}" @if($data->kodifikasi==$kodefikasi['kodifikasi']) selected @endif  >[{{$kodefikasi['kodifikasi']}}] {{$kodefikasi['kategori']}}</option>
            @endforeach
        
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Isi</label>
        <textarea class="form-control" id="isinya" placeholder="Ketik disini....." >{{$data->isi}}</textarea>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Nilai</label>
        <input type="text" name="nilai" style="width:40%" value="{{$data->nilai}}" id="inputmask" data-inputmask="'alias': 'currency'" onkeypress="return hanyaAngkaTitik(event)" placeholder="Ketik disini....." class="form-control">
    </div>
</form>    
<link href="{{url('assets/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
<link href="{{url('assets/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" />
<script src="{{url('assets/assets/plugins/ckeditor/ckeditor.js')}}"></script>
<script type='text/javascript' src="{{url('js/mask.js')}}"></script>
<script src="{{url('assets/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{url('assets/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
<script src="{{url('assets/assets/js/demo/form-plugins.demo.js')}}"></script>
	<script>
		$(document).ready(function() {
			$("#inputmask").inputmask();
        	$("#inputmask2").inputmask();
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
                url: "{{url('Lha/simpan_rekomendasi')}}",
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