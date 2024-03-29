@extends('layouts.web')

@push('style')
<link href="{{url('assets/assets/plugins/nvd3/build/nv.d3.css')}}" rel="stylesheet" />
<style>
	.progress.progress-xs {
    	height: 7px;
	}
	th{
		text-align:center;
		padding:0px !important;
		vertical-align: middle !important;
    	text-transform: uppercase;
		background:aqua;
	}
	td{
		background:#fff
	}
</style>
@endpush
@section('contex')
			<div class="d-sm-flex align-items-center mb-3" style="padding: 1%;background: #8195a9;">
				<label style="color:#fff">PILIH TAHUN &nbsp;&nbsp;</label>
				<select onchange="pilih_tahun(this.value)" style="width:30%;display:inline" class="form-control">
					@for($x=2020;$x<=date('Y');$x++)
						<option value="{{$x}}" @if($tahun==$x) selected @endif> Dashboard Tahun {{$x}}</option>
					@endfor
				</select>
			</div>
			<div class="row">
				<div class="col-xl-12" >
					<table class="table table-bordered">
						<tr>
							<th rowspan="2" width="3%">No</th>
							<th rowspan="2">Surat Tugas</th>
							<th rowspan="2" width="7%">Penerbitan</th>
							<th rowspan="2" width="6%">Plan</th>
							<th colspan="2">Desk</th>
							<th colspan="2">Comp</th>
							<th colspan="2">Subs</th>
							<th rowspan="2" width="6%">Draf</th>
							<th rowspan="2" width="6%">Qc</th>
							<th rowspan="2" width="6%">PEN</th>
							<th rowspan="2" width="6%">%</th>
						</tr>
						<tr>
							<th width="5%">Prg</th>
							<th width="5%">Cat</th>
							<th width="5%">Prg</th>
							<th width="5%">Cat</th>
							<th width="5%">Prg</th>
							<th width="5%">Cat</th>
							
						</tr>
						<?php
							$count=0;
							$sum=0;
						?>
						@foreach($data as $no=>$o)
							<?php
								$count+=1;
								$total=(cek_hasil_nilai($o->id,'plan')+
										cek_hasil_nilai($o->id,'desk_prog')+
										cek_hasil_nilai($o->id,'desk_catatan')+
										cek_hasil_nilai($o->id,'com_prog')+
										cek_hasil_nilai($o->id,'com_catatan')+
										cek_hasil_nilai($o->id,'subs_prog')+
										cek_hasil_nilai($o->id,'subs_catatan')+
										cek_hasil_nilai($o->id,'draf')+
										cek_hasil_nilai($o->id,'qc')+
										cek_hasil_nilai($o->id,'pen')
										);
								$sum+=round($total*(100/10));
							?>
							<tr style="cursor: pointer;" onclick="tampil_kan({{$o->id}})">
								<td>{{$no+1}}</td>
								<td><b>[{{$o->surattugas['nomortiket']}}]</b> {{$o->name}}</td>
								<td style="background:{{tgl_simple($o->tgl_lha_finis_end)}}">{{tgl_simple($o->tgl_lha_finis_end)}}</td>
								<td style="background:{{cek_hasil($o->id,'plan')}}"></td>
								<td style="background:{{cek_hasil($o->id,'desk_prog')}}"></td>
								<td style="background:{{cek_hasil($o->id,'desk_catatan')}}"></td>
								<td style="background:{{cek_hasil($o->id,'com_prog')}}"></td>
								<td style="background:{{cek_hasil($o->id,'com_catatan')}}"></td>
								<td style="background:{{cek_hasil($o->id,'subs_prog')}}"></td>
								<td style="background:{{cek_hasil($o->id,'subs_catatan')}}"></td>
								
								<td style="background:{{cek_hasil($o->id,'draf')}}"></td>
								<td style="background:{{cek_hasil($o->id,'qc')}}"></td>
								<td style="background:{{cek_hasil($o->id,'pen')}}"></td>
								<td style="text-align:center;background:#e0f9b0"><b>{{round($total*(100/10))}}%</b></td>
							</tr>
							
						@endforeach
							<tr>
								<td colspan="2" style="text-align:center;background:#e0f9b0">Progres %</td>
								<td style="text-align:center;background:#e0f9b0"></td>
								<td style="text-align:center;background:#e0f9b0">10%</td>
								<td style="text-align:center;background:#e0f9b0">20%</td>
								<td style="text-align:center;background:#e0f9b0">30%</td>
								<td style="text-align:center;background:#e0f9b0">40%</td>
								<td style="text-align:center;background:#e0f9b0">50%</td>
								<td style="text-align:center;background:#e0f9b0">60%</td>
								<td style="text-align:center;background:#e0f9b0">70%</td>
								<td style="text-align:center;background:#e0f9b0">80%</td>
								<td style="text-align:center;background:#e0f9b0">90%</td>
								<td style="text-align:center;background:#e0f9b0">100%</td>
								<td style="text-align:center;background:#e0f9b0">{{$sum/$count}}%</td>
							</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="modal" id="modalview" aria-hidden="true" style="display: none;">
					<div class="modal-dialog" style="max-width:80%">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">view Data</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							</div>
							<div class="modal-body">
								<div id="tampilkangrafik"></div>
								
							</div>
							<div class="modal-footer">
								<a href="javascript:;" class="btn btn-white" data-dismiss="modal">Tutup</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			
@endsection
@push('ajax')
<script src="{{url('assets/assets/plugins/d3/d3.min.js')}}"></script>
<script src="{{url('assets/assets/plugins/nvd3/build/nv.d3.min.js')}}"></script>

<script>
	function tampil_kan(id){
		
			$.ajax({
				type: 'GET',
				url: "{{url('Dashboardaudit/modal')}}",
				data: "id="+id,
				success: function(msg){
					$('#modalview').modal('show');
					$('#tampilkangrafik').html(msg);
				}
			}); 
		
		
	}
	function pilih_tahun(tahun){
		location.assign("{{url('Dashboardaudit')}}?tahun="+tahun);
	}
</script>
<script>

   
</script>
@endpush
