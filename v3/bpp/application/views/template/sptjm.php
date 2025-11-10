
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Cetak SPTJM</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Cetak SPTJM</strong>
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
                                    <h5>Cetak SPTJM</h5>
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
                                                    
                                                    <?php
                                                        $currentDate = date("Y");
                                                        $lowerDate = 2015;
                                                        for($i=$currentDate; $i>=$lowerDate; $i--)
                                                        {
                                                            echo "<option value='".$i."'>".$i."</option>";
                                                        }
                                                        
                                                        ?>
                                                    
                                                </select>                                            
                                            </div>
                                            <div class="col-md-2">
                                                <button id="btn-submit" onclick="CetakSPTJM();" class="btn btn-info"><span class="fa fa-file-excel-o"></span> Cetak SPTJM</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="ibox-content">

                                

                                </div>
                            </div>
                        </div>
                        </div>
                        
                


            </div>
            

        </div>
        <!--End of Page Content-->

<script>
function CetakSPTJM()
    {
        postData = $('#formTampil').serialize();   
        var button;
        var textStatus;
        var download;
                
        $.ajax(
        {
           url: "<?php echo base_url();?>index.php/MainControler/CetakSPTJM",
           type: "POST",
           data : postData,                   
           success: function (ajaxData)
           {
                $.notify({
                    title: "<strong>Cetak SPTJM</strong> ",
                    message: "Success"               
                },
                {
                    type : 'success',
                    delay : 3000,
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });

                download = "<?php echo base_url();?>"+ajaxData;
                //alert(download);
                window.location = download;
                
            },
            error: function(status)
            {
                $.notify({
                    title: "<strong>Cetak SPTJM</strong> ",
                    message: "Failed : "+status
                },
                {
                    type : 'danger',
                    delay : 3000,
                    placement: {
                        from: "top",
                        align: "center"
                    }
                });
            }
        });
        
    }
</script>