        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Daftar Dosen</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url(); ?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Daftar Dosen</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2"> </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Daftar Dosen</h5>
                                <div class="ibox-tools">
                                    <div class="hr-line-dashed"></div>
                                    <form id="formTampil" onsubmit="return false;">
                                        <div class="form-group" id="data_4">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <select class="form-control m-b" name="fakultas">
                                                        <option value='0'>Semua Fakultas</option>
                                                        <option value='blh'>Belum Ada Fakultas</option>
                                                        <?php
                                                        foreach ($fakultas as $d) {
                                                            echo "<option value='" . $d['id_fakultas'] . "''>" . $d['nama'] . " (" . $d['singkatan'] . ")</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control m-b" name="status">
                                                        <option value='0'>Semua Status Dosen</option>
                                                        <?php
                                                        foreach ($status as $s) {
                                                            echo "<option value='" . $s['id_status_dosen'] . "'>" . $s['deskripsi'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-info btnsubmit" onclick="getDosen();" id="btn-submit">
                                                        <span class="fa fa-search"></span> Tampilkan
                                                    </button>
                                                    <button class="btn btn-info" id="btn-export" onclick="ExportDataDosen();">
                                                        <span class="fa fa-file-excel-o"></span> Export
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table id='datatable' class="table table-striped table-bordered table-hover display dataTables-example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th>NIP/NIPUS</th>
                                            <th>Nama Dosen</th>
                                            <th>Email</th>
                                            <th>Program Studi</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!------------------------------------------ edit modal ------------------------------------>
            <div class="modal inmodal" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-tasks modal-icon"></i>
                            <h4 class="modal-title">Edit Data Dosen</h4>
                            <small>Edit Data Individu Dosen</small>
                        </div>
                        <form role='form' id='formEdit' onsubmit="return false;">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label class='control-label' for='nip'>NIP</label>
                                    <input id='nip-edit' type="number" min="1000000" class='form-control' name="nip" readonly>
                                    <input type="hidden" name="keyedit" id="keyedit">
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='nama'>Nama</label>
                                    <input id='nama-edit' class='form-control' name="nama" type="text">
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='id_bank'>Bank</label>
                                    <select class="form-control" id="id_bank" name="id_bank" required>
                                        <?php
                                        foreach ($bank as $d) {
                                            echo "<option value='" . $d['id_bank'] . "''>" . $d['nama'] . " (" . $d['singkatan'] . ")</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='norek'>No Rekening</label>
                                    <input id='norek-edit' class='form-control' name="norek">
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='prodi'>Program Studi</label>
                                    <select class="form-control" id='prodi-edit' name='prodi'>
                                        <?php
                                        foreach ($prodi as $d) {
                                            echo "<option value='" . $d['id_program_studi'] . "'>" . $d['nama'] . " (" . $d['singkatan'] . ")</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='status'>Status</label>
                                    <select class="form-control" id='status-edit' name='status'>
                                        <?php
                                        foreach ($status as $s) {
                                            echo "<option value='" . $s['id_status_dosen'] . "'>" . $s['deskripsi'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class='form-group col-xs-6'>
                                        <label class='control-label' for='notelepon'>No Telepon</label>
                                        <input id='notelepon-edit' class='form-control' name="notelepon">
                                    </div>

                                    <div class='form-group col-xs-6'>
                                        <label class='control-label' for='email'>Email</label>
                                        <input id='email-edit' class='form-control' name="email" type="email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='norek'>NPWP</label>
                                    <input id='npwp-edit' class='form-control' name="npwp">
                                </div>
                                <div class="form-group">
                                    <label class='control-label' for='foto'>Foto URL</label>
                                    <input id='foto-edit' type="url" class='form-control' name="foto">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button type="submit" id='btn-update' data-dismiss="modal" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--------------------------------------- Modal Confirm Hapus ------------------------------>
            <div class="modal inmodal" id="hapusModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-trash modal-icon"></i>
                            <h4 class="modal-title">Hapus Data Dosen</h4>
                            <small>Konfirmasi Hapus Data Individu Dosen</small>
                        </div>
                        <form role='form' id='formHapus' onsubmit="return false;">
                            <div class="modal-body">
                                Apakah anda yakin ingin menghapus data ini ?
                                <input type='hidden' id='idDosen' name='idDosen'>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                <button type="submit" id='btn-delete' data-dismiss="modal" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--------------------- Modal Confirm Keluarkan Dosen Dari HomeBase ------------------------>
            <div class="modal inmodal" id="ubahHomeBaseModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-trash modal-icon"></i>
                            <h4 class="modal-title">Keluarkan Dosen Dari Homebase Fakultas</h4>
                            <small>Konfirmasi Untuk Mengeluarkan Dosen Dari Homebase Fakultas</small>


                        </div>
                        <form role='form' id='formKeluarHomebase' onsubmit="return false;">
                            <div class="modal-body">

                                Apakah anda yakin ingin mengeluarkan data ini ?
                                <input type='hidden' id='idDosenKeluar' name='idDosenKeluar'>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                <button type="submit" id='btn-keluarhomebase' data-dismiss="modal" class="btn btn-danger">Proses</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!---------------------------- Modal Confirm Reset Password ----------------------------- -->
            <div class="modal inmodal" id="resetModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-user modal-icon"></i>
                            <h4 class="modal-title">Reset Password Dosen</h4>
                            <small>Konfirmasi Reset Password Individu Dosen</small>


                        </div>
                        <form role='form' id='formReset' onsubmit="return false;">
                            <div class="modal-body">

                                Password Dosen akan direset ke default : 123456.
                                <br>Apakah anda yakin ?
                                <input type='hidden' id='idDosenReset' name='idDosenReset'>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                <button type="submit" id='btn-reset' data-dismiss="modal" class="btn btn-success">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--End of Page Content-->

            <script type="application/javascript">
                var postData = $('#formTampil').serialize();
                const t = $("#datatable").DataTable({
                    pageLength: 50
                });

                function getDosen() {
                    postData = $('#formTampil').serialize();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Dosen/getDataDosen",
                        type: "GET",
                        data: postData,
                        success: function(ajaxData) {
                            t.clear().draw();
                            var result = JSON.parse(ajaxData);
                            for (var i = 0; i < result.length; i++) {
                                var button1 = "<a href='#' class='btn-edit' data-did='" + result[i]['id_dosen'] + "' title='Edit'><span class='fa fa-edit fa-2x'></span></a>";
                                var button2 = "<a href='#' class='btn-hapus' data-did='" + result[i]['id_dosen'] + "' title='Hapus'><span class='fa fa-trash fa-2x'></span></a>";
                                var button3 = "<a href='#' class='btn-reset-pass' data-did='" + result[i]['id_dosen'] + "' title='Reset Password'><span class='fa fa-user fa-2x'></span></a>";
                                var button4 = "<a href='#' class='btn-ubahhomebase' data-did='" + result[i]['id_dosen'] + "' title='Ganti Homebase Dosen'><span class='fa fa-code-fork fa-2x'></span></a>";
                                t.row.add([
                                    i + 1,
                                    result[i]['nip'],
                                    result[i]['nama'],
                                    result[i]['email'],
                                    result[i]['namaprodi'],
                                    result[i]['deskripsi'],
                                    button1 + "  " + button2 + " " + button3 + " " + button4,
                                ]).draw();
                            }
                        },
                        error: function(status) {
                            t.clear().draw();
                        }
                    });
                }

                $('#datatable').on('click', '.btn-edit', function() {
                    var n = $(this).data('did');
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Dosen/getDataDosenIndividu",
                        type: "GET",
                        data: {
                            nip: n
                        },
                        success: function(ajaxData) {
                            var result = JSON.parse(ajaxData);
                            $("#nip-edit").val(result[0]['nip']);
                            $("#keyedit").val(result[0]['id_dosen']);
                            $("#nama-edit").val(result[0]['nama']);
                            $("#id_bank").val(result[0]['id_bank']);
                            $("#norek-edit").val(result[0]['no_rekening']);
                            $("#notelepon-edit").val(result[0]['telepon']);
                            $("#email-edit").val(result[0]['email']);
                            $("#foto-edit").val(result[0]['foto']);
                            $("#npwp-edit").val(result[0]['npwp']);

                            $("#prodi-edit").val(result[0]['id_program_studi']);
                            $("#status-edit").val(result[0]['id_status_dosen']);

                            $('#editModal').modal('show');
                        }
                    });
                });

                $('#btn-update').click(function() {
                    $('#editModal').modal('hide');
                    var updateData = $("#formEdit").serialize();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Dosen/updateDataDosenIndividu",
                        type: "POST",
                        data: updateData,
                        success: function(data, status, xhr) {
                            getDosen();
                            $.notify({
                                title: "<strong>Update Data Dosen </strong> ",
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
                        error: function(jqXHR, status, errorThrown) {
                            $.notify({
                                title: "<strong>Tambah Stock: </strong> ",
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
                    });
                });

                $('#datatable').on('click', '.btn-hapus', function() {
                    var n = $(this).data('did');
                    $('#idDosen').val(n);
                    $('#hapusModal').modal('show');
                });

                $('#datatable').on('click', '.btn-ubahhomebase', function() {
                    var n = $(this).data('did');
                    $('#idDosenKeluar').val(n);
                    $('#ubahHomeBaseModal').modal('show');
                });

                $("#btn-delete").click(function() {
                    var deleteData = $('#formHapus').serialize();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Dosen/deleteDataDosenIndividu",
                        type: "POST",
                        data: deleteData,
                        success: function(data, status, xhr) {
                            getDosen();
                            $.notify({
                                title: "<strong>Hapus Data Dosen: </strong> ",
                                message: data
                            }, {
                                type: 'success',
                                delay: 3000,
                                placement: {
                                    from: "top",
                                    align: "center"
                                }
                            });
                        },
                        error: function(jqXHR, status, errorThrown) {
                            $.notify({
                                title: "<strong>Hapus Data Dosen: </strong> ",
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
                    });
                });

                $("#btn-keluarhomebase").click(function() {
                    var keluarData = $('#formKeluarHomebase').serialize();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Dosen/keluarHomeBaseDosenIndividu",
                        type: "POST",
                        data: keluarData,
                        success: function(data, status, xhr) {
                            getDosen();
                            $.notify({
                                title: "<strong>Dosen Keluar Dari Homebase : </strong> ",
                                message: data
                            }, {
                                type: 'success',
                                delay: 3000,
                                placement: {
                                    from: "top",
                                    align: "center"
                                }
                            });
                        },
                        error: function(jqXHR, status, errorThrown) {
                            $.notify({
                                title: "<strong>Dosen Keluar Dari Homebase : </strong> ",
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
                    });
                });

                $('#datatable').on('click', '.btn-reset-pass', function() {
                    var n = $(this).data('did');
                    $('#idDosenReset').val(n);
                    $('#resetModal').modal('show');
                });

                $("#btn-reset").click(function() {
                    var resetData = $('#formReset').serialize();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Dosen/resetPassDosen",
                        type: "POST",
                        data: resetData,
                        success: function(data, status, xhr) {
                            $.notify({
                                title: "<strong>Reset Password Dosen: </strong> ",
                                message: data
                            }, {
                                type: 'success',
                                delay: 3000,
                                placement: {
                                    from: "top",
                                    align: "center"
                                }
                            });
                        },
                        error: function(jqXHR, status, errorThrown) {
                            $.notify({
                                title: "<strong>Reset Password Dosen: </strong> ",
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
                    });
                });

                function ExportDataDosen() {
                    postData = $('#formTampil').serialize();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Dosen/ExportDataDosen",
                        type: "GET",
                        data: postData,
                        success: function(ajaxData) {
                            $.notify({
                                title: "<strong>Export Data Dosen</strong> ",
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
                                title: "<strong>Export Data Dosen</strong> ",
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
                    });
                }
            </script>