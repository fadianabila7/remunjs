
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Rekap Remunerasi</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url();?>">Home</a></li>
                        <li class="active"><strong>Rekap Remunerasi</strong></li>
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
                                <h5>Rekap Remunerasi Dosen</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-wrench"></i> </a>
                                    <ul class="dropdown-menu dropdown-user">
                                        <li><a href="#">Config option 1</a> </li>
                                        <li><a href="#">Config option 2</a> </li>
                                    </ul>
                                    <a class="close-link"> <i class="fa fa-times"></i> </a>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group" id="data_4">
                                        <form id="formTampil" onsubmit="return false;">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input id="namadosen" placeholder="Nama Dosen" autofocus data-validate-length-range="30" data-validate-words="2" class='form-control m-b' type="text" required="required" name='namadosen'>
                                                    <input id="nip" name="nip" type="hidden"> 
                                                </div>

                                                <div class="col-md-3">
                                                    <select class="form-control m-b" name="tahun">
                                                        <?php $currentDate=date('Y'); $previousDate=$currentDate-1; $nextDate=$currentDate+1; echo "<option>".$previousDate. "</option>"; echo "<option selected>".$currentDate. "</option>"; echo "<option>".$nextDate. "</option>"; ?> </select>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <button type="submit" onclick="getRekapIndividu();" class="btn btn-info"><span class="fa fa-search"></span>Tampilkan</button>
                                                    <button class="btn btn-info"><span class="fa fa-file-excel-o"></span>Export</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table id='datatable' class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Bendahara</th>
                                                    <th>Bulan</th>
                                                    <th>Σ SKS Gaji dibayar</th>
                                                    <th>Σ SKS Kinerja dibayar</th>
                                                    <th>Tarif Gaji(Rp.)</th>
                                                    <th>Tarif Kinerja(Rp.)</th>
                                                    <th>Jumlah (Rp.)</th>
                                                    <th>Pajak (Rp.)</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body"> </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <table width="50%">
                                            <tbody>
                                                <tr>
                                                    <td> Total SKS Remun s.d bulan Desember 2016 </td>
                                                    <td> : </td>
                                                    <td> 0 </td>
                                                </tr>
                                                <tr>
                                                    <td> Total SKS Remun sudah dibayar </td>
                                                    <td> : </td>
                                                    <td> 0 </td>
                                                </tr>
                                                <tr>
                                                    <td> Total SKS Remun belum dibayar s.d bulan Desember 2016 </td>
                                                    <td> : </td>
                                                    <td> 0 </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span> 
                            </button> 
                            <i class="fa fa-tasks modal-icon"></i>
                            <h4 class="modal-title">Update Data Operator</h4> 
                            <small>Update Data Individu Operator</small>
                        </div>
                        <form role='form' id='formEdit' onsubmit="return false;">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class='control-label' for='idOperator'>Operator</label>
                                    <input readonly id='operator-edit' name='idOperator' class='form-control'> 
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='idUser'>Username</label>
                                    <input id='user-edit' class='form-control' name="idUser">
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='nama'>Nama</label>
                                    <input id='nama-edit' class='form-control' name="nama">
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='prodi'>Program Studi</label>
                                    <select class="form-control" id='prodi-edit' name='prodi'>
                                        <?php 
                                            foreach ($prodi as $d){ 
                                                echo "<option value='".$d[ 'id_program_studi']."'>".$d[ 'nama']. " (".$d[ 'singkatan']. ")</option>"; 
                                            } 
                                        ?>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class='form-group col-xs-6'>
                                        <label class='control-label' for='notelepon'>No Telepon</label>
                                        <input id='notelepon-edit' class='form-control' name="notelepon">
                                    </div>

                                    <div class='form-group col-xs-6'>
                                        <label class='control-label' for='email'>Email</label>
                                        <input id='email-edit' class='form-control' name="email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class='control-label' for='foto'>Foto URL</label>
                                    <input id='foto-edit' class='form-control' name="foto">
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
            

            <div class="modal inmodal" id="hapusModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                            </button> <i class="fa fa-trash modal-icon"></i>
                            <h4 class="modal-title">Hapus Data Operator</h4> <small>Konfirmasi Hapus Data Individu Operator</small> </div>
                        <form role='form' id='formHapus' onsubmit="return false;">
                            <div class="modal-body"> Apakah anda yakin ingin menghapus data ini ?
                                <input type='hidden' id='idOperator' name='operator'>
                                <input type='hidden' id='idUser' name='user'> </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                <button type="submit" id='btn-delete' data-dismiss="modal" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!--End of Page Content-->
