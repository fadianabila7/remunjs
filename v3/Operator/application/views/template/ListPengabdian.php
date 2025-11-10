
        <!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>Daftar Pengabdian Kepada Masyarakat</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url();?>">Home</a>
                </li>
                <li class="active">
                    <strong>Daftar Pengabdian Kepada Masyarakat</strong>
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
                            <h5>Pengabdian Kepada Masyarakat</h5>
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
                                <div class="form-group" id="data_4">
                                <div class="row">
                                <form id="formTampil" onsubmit="return false;">
                                    <div class="col-md-2">
                                        <select class="form-control m-b" name="bulan" required="required">
                                            <option value="0">Semua Bulan</option>
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
                                                $lowerDate = 2016;
                                                $currentDate = date('Y');
                                                $previousDate = $currentDate-1;

                                                for($i = $currentDate; $i>$lowerDate; $i--)
                                                {
                                                    if($i==$currentDate)
                                                    {
                                                        echo "<option selected>".$i."</option>";        
                                                    }
                                                    else
                                                    {
                                                        echo "<option>".$i."</option>";        
                                                    }
                                                }
                                            ?>
                                        </select>                                            
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-info btnsubmit" onclick="getDataSKBulanTahun();" id="btn-submit" ><span class="fa fa-search"></span>Tampilkan</button>
                                        
                                        <button class="btn btn-info"><span class="fa fa-file-excel-o"></span>Export</button>
                                        </form>
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
                                <th>No SK Kontrak</th>
                                <th>Tanggal SK</th>
                                <th>Judul Kegiatan</th>
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
        <!---------------------- View Modal -------------------------------------- -->
        <div class="modal inmodal" id="editModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-tasks modal-icon"></i>
                        <h4 class="modal-title">Detail Pengabdian</h4>
                        <small>Detail Pengabdian Kepada Masyarakat</small>
                        
                        
                    </div>
                    <form role='form' class="form-horizontal" id='formEdit' onsubmit="return false;">
                    <div class="modal-body">                                             
                        <h3>Detail Pengabdian Kepada Masyarakat</h3>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label for="judul_keg" class="col-md-3 control-label">Nama Kegiatan</label>
                            <div class="input-group col-md-6">
                                <input class="form-control" id="judul_keg_modal" type="text" name="judul_keg" required>
                            </div>
                        </div>

                         <div class="form-group" id="tmtdate">
                                                <label class="control-label col-md-3">Tanggal Kegiatan *</label>
                                                <div class="input-group date col-md-6">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="tgl_keg_modal" name="tgl_keg" required>
                                                </div>
                                            </div>


                       <!--  <div class="form-group">
                            <label for="tgl_keg" class="col-md-3 control-label">Tanggal Kegiatan</label>
                            <div class="col-md-6">
                                <input class="form-control" id="tgl_keg_modal" type="text" name="tgl_keg" required>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="no_sk" class="col-md-3 control-label">No SK</label>
                            <div class="input-group col-md-6">
                                <input class="form-control" id="no_sk_modal" type="text" name="no_sk" required>
                            </div>
                        </div>

                         <div class="form-group" id="tmtdate">
                                                <label class="control-label col-md-3">Tanggal SK *</label>
                                                <div class="input-group date col-md-6">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="tgl_sk_modal" name="tgl_sk" required>
                                                </div>
                                            </div>
                       <!--  <div class="form-group">
                            <label for="tgl_sk" class="col-md-3 control-label">Tanggal SK</label>
                            <div class="col-md-6">
                                <input class="form-control" id="tgl_sk_modal" type="text" name="tgl_sk" required>
                            </div>
                        </div> -->
                        
                        <div class="hr-line-dashed"></div>
                        <h3>Data Peserta Pengabdian</h3>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="table-responsive">
                                <table id='datatable-modal' class="table table-striped table-bordered table-hover responsive display dataTables-example" width="100%" cellspacing="0">
                                    <thead>
                                       <tr>
                                           <th>
                                               No
                                           </th>
                                           <th>
                                               Nama
                                           </th>
                                           <th>
                                               NIP/NIPUS/NIDN
                                           </th>
                                           <th>
                                               Kode Kegiatan
                                           </th>
                                           <th>
                                               Action
                                           </th>
                                       </tr>
                                    </thead>
                                    <tbody id="tabel-modal-body">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>                                                                     
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" id='btn-update' onclick="updatePengabdian();" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-------------------------------------------------------- Delete Modal ------------------------- -->

        <div class="modal inmodal" id="hapusModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-trash modal-icon"></i>
                        <h4 class="modal-title">Hapus Data Pengabdian</h4>
                        <small>Konfirmasi Hapus Data Pengabdian</small>
                        
                        
                    </div>
                    <form role='form' id='formHapus' onsubmit="return false;">
                    <div class="modal-body">                                             
                    
                        Apakah anda yakin ingin menghapus data ini ?
                        <input type='hidden' id='no_sk_modal_hapus' name='no_sk'>
                                                                                                                
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-white" data-dismiss="modal">Cancel</button>
                        <button type="submit" id='btn-delete' data-dismiss="modal" onclick="deleteSK();" class="btn btn-danger">Delete</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
            

        
        <!--End of Page Content-->
        
<script>
var tabel = $("#datatable").DataTable();
var tabelModal = $("#datatable-modal").DataTable();

