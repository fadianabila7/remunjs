
        <!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>Pembayaran Remunerasi</h2>
            <ol class="breadcrumb">
                <li> <a href="<?php echo site_url();?>">Home</a> </li>
                <li class="active"> <strong>Pembayaran Remunerasi</strong> </li>
            </ol>
        </div>
        <div class="col-lg-2"> </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Pembayaran Remunerasi Dosen</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-wrench"></i> </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a> </li>
                                <li><a href="#">Config option 2</a> </li>
                            </ul>
                            <a class="close-link"> <i class="fa fa-times"></i> </a>
                            <div class="hr-line-dashed"></div>
                            <form id="formTampil" onsubmit="return false;">
                                <div class="form-group" id="data_4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-control m-b" name="prodi">
                                                <option value='0'>Semua Program Studi</option>
                                                <?php 
                                                foreach ($prodi as $d) { 
                                                    echo "<option value='".$d['id_program_studi']."''>".$d[ 'id_program_studi']. " :: ".$d[ 'nama']. " (".$d[ 'singkatan']. ")</option>"; 
                                                } 
                                                ?> 
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select class="form-control m-b" name="status" required="reuqired">
                                                <?php 
                                                    foreach($status as $s){ 
                                                        echo "<option value='".$s[ 'id_status_dosen']. "'>".$s[ 'deskripsi']. "</option>"; 
                                                    } 
                                                ?> 
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <select class="form-control m-b" id="tahun" name="tahun">
                                                <option value='0'>Tahun</option>
                                                <?php 
                                                    $currentDate = date( "Y"); 
                                                    $previousDate = $currentDate-1; 
                                                    $nextDate= $currentDate+1; 
                                                    echo "<option value='".$previousDate."'>".$previousDate. "</option>"; 
                                                    echo "<option selected value='".$currentDate. "'>".$currentDate. "</option>"; 
                                                    echo "<option value='".$nextDate. "'>".$nextDate. "</option>"; 
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

                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-info btnsubmit" onclick="getDataRemun();" id="btn-submit"><span class="fa fa-search"></span>Tampilkan</button>
                                            <button class="btn btn-info" id="btn-export" onclick="ExportBPP();"><span class="fa fa-file-excel-o"></span>Cetak Daftar BPP</button>
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
                                            <th>No</th>
                                            <th>Nama Dosen</th>
                                            <th>Σ SKS Gaji dibayar</th>
                                            <th>Σ SKS Kinerja dibayar</th>
                                            <th>Tarif Gaji(Rp.)</th>
                                            <th>Tarif Kinerja(Rp.)</th>
                                            <th>Jumlah (Rp.)</th>
                                            <th>Pajak (Rp.)</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body"> </tbody>
                                </table>
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
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span> 
                        </button> 
                        <i class="fa fa-tasks modal-icon"></i>
                        <h4 class="modal-title">Edit Data Dosen</h4> 
                        <small>Edit Data Individu Dosen</small> 
                    </div>
                    <form role='form' id='formEdit' class="form-horizontal" onsubmit="return false;">
                        <div class="modal-body">
                            <input type="hidden" name="idPembayaran" id="idPembayaran">
                            <div class="form-group">
                                <label class='control-label col-md-5' for='nip'>NIP Dosen</label>
                                <div class="col-md-6 col-md-offset-1">
                                    <input id='nip-edit' class='form-control col-md-6' name="nip" disabled> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class='control-label col-md-5' for='nama'>Nama</label>
                                <div class="col-md-6 col-md-offset-1">
                                    <input disabled id='nama-edit' class='form-control' name="nama"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class='control-label col-md-5' for='bulan'>Bulan</label>
                                <div class="col-md-6 col-md-offset-1">
                                    <input disabled id='bulan-edit' class='form-control' name="bulan"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class='control-label col-md-5' for='tahun'>Tahun</label>
                                <div class="col-md-6 col-md-offset-1">
                                    <input disabled id='tahun-edit' class='form-control' name="tahun"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class='control-label col-md-5' for='belumbayar'>Σ SKS Remun belum dibayar s.d bulan ini</label>
                                <div class="col-md-6 col-md-offset-1">
                                    <input id='belumbayar-edit' class='form-control' disabled name="belumbayar"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class='control-label col-md-5' for='bayar'>Σ SKS dibayar</label>
                                <div class="col-md-6 col-md-offset-1">
                                    <input disabled id='bayar-edit' class='form-control' name="bayar"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class='control-label col-md-5' for='tarif'>Tarif (Rp.)</label>
                                <div class="col-md-6 col-md-offset-1">
                                    <input disabled id='tarif-edit' class='form-control' name="tarif"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class='control-label col-md-5' for='jumlah'>Jumlah dibayar (Rp.)</label>
                                <div class="col-md-6 col-md-offset-1">
                                    <input disabled id='jumlah-edit' class='form-control' name="jumlah">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" id='btn-update' data-dismiss="modal" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal inmodal" id="confirmProsesModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span> </button> 
                            <i class="fa fa-trash modal-icon"></i>
                        <h4 class="modal-title">Konfirmasi Proses Pembayaran Remun</h4> 
                        <small>Konfirmasi Proses Pembayaran Remun</small> 
                    </div>

                    <form role='form' id='formProsesConfirm' onsubmit="return false;">
                        <div class="modal-body"> Status Pembayaran akan diubah telah diproses. Apakah Anda yakin?
                            <input type='hidden' id='idDosen_proses' name='idDosen'>
                            <input type="hidden" id='idBayar_proses' name="idBayar"> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">No</button>
                            <button type="submit" id='btn-yes-proses' data-dismiss="modal" class="btn btn-primary">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal inmodal" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span> </button> <i class="fa fa-trash modal-icon"></i>
                        <h4 class="modal-title">Konfirmasi Pembayaran Remun</h4> <small>Konfirmasi Pembayaran Remun</small> 
                    </div>
                    <form role='form' id='formConfirm' onsubmit="return false;">
                        <div class="modal-body"> Status Pembayaran akan diubah telah ditransfer. Apakah Anda yakin?
                            <input type='hidden' id='idDosen' name='idDosen'>
                            <input type="hidden" id='idBayar' name="idBayar"> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">No</button>
                            <button type="submit" id='btn-yes' data-dismiss="modal" class="btn btn-primary">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    
    <!--End of Page Content-->
        
