
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Profile Account</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Profile Account</strong>
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
                                <h5>Profile Account</h5>
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
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class='title'>
                                                    <h3>Ubah Password</h3>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <div class='content'>
                                                    <form role='form' class="form-horizontal" onsubmit="return false;">
                                                        <div class="form-group">
                                                            <label class='control-label col-md-5' for='passbaru'>Password Baru</label>
                                                            <div class="col-md-6 col-md-offset-1"> 
                                                                <input id='passbaru' type='password' class='form-control col-md-12' name="passbaru">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class='control-label col-md-5' for='passconfirm'>Konfirmasi Password</label>
                                                            <div class="col-md-6 col-md-offset-1"> 
                                                                <input id='passconfirm' type="password" class='form-control col-md-12' name="passconfirm">
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="form-group">
                                                            <div class="col-md-3 col-md-offset-6">
                                                            <button type="submit" class="btn btn-info btnsubmit" onclick="ubahPassword();" id="btn-submit" ><span class="fa fa-key"></span>Ubah Password</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script type="text/javascript">
    
    function ubahPassword()
    {
        var baru = $("#passbaru").val();
        var konfirm = $("#passconfirm").val();

        if(baru!=konfirm)
        {
            alert("Password Tidak Sama");
        }
        else
        {
            $.ajax(
            {
               url: "<?php echo base_url();?>index.php/MainControler/ubahPassword",
               type: "POST",
               data : {passbaru : baru},                   
               success: function (ajaxData)
               {
                    
                    swal({
                    title: 'Perubahan Password Berhasil',
                    text: '',
                    type: 'success'
                    });
                },
                error: function(status)
                {
                    swal({
                title: 'Perubahan Password Gagal',
                text: '',
                type: 'danger'
                });
                }
        });
        }
    }

</script>