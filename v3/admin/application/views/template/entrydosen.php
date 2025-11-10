<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>Registrasi Dosen</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url();?>">Home</a>
                </li>
                <li class="active">
                    <strong>Registrasi Dosen</strong>
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
                        <h5>Registrasi Dosen</h5>
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
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" id="formEntry" method="POST" action="<?php echo base_url();?>index.php/Dosen/entryDataDosen">

                                <div class="form-group">
                                    <label for="nip" class="col-md-3 control-label">NIP *</label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="number" min="1000000" name="nip" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="namadosen" class="col-md-3 control-label">Nama Dosen *</label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="namadosen" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="id_bank" class="col-md-3 control-label">Bank *</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="id_bank" required>
                                                <option value="">Pilih Bank</option>
                                                <?php
                                                    foreach ($bank as $d) {
                                                       echo "<option value='".$d['id_bank']."''>".$d['nama']." (".$d['singkatan'].")</option>";
                                                    }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="norek" class="col-md-3 control-label">No Rekening *</label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="norek" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fakultas" class="col-md-3 control-label">Fakultas *</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="fakultas" id="fakultas" required>
                                                <option value="">Pilih Fakultas</option>
                                                <?php
                                                    foreach ($fakultas as $d) {
                                                        echo "<option value='".$d['id_fakultas']."''>".$d['nama']." (".$d['singkatan'].")</option>";
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="prodi" class="col-md-3 control-label">Program Studi *</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="prodi" id="prodi" required>
                                            <option value="">Pilih Program Studi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-md-3 control-label">Status *</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="status" required>
                                                <option value="">Pilih Status Dosen</option>
                                                <?php
                                                    foreach($status as $s)
                                                    {
                                                        echo "<option value='".$s['id_status_dosen']."'>".$s['deskripsi']."</option>";
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="notelepon" class="col-md-3 control-label">No Telepon *</label>
                                    <div class="col-md-6">
                                        <input type="text" name="notelepon" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email *</label>
                                    <div class="col-md-6">
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">NPWP *</label>
                                    <div class="col-md-6">
                                        <input type="text" name="npwp" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="foto" class="col-md-3 control-label">Foto </label>
                                    <div class="col-md-6">
                                        <input type="url" name="foto" placeholder="linkFoto" class="form-control">
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

    <script type="text/javascript">
        $('select#fakultas').on('change', function() {
            $.ajax({
                url: "<?php echo base_url();?>index.php/MainControler/getJsonProdi",
                type: "POST",
                data : {id: this.value },
                success: function(ajaxData){
                    var prodi = "<option value=''>Pilih Program Studi</option>";
                    $('#prodi').empty();
                    x = JSON.parse(ajaxData);
                    for(i=0; i<x.length; i++){
                        prodi = prodi + "<option value="+ x[i].id_program_studi +">"+x[i].nama+" ("+x[i].singkatan+")</option>";
                    }
                    $('#prodi').append(prodi);
                },
                error: function(status){

                }
            });
        });
    </script>