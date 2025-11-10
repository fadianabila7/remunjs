
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Riwayat Golongan</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Riwayat Golongan</strong>
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
                                <h5>Tabel Riwayat Golongan Dosen</h5>
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
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table id='datatable' class="table table-striped table-bordered table-hover display dataTables-example" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>TMT</th>
                                                <th>Golongan</th>
                                                <th>PPh</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <?php 
                                                $i=1;
                                                foreach ($golongan as $gol)
                                                {
                                                    echo "<tr>";
                                                    echo "<td>".$i."</td>";
                                                    echo "<td>".$gol['tmt']."</td>";
                                                    echo "<td>".$gol['nama']."</td>";
                                                    echo "<td>".$gol['pph']."</td>";
                                                    echo "</tr>";
                                                }
                                            ?>                
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
    var t = $("#datatable").DataTable();
</script>