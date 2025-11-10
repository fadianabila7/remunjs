
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Daftar Kegiatan Dosen Universitas Riau</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Daftar Kegiatan Dosen</strong>
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
                                <h5>Tabel Daftar Kegiatan Dosen</h5>
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
                                                <select class="form-control m-b" name="jenis" required="required">
                                                    <option value="0">Semua Kegiatan</option>
                                                    <option value='1'>Pengajaran</option>
                                                    <option value='2'>Penelitian</option>
                                                    <option value='3'>Pengabdian</option>
                                                    <option value='4'>Penunjang</option>
                                                </select>                                            
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-info btnsubmit" onclick="getDaftarKegiatan();" id="btn-submit" ><span class="fa fa-search"></span>Tampilkan</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table id='datatable' class="table table-striped table-bordered table-hover display dataTables-example" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Bobot SKS</th>                                                
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Page Content-->

<script type="text/javascript">
    var t = $("#datatable").DataTable({"bSort":false});

    function getDaftarKegiatan()
    {
        postData = $('#formTampil').serialize();

            $.ajax(
            {
               url: "<?php echo base_url();?>index.php/KegiatanController/getDaftarKegiatan",
               type: "GET",
               data : postData,                   
               success: function (ajaxData)
               {
                    
                    
                    t.clear().draw();
                    var result = JSON.parse(ajaxData);
                    var column1, column2, column3, column4;

                    for(var i=0; i<result.length; i++)
                    {
                        column1 = result[i]['kode_kegiatan'];
                        column2 = result[i]['nama'];
                        column3 = result[i]['bobot_sks'];
                        column4 = result[i]['satuan'];
                        if(result[i]['bobot_sks']==null)
                        {
                            column1="";
                            column2 = "<strong>"+result[i]['nama']+"</strong>";
                            column3 = "";
                            column4 = "";
                        }
                        
                             t.row.add( [
                                    column1,
                                    column2,
                                    column3,
                                    column4,                                    
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