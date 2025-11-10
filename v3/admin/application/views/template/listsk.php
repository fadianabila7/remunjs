<link href="<?php echo base_url('assets'); ?>/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">
<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>List Surat Keputusan</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url(); ?>">Home</a>
                </li>
                <li class="active">
                    <strong>List Surat Keputusan</strong>
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
                        <h5>List Surat Keputusan</h5>
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
                        <div class="form-group" id="data_4">
                            <div class="row">
                                <form id="formTampil" onsubmit="return false;">
                                    <div class="col-md-2">
                                        <select class="form-control m-b" name="bulan" required="required">
                                            <option value="0">Semua Bulan</option>
                                            <option value='1'>Januari</option>
                                            <option value='2'>Februari</option>
                                            <option value='3'>Maret</option>
                                            <option value='4'>April</option>
                                            <option value='5'>Mei</option>
                                            <option value='6'>Juni</option>
                                            <option value='7'>Juli</option>
                                            <option value='8'>Agustus</option>
                                            <option value='9'>September</option>
                                            <option value='10'>Oktober</option>
                                            <option value='11'>November</option>
                                            <option value='12'>Desember</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control m-b" name="tahun" required="required">
                                            <?php
                                            $lowerDate = 2016;
                                            $currentDate = date('Y');
                                            $previousDate = $currentDate - 1;

                                            for ($i = $currentDate; $i > $lowerDate; $i--) {
                                                echo ($i == $currentDate) ? "<option selected>" . $i . "</option>" : "<option>" . $i . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="ladda-button btn btn-info btnsubmit" onclick="getDataSKBulanTahun();" id="btn-submit"><span class="fa fa-search"></span> Tampilkan</button>
                                        <button class="btn btn-info"><span class="fa fa-file-excel-o"></span>Export</button>
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
                                        <th style="width: 5%">No</th>
                                        <th style="width: 20%">No SK Kontrak</th>
                                        <th style="width: 10%">Tgl. SK</th>
                                        <th>Judul Kegiatan</th>
                                        <th style="width: 12%">Action</th>
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
        <!---------------------- View Modal -------------------------------------- -->
        <div class="modal inmodal" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width: 900px">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-tasks modal-icon"></i>
                        <h4 class="modal-title">Detail Surat Keputusan</h4>
                        <small>Detail Surat Keputusan dan Penerima Surat Keputusan</small>
                    </div>
                    <form role='form' class="form-horizontal" id='formEdit' onsubmit="return false;">
                        <div class="modal-body">
                            <h3>Detail Surat Keputusan</h3>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label for="no_sk" class="col-md-3 control-label">No Surat Keputusan</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="no_sk_modal" type="text" name="no_sk" required>
                                </div>
                            </div>
                            <div class="form-group" id="tmtdate">
                                <label class="control-label col-md-3">Tanggal SK *</label>
                                <div class="input-group date col-md-6">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="tgl_sk_modal" name="tgl_sk" placeholder="Tanggal SK" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="judul_keg" class="col-md-3 control-label">Judul Kegiatan</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="judul_keg_modal" type="text" name="judul_keg" required>
                                </div>
                            </div>

                            <div class="form-group" id="tmtdate2">
                                <label class="control-label col-md-3">Tanggal Kegiatan *</label>
                                <div class="input-group date col-md-6">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="tgl_keg_modal" name="tgl_keg" placeholder="Tanggal Kegiatan" required>
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
                                                <th>Action</th>
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
                            <button type="submit" id='btn-update' onclick="updateSK();" class="btn btn-primary" disabled>Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-------------------------------------------------------- Delete Modal ------------------------- -->

        <div class="modal inmodal" id="hapusModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-trash modal-icon"></i>
                        <h4 class="modal-title">Hapus Data Surat Keputusan</h4>
                        <small>Konfirmasi Hapus Data Surat Keputusan</small>
                    </div>
                    <form role='form' id='formHapus' onsubmit="return false;">
                        <div class="modal-body">
                            Apakah anda yakin ingin menghapus data ini ?
                            <input type='hidden' id='id_kegiatan_dosen' name='id_kegiatan_dosen'>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                            <button type="submit" id='btn-delete' data-dismiss="modal" onclick="deleteSK();" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!------------------------------------------------ Upload Berkas Modal ------------------------ -->
        <div class="modal inmodal" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-trash modal-icon"></i>
                        <h4 class="modal-title">Upload Berkas</h4>
                        <small>Upload Berkas Surat Keputusan</small>
                    </div>
                    <form role='form' class="form-horizontal" id='formUpload' method='POST' enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="berkas_old" class="col-md-3 control-label">Berkas Surat Keputusan</label>
                                <div class="col-md-6">
                                    <div class="input-group"><input type="text" id="berkas_old" name="berkas_old" class="form-control"> <span class="input-group-btn"> <a href="#" target="_blank" id="btn-download-berkas" type="button" class="btn btn-primary"><span class="fa fa-download"></span>
                                            </a> </span></div>

                                </div>
                            </div>
                            <input type="hidden" name="no_sk" id="no_sk_modal_upload">
                            <div class="form-group">
                                <label for="berkas_sk" class="col-md-3 control-label">Upload Berkas</label>
                                <div class="col-md-6">
                                    <input type="file" class="filestyle" data-buttonName="btn-info" id="berkas_sk" accept=".pdf" name="berkas_sk" required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                            <button type="submit" id='btn-upload' value="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End of Page Content-->
    <script src="<?php echo base_url('assets'); ?>/js/plugins/ladda/spin.min.js"></script>
    <script src="<?php echo base_url('assets'); ?>/js/plugins/ladda/ladda.min.js"></script>
    <script src="<?php echo base_url('assets'); ?>/js/plugins/ladda/ladda.jquery.min.js"></script>
    <script>
        var tabel = $("#datatable").DataTable();
        var tabelModal = $("#datatable-modal").DataTable();

        var postData = $('#formTampil').serialize();

        function convertMonth(data) {
            switch (data) {
                case 0:
                    return null;
                    break;
                case 1:
                    return "Januari";
                    break;
                case 2:
                    return "Februari";
                    break;
                case 3:
                    return "Maret";
                    break;
                case 4:
                    return "April";
                    break;
                case 5:
                    return "Mei";
                    break;
                case 6:
                    return "Juni";
                    break;
                case 7:
                    return "Juli";
                    break;
                case 8:
                    return "Agustus";
                    break;
                case 9:
                    return "September";
                    break;
                case 10:
                    return "Oktober";
                    break;
                case 11:
                    return "November";
                    break;
                case 12:
                    return "Desember";
                    break;
            }
        }

        function getDataSKBulanTahun() {
            $('#formTampil').validate({

                submitHandler: function(form) {
                    postData = $(form).serialize();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Penunjang/getDataSKBulanTahun",
                        type: "GET",
                        data: postData,
                        success: function(ajaxData) {
                            tabel.clear().draw();
                            var buttondetail = '';
                            var buttondelete = '';
                            var result = JSON.parse(ajaxData);

                            for (var i = 0; i < result.length; i++) {
                                var no_sk = "'" + result[i]['no_sk'] + "#" + result[i]['tgl_entry'] + "'";
                                buttondetail = '<button class="btn btn-info" onclick="detailSK(' + no_sk + ');"><span class="fa fa-eye"></span></button>';
                                //buttondelete = '<button class="btn btn-danger btn-delete" data-nosk = "'+result[i]['no_sk']+'"><span class="fa fa-trash"></span></button>';
                                buttondelete = '<button class="btn btn-danger btn-delete" data-nosk = "' + result[i]['no_sk'] + '#' + result[i]['tgl_sk'] + '#' + result[i]['tgl_entry'] + '"><span class="fa fa-trash"></span></button>';
                                buttonupload = '<button class="btn btn-info btn-upload" data-nosk = "' + result[i]['no_sk'] + '" title="Upload Berkas SK" disabled><span class="fa fa-file-pdf-o"></span></button>'
                                tabel.row.add([
                                    i + 1,
                                    result[i]['no_sk'],
                                    result[i]['tgl_sk'],
                                    //result[i]['nama_dosen']+"<br><b>"+result[i]['nip']+"</b>",
                                    result[i]['judul_keg'] + "<br><b>Jml. Kegiatan : " + result[i]['jml'] + " " + result[i]['satuan'] + "</b>",
                                    buttondetail + " " + buttonupload + " " + buttondelete
                                ]).draw();
                            }

                        },
                        error: function(status) {
                            tabel.clear().draw();
                        }
                    });
                }

            });
        }

        function detailSK(noSK) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Penunjang/getDataKegiatanByNoSK",
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

                    $('#no_sk_modal').val(result[0]['no_sk']);
                    $('#tgl_sk_modal').val(result[0]['tgl_sk']);
                    $('#judul_keg_modal').val(result[0]['judul_keg']);
                    $('#tgl_keg_modal').val(result[0]['tgl_keg']);

                    for (var i = 0; i < result.length; i++) {
                        buttondetail = '<button class="btn btn-danger btn-delete-modal" disabled><span class="fa fa-trash"></span></button>';
                        kode = "<a href='#' data-toggle='tooltip' data-placement='bottom' title='" + result[i]['nama_keg'] + "'>" + result[i]['nama_keg'] + " :: " + result[i]['kode_keg'] + "</a>";
                        inputNip = '<input type="hidden" id="nip' + i + '" name = "nip[]" value="' + result[i]['nip'] + '">';

                        tabelModal.row.add([
                            i + 1,
                            result[i]['nama_dosen'],
                            result[i]['nip'] + inputNip,
                            kode,
                            buttondetail
                        ]).draw();
                    }

                    $('#editModal').modal('show');
                    $('#editModal').on('shown.bs.modal', function() {
                        tabelModal.columns.adjust().responsive.recalc();
                    });
                },
                error: function(status) {
                    tabelModal.clear().draw();
                }
            });
        }

        $('#datatable').on('click', '.btn-delete', function() {
            var n = $(this).data('nosk');
            $('#id_kegiatan_dosen').val(n);
            $('#hapusModal').modal('show');
        });

        $('#datatable-modal').on('click', '.btn-delete-modal', function() {
            tabelModal
                .row($(this).parents('tr'))
                .remove()
                .draw();
        });

        $('#datatable').on('click', '.btn-upload', function() {
            var noSK = $(this).data('nosk');
            $('#no_sk_modal_upload').val(null);
            $('#berkas_old').val(null);
            $('#btn-download-berkas').attr("href", null);
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Penunjang/getBerkasSK",
                type: "GET",
                data: {
                    no_sk: noSK
                },
                success: function(ajaxData) {
                    $('#formUpload').attr('action', '<?php echo base_url(); ?>index.php/Penunjang/uploadBerkasSK');
                    $('#no_sk_modal_upload').val(noSK);
                    var result = JSON.parse(ajaxData);
                    $('#berkas_old').val(result['filename']);
                    $('#btn-download-berkas').attr("href", result['path_berkas']);
                    if (result['path_berkas'] != '#') {
                        $('#btn-download-berkas').removeAttr("disabled");
                    } else {
                        $('#btn-download-berkas').attr("disabled", "disabled");
                    }
                    $('#uploadModal').modal('show');
                },
                error: function(status) {

                }
            });
        });


        function updateSK() {
            $('#formEdit').validate({
                submitHandler: function(form) {
                    postData = $(form).serialize();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Penunjang/updateDataSK",
                        type: "POST",
                        data: postData,
                        success: function(ajaxData) {
                            $('#editModal').modal('hide');
                            $.notify({
                                title: "<strong>Update Data Surat Keputusan</strong> ",
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
                            $('#editModal').modal('hide');
                            $.notify({
                                title: "<strong>Update Data Surat Keputusan</strong> ",
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
            });
        }

        function deleteSK() {
            var deleteData = $('#formHapus').serialize();
            $.ajax({

                url: "<?php echo base_url(); ?>index.php/Penunjang/deleteDataSK",
                type: "POST",
                data: deleteData,
                success: function(ajaxData) {
                    $.notify({
                        title: "<strong>Delete Data Surat Keputusan</strong> ",
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
                        title: "<strong>Delete Data Surat Keputusan</strong> ",
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
        }


        function uploadBerkas() {
            console.log('masuk');
            $('#formUpload').validate({
                submitHandler: function(form) {
                    console.log('masuk upload');
                    $(form).ajaxForm({

                        beforeSubmit: function() {
                            console.log('belum');
                            $.notify({
                                title: "<strong>Uploading . . . .</strong> " + ajaxData,
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
                        success: function(data) {
                            $('#uploadModal').modal('hide');
                            $.notify({
                                title: "<strong>Upload Success</strong> " + ajaxData,
                                message: "Success"
                            }, {
                                type: 'success',
                                delay: 3000,
                                placement: {
                                    from: "top",
                                    align: "center"
                                }
                            });
                        }
                    });
                }
            });
        }
    </script>