<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>Riwayat Kegiatan Dosen </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url(); ?>">Home</a>
                </li>
                <li class="active">
                    <strong>Riwayat Kegiatan Dosen -
                        <?php
                        switch ($jenis) {
                            case 1:
                                echo "Pendidikan";
                                break;
                            case 2:
                                echo "Penelitian";
                                break;
                            case 3:
                                echo "Pengabdian";
                                break;
                            case 4:
                                echo "Penunjang";
                                break;
                        } ?>
                    </strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Riwayat Kegiatan Dosen - <?php
                                                        switch ($jenis) {
                                                            case 1:
                                                                echo "Pendidikan";
                                                                break;
                                                            case 2:
                                                                echo "Penelitian";
                                                                break;
                                                            case 3:
                                                                echo "Pengabdian";
                                                                break;
                                                            case 4:
                                                                echo "Penunjang";
                                                                break;
                                                        }
                                                        ?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a></li>
                                <li><a href="#">Config option 2</a></li>
                            </ul>
                            <a class="close-link"><i class="fa fa-times"></i></a>
                            <div class="hr-line-dashed"></div>
                            <form id="formTampil" onsubmit="return false;">
                                <div class="form-group" id="data_4">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select class="form-control m-b" name="bulan">
                                                <option value="0">Semua Bulan</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control m-b" name="tahun">
                                                <?php
                                                for ($i = date('Y'); $i >= 2019; $i--) {
                                                    echo "<option>" . $i . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control m-b" name="id_kegiatan" id="id_kegiatan">
                                                <option value="0">All</option>
                                            </select>
                                        </div>
                                        <input type="hidden" id="jenis-kegiatan" name="jenis" value="<?php echo "$jenis"; ?>">
                                        <div class="col-md-5">
                                            <button type="submit" onclick="getRiwayat();" class="btn btn-info"><span class="fa fa-search"></span> Tampilkan</button>
                                            <button class="btn btn-info" onclick="ExportRiwayat();"><span class="fa fa-file-excel-o"></span> Export</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="2%">No</th>
                                            <th class="col-lg-2">Operator & <br>Tanggal</th>
                                            <th class="col-lg-3">No. SK/Kontrak <br>Nama Kegiatan</th>
                                            <th>Bobot SKS</th>
                                            <th>SKS</th>
                                            <th>Jumlah</th>
                                            <th class="col-lg-4">Deskripsi</th>
                                            <?php if ($jenis == 4) echo "<th>Action</th>"; ?>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal inmodal" id="nilaiModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <i class="fa fa-tasks modal-icon"></i>
                        <h4 class="modal-title">Update Nilai Kegiatan Dosen</h4>
                        <small>Update Nilai Anggota Kegiatan Penunjang Dosen</small>
                    </div>

                    <form role='form' class="form-horizontal" id='nilaiForm' onsubmit="return false;">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="no_sk_modal" class="col-md-3 control-label">No Surat Keputusan</label>
                                <div class="col-md-6" id='no_sk'>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tgl_sk_modal" class="col-md-3 control-label">Tanggal Surat Keputusan</label>
                                <div class="col-md-6" id="tgl_sk">

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="judul_keg_modal" class="col-md-3 control-label">Judul Kegiatan</label>
                                <div class="col-md-6" id="judul_keg">

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tgl_keg_modal" class="col-md-3 control-label">Tanggal Kegiatan</label>
                                <div class="col-md-6" id="tgl_keg">

                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <h3>Detail Penerima Surat Keputusan</h3>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id='datatable-modal' class="table table-striped table-bordered table-hover responsive display dataTables-example" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIP/NIPUS</th>
                                                <th>Kode Kegiatan</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel_modal_body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="button" data-dismiss="modal" type="submit" id='btn-save' class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!--End of Page Content-->

    <script type="text/javascript">
        var t = $("#datatable").DataTable();
        var tabelModal = $("#datatable-modal").DataTable();
        var jenis = $('#jenis-kegiatan').val();
        var jenis_turunan = $('#id_kegiatan').val();

        function getRiwayat() {
            postData = $('#formTampil').serialize();
            console.log(postData);

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/KegiatanController/getKegiatanDosenJenisBulanTahun",
                type: "POST",
                data: postData,
                success: function(ajaxData) {

                    t.clear().draw();
                    var result = JSON.parse(ajaxData);

                    for (var i = 0; i < result.length; i++) {
                        var button = "<div class='tooltip-demo'><a href='#' data-toggle='tooltip' data-placement='bottom' title='" + result[i]['deskripsi'] + "'><span class='fa fa-list-ul fa-2x'></span></a></div>";
                        var buttonaction;
                        if (result[i]['posisi'].indexOf('Ketua') !== -1) {
                            var noSK = '"' + result[i]['no_sk_kontrak'] + '"';
                            buttonaction = "<button class='btn btn-info btn-edit' onclick='Penilaian(" + noSK + ")'><span class='fa fa-edit'></span></button>";
                        } else {
                            buttonaction = "";
                        }
                        var buttondownload = "<a href='http://localhost/keputusan/" + result[i]['path_berkas'] + "' class='btn btn-info' target='_blank'><span class='fa fa-download'></span></a>";
                        var kode_kegiatan_button = "<a href='#' data-toggle='tooltip' data-placement='bottom' title='" + result[i]['nama_keg'] + "'>" + result[i]['kode_kegiatan'] + "</a>";
                        var jumlah = result[i]['bobot_sks'] * result[i]['sks'];
                        var data = '';
                        var a = result[i]['deskripsi2'];

                        //deskripsi
                        for (var n in a) {
                            if (n === "keg_perbln" || n === "uuid_penelitian" || n === "uuid_bimbing" || n === "bln_ke" || n === "dari" || n === "tgl_mulai" || n === "uuid_penunjang") {} else {
                                data += (('<b>' + n + '</b> = ' + a[n] + '<br>').replace("_", " ")).replace(/\b\w/g, l => l.toUpperCase());
                            }
                        }

                        // nama Kegiatan
                        var b = {
                            "#": "<br>"
                        };
                        if (jenis == 4) {
                            t.row.add([
                                i + 1,
                                "<div style='text-align: left;'>" + result[i]['id_user'] +
                                "<br>" + result[i]['tanggal_kegiatan'] + "</div>",

                                "<div style='text-align: left;'><u>" + result[i]['no_sk_kontrak'] + "</u><br>" +
                                (result[i]['nama_keg']).replace(/#/gi, function(matched) {
                                    return b[matched];
                                }) + "</div>",
                                "<center>" + result[i]['bobot_sks'] + "</center>",
                                "<center>" + result[i]['sks'] + "</center>",
                                "<center>" + jumlah + "</center>",

                                "<div style='text-align: left;'>" + data + "</div>",
                                "<center>" + buttonaction + buttondownload + "</center>",

                            ]).draw();
                        } else {
                            t.row.add([
                                i + 1,
                                "<div style='text-align: left;'>" + result[i]['id_user'] +
                                "<br>" + result[i]['tanggal_kegiatan'] + "</div>",

                                "<div style='text-align: left;'><u>" + result[i]['no_sk_kontrak'] + "</u><br>" +
                                (result[i]['nama_keg']).replace(/#/gi, function(matched) {
                                    return b[matched];
                                }) + "</div>",
                                "<center>" + result[i]['bobot_sks'] + "</center>",
                                "<center>" + result[i]['sks'] + "</center>",
                                "<center>" + jumlah + "</center>",
                                "<div style='text-align: left;'>" + data + "</div>",
                            ]).draw();
                        }
                    }
                },
                error: function(status) {
                    t.clear().draw();
                }
            });

        }

        function Penilaian(noSK) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/KegiatanController/getDataKegiatanByNoSK",
                type: "GET",
                data: {
                    no_sk: noSK
                },
                success: function(ajaxData) {
                    tabelModal.clear().draw();
                    var buttondetail = '';
                    var result = JSON.parse(ajaxData);
                    var kode = '';
                    var inputNip = '';
                    var id_keg_dosen = '';


                    $('#no_sk').html('<div class="form-control">' + noSK + '</div>');
                    $('#tgl_sk').html('<div class="form-control">' + result[0]['tgl_sk'] + '</div>');
                    $('#judul_keg').html('<div class="form-control">' + result[0]['judul_keg'] + '</div>');
                    $('#tgl_keg').html('<div class="form-control">' + result[0]['tgl_keg'] + '</div>');

                    for (var i = 0; i < result.length; i++) {
                        inputNilai = '<input class="form-control" id="nilai' + i + '" name="nilai[]" value="' + result[i]['nilai'] + '">';
                        kode = "<a href='#' data-toggle='tooltip' data-placement='bottom' title='" + result[i]['nama_keg'] + "'>" + result[i]['kode_keg'] + "</a>";
                        inputNip = '<input type="hidden" id="nip' + i + '" name = "nip[]" value="' + result[i]['nip'] + '">';
                        id_keg_dosen = '<input type="hidden" id="id_keg' + i + '" name="id_keg_dosen[]" value="' + result[i]['id_keg_dosen'] + '">';
                        console.log(i + "," + result[i]['nama_dosen']);
                        tabelModal.row.add([
                            i + 1,
                            result[i]['nama_dosen'],
                            result[i]['nip'] + inputNip,
                            kode + id_keg_dosen,
                            inputNilai,
                        ]).draw();

                        //var row = "<tr><td>"+(i+1)+"</td><td>"+result[i]['nama_dosen']+"</td><td>"+result[i]['nip']+"</td><td>"+kode+"</td><kd>"+buttondetail+"</kd></tr>";
                        //$("#tabel-modal-body").append(row);
                    }
                    $('#nilaiModal').modal('show');
                },
                error: function(status) {
                    tabelModal.clear().draw();
                }
            });
        }

        $('#btn-save').on('click', function() {
            var updateData = $('#nilaiForm').serialize();

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/KegiatanController/updateNilaiPenunjang",
                type: "POST",
                data: updateData,
                success: function(ajaxData) {
                    $.notify({
                        title: "<strong>Update Nilai Anggota</strong> ",
                        message: "Success"
                    }, {
                        type: 'success',
                        delay: 3000,
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });
                },
                error: function(status) {
                    $.notify({
                        title: "<strong>Update Nilai Anggota</strong> ",
                        message: "Failed"
                    }, {
                        type: 'danger',
                        delay: 3000,
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });
                }
            })
        });
    </script>

    <script type="text/javascript">
        function getTurunan(id) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/KegiatanController/getTurunan",
                type: "POST",
                data: {
                    id: id
                },
                success: function(ajaxData) {
                    var lock = JSON.parse(ajaxData);
                    var option = '<option value="0">All </option>';
                    for (var i = 0; i < lock.length; i++) {
                        option += "<option value='" + lock[i].kategori + "'>" + lock[i].nama + " </option>";
                    }
                    $("#id_kegiatan option").remove();
                    $('#id_kegiatan').append(option);
                },

                error: function(status) {
                    $.notify({
                        title: "<strong>Failed Reload Kegiatan</strong> ",
                        message: "Failed : " + status
                    }, {
                        type: 'danger',
                        delay: 3000,
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });
                }
            });
        }
        window.onload = getTurunan(<?php echo "$jenis"; ?>);


        function ExportRiwayat() {
            postData = $('#formTampil').serialize();
            var button;
            var textStatus;
            var download;

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/KegiatanController/ExportRiwayatKegiatan",
                type: "POST",
                data: postData,
                success: function(ajaxData) {
                    $.notify({
                        title: "<strong>Export Riwayat Kegiatan</strong> ",
                        message: "Success"
                    }, {
                        type: 'success',
                        delay: 3000,
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });

                    download = "<?php echo base_url(); ?>" + ajaxData;
                    window.location = download;
                },

                error: function(status) {
                    $.notify({
                        title: "<strong>Export Riwayat Kegiatan</strong> ",
                        message: "Failed : " + status
                    }, {
                        type: 'danger',
                        delay: 3000,
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });
                }
            });
        }
    </script>