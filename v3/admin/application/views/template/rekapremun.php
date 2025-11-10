
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Rekap Remunisasi Individu</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Rekap Remunisasi</strong>
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
                                    <h5>Rekap Remunisasi Individu</h5>
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

                                                <input id="namadosen" placeholder="Nama Dosen" autofocus data-validate-length-range="30" data-validate-words="2" class='form-control m-b' type="text" required="required" name='namadosen'>
                                                <input id="nip" name="nip" type="hidden">
                                              <!-- <select class="form-control m-b" name="dosen">
                                                
                                                <?php
                                                //$i=1;
                                                  //  foreach ($dosen as $d) {
                                                    //    echo "<option value='".$d['id_dosen']."''>".$i.".".$d['nama']."</option>";
                                                      //  $i++;
                                                 //   }
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
                                                    
                                                <!--</select>                                            -->
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-control m-b" name="bulan" required="required">
                                                    <option value="">Sampai Bulan...</option>
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
                                                        $previousDate = $currentDate-1;

                                                        echo "<option>".$previousDate."</option>";
                                                        echo "<option selected>".$currentDate."</option>";
                                                    ?>
                                                </select>                                            
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-info btnsubmit" onclick="getRekapIndividu();" id="btn-submit" ><span class="fa fa-search"></span> Tampilkan</button>
                                                </form>
                                                <button class="btn btn-info"><span class="fa fa-file-excel-o"></span> Export</button>
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
                                        <th>Bulan</th>
                                        <th>Jab. Struktural</th>
                                        <th>Total SKS (A)</th>
                                        <th>Σ SKS Gaji (B)</th>
                                        <th>Σ SKS Kinerja (C)</th>
                                        <th>Σ Sisa SKS (D)</th>

                                        
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
                                                    <?php
                                                    foreach ($prodi as $d) {
                                                        echo "<option value='".$d['id_program_studi']."'>".$d['nama']." (".$d['singkatan'].")</option>";
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class='control-label' for='status'>Status</label>
                                                <select class="form-control" id='status-edit' name='status'>                                                    
                                                    <?php
                                                    foreach($status as $s)
                                                        {
                                                            echo "<option value='".$s['id_status_dosen']."'>".$s['deskripsi']."</option>";
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
                                            <input type='hidden' id='idDosen' name='idDosen'>
                                                                                                                                    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  class="btn btn-white" data-dismiss="modal">Cancel</button>
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
           url: "<?php echo base_url();?>index.php/Dosen/getDataDosenByFakultas",
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

var postData = $('#formTampil').serialize();



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

    function getRekapIndividu()
    {
         
        
        $('#formTampil').validate({

        //var postData = $('#demo-form2').serialize();
        
      
            submitHandler: function(form) {

                postData = $(form).serialize();

                $.ajax(
            {
               url: "<?php echo base_url();?>index.php/MainControler/getDataRekapIndividu",
               type: "GET",
               data : postData,                   
               success: function (ajaxData)
               {
                    
                    
                    t.clear().draw();
                    var result = JSON.parse(ajaxData);
                    var grandtotalsks=0;
                    var grandtotalskslebih=0;
                    var grandtotalsksbayar=0;
                    var grandtotalsisasks=0;

                    for(var i=0; i<result.length; i++)
                    {
                        var textbulan = convertMonth(result[i]['bulan']);
                        if(textbulan!=null)
                        {
                             t.row.add( [
                                    i+1,
                                    textbulan,
                                    "<a href='#' data-toggle='tooltip' data-placement='Right' title='SKS Tugas Tambahan = "+result[i]['skstt']+"'>"+result[i]['struktural']+"</a>",
                                    result[i]['totalsks'],
                                    result[i]['sksgaji'],
                                    result[i]['skskinerja'],
                                    result[i]['sisasks'],
                                    
                                ] ).draw();
                        }
                        else
                        {
                            t.row.add( [
                                    i+1,
                                    textbulan,
                                    result[i]['struktural'],
                                    result[i]['totalsks'],
                                    result[i]['sksgaji'],
                                    result[i]['skskinerja'],
                                    result[i]['sisasks']
                                    
                                ] ).draw();
                        }
                        
                        //grandtotalsks =  parseFloat(grandtotalsks)+ parseFloat(result[i]['totalsks']);
                        //grandtotalskslebih =  parseFloat(grandtotalskslebih) +  parseFloat(result[i]['lebihsks']);
                        //grandtotalsksbayar =  parseFloat(grandtotalsksbayar) +  parseFloat(result[i]['lebihsksbayar']);
                        //grandtotalsisasks =  parseFloat(grandtotalsisasks) +  parseFloat(result[i]['sisasksbayar']);
                    }
                    
                },
                error: function(status)
                {
                    t.clear().draw();
                }
        });


            }

        });
                
        
        
    }

    $('#datatable').on('click', '.btn-edit', function(){

        var n = $(this).data('did');
        $.ajax(
        {
            url:"<?php echo base_url();?>index.php/MainControler/getDataDosenIndividu",
            type:"GET",
            data : {nip:n},
            success: function (ajaxData)
           {
                var result = JSON.parse(ajaxData);
                //$('#prodi-edit option:selected').removeAttr('selected');
                //$('#status-edit option:selected').removeAttr('selected');

                $("#nip-edit").val(result[0]['nip']);
                $("#nama-edit").val(result[0]['nama']);
                $("#norek-edit").val(result[0]['no_rekening']);
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
                $("#status-edit").val(result[0]['id_status_dosen']);
                
                $('#editModal').modal('show');
           }
        });
        

      });
    
    $('#btn-update').click(function(){

        $('#editModal').modal('hide');
                var updateData = $("#formEdit").serialize();
                
                  $.ajax({
                    url : "<?php echo base_url();?>index.php/MainControler/updateDataDosenIndividu",
                    type: "POST",
                    data : updateData,
                    success: function(data,status, xhr)
                    {
                      //if success then just output the text to the status div then clear the form inputs to prepare for new data
                     
                    getDosen();
                     $.notify({
                            title: "<strong>Update Data Dosen </strong> ",
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
                            title: "<strong>Tambah Stock: </strong> ",
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
        $('#idDosen').val(n);
        $('#hapusModal').modal('show');
      });

   $("#btn-delete").click(function(){
      
      var deleteData = $('#formHapus').serialize();
      
      

      $.ajax({
        url : "<?php echo base_url();?>index.php/MainControler/deleteDataDosenIndividu",
        type: "POST",
        data : deleteData,
        success: function(data,status, xhr)
        {
          //if success then just output the text to the status div then clear the form inputs to prepare for new data
         getDosen();
         $.notify({
                title: "<strong>Hapus Data Dosen: </strong> ",
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
                title: "<strong>Hapus Data Dosen: </strong> ",
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