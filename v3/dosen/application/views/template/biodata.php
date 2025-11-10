
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
                            <strong>Daftar Dosen</strong>
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
                                <h5>Biodata Terkini</h5>
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
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td><?php echo $dosen[0]['nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>NIP/NIPUS</td>
                                            <td>:</td>
                                            <td><?php echo $dosen[0]['nip']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Fakultas/Program Studi</td>
                                            <td>:</td>
                                            <td><?php echo $dosen[0]['namafakultas']." / ".$dosen[0]['namaprodi']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status PNS/Non PNS</td>
                                            <td>:</td>
                                            <td><?php echo $dosen[0]['deskripsi']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Golongan</td>
                                            <td>:</td>
                                            <td><?php if(count($golongan)>0)echo $golongan[0]['nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Pendidikan Tertinggi</td>
                                            <td>:</td>
                                            <td><?php if(count($pendidikan)>0)echo $pendidikan[0]['singkatan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan Fungsional</td>
                                            <td>:</td>
                                            <td><?php if(count($fungsional))echo $fungsional[0]['nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan Struktural</td>
                                            <td>:</td>
                                            <td><?php if(count($struktural))echo @$struktural[0]['nama']; else echo @$struktural['nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><tab>Deskripsi Jab. Struktural</tab></td>
                                            <td>:</td>
                                            <td><?php if(count($struktural))echo @$struktural[0]['deskripsi']; else echo @$struktural['deskripsi'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>