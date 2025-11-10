        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?php echo base_url('assets');?>/img/profile_small.jpg" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $data['datasession']['name']; ?></strong>
                             </span> <span class="text-muted text-xs block"><?php echo $data['datasession']['role']; ?><b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">


                                <li><a href="<?php echo site_url('MainControler/logout');?>">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+t
                        </div>
                    </li>
                    <li id="home" >
                        <a href="<?php echo site_url('MainControler');?>"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
                    </li>
                    <li id="dashboard">
                        <a href="<?php echo site_url('pengajaran');?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>
                    </li>
                    <li id="entry_matakuliah">
                        <a href="<?php echo site_url('pengajaran/EntryMataKuliah');?>"><i class="fa fa-edit"></i> <span class="nav-label">Entry Mata Kuliah</span> </a>
                    </li>

                    <li id="kelaskuliah">
                        <a href="<?php echo site_url('pengajaran/EntryKelasKuliah');?>"><i class="fa fa-calendar-o"></i> <span class="nav-label">Kelas Kuliah</span> </a>
                    </li>
                    <!-- <li id="mengajar">
                        <a href="<?php// echo site_url('pengajaran/EntryKegiatanDosen');?>"><i class="fa fa-edit"></i> <span class="nav-label">Entry Dosen Mengajar</span> </a>
                    </li> -->
                    <li id="membimbing">
                        <a href="<?php echo site_url('pengajaran/EntryMembimbingTa');?>"><i class="fa fa-edit"></i> <span class="nav-label">Membimbing</span> </a>
                    </li>

                    <li id="menguji">
                        <a href="<?php echo site_url('pengajaran/EntryMengujiTa');?>"><i class="fa fa-edit"></i> <span class="nav-label">Menguji</span> </a>
                    </li>
                    <!-- <li id="membimbingpa">
                        <a href="<?php echo site_url('pengajaran/EntryLainya');?>"><i class="fa fa-edit"></i> <span class="nav-label">Lainnya</span> </a>
                    </li> -->
                    <li><a href="<?php echo site_url('MainControler/logout');?>"> <i class="fa fa-sign-out"></i> Logout</a></li>


                </ul>

            </div>
        </nav>
