
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Daftar Operator</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Daftar Operator</strong>
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
                                    <h5>Daftar Operator</h5>
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
                                        <div class="form-group" id="data_4">
                                        <form id="formTampil" onsubmit="return false;">
                                            <div class="row">
                                            
                                            <div class="col-md-3">
                                                <select class="form-control m-b" name="prodi">
                                                    <option value='0'>Semua Program Studi</option>
                                                    <?php
                                                    foreach ($prodi as $d) {
                                                        echo "<option value='".$d['id_program_studi']."''>".$d['nama']." (".$d['singkatan'].")</option>";
                                                    }
                                                ?>
                                                    
                                                </select>                                            
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <button type="submit" onclick="getOperator();" class="btn btn-info"><span class="fa fa-search"></span> Tampilkan</button>
                                                </form>
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="ibox-content">

                                <div class="table-responsive">
                                <table id='datatable' class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Operator</th>
                                    <th>Fakultas</th>
                                    <th>Program Studi</th>                                    
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                <!--<tr class="gradeX">
                                    <td>1</td>                                    
                                    <td>Muhammad Syahroyni, S.Kom</td>
                                    <td>Ilmu Komputer</td>
                                    <td>Teknik Informatika</td>                                   
                                    <td><center><a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit"><span class="fa fa-edit"></span></a></center></td>
                                    <td><center><a href="#" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="fa fa-trash"></span></a></center></td>
                                                                    
                                </tr>
                                <tr class="gradeX">
                                    <td>2</td>
                                    <td>Muhammad Syahroyni, S.Kom</td>
                                    <td>Ilmu Komputer</td>
                                    <td>Teknik Informatika</td>                                   
                                    <td><center><a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit"><span class="fa fa-edit"></span></a></center></td>
                                    <td><center><a href="#" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="fa fa-trash"></span></a></center></td>
                                                                   
                                </tr>
                                <tr class="gradeX">
                                    <td>3</td>
                                    <td>Muhammad Syahroyni, S.Kom</td>
                                    <td>Ilmu Komputer</td>
                                    <td>Teknik Informatika</td>                                   
                                    <td><center><a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit"><span class="fa fa-edit"></span></a></center></td>
                                    <td><center><a href="#" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="fa fa-trash"></span></a></center></td>
                                                                      
                                </tr>      -->                         
                                </tbody>
                                <!--<tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Operator</th>
                                    <th>Fakultas</th>
                                    <th>Program Studi</th>                                    
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
                                            <h4 class="modal-title">Update Data Operator</h4>
                                            <small>Update Data Individu Operator</small>
                                            
                                            
                                        </div>
                                        <form role='form' id='formEdit' onsubmit="return false;">
                                        <div class="modal-body">                                             
                                            <div class="form-group">
                                                <label class='control-label' for='idOperator'>Operator</label><input readonly id='operator-edit' name='idOperator' class='form-control'>
                                            </div>
                                            <div class="form-group">
                                                <label class='control-label' for='idUser'>Username</label><input id='user-edit' class='form-control' name="idUser">
                                            </div>
                                            <div class="form-group">
                                                <label class='control-label' for='nama'>Nama</label><input id='nama-edit' class='form-control' name="nama">
                                            </div>                                           
                                            <div class="form-group">
                                                <label class='control-label' for='prodi'>Program Studi</label>
                                                <select class="form-control" id='prodi-edit' name='prodi'>                                                    
                                                    <?php
                                                    foreach ($prodi as $d) {
                                                        echo "<option value='".$d['id_program_studi']."'>".$d['nama']." (".$d['singkatan'].")</option>";
                                                    }
                                                ?>
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
                                            <button type="submit" data-dismiss='modal' id='btn-update' class="btn btn-primary">Save changes</button>
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
                                            <h4 class="modal-title">Hapus Data Operator</h4>
                                            <small>Konfirmasi Hapus Data Individu Operator</small>
                                            
                                            
                                        </div>
                                        <form role='form' id='formHapus' onsubmit="return false;">
                                        <div class="modal-body">                                             
                                        
                                            Apakah anda yakin ingin menghapus data ini ?
                                            <input type='hidden' id='idOperator' name='operator'>
                                            <input type='hidden' id='idUser' name='user'>
                                                                                                                                    
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
                                            <h4 class="modal-title">Reset Password Operator</h4>
                                            <small>Konfirmasi Reset Password Individu Operator</small>
                                            
                                            
                                        </div>
                                        <form role='form' id='formReset' onsubmit="return false;">
                                        <div class="modal-body">                                             
                                        
                                            Password Operator akan direset ke default : 123456. 
                                            <br>Apakah anda yakin ?
                                            <input type='hidden' id='idOperatorReset' name='idOperatorReset'>
                                                                                                                                    
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

