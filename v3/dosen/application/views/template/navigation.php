        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?php echo base_url('assets');?>/img/profile_small.jpg" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $datasession['name']; ?></strong>
                             </span> <span class="text-muted text-xs block"><?php echo $datasession['namafakultas']; ?><b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="<?php echo site_url('MainControler/Profile');?>">Profile</a></li>
                                
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url('MainControler/logout');?>">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+t
                        </div>
                    </li>
                    <li class="special_link">
                        <a class="disabled"><span class="nav-label">Dosen Navigation</span></a>
                    </li>
                    <li class="divider">

                    </li>
                    <li id="home">
                        <a href="<?php echo site_url();?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>                        
                    </li>
                    <li id="bioterkini">
                        <a href="<?php echo site_url('BiodataController/BiodataTerkini');?>"><i class="fa fa-user"></i> <span class="nav-label">Biodata Terkini</span> </a>                        
                    </li>
                    <li id="riwayat">
                        <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Riwayat</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="<?php echo site_url('RiwayatController/RiwayatGolongan');?>"><i class="fa fa-list-ul"></i>Riwayat Golongan</a></li>
                            <li><a href="<?php echo site_url('RiwayatController/RiwayatPendidikan');?>"><i class="fa fa-list-ul"></i>Riwayat Pendidikan</a></li>
                            <li><a href="<?php echo site_url('RiwayatController/RiwayatFungsional');?>"><i class="fa fa-list-ul"></i>Riwayat Jabatan Fungsional</a></li>
                            <li><a href="<?php echo site_url('RiwayatController/RiwayatStruktural');?>"><i class="fa fa-list-ul"></i>Riwayat Jabatan Struktural</a></li>
                        </ul>
                    </li>
                    <li id="kelas">
                        <a href="<?php echo site_url('KegiatanController/KelasKuliah');?>"><i class="fa fa-calendar-o"></i> <span class="nav-label">Kelas Kuliah</span> </a>                        
                    </li>
                    <li id="kegiatan">
                        <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Kegiatan Dosen</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="<?php echo site_url('KegiatanController/RiwayatKegiatan/1');?>"><i class="fa fa-list-ul"></i>Riwayat - Kegiatan Pengajaran</a></li>
                            <li><a href="<?php echo site_url('KegiatanController/RiwayatKegiatan/2');?>"><i class="fa fa-list-ul"></i>Riwayat - Kegiatan Penelitian & Pengabdian</a></li>
                            <li><a href="<?php echo site_url('KegiatanController/RiwayatKegiatan/4');?>"><i class="fa fa-list-ul"></i>Riwayat - Kegiatan Penunjang</a></li>
                            <li><a href="<?php echo site_url('KegiatanController/RiwayatKegiatan/5');?>"><i class="fa fa-list-ul"></i>Riwayat - Kegiatan Tugas Tambahan Non Struktural</a></li>
                            <!-- <li><a href="<?php echo site_url('KegiatanController/RekapKegiatan');?>"><i class="fa fa-list-ul"></i>Rekapitulasi - Individu</a></li> -->
                        </ul>
                    </li>
                    <li id="rekap">
                        <a href="#"><i class="fa fa-briefcase"></i> <span class="nav-label">Rekapitulasi</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="<?php echo site_url('kegiatanController/rekapKegiatan');?>"><i class="fa fa-cubes"></i>Individu</a></li>
                                <li><a href="<?php echo site_url('mainControler/myvalidasi');?>"><i class="fa fa-check-square"></i>Validasi</a>
                                <li><a href="<?php echo site_url('mainControler/RekapPembayaran');?>"><i class="fa fa-bank"></i>Pembayaran</a>
                            </ul>                        
                    </li>
                    <li id="help">
                        <a href="#"><i class="fa fa-question"></i> <span class="nav-label">Help </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="<?php echo site_url('KegiatanController/DaftarKegiatan');?>"><i class="fa fa-list-ul"></i>Daftar Kegiatan</a></li>                            
                            <li><a href="<?php echo site_url('KegiatanController/Update');?>"><i class="fa fa-book"></i>Note Update</a></li>                            
                        </ul>
                    </li>
                    <?php
                        if(isset($menuextend)){
                            print_r($menuextend);
                        }
                    ?>
                </ul>

            </div>
        </nav>