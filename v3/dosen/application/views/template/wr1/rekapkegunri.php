
<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>Rekapitulasi Remunerasi Dosen</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url();?>">Home</a>
                </li>
                <li class="active">
                    <strong>Rekapitulasi Remunerasi</strong>
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
                        <h5>Rekap Kegiatan Dosen</h5>
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
                                            <select class="form-control m-b" name="fakultas" required="required">
                                                <option value="">Pilih Fakultas</option>
                                                <?php
                                                    foreach($fakultas as $f){
                                                        echo "<option value='".$f['id_fakultas']."'>"."Fakultas ".$f['nama']."</option>";
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
                                            <select class="form-control m-b" name="tahun" required="required">
                                                <?php
                                                    $currentDate = date('Y');
                                                    $lowerDate = 2017;
                                                     for($i=$currentDate; $i>=$lowerDate; $i--){
                                                        echo "<option>".$i."</option>";
                                                     }
                                                ?>
                                            </select>                                            
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control m-b" id="status_dosen" name="status_dosen" required>
                                                <option value="">Pilih Status</option>
                                                <option value="1">PNS</option>
                                                <option value="2">NON PNS</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-info btnsubmit" onclick="getRekapKegiatanDosen();" id="btn-submit" ><span class="fa fa-search"></span>Tampilkan</button>
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
                                            <th class="text-center" >No</th>
                                            <th class="text-center" >Nama Dosen</th>
                                            <th class="text-center" >NIP / NIK</th>
                                            <th class="text-center" >Program Studi</th>
                                            <th class="text-center" >Golongan</th>
                                            <th class="text-center" >Pendidikan Terakhir</th>
                                            <th class="text-center" >Jabatan Fungsional</th>
                                            <th class="text-center" >Jabatan Struktural</th>
                                            <th class="text-center" >SKS Struktural</th>
                                            <th class="text-center" >SKS Gaji Maks</th>
                                            <th class="text-center" >SKS Kinerja Maks</th>
                                            <th class="text-center" >Total SKS</th>
                                            <th class="text-center" >Total SKS Gaji</th>
                                            <th class="text-center" >Total SKS Kinerja</th>
                                        </tr>                                    
                                    </thead>
                                    <form id="validasiForm" onsubmit="return false;">
                                        <tbody id="table-body">
                                        <!--
                                        <tr class="gradeX">
                                            <td>1</td>
                                            <td>09111002051</td>
                                            <td>Muhammad Syahroyni, S.Kom</td>
                                            <td>msyahroyni@gmail.com</td>
                                            <td>Teknik Informatika</td>
                                            <td>PNS</td>
                                            <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit"><span class="fa fa-edit"></span></a></td>
                                            <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="fa fa-trash"></span></a></td>                    
                                        </tr>      -->                         
                                        </tbody>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>
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
        url: "<?php echo base_url();?>index.php/Dosen/getDataDosenByFakultas",
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
    var t = $('#datatable').DataTable();

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

    function getRekapKegiatanDosen() {
        $('#formTampil').validate({
            //var postData = $('#demo-form2').serialize();

            submitHandler: function(form) {

                postData = $(form).serialize();

                $.ajax({
                    url: "<?php echo base_url();?>index.php/WRController/getDataRekapKegiatanBulanTahunStatusFakultas",
                    type: "GET",
                    data: postData,
                    success: function(ajaxData) {

                        t.clear().draw();
                        var result = JSON.parse(ajaxData);

                        for (var i = 0; i < result.length; i++) {
                            var lastrow = t.row.add([
                                i + 1,
                                result[i]['namadosen'],
                                result[i]['nip'],
                                result[i]['prodi'],
                                result[i]['golongan'],
                                result[i]['pendidikan'],
                                result[i]['jabFungsional'],
                                result[i]['jabStruktural'],
                                result[i]['sksr_tt'],
                                result[i]['sksr_gaji'],
                                result[i]['sksr_kinerja'],
                                result[i]['totalsks'],
                                result[i]['grandtotalsks'],
                                result[i]['sks_gaji'],
                                result[i]['sks_kinerja'],
                            ]).draw();
                            
                            /*                        
                            if(result[i]['status']=="Belum di Validasi" || result[i]['status']=="Kegiatan Tidak Valid"){
                                lastrow.nodes().to$().css('background-color', '#fa8072');
                            }else if(result[i]['status']=="Pembayaran Valid"){
                                lastrow.nodes().to$().css('background-color', '#86ddbc');
                            }
                            */
                        }
                    },
                    error: function(status) {
                        t.clear().draw();
                    }
                });
            }
        });
    }
</script>

