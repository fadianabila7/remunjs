<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>Rekapitulasi Sisa SKSR Dosen</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url(); ?>">Home</a>
                </li>
                <li class="active">
                    <strong>Rekapitulasi Sisa SKSR</strong>
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
                        <h5>Rekap Sisa SKSR Dosen</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a></li>
                                <li><a href="#">Config option 2</a></li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                            <div class="hr-line-dashed"></div>
                            <form id="formTampil" onsubmit="return false;">
                                <div class="form-group" id="data_4">
                                    <div class="row">

                                        <div class="col-md-2">
                                            <select class="form-control m-b" name="fakultas" required="required">
                                                <option value="">Pilih Fakultas</option>
                                                <?php
                                                foreach ($fakultas as $f) {
                                                    echo "<option value='" . $f['id_fakultas'] . "'>" . "Fakultas " . $f['nama'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select class="form-control m-b" name="bulan" required="required">
                                                <option value="">Pilih Bulan</option>
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
                                            <select class="form-control m-b" name="endbulan" required="required">
                                                <option value="">Sampai Bulan</option>
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
                                        <div class="col-md-2">
                                            <button type="submit" class="ladda-button ladda-button-load btn btn-info btnsubmit" id="btn-submit" data-style="slide-down">
                                                <span class="fa fa-search"></span> Tampilkan
                                            </button>
                                            <!-- <button class="btn btn-info"><span class="fa fa-file-excel-o"></span>Export</button> -->
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table id='datatable' class="table table-striped table-bordered table-hover display dataTables-example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="3" width="1%">No</th>
                                            <th class="text-center" rowspan="3">Nama Dosen</th>
                                            <th class="text-center" rowspan="3">NIP</th>
                                            <th class="text-center" rowspan="1" colspan="7" class="text-center" width="20%">Kegiatan Dosen</th>
                                            <th class="text-center" rowspan="3">Total<br>SKSR</th>
                                            <th class="text-center" rowspan="3">Total<br>Potongan<br>SKSR</th>
                                            <th class="text-center" rowspan="3">Kelebihan<br>SKSR</th>
                                            <th class="text-center" rowspan="3"><br>Bonus</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" rowspan='2'>Pengajaran</th>
                                            <th class="text-center" rowspan='1' colspan="2">Penelitian<br>Pengabdian</th>
                                            <th class="text-center" rowspan='1' colspan="2">Penunjang</th>
                                            <th class="text-center" rowspan='2'>NonStruktural</th>
                                            <th class="text-center" rowspan='2'>Struktural</th>
                                        </tr>
                                        <tr>
                                            <th>Nilai</th>
                                            <th>max</th>
                                            <th>Nilai</th>
                                            <th>max</th>
                                        </tr>
                                    </thead>
                                    <form id="validasiForm" onsubmit="return false;">
                                        <tbody id="table-body">
                                        </tbody>
                                    </form>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

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
                                <label class='control-label' for='nip'>NIP</label><input id='nip-edit' class='form-control' name="nip">
                            </div>
                            <div class="form-group">
                                <label class='control-label' for='nama'>Nama</label><input id='nama-edit' class='form-control' name="nama">
                            </div>
                            <div class="form-group">
                                <label class='control-label' for='norek'>No Rekening</label><input id='norek-edit' class='form-control' name="norek">
                            </div>
                            <div class="form-group">
                                <label class='control-label' for='prodi'>Program Studi</label>
                                <select class="form-control" id='prodi-edit' name='prodi'>
                                    <?php foreach ($prodi as $d) {
                                        echo "<option value='" . $d['id_program_studi'] . "'>" . $d['nama'] . " (" . $d['singkatan'] . ")</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class='control-label' for='status'>Status</label>
                                <select class="form-control" id='status-edit' name='status'>
                                    <?php foreach ($status as $s) {
                                        echo "<option value='" . $s['id_status_dosen'] . "'>" . $s['deskripsi'] . "</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class='form-group col-xs-6'>
                                    <label class='control-label' for='notelepon'>No Telepon</label><input id='notelepon-edit' class='form-control' name="notelepon">
                                </div>
                                <div class='form-group col-xs-6'>
                                    <label class='control-label' for='email'>Email</label><input id='email-edit' class='form-control' name="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class='control-label' for='foto'>Foto URL</label><input id='foto-edit' class='form-control' name="foto">
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

    </div>
</div>
<!--End of Page Content-->

<script>
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
        error: function(status) {}
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


    var postData = $('#formTampil').serialize();
    var t = $('#datatable').DataTable({
        'paging': false
    });

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

    var l = $('.ladda-button-load').ladda();
    l.click(function() {
        l.ladda('start');
        $('#formTampil').validate({
            submitHandler: function(form) {
                postData = $(form).serialize();
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/WRController/getDataRekapRemunBulanTahunStatusFakultasRange",
                    type: "GET",
                    data: postData,
                    success: function(ajaxData) {
                        t.clear().draw();
                        var result = JSON.parse(ajaxData);
                        for (var i = 0; i < result.length; i++) {
                            var lastrow = t.row.add([
                                i + 1,
                                result[i]['nama_dosen'],
                                result[i]['nip'],
                                result[i]['pengajaran'],
                                result[i]['penelitian'],
                                result[i]['max_bidang_2'],
                                result[i]['penunjang'],
                                result[i]['max_bidang_4'],
                                result[i]['nonstruktural'],
                                result[i]['sksr_tugas_tambahan'],
                                result[i]['total_sks'],
                                result[i]['total_ext'],
                                result[i]['sksr_max'],
                                result[i]['bonus'],
                            ]).draw();
                            // if(result[i]['status']=="Belum di Validasi" || result[i]['status']=="Kegiatan Tidak Valid"){
                            //     lastrow.nodes().to$().css('background-color', '#efbbbb');
                            // }
                            // else if(result[i]['status']=="Pembayaran Valid"){
                            //     lastrow.nodes().to$().css('background-color', '#86ddbc');
                            // }
                        }
                    },
                    error: function(status) {
                        t.clear().draw();
                    }
                });
            }
        });
        l.ladda('stop');
    });
</script>