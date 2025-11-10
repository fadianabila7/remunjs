
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Daftar Dosen</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Daftar Admin</strong>
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
                                    <h5>Daftar Admin</h5>
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
                                            
                                            <div class="col-md-3">

                                                <select class="form-control m-b" name="fakultas">
                                                <option value='0'>Semua Fakultas</option>
                                                <?php
                                                    foreach ($fakultas as $d) {
                                                        echo "<option value='".$d['id_fakultas']."''>Fakultas ".$d['nama']." (".$d['singkatan'].")</option>";
                                                    }
                                                ?>
                                                    <!--<option>Semua Program Studi</option>
                                                    <option>Manajemen Informatika (D3)</option>
                                                    <option>Komputerisasi Akuntansi (D3)</option>
                                                    <option>Teknik Komputer (D3)</option>
                                                    <option>Sistem Komputer (S1)</option>
                                                    <option>Teknik Informatika (S1)</option>
                                                    <option>Sistem Informasi (S1)</option>
                                                    <option>Teknik Informatika (S2)</option>
                                                    <option>Laboratorium Komputer (S1)</option>-->
                                                    
                                                </select>                                            
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-info btnsubmit" onclick="getAdmin();" id="btn-submit" ><span class="fa fa-search"></span>Tampilkan</button>
                                                </form>
                                                <button class="btn btn-info" id="btn-export" onclick="ExportDataDosen();"><span class="fa fa-file-excel-o"></span>Export</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="ibox-content">

                                <div class="table-responsive">
                                    <table id='datatable' class="table table-striped table-bordered table-hover display dataTables-example" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID User</th>                                        
                                        <th>Nama Admin</th>
                                        <th>Email</th>
                                        <th>Fakultas</th>
                                        <th>Telepon</th>
                                        <th>Action</th>

                                        
                                    </tr>
                                    </thead>
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
                                                                        
                                    </tr>
                                    <tr class="gradeX">
                                        <td>2</td>
                                        <td>09111002051</td>
                                        <td>Muhammad Syahroyni, S.Kom</td>
                                        <td>msyahroyni@gmail.com</td>
                                        <td>Teknik Informatika</td>
                                        <td>PNS</td>
                                        <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit"><span class="fa fa-edit"></span></a></td>
                                        <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="fa fa-trash"></span></a></td>
                                                                       
                                    </tr>
                                    <tr class="gradeX">
                                        <td>3</td>
                                        <td>09111002051</td>
                                        <td>Muhammad Syahroyni, S.Kom</td>
                                        <td>msyahroyni@gmail.com</td>
                                        <td>Teknik Informatika</td>
                                        <td>PNS</td>
                                        <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit"><span class="fa fa-edit"></span></a></td>
                                        <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="fa fa-trash"></span></a></td>
                                                                          
                                    </tr>      -->                         
                                    </tbody>
                                    <!--<tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>NIP/NIPUS</th>
                                        <th>Nama Dosen</th>
                                        <th>Email</th>
                                        <th>Program Studi</th>
                                        <th>Status</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    </tfoot>-->
                                    </table>
                                </div>

                                </div>
                            </div>
                        </div>
                        </div>
                        
                


            </div>
            <div class="modal inmodal" id="editModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-tasks modal-icon"></i>
                                            <h4 class="modal-title">Edit Data Admin</h4>
                                            <small>Edit Data Individu Admin</small>
                                            
                                            
                                        </div>
                                        <form role='form' id='formEdit' onsubmit="return false;">
                                        <div class="modal-body">                                             
                                        
                                            <div class="form-group">
                                                <label class='control-label' for='nip'>ID User</label><input id='user-edit' class='form-control' name="id_user" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class='control-label' for='nama'>Nama</label><input id='nama-edit' class='form-control' name="nama_admin">
                                            </div>                                            
                                            <div class="form-group">
                                                <label class='control-label' for='fakultas'>Fakultas</label>
                                                <select class="form-control" id='fakultas-edit' name='fakultas'>                                                    
                                                    <?php
                                                    foreach ($fakultas as $d) {
                                                        echo "<option value='".$d['id_fakultas']."'>".$d['nama']." (".$d['singkatan'].")</option>";
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class='form-group col-xs-6'>
                                                    <label class='control-label' for='notelepon'>No Telepon</label><input id='notelepon-edit' class='form-control' name="no_telepon">
                                                </div>
                                                <div class='form-group col-xs-6'>
                                                    <label class='control-label' for='email'>Email</label><input id='email-edit' class='form-control' name="email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class='control-label' for='foto'>Foto URL</label><input id='foto-edit' class='form-control' name="foto">
                                            </div>       
                                            <input type="hidden" id="admin-edit" name="id_admin">                                     
                                                                                                                                    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button type="submit" id='btn-update' data-dismiss="modal" class="btn btn-primary">Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
<!----------------------------------------- Modal Confirm Hapus ------------------------>
                            <div class="modal inmodal" id="hapusModal" tabindex="-1" role="dialog"  aria-hidden="true">
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
                                            <input type='hidden' id='admin-hapus' name='id_admin'>
                                                                                                                                    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  class="btn btn-white" data-dismiss="modal">Cancel</button>
                                            <button type="submit" id='btn-delete' data-dismiss="modal" class="btn btn-danger">Delete</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

<!-------------------------------------------- Modal Confirm Reset Password ----------------------------------------------- -->
                            <div class="modal inmodal" id="resetModal" tabindex="-1" role="dialog"  aria-hidden="true">
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
                                            <input type='hidden' id='idAdminReset' name='id_admin'>
                                                                                                                                    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  class="btn btn-white" data-dismiss="modal">Cancel</button>
                                            <button type="submit" id='btn-reset' data-dismiss="modal" class="btn btn-success">Reset</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
        </div>
        <!--End of Page Content-->
        
<script>

var postData = $('#formTampil').serialize();



var t = $("#datatable").DataTable();

    function getAdmin()
    {
        postData = $('#formTampil').serialize();   
        
                
        $.ajax(
        {
           url: "<?php echo base_url();?>index.php/Admin/getDataAdmin",
           type: "GET",
           data : postData,                   
           success: function (ajaxData)
           {
                
                
                t.clear().draw();
                var result = JSON.parse(ajaxData);


                for(var i=0; i<result.length; i++)
                {
                    var button1 = "<a href='#' class='btn-edit' data-did='"+result[i]['id_admin']+"' title='Edit'><span class='fa fa-edit fa-2x'></span></a>";
                    var button2 = "<a href='#' class='btn-hapus' data-did='"+result[i]['id_admin']+"' title='Hapus'><span class='fa fa-trash fa-2x'></span></a>";
                    var button3 = "<a href='#' class='btn-reset-pass' data-did='"+result[i]['id_admin']+"' title='Reset Password'><span class='fa fa-user fa-2x'></span></a>";
                     t.row.add( [
                            i+1,
                            result[i]['id_user'],
                            result[i]['nama'],
                            result[i]['email'],
                            "Fakultas "+result[i]['nama_fakultas'],
                            result[i]['telepon'],
                            button1+"  "+button2+" "+button3,
                            
                        ] ).draw();
                        
                }
                
            },
            error: function(status)
            {
                t.clear().draw();
            }
        });
        
    }

    $('#datatable').on('click', '.btn-edit', function(){

        var n = $(this).data('did');
        $.ajax(
        {
            url:"<?php echo base_url();?>index.php/Admin/getDataAdminIndividu",
            type:"GET",
            data : {id_admin:n},
            success: function (ajaxData)
           {
                var result = JSON.parse(ajaxData);
                //$('#prodi-edit option:selected').removeAttr('selected');
                //$('#status-edit option:selected').removeAttr('selected');

                $("#user-edit").val(result[0]['id_user']);
                $("#nama-edit").val(result[0]['nama']);                
                $("#notelepon-edit").val(result[0]['telepon']);
                $("#email-edit").val(result[0]['email']);
                $("#foto-edit").val(result[0]['foto']);
                $("#admin-edit").val(result[0]['id_admin']);
                /*$('#prodi-edit > option').each(function(){
                    if($(this).attr('value')==result[0]['id_program_studi'])
                    {
                        $(this).attr('selected', true);
                    }
                });
                $('#status-edit > option').each(function(){
                    if($(this).attr('value')==result[0]['id_status_dosen'])
                    {
                        $(this).attr('selected',true);
                    }
                });*/
                $("#fakultas-edit").val(result[0]['id_fakultas']);
                $('#editModal').modal('show');
           }
        });
        

      });
    
    $('#btn-update').click(function(){

        $('#editModal').modal('hide');
                var updateData = $("#formEdit").serialize();
                
                  $.ajax({
                    url : "<?php echo base_url();?>index.php/Admin/updateDataAdminIndividu",
                    type: "POST",
                    data : updateData,
                    success: function(data,status, xhr)
                    {
                      //if success then just output the text to the status div then clear the form inputs to prepare for new data
                     
                    getAdmin();
                     $.notify({
                            title: "<strong>Update Data Admin </strong> ",
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
                      
                        
                        
                    },
                    error: function (jqXHR, status, errorThrown)
                    {
                      //if fail show error and server status
                      
                      $.notify({
                            title: "<strong>Update Data Admin </strong> ",
                            message: "Failed"               
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
    })
    
</script>

<script>

   $('#datatable').on('click', '.btn-hapus', function(){

        var n = $(this).data('did');        
        $('#admin-hapus').val(n);
        $('#hapusModal').modal('show');
      });

   $("#btn-delete").click(function(){
      
      var deleteData = $('#formHapus').serialize();
      
      

      $.ajax({
        url : "<?php echo base_url();?>index.php/Admin/deleteDataAdminIndividu",
        type: "POST",
        data : deleteData,
        success: function(data,status, xhr)
        {
          //if success then just output the text to the status div then clear the form inputs to prepare for new data
         getDosen();
         $.notify({
                title: "<strong>Hapus Data Admin: </strong> ",
                message: data              
            },
            {
                type : 'success',
                delay : 3000,
                placement: {
                    from: "top",
                    align: "center"
                }
            });
            

            
        },
        error: function (jqXHR, status, errorThrown)
        {
          //if fail show error and server status
          
          $.notify({
                title: "<strong>Hapus Data Admin: </strong> ",
                message: "Failed"               
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
    });
    </script>

    <script>
        $('#datatable').on('click', '.btn-reset-pass', function(){

        var n = $(this).data('did');        
        $('#idAdminReset').val(n);
        $('#resetModal').modal('show');
      });

    $("#btn-reset").click(function(){
      
      var resetData = $('#formReset').serialize();
      
      

      $.ajax({
        url : "<?php echo base_url();?>index.php/Admin/resetPassAdmin",
        type: "POST",
        data : resetData,
        success: function(data,status, xhr)
        {
          //if success then just output the text to the status div then clear the form inputs to prepare for new data
         
         $.notify({
                title: "<strong>Reset Password Dosen: </strong> ",
                message: data              
            },
            {
                type : 'success',
                delay : 3000,
                placement: {
                    from: "top",
                    align: "center"
                }
            });
            

            
        },
        error: function (jqXHR, status, errorThrown)
        {
          //if fail show error and server status
          
          $.notify({
                title: "<strong>Reset Password Dosen: </strong> ",
                message: "Failed"               
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
    });
    </script>
      
<script>
   function ExportDataDosen()
    {
        postData = $('#formTampil').serialize();   
        
                
        $.ajax(
        {
           url: "<?php echo base_url();?>index.php/Dosen/ExportDataDosen",
           type: "GET",
           data : postData,                   
           success: function (ajaxData)
           {
                $.notify({
                    title: "<strong>Export Data Dosen</strong> ",
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
                window.location = download;
                
            },
            error: function(status)
            {
                $.notify({
                    title: "<strong>Export Data Dosen</strong> ",
                    message: "Failed"               
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