
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>List Dosen</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Riwayat Kegiatan Dosen - Individu</strong>
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
                                    <h5>Kegiatan Dosen</h5>
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
                                            <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control m-b" name="bulan">
                                                    <option>Semua Bulan</option>
                                                    <option>Januari</option>
                                                    <option>Februari</option>
                                                    <option>Maret</option>
                                                    <option>April</option>
                                                    <option>Mei</option>
                                                    <option>Juni</option>
                                                    <option>Juli</option>
                                                    <option>Agustus</option>
                                                    <option>September</option>
                                                    <option>Oktober</option>
                                                    <option>November</option>
                                                    <option>Desember</option>
                                                </select>                                            
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control m-b" name="tahun">
                                                    <option>2016</option>
                                                    <option>2015</option>                                                    
                                                </select>                                            
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-info"><span class="fa fa-search"></span>Tampilkan</button>
                                                <button class="btn btn-info"><span class="fa fa-file-excel-o"></span>Export</button>
                                            </div>
                                    </div>
                                </div>
                                <div class="ibox-content">

                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th class="col-lg-1">No</th>
                                    <th>id Operator</th>
                                    <th>Tanggal Kegiatan</th>
                                    <th>Kode Kegiatan</th>
                                    <th>Bobot SKS</th>                                    
                                    <th>SKS</th>
                                    <th>Jumlah</th>
                                    <th>Deskripsi</th>
                                    <th>No. SK/Kontrak</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="gradeX">
                                    <td>1</td>
                                    <td>Fitriyanti</td>
                                    <td>2016-01-28</td>
                                    <td>1</td>
                                    <td>0.06</td>
                                    <td>2</td>
                                    <td>0.12</td>
                                    <td><span class="fa fa-list"></td>
                                    <td>0013/UN9.1.9/PP/2016</td>
                                </tr>
                                <tr class="gradeX">
                                    <td>2</td>
                                    <td>Fitriyanti</td>
                                    <td>2016-01-28</td>
                                    <td>1</td>
                                    <td>0.06</td>
                                    <td>3</td>
                                    <td>0.18</td>
                                    <td><span class="fa fa-list"></td>
                                    <td>0013/UN9.1.9/PP/2016</td>
                                </tr>
                                <tr class="gradeX">
                                    <td>3</td>
                                    <td>septi</td>
                                    <td>2016-01-27</td>
                                    <td>1</td>
                                    <td>0.06</td>
                                    <td>2</td>
                                    <td>0.12</td>
                                    <td><span class="fa fa-list"></td>
                                    <td>0013/UN9.1.9/PP/2016</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>id Operator</th>
                                    <th>Tanggal Kegiatan</th>
                                    <th>Kode Kegiatan</th>
                                    <th>Bobot SKS</th>                                    
                                    <th>SKS</th>
                                    <th>Jumlah</th>
                                    <th>Deskripsi</th>
                                    <th>No. SK/Kontrak</th>
                                    
                                </tr>
                                </tfoot>
                                </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        </div>
                        
                


            </div>
            <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-tasks modal-icon"></i>
                                            <h4 class="modal-title">Update Aktivitas Dosen</h4>
                                            <small>Update Aktivitas Dosen per Bulan</small>
                                            
                                            
                                        </div>
                                        <div class="modal-body">                                             
                                                        <div class="input-group m-b"><span class="input-group-addon">Mengajar</span><input type="text" class="form-control"></div>
                                                        <div class="input-group m-b"><span class="input-group-addon">Penelitian</span><input type="text"  class="form-control"></div>
                                                        <div class="input-group m-b"><span class="input-group-addon">Pengabdian</span><input type="text" class="form-control"></div>                                      
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
               