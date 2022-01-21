
<html>
	<head>
		<title>LHA</title>
		<style>
			html{
				margin:2%;
			}
			td{
				font-size:13px;
				vertical-align:top;
			}
			body{
				margin:3% 6%;
			}
		</style>
	</head>
	<body>
		<table width="100%" border="0">
			<tr>
				<td width="3%"></td>
				<td width="3%"></td>
				<td width="3%"></td>
				<td width="3%"></td>
				<td width="3%"></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="6"><u><b>6. KESIMPULAN</b></u></td>
			</tr>
			@foreach(kesimpulan_get($id) as $kesimpulan)
				<tr>
					<td></td>
					<td><b>{{$kesimpulan->nomor}}</b></td>
					<td colspan="4">{{$kesimpulan->name}}</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td colspan="4">{!! $kesimpulan->isi !!}</td>
				</tr>
				@foreach(rekomendasi_get($kesimpulan->id) as $rekomendasi)
					<tr>
						<td></td>
						<td></td>
						<td><b>{{$rekomendasi->nomor}}.{{$rekomendasi->urutan}}</b></td>
						<td colspan="3">{!! $rekomendasi->isi !!}</td>
					</tr>
				@endforeach
			@endforeach
		</table>
	<body>
</html>