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
                                <li><a href="#">Profile</a></li>
                                
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url('MainControler/logout');?>">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+t
                        </div>
                    </li>
                    <li id="home">
                        <a href="<?php echo base_url(); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>                        
                    </li>
                    <li id="dosen">
                        <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Pembayaran Remun</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="<?php echo site_url('MainControler/PembayaranRemunerasi');?>"><i class="fa fa-list-ul"></i> Validasi dan Entry</a></li>
                            <li><a href="<?php echo site_url('MainControler/RekapRemun');?>"><i class="fa fa-plus"></i>Rekapitulasi Bulanan</a></li>
                        </ul>
                    </li>
                    <li id="sptjm">
                        <a href="<?php echo site_url('MainControler/SPTJM'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Cetak SPTJM</span> </a>                        
                    </li>
                    
                </ul>

            </div>
        </nav>