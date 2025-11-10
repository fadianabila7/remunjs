    <!--Start Page Content-->
    <div id="page-content">
        <div class="row wrapper border-bottom white-bg dashboard-header">
            <div class="col-lg-10">
                <h2>Rekapitulasi Kegiatan Dosen Individu</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo site_url(); ?>">Home</a>
                    </li>
                    <li class="active">
                        <strong>Rekapitulasi Kegiatan</strong>
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
                            <h5>Rekap Remunisasi Dosen</h5>

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

                                <form id="formTampil" onsubmit="return false;">
                                    <div class="form-group" id="data_4">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select class="form-control m-b" id="bulan" name="bulan" required="required">
                                                    <option value="">Pilih Bulan</option>
                                                    <option value='1' selected>Januari</option>
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
                                                <select class="form-control m-b" id="tahun" name="tahun" required="required">
                                                    <?php
                                                    $currentDate = date('Y');
                                                    $lowerDate = 2017;
                                                    for ($i = $currentDate; $i >= $lowerDate; $i--) {
                                                        echo "<option>" . $i . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <select class="form-control m-b" id="status_dosen" name="status_dosen" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="1" selected>PNS</option>
                                                    <option value="2">NON PNS</option>
                                                    <option value="7">PPPK</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-info btnsubmit" onclick="getRekapRemunDosen();" id="btn-submit"><span class="fa fa-search"></span> Tampilkan</button>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <form id="validasiForm" onsubmit="return false;">
                                        <table id='datatable' class="table table-striped table-bordered table-hover display dataTables-example" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">
                                                        <input type="checkbox" id="checkbox-parent" checked value="">
                                                    </th>
                                                    <th rowspan="2">No</th>
                                                    <th rowspan="2">Nama Dosen</th>
                                                    <th rowspan="2">NIP</th>
                                                    <th rowspan="1" colspan="5" class="text-center" width="5%">Kegiatan Dosen</th>
                                                    <th rowspan="2">Total SKS</th>
                                                    <th rowspan="2" width="5%">Status</th>
                                                    <th rowspan="2" width="5%">Action</th>
                                                </tr>
                                                <tr>
                                                    <th>Pengajaran</th>
                                                    <th>Penelitian
                                                        <br>Pengabdian
                                                    </th>
                                                    <th>Penunjang</th>
                                                    <th>Non Struktural</th>
                                                    <th>Struktural</th>
                                                </tr>
                                            </thead>

                                            <tbody id="table-body">

                                            </tbody>
                                        </table>
                                        <div>
                                            <button type="submit" class="btn btn-primary" onclick="Validasi();">Validasi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!----------------------------------------- Modal Confirm Hapus ------------------------>
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

            <!-------------------------------------------------------- Modal Detail Kegiatan Pengajaran ---------------------- -->
            <div class="modal inmodal" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-tasks modal-icon"></i>
                            <h4 class="modal-title">Data Kegiatan Dosen</h4>
                            <small>Detail Data Kegiatan Individu Dosen</small>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label">Catatan</label>
                                        <div>
                                            <textarea class="form-control" id='note-tampil' style="resize: none;" rows="3" placeholder="Catatan"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tabs-container">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#tab-1">Pengajaran</a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-2">Penelitian & Pengabdian</a></li>
                                                <!-- <li class=""><a data-toggle="tab" href="#tab-3">Pengabdian</a></li> -->
                                                <li class=""><a data-toggle="tab" href="#tab-4">Penunjang</a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-5">Non Struktural</a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div id="tab-1" class="tab-pane active">
                                                    <div class="panel-body">
                                                        <h3>Data Kegiatan Pengajaran</h3>
                                                        <div class="hr-line-dashed"></div>
                                                        <div class="table-responsive">
                                                            <table id='datatable-modal1' class="table table-striped table-bordered table-hover responsive display dataTables-example" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nomor SK Kontrak</th>
                                                                        <th>Nama Kegiatan</th>
                                                                        <th>Tanggal Kegiatan</th>
                                                                        <th>Judul Kegiatan</th>
                                                                        <th width="5%">SKSR</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                                <tfoot>

                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="tab-2" class="tab-pane">
                                                    <div class="panel-body">
                                                        <h3>Data Kegiatan Penelitian</h3>
                                                        <div class="hr-line-dashed"></div>
                                                        <div class="table-responsive">
                                                            <table id='datatable-modal2' class="table table-striped table-bordered table-hover responsive display dataTables-example" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nomor SK Kontrak</th>
                                                                        <th>Nama Kegiatan</th>
                                                                        <th>Tanggal Kegiatan</th>
                                                                        <th>Judul Kegiatan</th>
                                                                        <th width="5%">SKSR</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="tab-3" class="tab-pane">
                                                    <div class="panel-body">
                                                        <h3>Data Kegiatan Pengabdian</h3>
                                                        <div class="hr-line-dashed"></div>
                                                        <div class="table-responsive">
                                                            <table id='datatable-modal3' class="table table-striped table-bordered table-hover responsive display dataTables-example" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nomor SK Kontrak</th>
                                                                        <th>Nama Kegiatan</th>
                                                                        <th>Tanggal Kegiatan</th>
                                                                        <th>Judul Kegiatan</th>
                                                                        <th width="5%">SKSR</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="tab-4" class="tab-pane">
                                                    <div class="panel-body">
                                                        <h3>Data Kegiatan Penunjang</h3>
                                                        <div class="hr-line-dashed"></div>
                                                        <div class="table-responsive">
                                                            <table id='datatable-modal4' class="table table-striped table-bordered table-hover responsive display dataTables-example" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nomor SK Kontrak</th>
                                                                        <th>Nama Kegiatan</th>
                                                                        <th>Tanggal Kegiatan</th>
                                                                        <th>Judul Kegiatan</th>
                                                                        <th width="5%">SKSR</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="tab-5" class="tab-pane">
                                                    <div class="panel-body">
                                                        <h3>Non Struktural</h3>
                                                        <div class="hr-line-dashed"></div>
                                                        <div class="table-responsive">
                                                            <table id='datatable-modal5' class="table table-striped table-bordered table-hover responsive display dataTables-example" width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nomor SK Kontrak</th>
                                                                        <th>Nama Kegiatan</th>
                                                                        <th>Tanggal Kegiatan</th>
                                                                        <th>Judul Kegiatan</th>
                                                                        <th width="5%">SKSR</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <!--  <button type="submit" id='btn-update' data-dismiss="modal" class="btn btn-primary">Save changes</button> -->
                        </div>

                    </div>
                </div>
            </div>

            <!----------------------------------------- Modal Confirm Notes ------------------------>
            <div class="modal inmodal" id="notesModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-edit modal-icon"></i>
                            <h4 class="modal-title">Submit Catatan</h4>
                            <small>Submit Catatan Kegiatan Dosen</small>
                        </div>

                        <form role='form' id='formNote' onsubmit="return false;">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label">Catatan</label>
                                    <div>
                                        <textarea style="resize: vertical;" class="form-control" rows='5' id="note" name="note" placeholder="catatan"></textarea>
                                        <input type="hidden" id="id_dosen" name="id_dosen">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                <button type="submit" id='btn-note' class="btn btn-primary">Submit Catatan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Page Content-->
    <script>
        var tabelModal1 = $('#datatable-modal1').DataTable();
        var tabelModal2 = $('#datatable-modal2').DataTable();
        var tabelModal3 = $('#datatable-modal3').DataTable();
        var tabelModal4 = $('#datatable-modal4').DataTable();
        var tabelModal5 = $('#datatable-modal5').DataTable();


        var datajsondosen;
        var n = 0;

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Dosen/getDataDosenByFakultas",
            type: "POST",
            data: {
                nip: n
            },
            success: function(ajaxData) {
                datajsondosen = JSON.parse(ajaxData);
            },
            error: function(status) {

            }
        });

        $('#namadosen').autoComplete({
            minChars: 1,
            source: function(term, suggest) {
                term = term.toLowerCase();
                var choices = [];
                for (i = 0; i < datajsondosen.length; i++) {
                    choices.push(datajsondosen[i].nama);

                }
                var suggestions = [];
                for (i = 0; i < choices.length; i++)
                    if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                console.log(suggestions);
                suggest(suggestions);
            },
            onSelect: function(event, ui) {
                var id = "";
                for (k = 0; k < datajsondosen.length; k++)
                    if (datajsondosen[k].nama == ui) id = datajsondosen[k].id_dosen;
                $('#nip').val(id);
            }
        });
    </script>


    <script>
        var postData = $('#formTampil').serialize();
        var t = $('#datatable').DataTable({
            "paging": false,
            "columns": [{
                "orderable": false
            }, null, null, null, null, null, null, null, null, null, null, {
                "orderable": false
            }],
        });

        function loadJSAll() {
            $('#checkbox-parent').change(function() {
                var cells = t.cells().nodes();
                $(cells).find(':checkbox').prop('checked', $(this).is(':checked'));
            });

            $('.checkbox-child').change(function() {
                $('#checkbox-parent').prop('checked', false);
                if ($(this).prop('checked') == false) {
                    $('#id_dosen').val($(this).val());
                    console.log($(this).val());
                    $('#notesModal').modal('show');
                }
            });
        }

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

        function getRekapRemunDosen() {
            $('#formTampil').validate({
                //var postData = $('#demo-form2').serialize();
                submitHandler: function(form) {
                    postData = $(form).serialize();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/WDController/getDataRekapKegiatanBulanTahunStatus",
                        type: "GET",
                        data: postData,

                        success: function(ajaxData) {
                            t.clear().draw();
                            var result = JSON.parse(ajaxData);
                            var buttondetail = '';
                            var status = '';
                            var checkbox = "";
                            for (var i = 0; i < result.length; i++) {
                                checkbox = '<input type="checkbox" class="checkbox-child" checked name = "nip[]" value="' + result[i]['nip'] + '">';
                                buttondetail = '<button class="btn btn-primary btn-detail" data-did="' + result[i]['nip'] + '"><span class="fa fa-eye"></span></button>';
                                if (result[i]['status'] == 2) {
                                    status = "Kegiatan Valid";
                                    if (result[i]['catatan_extend'] != "") {
                                        status += ". Mohon tinjau ulang kegiatan";
                                    }
                                } else if (result[i]['status'] == 1) {
                                    status = "Kegiatan Tidak Valid";
                                    if (result[i]['catatan_extend'] != "") {
                                        status += ". Mohon tinjau ulang kegiatan";
                                    }
                                } else if (result[i]['status'] == 3) {
                                    status = "Pembayaran Valid";
                                    checkbox = "";
                                } else {
                                    status = "Belum di Validasi";
                                }

                                var lastrow = t.row.add([
                                    checkbox,
                                    i + 1,
                                    result[i]['nama_dosen'],
                                    result[i]['nip'],
                                    result[i]['pengajaran'],
                                    result[i]['penelitian'],
                                    //result[i]['pengabdian'],
                                    result[i]['penunjang'],
                                    result[i]['tugas_tambahan_non_struktural'],
                                    result[i]['tugas_tambahan_struktural'],
                                    result[i]['total_sks'],
                                    status,
                                    buttondetail,
                                ]).draw();

                                if (result[i]['status'] == 1 || result[i]['status'] == 0) {
                                    if (result[i]['catatan_extend'] == "") {
                                        lastrow.nodes().to$().css('background-color', '#fa8072');
                                        lastrow.nodes().to$().css('color', '#000');
                                    } else {
                                        lastrow.nodes().to$().css('background-color', '#feffb6');
                                        lastrow.nodes().to$().css('color', '#000');
                                    }
                                }

                                if (result[i]['status'] == 2 && result[i]['catatan_extend'] != "") {
                                    lastrow.nodes().to$().css('background-color', '#feffb6');
                                    lastrow.nodes().to$().css('color', '#000');
                                }
                            }

                            loadJSAll();
                        },
                        error: function(status) {
                            t.clear().draw();
                        }
                    });
                }
            });
        }

        $('#datatable').on('click', '.btn-detail', function() {
            var nip = $(this).data('did');
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            var jenis, totalsksr1 = 0;
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/WDController/getDataKegiatanDosenBulanTahunJenis",
                type: "GET",
                data: {
                    bulan: bulan,
                    tahun: tahun,
                    nip: nip
                },
                success: function(ajaxData) {
                    var result = JSON.parse(ajaxData);
                    tabelModal1.clear().draw();
                    tabelModal2.clear().draw();
                    tabelModal3.clear().draw();
                    tabelModal4.clear().draw();
                    tabelModal5.clear().draw();
                    var catatan = "";
                    for (i = 0; i < result.length - 1; i++) {
                        jenis = result[i]['jenis_keg'];
                        if (jenis == 1) {
                            totalsksr1 += result[i]['sksr'];
                            tabelModal1.row.add([
                                result[i]['no_sk'],
                                result[i]['kode_keg'] + ':' + result[i]['nama_keg'],
                                result[i]['tgl_keg'],
                                result[i]['judul_keg'],
                                result[i]['sksr'],
                            ]).draw();
                        } else if (jenis == 2) {
                            tabelModal2.row.add([
                                result[i]['no_sk'],
                                result[i]['kode_keg'] + ':' + result[i]['nama_keg'],
                                result[i]['tgl_keg'],
                                result[i]['judul_keg'],
                                result[i]['sksr'],
                            ]).draw();
                        } else if (jenis == 3) {
                            tabelModal3.row.add([
                                result[i]['no_sk'],
                                result[i]['kode_keg'] + ':' + result[i]['nama_keg'],
                                result[i]['tgl_keg'],
                                result[i]['judul_keg'],
                                result[i]['sksr'],
                            ]).draw();
                        } else if (jenis == 4) {
                            tabelModal4.row.add([
                                result[i]['no_sk'],
                                result[i]['kode_keg'] + ':' + result[i]['nama_keg'],
                                result[i]['tgl_keg'],
                                result[i]['judul_keg'],
                                result[i]['sksr'],
                            ]).draw();
                        } else if (jenis == 5) {
                            tabelModal5.row.add([
                                result[i]['no_sk'],
                                result[i]['kode_keg'] + ':' + result[i]['nama_keg'],
                                result[i]['tgl_keg'],
                                result[i]['judul_keg'],
                                result[i]['sksr'],
                            ]).draw();
                        }
                    }

                    var j = result.length - 1;
                    catatan = result[j]['catatan'] + "\n" + result[j]['catatan_extend'];
                    $('#note-tampil').val(catatan);
                    $('#detailModal').modal('show');

                },
                error: function(status) {

                }
            });
        });

        $('#btn-note').on('click', function() {
            var noteData = $('#formNote').serialize();
            noteData = noteData + "&tahun=" + $('#tahun').val() + "&bulan=" + $('#bulan').val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/WDController/submitCatatan",
                type: "POST",
                data: noteData,
                success: function(ajaxData) {
                    $('#notesModal').modal('hide');
                    $.notify({
                        title: "<strong>Submit Catatan Kegiatan</strong> ",
                        message: "Success"
                    }, {
                        type: 'success',
                        delay: 3000,
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });
                    getRekapRemunDosen();
                },
                error: function(status) {
                    $('#notesModal').modal('hide');
                    $.notify({
                        title: "<strong>Submit Catatan Kegiatan</strong> ",
                        message: "Failed"
                    }, {
                        type: 'danger',
                        delay: 3000,
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });
                    getRekapRemunDosen();
                }
            });
        });


        function Validasi() {
            var data = [];
            var datastring = '';
            var index = 0;
            $('.checkbox-child:checked').each(function() {
                data.push($(this).val());
                if (index != 0) {
                    datastring += '&';
                }
                datastring += 'nip%5B%5D=' + $(this).val();
                index++;
            });
            datastring = datastring + "&tahun=" + $('#tahun').val() + "&bulan=" + $('#bulan').val();
            console.log(datastring);

            $.ajax({
                url: "<?php echo base_url(); ?>index.php/WDController/ValidasiKegiatan",
                type: "POST",
                data: datastring,
                success: function(ajaxData) {
                    $.notify({
                        title: "<strong>Validasi Rekap Kegiatan</strong>",
                        message: "Success"
                    }, {
                        type: 'success',
                        delay: 3000,
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });
                    setTimeout(function() {
                        location.reload()
                    }, 2000);

                },
                error: function(status) {
                    $.notify({
                        title: "<strong>Validasi Rekap Kegiatan</strong>",
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