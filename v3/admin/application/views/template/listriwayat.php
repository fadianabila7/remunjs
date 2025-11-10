
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Data Dosen</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Data Dosen</strong>
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
                                    <h5>Data Dosen</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-wrench"></i>
                                        </a>
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                        <div class="hr-line-dashed"></div>
                                        <form id="formTampil" onsubmit="return false;">
                                        <div class="form-group" id="data_4">
                                            <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control m-b" name="fakultas">
                                                    <option value="0">Pilih Fakultas</option>
                                                    <?php
                                                    foreach ($fakultas as $d) {
                                                        echo "<option value='".$d['id_fakultas']."''>".$d['nama']." (".$d['singkatan'].")</option>";
                                                    }
                                                ?>
                                                    
                                                </select>                                            
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control m-b" name="status">
                                                    <option value="0">Semua Status Dosen</option>
                                                    <?php
                                                        foreach($status as $s){
                                                            echo "<option value='".$s['id_status_dosen']."'>".$s['deskripsi']."</option>";
                                                        }
                                                    ?>
                                                </select>                                            
                                            </div>
                                            <div class="col-md-3">
                                                <button id="btn-submit" onclick="getRiwayat();" class="btn btn-info"><span class="fa fa-search"></span> Tampilkan</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th width="2%">No</th>
                                                    <th width="20%">NIP</th>
                                                    <th>Nama Dosen</th>
                                                    <th width="20%">Fakultas</th>
                                                    <th width="20%">Program Studi</th>
                                                    <th width="5%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>NIP</th>
                                                    <th>Nama Dosen</th>
                                                    <th>Fakultas</th>
                                                    <th>Program Studi</th>
                                                    <th>Status</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                            </button>
                            <i class="fa fa-tasks modal-icon"></i>
                            <h4 class="modal-title">Update Aktivitas Dosen</h4>
                            <small>Update Aktivitas Dosen per Bulan</small>

                        </div>
                        <div class="modal-body">
                            <div class="input-group m-b"><span class="input-group-addon">Mengajar</span>
                                <input type="text" class="form-control">
                            </div>
                            <div class="input-group m-b"><span class="input-group-addon">Penelitian</span>
                                <input type="text" class="form-control">
                            </div>
                            <div class="input-group m-b"><span class="input-group-addon">Pengabdian</span>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--End of Page Content-->

    <script>
    var postData;
    var t = $("#datatable").DataTable({
        aLengthMenu: [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
        ],
        iDisplayLength: 50
    });
    function getRiwayat()
    {

        postData = $('#formTampil').serialize();   
        $.ajax(
        {
           url: "<?php echo base_url();?>index.php/Riwayat/getDataRiwayat",
           type: "GET",
           data : postData,                   
           success: function (ajaxData)
           {
                t.clear().draw();
                var result = JSON.parse(ajaxData);
                for(var i=0; i<result.length; i++)
                {
                    t.row.add( [
                        i+1,
                        "<a href='<?php echo base_url();?>index.php/MainControler/RiwayatIndividu/"+result[i]['id_dosen']+"'>"+result[i]['nip']+"</a>",
                        result[i]['nama'],
                        result[i]['namafakultas'],
                        result[i]['namaprodi'],
                        result[i]['deskripsi']
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