var postData = $('#formTampil').serialize();
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

    function getDataSKBulanTahun()
    {
         
        
        $('#formTampil').validate({

        //var postData = $('#demo-form2').serialize();
        
      
            submitHandler: function(form) {

                postData = $(form).serialize();

                $.ajax(
            {
               url: "<?php echo base_url();?>index.php/pengabdian/getDataPengabdianBulanTahun",
               type: "GET",
               data : postData,                   
               success: function (ajaxData)
               {
                    
                    
                    tabel.clear().draw();

                    var buttondetail = '';
                    var buttondelete='';
                    var result = JSON.parse(ajaxData);
                    
                    for(var i=0; i<result.length; i++)
                    {  
                        var id_kegiatan = "'"+result[i]['id_kegiatan']+"'";
                           buttondetail = '<button class="btn btn-info" onclick="detailSK('+"'"+result[i]['no_sk']+"'"+');"><span class="fa fa-eye"></span></button>';
                        buttondelete = '<button class="btn btn-danger" onclick="deleteSK('+id_kegiatan+');"><span class="fa fa-trash"></span></button>';
                         tabel.row.add( [
                                i+1,                                
                                result[i]['no_sk'],
                                result[i]['tgl_sk'],
                                result[i]['judul_keg'],                                
                                buttondetail +" "+ buttondelete                                
                            ] ).draw();
                       
                        
                        //grandtotalsks =  parseFloat(grandtotalsks)+ parseFloat(result[i]['totalsks']);
                        //grandtotalskslebih =  parseFloat(grandtotalskslebih) +  parseFloat(result[i]['lebihsks']);
                        //grandtotalsksbayar =  parseFloat(grandtotalsksbayar) +  parseFloat(result[i]['lebihsksbayar']);
                        //grandtotalsisasks =  parseFloat(grandtotalsisasks) +  parseFloat(result[i]['sisasksbayar']);
                    }
                    
                },
                error: function(status)
                {
                    tabel.clear().draw();
                }
        });


            }

        });
                
        
        
    }
function updatePengabdian()
    {
       
        
        $('#formEdit').validate({

            submitHandler: function(form) {
 
                postData = $(form).serialize();

                $.ajax(
                {
                   url: "<?php echo base_url();?>index.php/Pengabdian/updatePengabdian",
                   type: "POST",
                   data : postData,                   
                   success: function (ajaxData)
                   {

                        $('#editModal').modal('hide');

                        $.notify({
                            title: "<strong>Update Data Pengabdian</strong> ",
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
                    error: function(status)
                    {
                        $('#editModal').modal('hide');

                        $.notify({
                            title: "<strong>Update Data Pengabdian</strong> ",
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

        });
    }
   function detailSK(noSK)
    {        
        
        
        $.ajax(
        {
               url: "<?php echo base_url();?>index.php/pengabdian/getDataPengabdian",
               type: "GET",
               data : {noSK:noSK},                   
               success: function (ajaxData)
               {    
                    
                        tabelModal.clear().draw();
                    

                    var buttondetail = '';
                    var result = JSON.parse(ajaxData);
                    var kode = '';

                    $('#no_sk_modal').val(noSK);
                    $('#tgl_sk_modal').val(result[0]['tgl_sk']);
                    $('#judul_keg_modal').val(result[0]['judul_keg']);
                    $('#tgl_keg_modal').val(result[0]['tgl_keg']);


                        for(var i=0; i<result.length; i++)
                        {  
                            buttondetail = '<button class="btn btn-danger"><span class="fa fa-trash"></span></button>';
                            kode = "<a href='#' data-toggle='tooltip' data-placement='bottom' title='"+result[i]['nama_keg']+"'>"+result[i]['kode_keg']+"</a>";
                            inputNip = '<input type="hidden" id="nip'+i+'" name = "nip[]" value="'+result[i]['nip']+'">';
                            console.log(i+","+result[i]['nama_dosen']);
                            tabelModal.row.add( [
                                    i+1,                                
                                    result[i]['nama_dosen'],
                                    result[i]['nip']+inputNip,
                                    kode,
                                    buttondetail                                
                                ] ).draw();

                            //var row = "<tr><td>"+(i+1)+"</td><td>"+result[i]['nama_dosen']+"</td><td>"+result[i]['nip']+"</td><td>"+kode+"</td><kd>"+buttondetail+"</kd></tr>";
                            //$("#tabel-modal-body").append(row);
                        }

                    $('#editModal').modal('show');
                    
                   $('#editModal').on('shown.bs.modal', function() {                        
                        tabelModal.columns.adjust().responsive.recalc();
                        
                    });

                    
                },
                error: function(status)
                {
                    tabelModal.clear().draw();
                }
        });
    }


    $('#datatable').on('click','.btn-delete',function(){
        var n = $(this).data('nosk');       
        $('#no_sk_modal_hapus').val(n);
        $('#hapusModal').modal('show');
    });
    $('#tmtdate .input-group.date').datepicker({
                todayBtn: 'linked',
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                     format: "yyyy-mm-dd"
            })

    function deleteSK(id_kegiatan)
    {
          swal({
        title: "Apakah Anda Yakin?",
        text: "Anda tidak bisa mengembalikan lagi data ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Hapus!",
        closeOnConfirm: false
    }, function () {
        
    

        var deleteData = $('#formHapus').serialize();
        $.ajax({

            url: "<?php echo base_url();?>index.php/pengabdian/deleteData",
            type: "POST",
            data : {id_kegiatan:id_kegiatan},                   
            success: function (ajaxData)
            {
                swal("Dihapus!", "Data berhasil dihapus.", "success");
            },
            error: function(status)
            {
               swal("Gagal!", "Data Gagal dihapus.", "failed");
            }
        })   

        });
    }

    
      

 </script>