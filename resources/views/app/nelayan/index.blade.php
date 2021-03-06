@extends('app.layout.main')

@section('title')
	Nelayan | Tambah
@endsection



@section('konten')

<!-- START PAGE-CONTAINER -->
<div class="page-container">

	<!-- START PAGE CONTENT WRAPPER -->
	<div class="page-content-wrapper">
		
		<!-- START PAGE CONTENT -->			
		<div class="content">
			
			<div class="jumbotron bg-darkblue" data-pages="parallax">
				<div class="container-fluid container-fixed-lg">
					<div class="inner" style="transform: translateY(0px); opacity: 1;">
						<!-- START BREADCRUMB -->
						<ul class="breadcrumb pull-left">
							<li>
								<a href="{{ route('nelayan') }}">Nelayan</a>
							</li>
						</ul>
						
						<button id="show-tambah-nelayan" class="btn btn-primary bg-blueblur m-t-10 m-b-10 pull-right">Tambah</button>
					</div>
				</div>

			</div>

			<br>

			<div class="container-fluid container-fixed-lg">

				<div class="inner" style="transform: translateY(0px); opacity: 1;">

					<div class="row">

						<div id="tambah-nelayan" style="display:none">
							<div class="col-lg-7 col-md-6 ">

								@if ( Session::has('error_nik') )
									<?php $user = App\User::where('nik', Session::get('error_nik'))->first() ?>
						    		<div class="alert alert-danger">GAGAL!!! NIK <b>{{ Session::get('error_nik') }}</b> telah terdaftar. <a href="javascript:;" data-toggle="modal" data-target="#modal-double-nik">Lihat</a></div> 
								@endif

								@if ( Session::has('gagal') ) 
						    		@include('app/layout/partials/alert-danger', ['message' => session('gagal')])
								@endif

								@if ( count($errors) > 0 )
									@include('app/layout/partials/alert-danger', ['errors' => $errors])
								@endif

								<!-- START PANEL -->
								<div class="panel panel-transparent">
									<div class="panel-body">
										<form id="form-personal" method="post" action="{{ route('nelayan_simpan') }}" role="form">
											
											{{ csrf_field() }}

											<div class="row clearfix">
												<div class="col-sm-6">
													<div class="form-group required">
														<label>NIK</label>
														<input type="text" class="form-control number" name="nik" value="{{ Input::old('nik') }}" required>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Nama Lengkap</label>
														<input type="text" class="form-control" name="name" value="{{ Input::old('name') }}" required>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-6">
													<div class="form-group required">
														<label>No. Kartu Nelayan</label>
														<input type="text" class="form-control" name="no_kartu_nelayan" value="{{ Input::old('no_kartu_nelayan') }}" required>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Alamat</label>
														<input type="text" class="form-control" name="alamat" value="{{ Input::old('alamat') }}"required>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
													<label>Kecamatan</label>
														<div id="kecamatan">
															<select class="full-width" data-init-plugin="select2" name="kecamatan" onchange="get_desa(this.value)" required>
																<option value="">Pilih Kecamatan...</option>
																<?php $kecamatan = App\Kecamatan::get() ?>
																@foreach ( $kecamatan as $kec )
																	<option value="{{ $kec->id }}">{{ $kec->nama }}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
														<label><b>Desa/Kelurahan</b></label>
													<div class="form-group">
														<span id="desa">
														<select class="full-width" name="desa" data-init-plugin="select2" required>
															<option value="">Pilih Desa/Kelurahan...</option>
														</select>
														</span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label>RT/RW</label>
														<input type="text" class="form-control" name="erte" value="{{ Input::old('erte') }}">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label>Telepon</label>
														<input type="text" class="form-control" name="tlp" value="{{ Input::old('tlp') }}">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label>Kode POS</label>
														<input type="text" class="form-control" name="pos" value="{{ Input::old('pos') }}">
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label>Nama Kelompok</label>
														<select class="full-width" name="id_kelompok" data-init-plugin="select2" required>
															<option value="">Pilih Kelompok...</option>
															@foreach( $kelompok as $klp )
																<option value="{{ $klp->id_kelompok }}" {{ Input::old('id_kelompok') == $klp->id_kelompok ? "selected":"" }}>{{ $klp->nama }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Jabatan Dalam Kelompok</label>
														<select class="full-width" name="id_jabatan" data-init-plugin="select2" required>
															<option value="">Pilih Jabatan...</option>
															@foreach( $jabatan as $jab )
																<option value="{{ $jab->id }}" {{ Input::old('id_jabatan') == $jab->id ? "selected":"" }}>{{ $jab->nama }}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label>Kepemilikan Sarana dan Prasarana</label>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<select name="id_sarana[]" class="full-width" data-init-plugin="select2" multiple="" data-placeholder="Pilih Sarana / Prasaranan...">

															<optgroup label="Perahu/Kapal">
															<?php $PK = App\Sarana::where('tipe','Nelayan')->where('jenis','Perahu Kapal')->get() ?>
															@foreach( $PK as $rpk )
																<option value="{{ $rpk->id }}">{{ $rpk->sub }}</option>
															@endforeach
															</optgroup>

															<optgroup label="Alat Tangkap">
															<?php $PK = App\Sarana::where('tipe','Nelayan')->where('jenis','Alat Tangkap')->get() ?>
															@foreach( $PK as $rpk )
																<option value="{{ $rpk->id }}">{{ $rpk->sub }}</option>
															@endforeach
															</optgroup>

															<optgroup label="Mesin">
															<?php $PK = App\Sarana::where('tipe','Nelayan')->where('jenis','Mesin')->get() ?>
															@foreach( $PK as $rpk )
																<option value="{{ $rpk->id }}">{{ $rpk->sub }}</option>
															@endforeach
															</optgroup>
														</select>
													</div>
												</div>
											</div>

											<div class="clearfix"></div>
											<br>
											
											<button class="btn btn-primary" type="submit">Tambah</button>
										</form>
									</div>
								</div>
								<!-- END PANEL -->
							</div>
						</div>

						<div class="col-md-12">
								
							@if ( Session::has('success') ) 
					    		@include('app/layout/partials/alert-sukses', ['message' => session('success')])
							@endif
							
							<!-- START PANEL -->
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="">
										<form action="{{ url('/app/nelayan') }}">
											<div class="col-md-4">
												<div class="input-group">
													<input type="date" class="form-control" name="offset" value="{{ $_GET['offset'] }}"/>
													<span class="input-group-addon" style="border: 0;">-</span>
													<input type="date" class="form-control" name="limit" value="{{ $_GET['limit'] }}"/>
												</div>
											</div>

											<div class="col-md-1">
												<button class="btn btn-default">Tampilkan</button>
											</div>

										</form>

										<div class="col-md-offset-1 col-md-6">
											<div class="input-group">
											<input type="text" onkeyup="cari_data(this.value)" class="form-control" placeholder="Pencarian">
											<span class="input-group-btn">
												<a href="" class="btn btn-default" data-toggle="modal" data-target="#modal-ekspor"><i class="fa fa-file-archive-o"></i> &nbsp;Ekspor</a>
											</span>
										</div>
										</div>
										<br>
										<div id="show-pencarian"></div>

										<div id="show-data">
											<table class="table table-hover demo-table-dynamic custom">
												<thead>
													<tr>
														<th rowspan="2">
															<button class="btn btn-check" data-toggle="modal" data-target="#modal-hapus" disabled id="hapus"><i class="pg-trash"></i></button>
														</th>
														<th rowspan="2">No.</th>
														<th rowspan="2">Nama Lengkap</th>
														<th rowspan="2">Nama Kelompok</th>
														<th rowspan="2">Jabatan Kelompok</th>
														<th colspan="3"><center>Alamat</center></th>
														<th rowspan="2" style="text-align:center">Aksi</th>
													</tr>
													<tr>
														<th>RT/RW</th>
														<th>Desa/Kel.</th>
														<th>Kecamatan</th>
													</tr>
												</thead>
												<tbody>

													<?php
														if ( isset($_GET['page']) ) {
															$i = ($_GET['page'] - 1) * $limit + 1;
														} else {
															$i = 1;
														}
													?>
													
													@foreach( $nelayan as $nel )
														<tr>
															<td>
																<div class="checkbox">
																	<input type="checkbox" class="pilih" value="{{ $nel->id }}" id="pb{{ $nel->id }}">
																	<label for="pb{{ $nel->id }}" class="m-l-20"></label>
																</div>
															</td>
															<td>{{ $i++ }}</td>
															<td>{{ $nel->name }}</td>
															<td>{{ $nel->kelompok->nama }}</td>
															<td>{{ $nel->jabatan->nama }}</td>
															<td>{{ $nel->erte }}</td>
															<td>{{ $nel->desa->nama }}</td>
															<td>{{ $nel->desa->kecamatan->nama }}</td>
															<td style="text-align:center">
																<a class="btn btn-default btn-xs view" data-id="{{ $nel->id }}"><i class="fa fa-search-plus"></i></a>
																<a href="{{ route('nelayan_edit',$nel->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
															</td>
														</tr>
													@endforeach
												</tbody>
											</table>
											<center>{!! $nelayan->appends( ['offset' => $_GET['offset'], 'limit' => $_GET['limit'] ])->links() !!}</center>
										</div>

									</div>
								</div>
							</div>
							<!-- END PANEL -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
		<!-- START COPYRIGHT -->
		<!-- START CONTAINER FLUID -->

			@include('app.layout.partials.copyright')
			
		<!-- END COPYRIGHT -->
	</div>
	<!-- END PAGE CONTENT WRAPPER -->

</div>
<!-- END PAGE CONTAINER -->

<!-- MODAL STICK UP VIEW -->
<div class="modal fade stick-up" id="modal-view" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal"  aria-hidden="true"><i class="pg-close fs-14"></i></button>
					<h5>Detail Nelayan</h5>
				</div>
				<div class="modal-body" id="view-detail">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-cons no-margin inline" data-dismiss="modal">Kembali</button>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<!-- MODAL STICK UP SMALL ALERT -->
<div class="modal fade stick-up" id="modal-hapus" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal"  aria-hidden="true"><i class="pg-close fs-14"></i></button>
					<h5>Hapus Data</h5>
				</div>
				<div class="modal-body">
					<p class="no-margin">Data akan dihapus. Apakah Anda yakin?</p>
				</div>
				<div class="modal-footer">
					<a class="btn btn-danger btn-hapus btn-cons pull-left inline">Ya</a>
					<button type="button" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">Tidak</button>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- END MODAL STICK UP SMALL ALERT -->


<!-- MODAL STICK UP SMALL ALERT -->
<div class="modal fade slide-up" id="modal-ekspor" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header clearfix text-left">
					<button type="button" class="close" data-dismiss="modal"  aria-hidden="true"><i class="pg-close fs-14"></i></button>
					<h5>Ekspor Data</h5>
					<hr>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<a href="{{ url('/app/nelayan/export-excel?offset='.$_GET['offset'].'&limit='.$_GET['limit']) }}">
								<i class="fa fa-file-excel-o export-excel"></i>
								Unduh Dalam Format Mic.Excel
							</a>
						</div>
						<div class="col-md-6">
							<a href="{{ url('/app/nelayan/export-pdf?offset='.$_GET['offset'].'&limit='.$_GET['limit']) }}">
								<i class="fa fa-file-pdf-o export-pdf"></i>
								Unduh Dalam Format PDF
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- END MODAL STICK UP SMALL ALERT -->

@if ( Session::has('error_nik') )

	<!-- MODAL STICK UP VIEW -->
	<div class="modal fade stick-up" id="modal-double-nik" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content-wrapper">
				<div class="modal-content">
					<div class="modal-header clearfix text-left">
						<button type="button" class="close" data-dismiss="modal"  aria-hidden="true"><i class="pg-close fs-14"></i></button>
						<h5>Data</h5>
					</div>
					<div class="modal-body" id="view-detail">
						<table class="table">
							<tr>
								<td style="width:100px">NIK</td><td>: {{ $user->nik }}</td>
							</tr>
							<tr>
								<td style="width:100px">Nama</td><td>: {{ $user->name }}</td>
							</tr>
							<tr>
								<td style="width:100px">Kelompok</td><td>: {{ $user->kelompok->nama }}</td>
							</tr>
							<tr>
								<td style="width:100px">Profesi</td><td>: {{ $user->profesi }}</td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-cons no-margin inline" data-dismiss="modal">Kembali</button>
					</div>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

@endif

@endsection


@section('registerscript')
	<script>
		$(".menu-items .link-nelayan").addClass("active open");
		$(".menu-items .link-nelayan .sub-nelayan").addClass("active");

		$(function(){

			var _token = $('meta[name="csrf-token"]').attr('content');

			$("#hapus").click(function(){

				if($(".pilih:checked").length) {
		          var id = "";
		          $(".pilih:checked").each(function() {
		            id += $(this).val() + ",";
		          });
		          id =  id.slice(0,-1);
		        }
		        else {
				  return false;
		        }
		        $(".btn-hapus").attr('href',"{{ route('nelayan_hapus') }}/"+id);

			});

			$("#show-tambah-nelayan").click(function(){
				$("#tambah-nelayan").fadeIn();
				$("input[name='nik']").focus();
				$(this).hide();
			});

			// Show detail
			$(".panel").on('click','.view', function(){
				var id = $(this).data('id');
				var url = "{{ url('app/nelayan/detail') }}";
				var url = url+'/'+id;
				$.get(url, {id:id, _token:_token}, function(data){
					$("#view-detail").html(data);
					$("#modal-view").modal('show');
				});
			});

			@if ( count($errors) > 0 || Session::has('gagal') || Session::has('error_nik') )
				$("#tambah-nelayan").fadeIn();
			@endif

		});

		function get_sarana(id){
			$('#sarana').html('<i class="fa fa-spinner fa-spin"></i>');
			var _token = $('meta[name="csrf-token"]').attr('content');
			var url = "{{ url('app/nelayan/sarana') }}";
			var url = url+"/"+id;
			$.get(url, { id:id, _token:_token}, function(data){
				$('#sarana').html(data);
			});
		}

		function cari_data(cari){
			if ( cari == "" ) {
				$("#show-data").show();
				$("#show-pencarian").hide();
			} else {
				$("#show-data").hide();
				$("#show-pencarian").show();
				$("#show-pencarian").html('<tr><td colspan="6"><i class="fa fa-spinner fa-spin"></i></td></tr>');
				var _token = $('meta[name="csrf-token"]').attr('content');
				var url = "{{ url('app/nelayan/cari') }}";
				var url = url+"/"+cari;
				$.get(url, { cari:cari, _token:_token}, function(data){
					$('#show-pencarian').html(data);
				});
			}
		}

		function get_desa(id_kecamatan){
			$('#desa').html("<i class='fa fa-spinner fa-spin'></i>");
			var url = "{{ url('get-desa') }}";
			var url = url+"/"+id_kecamatan;
			$.get(url, { id_kecamatan:id_kecamatan}, function(data){
				$('#desa').html(data);
			});
		}

	</script>
@endsection