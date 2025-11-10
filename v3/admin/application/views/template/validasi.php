<link href="<?php echo base_url('assets');?>/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">
<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>Cetak Rekap Per Fakultas</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url();?>">Home</a>
                </li>
                <li class="active">
                    <strong>Cetak Rekap Per Fakultas</strong>
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
                        <h5>Rekap Per Fakultas</h5>
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
                                            <select class="form-control m-b" name="status">

                                                <?php 
                                                foreach($status as $s){ 
                                                    echo "<option value='".$s[ 'id_status_dosen']. "'>".$s[ 'deskripsi']. "</option>"; 
                                                } 
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control m-b" id="bulan" name="bulan">
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
                                            <select class="form-control m-b" id="tahun" name="tahun">
                                                <option value='0'>Tahun</option>
                                                <?php 
                                                    $currentDate=date( "Y"); 
                                                    $previousDate=$currentDate-1; 
                                                    $nextDate=$currentDate+1; 
                                                    echo "<option value='".$previousDate. "'>".$previousDate. "</option>"; 
                                                    echo "<option selected value='".$currentDate. "'>".$currentDate. "</option>"; 
                                                    echo "<option value='".$nextDate. "'>".$nextDate. "</option>"; 
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button id="validasi" class="ladda-button btn btn-info"  data-style="expand-right"><span class="fa fa-file-excel-o"></span> Cetak Validasi</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="ibox-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Page Content-->

<script src="<?php echo base_url('assets');?>/js/plugins/ladda/spin.min.js"></script>
<script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.min.js"></script>
<script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.jquery.min.js"></script>
<script>
$(document).ready(function (){
    var t = $('.ladda-button').ladda();
    t.click(function(){
        postData = $('#formTampil').serialize();
        var button;
        var textStatus;
        var download;
        t.ladda('start');
        $.ajax({
            url: "<?php echo base_url();?>index.php/MainControler/ExportValidasiWD1",
            type: "POST",
            data: postData,
            success: function(ajaxData) {
                t.ladda('stop')
                $.notify({
                    title: "<strong>Cetak Daftar Validasi</strong> ",
                    message: "Success"
                }, {
                    type: 'success',
                    delay: 3000,
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });

                download = "<?php echo base_url();?>" + ajaxData;
                window.location = download;;
                //alert(download);
            },
            error: function(status) {
                t.ladda('stop')
                $.notify({
                    title: "<strong>Cetak Daftar Validasi</strong> ",
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
    });
});
</script>