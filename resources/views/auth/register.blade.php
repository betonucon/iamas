@extends('layouts.auth')
@push('style')
	<style>
		@media only screen and (min-width: 600px) {
			.register.register-with-news-feed .right-content {
				min-height: 100%;
				background: #fff;
				width: 530px;
				margin-left: auto;
				padding: 60px;
				display: -webkit-box;
				display: -ms-flexbox;
				display: flex;
				-webkit-box-orient: vertical;
				-webkit-box-direction: normal;
				-ms-flex-direction: column;
				flex-direction: column;
				-webkit-box-pack: center;
				-ms-flex-pack: center;
				justify-content: center;
			}
			.row>[class^=col-] {
				padding-left: 2px;
				padding-right: 2px;
			}
			.colom-isian{
				padding:1%;
				border:solid 1px #000;
			}
		}
		@media only screen and (max-width: 590px) {

		}
	</style>
@endpush
@section('app')	
			<div class="right-content">
				<!-- begin register-header -->
				<h1 class="register-header" style="text-align: center;">
					Daftar
					<small>Daftarkan akun anda dibawah ini</small>
					@if ($message = Session::get('success'))
					<small style="background: #d3f7d3;padding: 1%;">Sistem telah mengirimkan link aktivasi ke email anda</small>
					@endif
					
				</h1>
				<!-- end register-header -->
				<!-- begin register-content -->
				<div class="register-content">
					<form id="my_register" method="POST" class="margin-bottom-0">
						@csrf
						
						<div class="row m-b-10">
							<div class="col-md-12">
								<label class="control-label">Name </label>
								<input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="First name" required />
								<span class="text-danger" id="error-name"></span>
							</div>
							
						</div>
						
						<div class="row m-b-10">
							<div class="col-md-12">
								<label class="control-label">Email </label>
								<input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email address" required />
								<span class="text-danger" id="error-email"></span>
							</div>
						</div>
						
						<div class="row m-b-10">
							<div class="col-md-12">
								<label class="control-label">Password <span class="text-danger">*</span></label>
								<input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required />
								<span class="text-danger" id="error-password"></span>
							</div>
						</div>
						
						<div class="row m-b-10">
							<div class="col-md-12">
								<label class="control-label">Re-enter Password <span class="text-danger">*</span></label>
								<input type="password" name="password_confirmation" class="form-control" placeholder="Password" required />
								
							</div>
						</div>
						<div class="row m-b-10">
							<div class="col-md-12">
								<label class="control-label">Warga Negara <span class="text-danger">*</span></label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-angle-down"></i></span></div>
									<select class="form-control" onchange="pilih_warga(this.value)" name="sts_warga">
										<option value="">Pilih Warga---</option>	
										<option value="1">WNI</option>	
										<option value="2">WNA</option>	
										
									</select>
								</div>
								<span class="text-danger" id="error-sts_warga"></span>
							</div>
						</div>
						
						<div id="isi_warga" class="row m-b-10">

						</div>
						
						<div class="checkbox checkbox-css m-b-30">
							<div class="checkbox checkbox-css m-b-30">
								<input type="checkbox" id="agreement_checkbox" value="">
								<label for="agreement_checkbox">
								By clicking Sign Up, you agree to our <a href="javascript:;">Terms</a> and that you have read our <a href="javascript:;">Data Policy</a>, including our <a href="javascript:;">Cookie Use</a>.
								</label>
							</div>
						</div>
						<div class="register-buttons">
							<span type="submit" onclick="click_registrasi()" class="btn btn-primary btn-block btn-lg">Sign Up</span>
						</div>
						<!-- <div class="m-t-30 m-b-30 p-b-30">
							Already a member? Click <a href="login_v3.html">here</a> to login.
						</div>
						<hr />
						<p class="text-center mb-0">
							&copy; Color Admin All Right Reserved 2020
						</p> -->
					</form>
				</div>
				<!-- end register-content -->
			</div>
			<div class="row">
				<div class="modal fade" id="modal-alert" style="display: none;" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Notifikasi</h4>
								<button type="button" class="close" >×</button>
							</div>
							<div class="modal-body">
								<div class="alert alert-danger m-b-0">
									<h5><i class="fa fa-info-circle"></i> Sukses</h5>
									<p>Akun anda berhasil didaftarkan silahkan klik tombol masuk dibawah ini</p>
								</div>
							</div>
							<div class="modal-footer">
								<a href="javascript:;" class="btn btn-danger" onclick="masuk()">Masuk</a>
							</div>
						</div>
					</div>
				</div>
			</div>
