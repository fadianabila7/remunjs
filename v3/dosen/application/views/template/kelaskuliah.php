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
                    <a href="<?php echo site_url('KegiatanController/KelasKuliah'); ?>">Kelas Kuliah</a>
                </li>
                <li class="active">
                    <strong>List Kelas Kuliah</strong>
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

                        <h5>Tabel Kelas Kuliah</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                            <div class="hr-line-dashed"></div>

                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-xs-3">
                                <select class="form-control" name="tahun" id="tahun">
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
                                        echo '
                                            <option value="1">Ganjil</option>
                                            <option selected value="2">Genap</option>
                                            <option value="9">Semester Pendek</option>
                                        ';
                                    } else if ($currentmonth >= 7 && $currentmonth <= 12) {
                                        echo '
                                            <option value="1" selected>Ganjil</option>
                                            <option value="2">Genap</option>
                                            <option value="9">Semester Pendek</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-4">
                                <button class='btn btn-info' type='button' id="filterTabel" name="filterTabel"><span class="fa fa-search"></span> Tampilkan</button>
                            </div>

                        </div>
                        <div class="table-responsive">

                            <table id="datatable" class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Kuliah</th>
                                        <th>Tahun</th>
                                        <th>Smstr</th>
                                        <th>SKS Tatap Muka</th>
                                        <th>Hari</th>
                                        <th>Waktu</th>
                                        <th>Ruang</th>
                                        <th>Jumlah Peserta</th>
                                        <th>Jumlah Tatap Muka</th>

                                    </tr>
                                </thead>
                                <tbody id="tabelBody">


                                </tbody>
                            </table>

                        </div>



                    </div>
                    <div class="ibox-footer" style="padding-left:82%;">



                    </div>
                </div>
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
                <!--------------------- End Modal View --------------- -->

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
                <!---------------------- End OF Delete Modal ------- -->
            </div>
        </div>
    </div>
</div>

<!--End of Page Content-->

<script type="text/javascript">
    var tabel_utama = $('#datatable').DataTable();
    $('#filterTabel').click(function() {
        var tahun = $('#tahun').val();
        var semester = $('#semester').val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/KegiatanController/getKelasKuliah",
            type: "GET",
            data: {
                tahun: tahun,
                semester: semester
            },
            success: function(ajaxData) {
                tabel_utama.clear().draw();
                var result = JSON.parse(ajaxData);
                var hari = {
                    0: "Belum di Entry",
                    1: "Minggu",
                    2: "Senin",
                    3: "Selasa",
                    4: "Rabu",
                    5: "Kami",
                    6: "Jum'at",
                    7: "Sabtu"
                };
                var semesterstring = {
                    1: "Ganjil",
                    2: "Genap",
                    9: "Semester Pendek"
                };
                for (var i = 0; i < result.length; i++) {
                    var button = "<button class='btn btn-info btn-detail' data-kkid='" + result[i]['id_kelaskuliah'] + "'>" + result[i]['jumlah'] + "</button>";
                    tabel_utama.row.add([
                        i + 1,
                        result[i]['namamatakuliah'],
                        result[i]['tahunakademik'],
                        semesterstring[result[i]['semester']],
                        "<center>" + result[i]['sks'] + "</center>",
                        hari[result[i]['hari']],
                        result[i]['waktu_mulai'].substring(0, 5),
                        result[i]['ruang'],
                        "<center>" + result[i]['peserta'] + "</center>",
                        "<center>" + button + "</center>",
                    ]).draw();
                }
            },
            error: function(status) {

            }
        });
    })
</script>


<script type="text/javascript">
    var tabel = $('#table-view').DataTable();
    $('#datatable').on('click', '.btn-detail', function() {
        var idkk = $(this).data('kkid');
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/KegiatanController/getDetailKelasKuliah",
            type: "GET",
            data: {
                idkk: idkk
            },
            success: function(ajaxData) {
                var result = JSON.parse(ajaxData);

                console.log(ajaxData);
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
                    var button = "<button class='btn btn-danger btn-delete' data-kid='" + result[i]['id_kegiatan_dosen'] + "'><span class='fa fa-trash'></span></button>";
                    tabel.row.add([
                        result[i]['operator'],
                        result[i]['tgl_entry'],
                        result[i]['tgl_kegiatan'],
                        result[i]['makul'],
                        hari[d.getDay()],
                        result[i]['waktu'].substring(0, 5),
                        result[i]['ruang'],

                    ]).draw();
                }
                $('#viewModal').modal('show');

            }
        });
    });

    $('#table-view').on('click', '.btn-delete', function() {
        var n = $(this).data('kid');
        $('#id_KegDosen').val(n);
        $('#viewModal').modal('hide');
        $('#hapusModal').modal('show');
    });

    $('#btn-hapus').on('click', function() {
        var hapusData = $('#formHapus').serialize();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Pengajaran/DeleteKegiatanDosenMengajar",
            type: "POST",
            data: hapusData,
            success: function(ajaxData) {
                swal({
                    title: 'Data Berhasil Dihapus!',
                    text: '',
                    type: 'success'
                });
            },
            error: function(status) {
                swal({
                    title: 'Data Gagal Dihapus!',
                    text: '',
                    type: 'danger'
                });
            }
        });
    });
</script>