<script>
    var datajsondosen;
    var n=0;
             
            $.ajax(
        {
           url: "<?php echo base_url();?>index.php/MainControler/getDataDosenByFakultas",
           type: "POST",
           data : {nip: n},                   
           success: function (ajaxData)
           {
                datajsondosen = JSON.parse(ajaxData);
            },
            error: function(status)
            {
                
            }
        });

        $('#namadosen').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                term = term.toLowerCase();
                var choices=[];
                 for(i=0;i<datajsondosen.length;i++){
                    choices.push(datajsondosen[i].nama);
                    
                }
                var suggestions = []; 
                for (i=0;i<choices.length;i++)
                    if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                console.log(suggestions);
                suggest(suggestions);  
            },
            onSelect: function(event,ui){
                var id="";
                 for (k=0;k<datajsondosen.length;k++)
                    if (datajsondosen[k].nama==ui) id=datajsondosen[k].id_dosen;
                  $('#nip').val(id);
            }
        });
</script>

<script>

var postData;
var t = $("#datatable").DataTable();
    
    function convertMonth(data)
    {
        switch(data)
        {
            case 0: return null;break;
            case 1: return "Januari"; break;
            case 2: return "Februari";break;
            case 3: return "Maret";break;
            case 4: return "April";break;
            case 5: return "Mei";break;
            case 6: return "Juni";break;
            case 7: return "Juli";break;
            case 8: return "Agustus";break;
            case 9: return "September";break;
            case 10: return "Oktober";break;
            case 11: return "November";break;
            case 12: return "Desember";break;
        }
    }

    function convertStatus(status)
    {
        switch(status)
        {
            case -1 : return "Kegiatan Tidak Valid"; break;
            case -2 : return "Kegiatan Valid"; break;
            case -3 : return "Pembayaran Valid"; break;
            case -4 :  return "Belum di Validasi"; break;
            case 0 : return "Belum Diproses Bendahara Fakultas"; break;
            case 1 : return "Sudah Diproses Bendahara Fakultas"; break;
            case 2 : return "Sudah Dibayarkan Unsri"; break;
        }
    }

    function getRekapIndividu()
    {
        postData = $('#formTampil').serialize();   
        var button;
                
        $.ajax(
        {
           url: "<?php echo base_url();?>index.php/MainControler/getDataRekapIndividu",
           type: "GET",
           data : postData,                   
           success: function (ajaxData)
           {
                
                
                t.clear().draw();
                var result = JSON.parse(ajaxData);


                for(var i=0; i<result.length; i++)
                {
                    var texBulan = convertMonth(result[i]['bulan']);


                    textStatus = convertStatus(result[i]['status']);

                     t.row.add( [
                            i+1,
                            result[i]['bendahara'],
                            texBulan,
                            result[i]['sks_gaji'],
                            result[i]['sks_kinerja'],
                            result[i]['tarif_gaji'],
                            result[i]['tarif_kinerja'],
                            result[i]['total'],
                            result[i]['pajak'],
                            textStatus,                            
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
            url:"<?php echo base_url();?>index.php/MainControler/getDataOperatorIndividu",
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
                    url : "<?php echo base_url();?>index.php/MainControler/updateDataOperatorIndividu",
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
      
      alert(deleteData);

      $.ajax({
        url : "<?php echo base_url();?>index.php/MainControler/deleteDataOperatorIndividu",
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