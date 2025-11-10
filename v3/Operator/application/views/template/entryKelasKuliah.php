<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>List Kelas Kuliah</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url(); ?>">Home</a>
                </li>
                <li>
                    <a href="<?php echo site_url('pengajaran'); ?>">Pengajaran</a>
                </li>
                <li class="active">
                    <strong>List Kelas Kuliah</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <?php $namaJurusan = "";
                        foreach ($data['namaJurusan'] as $key) {
                            $namaJurusan = $key['nama'];
                        }
                        ?>
                        <h5>Tabel Mata Kuliah <?php echo $namaJurusan; ?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                            <div class="hr-line-dashed"></div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-xs-3">
                                <select class="form-control" name="tahunajaran" id="tahunajaran">
                                    <?php
                                    $loweryear = 2015;
                                    $currentyear = date('Y');

                                    for ($i = $currentyear; $i >= $loweryear; $i--) {
                                        echo "<option>" . $i . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-xs-3">
                                <select class="form-control" name="semester" id="semester">
                                    <?php
                                    $currentmonth = date('m');
                                    if ($currentmonth >= 1 && $currentmonth <= 6) {
                                        echo '<option value="1">Ganjil</option>
                                                <option selected value="2">Genap</option>>';
                                    } else if ($currentmonth >= 7 && $currentmonth <= 12) {
                                        echo '<option selected value="1">Ganjil</option>
                                                <option value="2">Genap</option>';
                                    }
                                    ?>
                                    <option value="9">Semester Pendek</option>
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-4 col-xs-4">
                                <button class='btn btn-info' type='button' id="filterTabel" onclick="filterTable();" name="filterTabel">Filter</button>
                                <button align="center" id="tambahMK" type="button" class="btn btn-success" onclick='location.href="<?php echo site_url('pengajaran/tambahkelaskuliah'); ?>"'>Tambah Kelas Kuliah</button>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen</th>
                                        <th>Tahun</th>
                                        <th>Smstr</th>
                                        <th>SKS Tatap Muka</th>
                                        <th>Hari</th>
                                        <th>Waktu</th>
                                        <th>Ruang</th>
                                        <th>Jumlah Peserta</th>
                                        <th>Jumlah Tatap Muka</th>
                                        <th align="center" class="center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelBody">

                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="ibox-footer" style="padding-left:82%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--End of Page Content-->
<div class="modal inmodal" id="viewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">Data Dosen Mengajar</h4>
                <small>View Data Dosen Mengajar</small>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="table-view" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Operator</th>
                                    <th>Tanggal Entry</th>
                                    <th>Tanggal Kegiatan</th>
                                    <th>Mata Kuliah</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>Ruang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="hapusModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-trash modal-icon"></i>
                <h4 class="modal-title">Hapus Data Kegiatan Dosen</h4>
                <small>Konfirmasi Hapus Data Kegiatan Mengajar Dosen</small>
            </div>
            <form role='form' id='formHapus' onsubmit="return false;">
                <div class="modal-body">

                    Apakah anda yakin ingin menghapus data ini ?
                    <input type='hidden' id='id_KegDosen' name='id_kegiatan_dosen'>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="submit" id='btn-hapus' data-dismiss="modal" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Entry Dosen Modal -->
<div class="modal inmodal" id="ModalEntryKegiatan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks fa-3x"></i>
                <h4 class="modal-title">Tambah Aktivitas Dosen</h4>
                <small>Tambah Aktivitas Dosen Mengajar</small>
                <h3 id="namaDosen"></h3>
                <h4 id="infoModal"></h4>
            </div>
            <form role='form' id="form-tambah" onsubmit="return false;">
                <input type="hidden" name="id_kkHidden" id="id_kkHidden">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input id="DeskripsiEntry" class="form-control" name="DeskripsiEntry" placeholder="Deskripsi" type="text">
                    </div>
                    <br>

                    <div class="form-group" id="data1">
                        <label>Tanggal</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input required type="text" id="Tanggal_Keg" placeholder="yyyy-mm-ddd" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="buttonSimpanEntry">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#datatable').DataTable({
        "language": {
            "emptyTable": "Checking to Database ..."
        }
    });
    filterTable();

    function filterTable() {
        $('#datatable').DataTable().clear().draw();
        tahunajaran = $('#tahunajaran').val();
        semester = $('#semester').val();
        post = $.post("get_Kelas_Kuliah_filter", {
            tahunajaran: tahunajaran,
            semester: semester,
        });
        post.done(function(data) {
            array = JSON.parse(data);
            $('#scripAlert').html('');
            var iter = 0;
            var semesterstring = {
                1: 'Ganjil',
                2: 'Genap',
                9: 'Semester Pendek'
            };
            var haristring = {
                1: "Minggu",
                2: "Senin",
                3: "Selasa",
                4: "Rabu",
                5: "Kamis",
                6: "Jum'at",
                7: "Sabtu"
            };
            if (array != null) {
                for (i = 0; i < array.dataKelasKuliah.length; i++) {

                    linkUbah = "<?php echo site_url('pengajaran/ubahkelaskuliah/'); ?>" + array.dataKelasKuliah[i].id_kelaskuliah;
                    linkHapus = "<?php echo site_url('pengajaran/do_deletekelaskuliah/'); ?>" + array.dataKelasKuliah[i].id_kelaskuliah;

                    if (array.dataAgregat[i].jumlah_pertemuan == '0') {
                        button = `
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action 
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="EntryKegiatan" data-idkk="` + array.dataAgregat[i].id_kelas_kuliah + `" data-kodekk="` + array.dataKelasKuliah[i].kode_kegiatan + `"> Update </a>
                                    </li>
                                    <li>
                                        <a href="` + linkUbah + `"> Ubah </a>
                                    </li>
                                    <li class="demo4">
                                        <a id="hapus" onclick="hapusData(` + array.dataAgregat[i].id_kelas_kuliah + `)">Hapus</a>
                                    </li>
                                </ul>
                            </div>`;
                    } else {
                        button = `
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action 
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="EntryKegiatan" data-idkk="` + array.dataAgregat[i].id_kelas_kuliah + `" data-kodekk="` + array.dataKelasKuliah[i].kode_kegiatan + `"> Update </a>
                                    </li>
                                    <li>
                                        <a href="` + linkUbah + `"> Ubah </a>
                                    </li>
                                </ul>
                            </div>
                        `;
                    }

                    $('#datatable').DataTable().row.add([
                        (i + 1),
                        array.dataKelasKuliah[i].namamatakuliah,
                        array.dataKelasKuliah[i].namadosen,
                        array.dataKelasKuliah[i].tahunakademik,
                        semesterstring[array.dataKelasKuliah[i].semester],
                        array.dataKelasKuliah[i].sks,
                        haristring[array.dataKelasKuliah[i].hari],
                        array.dataKelasKuliah[i].waktu_mulai.substring(0, 5),
                        array.dataKelasKuliah[i].ruang,
                        array.dataKelasKuliah[i].peserta,
                        "<button class='btn btn-info btn-detail' data-kkid = '" + array.dataAgregat[i].id_kelas_kuliah + "'><span>" + array.dataAgregat[i].jumlah_pertemuan + "</span></button>",
                        button
                    ]).draw();
                    iter++;
                }

            } else {
                msg = $("<td colspan='3' style='text-align: center;'> <h2>Data Kosong</h2> </td>");
                tr = $("<tr></tr>");
                tr.append(msg);
                $('#tabelBody').append(tr);
            }
        });
    }

    $('#data1 .input-group.date').datepicker({
        todayBtn: 'linked',
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    var linkInsertdata = "<?php echo site_url("pengajaran/NewInsertKegiatanDosenMengajar"); ?>";

    $('#buttonSimpanEntry').on('click', function() {
        $('#form-tambah').validate({
            submitHandler: function(form) {
                id_kk = $('#id_kkHidden').val();
                deskripsi = $('#DeskripsiEntry').val();
                tgl_kegiatan = $('#Tanggal_Keg').val();
                post = $.post(linkInsertdata, {
                    id_kk: id_kk,
                    tgl_kegiatan: tgl_kegiatan,
                    deskripsi: deskripsi,
                });

                post.done(function(data) {
                    if (data == '1') {
                        swal({
                            title: 'Data Berhasil Dimasukan!',
                            text: '',
                            type: 'success'
                        });
                    } else {
                        swal({
                            title: 'Data Gagal Dimasukan!',
                            text: '',
                            type: 'warning'
                        });
                    }

                    filterTable();
                });
            }
        });
    });

    var tabel1 = $('#datatable').DataTable();
    var idxtabel;
    $('#datatable tbody').on('click', 'tr', function() {
        idxtabel = tabel1.row(this).index();
    });
    $('#datatable tbody').on('click', '.EntryKegiatan', function() {
        var kkid = $(this).data('idkk');
        var kodekk = $(this).data('kodekk');

        if (kodekk == 0 || kodekk == "undefined") {
            swal({
                title: 'Peringatan!',
                text: 'Silahkan Pilih Kegiatan dimenu ubah kelas kuliah.',
            });
        } else {
            var rows = tabel1.row(idxtabel).data();
            $('#namaDosen').html(rows[2]);
            $('#infoModal').html(rows[1] + "(" + rows[6] + "," + rows[7] + "," + rows[8] + ")");
            $('#id_kkHidden').val(kkid);
            $('#ModalEntryKegiatan').modal('show');
        }
    });

    var tabel = $('#table-view').DataTable();
    $('#datatable').on('click', '.btn-detail', function() {
        var idkk = $(this).data('kkid');
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Pengajaran/ViewDosenMengajarByIDKelasKuliah",
            type: "GET",
            data: {
                idkk: idkk
            },
            success: function(ajaxData) {
                var result = JSON.parse(ajaxData);
                var hari = {
                    0: "Minggu",
                    1: "Senin",
                    2: "Selasa",
                    3: "Rabu",
                    4: "Kamis",
                    5: "Jum'at",
                    6: "Sabtu"
                };
                tabel.clear().draw();

                for (var i = 0; i < result.length; i++) {
                    var d = new Date(result[i]['tgl_kegiatan']);
                    var button = "<button class='btn btn-danger btn-delete' data-idkk='" + idkk + "' data-kid='" + result[i]['id_kegiatan_dosen'] + "'><span class='fa fa-trash'></span></button>";
                    tabel.row.add([
                        result[i]['operator'],
                        result[i]['tgl_entry'],
                        result[i]['tgl_kegiatan'],
                        result[i]['makul'],
                        hari[d.getDay()],
                        result[i]['waktu'],
                        result[i]['ruang'],
                        button,
                    ]).draw();
                }
                $('#viewModal').modal('show');
            }
        }); //tutup ajak
    });

    $('#table-view').on('click', '.btn-delete', function() {
        var n = $(this).data('kid');
        var idkk = $(this).data('idkk');
        swal({
                title: 'Hapus Data Ini?' + n + '-' + idkk,
                text: 'Data ini tidak bisa dikembalikan!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Tidak',
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    DeleteKegiatanDosen(n, idkk);
                } else {
                    swal('Dibatalkan', 'Tidak Terhapus', 'error');
                }
            });
    });

    function DeleteKegiatanDosen(hapusData, idkelask) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Pengajaran/DeleteKegiatanDosenMengajar",
            type: "POST",
            data: {
                id_kegiatan_dosen: hapusData
            },
            success: function(ajaxData) {

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Pengajaran/ViewDosenMengajarByIDKelasKuliah",
                    type: "GET",
                    data: {
                        idkk: idkelask
                    },
                    success: function(ajaxData) {
                        var result = JSON.parse(ajaxData);
                        var hari = {
                            0: "Minggu",
                            1: "Senin",
                            2: "Selasa",
                            3: "Rabu",
                            4: "Kamis",
                            5: "Jum'at",
                            6: "Sabtu"
                        };
                        tabel.clear().draw();

                        for (var i = 0; i < result.length; i++) {
                            var d = new Date(result[i]['tgl_kegiatan']);
                            var button = "<button class='btn btn-danger btn-delete' data-idkk ='" + idkelask + "' data-kid='" + result[i]['id_kegiatan_dosen'] + "'><span class='fa fa-trash'></span></button>";
                            tabel.row.add([
                                result[i]['operator'],
                                result[i]['tgl_entry'],
                                result[i]['tgl_kegiatan'],
                                result[i]['makul'],
                                hari[d.getDay()],
                                result[i]['waktu'],
                                result[i]['ruang'],
                                button,
                            ]).draw();
                        }
                    }
                }); //tutup ajak
            },
            error: function(status) {

            }
        });
    }
    $('#btn-hapus').on('click', function() {

    });

    function hapusData(dataid) {
        swal({
            title: 'Hapus Data Ini?',
            text: 'Data ini tidak bisa dikembalikan!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Tidak',
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm) {
            if (isConfirm) {
                swal('Terhapus!', 'Data Berhasil Dihapus!', 'success');
                window.location.href = '<?php echo site_url('pengajaran/do_deletekelaskuliah/'); ?>' + dataid;
            } else {
                swal('Dibatalkan', 'Tidak Terhapus', 'error');
            }
        });
    }
</script>