@endsection

@push('ajax')
	<script>
		function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}

		function masuk(){
			location.assign("{{url('login')}}");
		}
		function cari_kelurahan_tinggal(kode_kecamatan){
            $.ajax({
                type: 'GET',
                url: "{{ url('cari_kelurahan') }}",
                data: "kode_kecamatan="+kode_kecamatan,
                success: function(msg){
                    $('#tampilkelurahantinggal').html(msg);
                }
            });
        }

		function cari_kota(kode_provinsi){
            $.ajax({
                type: 'GET',
                url: "{{ url('cari_kota') }}",
                data: "kode_provinsi="+kode_provinsi,
                success: function(msg){
                    $('#tampilkota').html(msg);
                    $('#tampilkecamatan').html('<option value="">Pilih Kecamatan--</option>');
                    $('#tampilkelurahan').html('<option value="">Pilih Kelurahan--</option>');
                }
            });
        }
		function cari_kecamatan(kode_kota){
            $.ajax({
                type: 'GET',
                url: "{{ url('cari_kecamatan') }}",
                data: "kode_kota="+kode_kota,
                success: function(msg){
                    $('#tampilkecamatan').html(msg);
                    $('#tampilkelurahan').html('<option value="">Pilih Kelurahan--</option>');
                }
            });
        }
		function cari_kelurahan(kode_kecamatan){
            $.ajax({
                type: 'GET',
                url: "{{ url('cari_kelurahan') }}",
                data: "kode_kecamatan="+kode_kecamatan,
                success: function(msg){
                    $('#tampilkelurahan').html(msg);
                }
            });
        }

		function pilih_warga(id){
            $.ajax({
                type: 'GET',
                url: "{{ url('isi_warga') }}",
                data: "id="+id,
                success: function(msg){
                    $('#isi_warga').html(msg);
                }
            });
        }

		function click_registrasi(){
			var form=document.getElementById('my_register');
			
			$.ajax({
				type: 'POST',
				url: "{{ url('prosesregister') }}",
				data: new FormData(form),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function() {
					document.getElementById("loadnya").style.width = "100%";
				},
				success: function(msg){
					var data=msg.split('@'); 
					if(data[0]=='ok'){
						document.getElementById("loadnya").style.width = "0px";
						$('#modal-alert').modal({backdrop: 'static', keyboard: false});
					}else{
						document.getElementById("loadnya").style.width = "0px";
						
						$('#error-name').html(data[0]);
						$('#error-email').html(data[2]);
						$('#error-password').html(data[3]);
						$('#error-sts_warga').html(data[4]);
						$('#error-username').html(data[1]);
						$('#error-kode_provinsi').html(data[5]);
						$('#error-kode_kota').html(data[6]);
						$('#error-kode_kecamatan').html(data[7]);
						$('#error-kode_kelurahan').html(data[8]);
						$('#error-rw').html(data[9]);
						$('#error-rt').html(data[10]);
						$('#error-kode_provinsi_tinggal').html(data[11]);
						$('#error-kode_kota_tinggal').html(data[12]);
						$('#error-kode_kecamatan_tinggal').html(data[13]);
						$('#error-kode_kelurahan_tinggal').html(data[14]);
						$('#error-rw_tinggal').html(data[15]);
						$('#error-rt_tinggal').html(data[16]);
					}
				}
			});

    	}
	</script>

@endpush