var postData;
var t = $("#datatable").DataTable();

    function getOperator()
    {
        postData = $('#formTampil').serialize();   
        
                
        $.ajax(
        {
           url: "<?php echo base_url();?>index.php/Operator/getDataOperator",
           type: "GET",
           data : postData,                   
           success: function (ajaxData)
           {
                
                
                t.clear().draw();
                var result = JSON.parse(ajaxData);


                for(var i=0; i<result.length; i++)
                {
                    var button1 = "<a href='#' class='btn-edit' data-uid='"+result[i]['id_user']+"' data-oid='"+result[i]['id_operator']+"' title='Edit'><span class='fa fa-edit fa-2x'></span></a>";
                    var button2 = "<a href='#' class='btn-hapus' data-uid='"+result[i]['id_user']+"' data-oid='"+result[i]['id_operator']+"' title='Hapus'><span class='fa fa-trash fa-2x'></span></a>";
                    var button3 = "<a href='#' class='btn-reset-pass' data-uid='"+result[i]['id_user']+"' data-oid='"+result[i]['id_operator']+"' title='Reset Password'><span class='fa fa-user fa-2x'></span></a>";

                     t.row.add( [
                            i+1,
                            result[i]['nama'],
                            result[i]['namafakultas'],
                            result[i]['namaprodi'],                            
                            button1+"  "+button2+" "+button3
                            
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

        var n = $(this).data('oid');
        $.ajax(
        {
            url:"<?php echo base_url();?>index.php/Operator/getDataOperatorIndividu",
            type:"GET",
            data : {operator:n},
            success: function (ajaxData)
           {
                var result = JSON.parse(ajaxData);
                //$('#prodi-edit option:selected').removeAttr('selected');
                //$('#status-edit option:selected').removeAttr('selected');

                $("#operator-edit").val(result[0]['id_operator']);
                $("#user-edit").val(result[0]['id_user']);
                $("#nama-edit").val(result[0]['nama']);
                $("#notelepon-edit").val(result[0]['telepon']);
                $("#email-edit").val(result[0]['email']);
                $("#foto-edit").val(result[0]['foto']);
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
                $("#prodi-edit").val(result[0]['id_program_studi']);
                
                
                $('#editModal').modal('show');
           }
        });
        

      });
    
    $('#btn-update').click(function(){

        //$('#editModal').modal('hide');
                var updateData = $("#formEdit").serialize();
                
                
                  $.ajax({
                    url : "<?php echo base_url();?>index.php/Operator/updateDataOperatorIndividu",
                    type: "POST",
                    data : updateData,
                    success: function(data,status, xhr)
                    {
                      //if success then just output the text to the status div then clear the form inputs to prepare for new data
                     
                    getOperator();
                     $.notify({
                            title: "<strong>Update Data Operator </strong> ",
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
                            title: "<strong>Update Data Operator: </strong> ",
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

        var n = $(this).data('oid');        
        var u = $(this).data('uid');
        $('#idOperator').val(n);
        $('#idUser').val(u);
        $('#hapusModal').modal('show');
      });

   $("#btn-delete").click(function(){
      
      var deleteData = $('#formHapus').serialize();
      
      

      $.ajax({
        url : "<?php echo base_url();?>index.php/Operator/deleteDataOperatorIndividu",
        type: "POST",
        data : deleteData,
        success: function(data,status, xhr)
        {
          //if success then just output the text to the status div then clear the form inputs to prepare for new data
         getOperator();
         $.notify({
                title: "<strong>Hapus Data Operator: </strong> ",
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
                title: "<strong>Hapus Data Operator: </strong> ",
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

        var n = $(this).data('uid');        
        $('#idOperatorReset').val(n);
        $('#resetModal').modal('show');
      });

    $("#btn-reset").click(function(){
      
      var resetData = $('#formReset').serialize();
      
      

      $.ajax({
        url : "<?php echo base_url();?>index.php/Operator/resetPassOperator",
        type: "POST",
        data : resetData,
        success: function(data,status, xhr)
        {
          //if success then just output the text to the status div then clear the form inputs to prepare for new data
         
         $.notify({
                title: "<strong>Reset Password Operator: </strong> ",
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
                title: "<strong>Reset Password Operator: </strong> ",
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