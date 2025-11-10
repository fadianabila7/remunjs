        <div class="right_col" role="main">
        	<div class="row wrapper border-bottom white-bg dashboard-header">
        		<div class="page-title">
        			<div class="title_left">
        				<h3>Ubah Kelas Kuliah</h3>
        			</div>
        		</div>

        		<div class="row">
        			<div class="col-md-12 col-sm-12 col-xs-12">
        				<div class="x_panel">
        					<h2>Form Ubah Kelas Kuliah</h2>
        					<?php
							foreach ($data['jenjangPendidikan'] as $key) {
								$jenjangPendidikan = $key['id_jenjang_pendidikan'];
							}
							// print_r($data['dataKelasKuliah']);
							?>
        					<div class="x_content" id="sini">
        						<?php

								foreach ($data['dataKelasKuliah'] as $key) {
									$link = "pengajaran/do_editkelaskuliah/" . $key['id_kelaskuliah'];
								?>

        							<form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url($link) ?>">
        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">Kegiatan</label>
        									<div class="col-md-6 col-sm-6 col-xs-12">
        										<select autofocus class="select2_single form-control" tabindex="-1" name="kegiatan" id="kegiatan">
        											<option value="<?php echo $key['kode_kegiatan']; ?>"><?php echo $key['nama_kegiatan']; ?></option>
        											<?php
													foreach ($data['dataKegiatan'] as $keya) {
														if ($jenjangPendidikan == 0 or $jenjangPendidikan == 1 or $jenjangPendidikan == 8 || $jenjangPendidikan == 10 || $jenjangPendidikan == 11) {
															if (in_array($keya['kode_kegiatan'], [2, 6, 9, 7, 8, 10, 318, 319, 320, 324, 325])) {
																echo "<option value='" . $keya['kode_kegiatan'] . "'>" . $keya['nama'] . "</option>";
															}
														} elseif ($jenjangPendidikan == 2 or $jenjangPendidikan == 4 or $jenjangPendidikan == 5) {
															if ($keya['kode_kegiatan'] == 3 or $keya['kode_kegiatan'] == 4 or $keya['kode_kegiatan'] == 6 or $keya['kode_kegiatan'] == 8 or $keya['kode_kegiatan'] == 9 or $keya['kode_kegiatan'] == 11) {
																echo "<option value='" . $keya['kode_kegiatan'] . "'>" . $keya['nama'] . "</option>";
															}
														} elseif ($jenjangPendidikan == 3 or $jenjangPendidikan == 6) {
															if ($keya['kode_kegiatan'] == 5 or $keya['kode_kegiatan'] == 6 or $keya['kode_kegiatan'] == 10 or $keya['kode_kegiatan'] == 11) {
																echo "<option value='" . $keya['kode_kegiatan'] . "'>" . $keya['nama'] . "</option>";
															}
														}
													}
													?>
        										</select>
        										<input type="hidden" id="kegiatan_hidden" name="kegiatan_hidden" value="<?php echo $key['kode_kegiatan']; ?>">
        									</div>
        								</div>

        								<div id="jenis-extend">

        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">Mata Kuliah</label>
        									<div class="col-md-6 col-sm-6 col-xs-12">
        										<input class="form-control col-md-7 col-xs-12" name="matakuliah" id="matakuliah" required="required" type="text" autocomplete="off" value="<?php echo $key['nama_matakuliah']; ?>" onfocusout="FunctionChekMK()" onfocus="FunctionGetMK()">
        										<input type="hidden" name="id_matakuliah" id="id_matakuliah" value="<?php echo $key['id_matakuliah']; ?>">
        									</div>
        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">Dosen</label>
        									<div class="col-md-6 col-sm-6 col-xs-12">
        										<input class="form-control col-md-7 col-xs-12" autofocus data-validate-length-range="30" data-validate-words="2" name="nama_dosen" id="nama_dosen" placeholder="Nama Dosen" required="required" type="text" value="<?php echo $key['namadosen']; ?>" onfocusout="FunctionChekDosen()" onfocus="FunctiongetDosen()">
        										<input type="hidden" name="id_dosen" id="id_dosen" value="<?php echo $key['id_dosen'] ?>">
        									</div>
        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Akademik</label>
        									<div class="col-md-6 col-sm-6 col-xs-12">
        										<input id="tahunakademik" class="form-control col-md-7 col-xs-12" data-validate-length-range="4" data-validate-words="1" name="tahunakademik" placeholder="Tahun Akademik" required="required" type="number" value="<?php echo $key['tahunakademik']; ?>">
        									</div>
        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">Semester</label>
        									<div class="col-md-6 col-sm-6 col-xs-12">
        										<select class="select2_single form-control" tabindex="-1" name="semester" id="semester">
        											<option value="<?php echo $key['semester']; ?>">
        												<?php if ($key['semester'] == "1") echo "Ganjil";
														else if ($key['semester'] == "2") echo "Genap";
														else if ($key['semester'] == "9") echo "Semester Pendek";
														else echo "Antara"; ?>
        											</option>
        											<option value="1">Ganjil</option>
        											<option value="2">Genap</option>
        										</select>
        									</div>
        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">SK Kontrak</label>
        									<div class="col-md-6 col-sm-6 col-xs-12">
        										<input id="tahunakademik" class="form-control col-md-7 col-xs-12" name="skkontrak" placeholder="Nomor SK Kontrak" required="required" type="text" value="<?php echo $key['no_sk_kontrak'] ?>">
        									</div>
        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">Hari</label>
        									<div class="col-md-3 col-sm-6 col-xs-12">
        										<select class="select2_single form-control" tabindex="-1" name="hari" id="hari">
        											<option value="<?php echo $key['hari']; ?>">
        												<?php if ($key['hari'] == "1") echo "Minggu";
														else if ($key['hari'] == "2") echo "Senin";
														else if ($key['hari'] == "3") echo "Selasa";
														else if ($key['hari'] == "4") echo "Rabu";
														else if ($key['hari'] == "5") echo "Kamis";
														else if ($key['hari'] == "6") echo "Jum'at";
														else if ($key['hari'] == "7") echo "Sabtu"; ?>
        											</option>
        											<option value="2">Senin</option>
        											<option value="3">Selasa</option>
        											<option value="4">Rabu</option>
        											<option value="5">Kamis</option>
        											<option value="6">Jum'at</option>
        											<option value="7">Sabtu</option>
        										</select>
        									</div>
        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">Waktu Mulai</label>
        									<div class="col-md-3 col-sm-6 col-xs-12">
        										<div class="input-group clockpicker" data-autoclose="true">
        											<input type="text" class="form-control" value="<?php echo substr($key['waktu_mulai'], 0, 5) ?>" name="waktu_mulai">
        											<span class="input-group-addon">
        												<span class="fa fa-clock-o"></span>
        											</span>
        										</div>
        									</div>
        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">SKS</label>
        									<div class="col-md-3 col-sm-6 col-xs-12">
        										<input id="sks" class="form-control col-md-7 col-xs-12" max=4 min=1 data-validate-length-range="4" data-validate-words="1" name="sks" placeholder="SKS" required="required" type="number" value="<?php echo $key['sks'] ?>" onkeyup="FunctionChekSKS()">
        									</div>
        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">Ruangan</label>
        									<div class="col-md-3 col-sm-6 col-xs-12">
        										<input id="ruangan" class="form-control col-md-7 col-xs-12" name="ruangan" placeholder="Ruangan" required="required" type="text" value="<?php echo $key['ruang'] ?>">
        									</div>
        								</div>

        								<div class="form-group">
        									<label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Peserta</label>
        									<div class="col-md-3 col-sm-6 col-xs-12">
        										<input id="jumlah_peserta" class="form-control col-md-7 col-xs-12" data-validate-length-range="4" data-validate-words="1" name="jumlah_peserta" placeholder="Jumlah Peserta" required="required" type="number" value="<?php echo $key['peserta'] ?>">
        									</div>
        								</div>
        							<?php } ?>

        							<div class="form-group">
        								<div class="col-md-6 col-md-offset-3">
        									<button type="button" class="btn btn-primary" id="cancel" name="cancel">Cancel</button>
        									<button id="send" type="submit" class="btn btn-success">Submit</button>
        								</div>
        							</div>

        							</form>
        					</div>
        				</div>
        			</div>
        		</div>

        	</div>
        </div>

        <br><br><br>

        <script type="text/javascript">
        	var MK = "";
        	var Dosen = "";

        	$('#kegiatan').on("change", function(e) {
        		let pilihan = this.value
        		if (pilihan == 324 || pilihan == 325) {
        			$("#semester").empty().append('<option value="">Pilih Semester</option><option value="9" selected>Semester Pendek</option>');
        		} else {
        			$("#semester").empty().append('<option value="">Pilih Semester</option><option value="1">Ganjil</option><option value="2">Genap</option>');
        		}
        	});

        	function FunctiongetDosen() {
        		Dosen = $("#nama_dosen").val();
        	}

        	function FunctionGetMK() {
        		MK = $("#matakuliah").val();
        	}

        // 	function FunctionChekSKS() {
        // 		var a = $("#sks").val();
        // 		if (a < 1 || a > 10) {
        // 			swal({
        // 				title: "Peringatan",
        // 				text: "Jumlah SKS Harus 0 < SKS < 10."
        // 			});
        // 			$("#sks").val("1");
        // 			$("#sks").html("1");
        // 		}
        // 	}
        
            function FunctionChekSKS() {
                var a = parseFloat($("#sks").val().replace(",", ".").replace(".", ",")); 
                if (a <= 0 || a >= 10 || isNaN(a)) {
                    swal({
                        title: "Peringatan",
                        text: "Jumlah SKS Harus 0 < SKS < 10."
                    });
                    $("#sks").val("1");
                    $("#sks").html("1");
                }
            }

        	function FunctionChekMK() {

        		var b = $("#matakuliah").val();
        		var a = $("#id_matakuliah").val();

        		if (b != MK && a == "") {
        			swal({
        				title: "Peringatan",
        				text: "Anda Haru Memilih Mata Kuliah!!"
        			});
        			$("#matakuliah").val(MK);
        			$("#matakuliah").html(MK);
        		}
        	}

        	function FunctionChekDosen() {
        		var a = $("#id_dosen").val();
        		var b = $("#nama_dosen").val();

        		if (b != Dosen && a == "") {
        			swal({
        				title: "Peringatan",
        				text: "Anda Harus Memilih Dosen!!."
        			});
        			$("#nama_dosen").val(Dosen);
        			$("#nama_dosen").html(Dosen);
        		}
        	}

        	$(document).ready(function(e) {
        		var datajsonmk;
        		post = $.post("<?php echo site_url('pengajaran/json_search_matakuliah') ?>", {});
        		post.done(function(datamk) {
        			datajsonmk = JSON.parse(datamk);
        		});

        		$('#matakuliah').autoComplete({
        			minChars: 1,
        			source: function(term, suggest) {
        				term = term.toLowerCase();
        				var choices = [];
        				for (i = 0; i < datajsonmk.length; i++) {
        					choices.push(datajsonmk[i].nama);
        				}
        				var suggestions = [];
        				for (i = 0; i < choices.length; i++)
        					if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
        				suggest(suggestions);
        			},
        			onSelect: function(event, ui) {
        				var id = "";
        				for (i = 0; i < datajsonmk.length; i++) {
        					if (datajsonmk[i].nama == ui) {
        						id = datajsonmk[i].id_matakuliah;
        					}
        				}
        				$('#id_matakuliah').val(id);
        			}
        		});

        		var datajsondosen;
        		post = $.post("<?php echo site_url('pengajaran/json_search_dosen') ?>", {});
        		post.done(function(datad) {
        			datajsondosen = JSON.parse(datad);
        		});

        		$('#nama_dosen').autoComplete({
        			minChars: 1,
        			source: function(term, suggest) {
        				term = term.toLowerCase();
        				var choices = [];
        				for (i = 0; i < datajsondosen.length; i++) {
        					choices.push(datajsondosen[i].nama + "::" + datajsondosen[i].id_dosen);
        				}
        				var suggestions = [];
        				for (i = 0; i < choices.length; i++)
        					if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
        				suggest(suggestions);
        			},
        			onSelect: function(event, ui) {
        				var temp = ui.split("::");
        				var id = temp[1];
        				/* for (k=0;k<datajsondosen.length;k++)
        				    if (datajsondosen[k].nama==ui) id=datajsondosen[k].id_dosen;*/
        				$('#id_dosen').val(id);
        			}
        		});


        		$('#kegiatan').on('change', function() {
        			var kode_induk = $(this).val();
        			$('#jenis-extend').html('');
        			console.log('induk' + kode_induk);
        			getKegiatanTurunan(kode_induk);
        		});

        		$('#jenis-extend').on('change', '.jenis_kegiatan', function() {
        			var kode_induk = $(this).val();
        			console.log('extend' + kode_induk);
        			getKegiatanTurunan(kode_induk);
        		});

        		function getKegiatanTurunan(kode_induk) {
        			var idxjenis = 0;
        			var kegiatan = "";
        			var opt = "";
        			$.ajax({
        				url: "<?php echo base_url(); ?>index.php/pengajaran/getKegiatanByInduk",
        				type: "GET",
        				data: {
        					kode: kode_induk
        				},
        				success: function(ajaxData) {

        					if (ajaxData != "1") {
        						kegiatan = JSON.parse(ajaxData);
        						opt = opt + "<option value=''>Pilih Kegiatan</option>";
        						for (i = 0; i < kegiatan.length; i++) {
        							opt = opt + "<option value='" + kegiatan[i]['kode_kegiatan'] + "'>" + kegiatan[i]['nama'] + "</option>";
        						}

        						var jenisextend = ' <div class="form-group"><label for="jenis_keg" class="col-md-3 control-label"> </label><div class="col-md-6 col-xs-12 col-sm-6"><select class="form-control jenis_kegiatan" type="text" id ="jenis_keg' + idxjenis + '" name="jenis_keg' + idxjenis + '" required>' + opt + '</select>';
        						console.log(jenisextend);
        						idxjenis++;
        						$('#jenis-extend').append(jenisextend);
        						//reloadJSkegiatan();                         
        					} else {
        						$('#kegiatan_hidden').val(kode_induk);
        					}
        				},
        				error: function(status) {

        				}
        			});
        		}

        	});
        </script>