<script>

var postData = $('#formTampil').serialize();



var t = $("#datatable").DataTable();

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
            case 2 : return "Sudah Dibayarkan UR"; break;
        }
    }

    function getDataRemun()
    {
        postData = $('#formTampil').serialize();   
        var button;
        var textStatus;
                
        $.ajax(
        {
           url: "<?php echo base_url();?>index.php/MainControler/getDataRekapPerBulan",
           type: "GET",
           data : postData,                   
           success: function (ajaxData)
           {
                
                
                t.clear().draw();
                var result = JSON.parse(ajaxData);


                for(var i=0; i<result.length; i++)
                {
                    if(result[i]['status']==2)
                    {
                        button='x';
                    }
                    else if(result[i]['status']==1)
                    {
                        button="<a href='#' data-pid='"+result[i]['idBayar']+"' data-did='"+result[i]['nip']+"' class='fa fa-check-square-o fa-2x btn-confirm-bayar' ></a>";
                    }
                    else if(result[i]['status']==0)
                    {
                        button="<a href='#' data-pid='"+result[i]['idBayar']+"' class='fa fa-check fa-2x btn-confirm-proses' ></a>";
                    }
                    else
                    {
                        button="";
                    }

                    textStatus = convertStatus(result[i]['status']);
                    
                     t.row.add( [
                            i+1,
                            result[i]['nama_dosen'],
                            result[i]['sks_gaji'],
                            result[i]['sks_kinerja'],
                            result[i]['tarif_gaji'],
                            result[i]['tarif_kinerja'],
                            result[i]['total'],
                            result[i]['pajak'],
                            textStatus,
                            button
                        ] ).draw();
                        
                }
                
            },
            error: function(status)
            {
                t.clear().draw();
            }
        });
        
    }
    
</script>

<script>

   $('#datatable').on('click', '.btn-confirm-bayar', function(){

        var n = $(this).data('did'); 
        var p = $(this).data('pid');
        $('#idDosen').val(n);
        $('#idBayar').val(p);
        $('#confirmModal').modal('show');
      });

   $("#btn-yes").click(function(){
      
      var confirmData = $('#formConfirm').serialize();
      
      

      $.ajax({
        url : "<?php echo base_url();?>index.php/MainControler/confirmTransferRemun",
        type: "POST",
        data : confirmData,
        success: function(data,status, xhr)
        {
          //if success then just output the text to the status div then clear the form inputs to prepare for new data
         getDataRemun();
         $.notify({
                title: "<strong>Perubahan Status Pembayaran Remunerasi</strong> ",
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
                title: "<strong>Perubahan Status Pembayaran Remunerasi</strong> ",
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

   $('#datatable').on('click', '.btn-confirm-proses', function(){

        var n = $(this).data('did'); 
        var p = $(this).data('pid');
        $('#idDosen_proses').val(n);
        $('#idBayar_proses').val(p);
        $('#confirmProsesModal').modal('show');
      });

   $("#btn-yes-proses").click(function(){
      
      var confirmData = $('#formProsesConfirm').serialize();
      
      

      $.ajax({
        url : "<?php echo base_url();?>index.php/MainControler/confirmProsesRemun",
        type: "POST",
        data : confirmData,
        success: function(data,status, xhr)
        {
          //if success then just output the text to the status div then clear the form inputs to prepare for new data
         getDataRemun();
         $.notify({
                title: "<strong>Perubahan Status Pembayaran Remunerasi</strong> ",
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
                title: "<strong>Perubahan Status Pembayaran Remunerasi</strong> ",
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
      
   function ExportBPP()
    {
        postData = $('#formTampil').serialize();   
        var button;
        var textStatus;
        var download;
                
        $.ajax(
        {
           url: "<?php echo base_url();?>index.php/MainControler/ExportDaftarBPP",
           type: "GET",
           data : postData,                   
           success: function (ajaxData)
           {
                $.notify({
                    title: "<strong>Cetak Daftar BPP</strong> ",
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
                    title: "<strong>Cetak Daftar BPP</strong> ",
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