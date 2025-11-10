
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Registrasi Bendahara</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Registrasi Bendahara</strong>
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
                                    <h5>Registrasi Bendahara</h5>
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
                                <div class="ibox-content">
                                    <form class="form-horizontal" id="formEntry" method="POST" action="<?php echo base_url();?>index.php/Bendahara/entryDataBendahara">

                                        <div class="form-group">
                                        <label for="nip" class="col-md-3 control-label">ID User *</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="id_user" required>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label for="namadosen" class="col-md-3 control-label">Nama Bendahara *</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="nama_bendahara" required>
                                        </div>
                                        </div>                                                                          
                                        <div class="form-group">
                                        <label for="fakultas" class="col-md-3 control-label">Fakultas *</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="fakultas" required>
                                                <option>Pilih Fakultas</option>
                                                <?php
                                                    foreach ($fakultas as $f) {
                                                        echo "<option value='".$f['id_fakultas']."''>Fakultas ".$f['nama']." (".$f['singkatan'].")</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        </div>
                                        
                                        <div class="form-group">
                                        <label for="notelepon" class="col-md-3 control-label">No Telepon *</label>
                                        <div class="col-md-6">
                                            <input type="text" name="no_telepon" class="form-control">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label for="email" class="col-md-3 control-label">Email *</label>
                                        <div class="col-md-6">
                                            <input type="text" name="email" class="form-control">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label for="foto" class="col-md-3 control-label">Foto</label>
                                        <div class="col-md-6">
                                            <input type="text" name="foto" placeholder="linkFoto" class="form-control">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-9">
                                            <center>
                                                <button type="reset" class="btn btn-normal">Reset</button>
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                </center>
                                            </div>
                                        </div>                                                             
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                        
            </div>
            

        </div>
        <!--End of Page Content-->
               