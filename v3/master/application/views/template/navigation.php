<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?php echo base_url('assets');?>/img/profile_small.jpg" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $datasession['name']; ?></strong>
                             </span> <span class="text-muted text-xs block">Administrator<b class="caret"></b></span> </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="<?php echo site_url('MainControler/Profile');?>">Profile</a>
                        </li>

                        <li class="divider"></li>
                        <li><a href="<?php echo site_url('MainControler/logout');?>">Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+t
                </div>
            </li>
            <li id="home">
                <a href="<?php echo site_url('MainControler');?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>
            </li>
            <?php if($datasession['name']=="root"){ ?>
                <li id="admin">
                    <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Admin Fakultas</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo site_url('MainControler/DataAdmin');?>"><i class="fa fa-list-ul"></i> Tabel Data Admin</a>
                        </li>
                        <li><a href="<?php echo site_url('MainControler/RegistrasiAdmin');?>"><i class="fa fa-plus"></i>Registrasi Admin</a>
                        </li>
                    </ul>
                </li>
                
                <li id="bendahara">
                    <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Bendahara Fakultas</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo site_url('MainControler/DataBendahara');?>"><i class="fa fa-list-ul"></i> Tabel Data Bendahara</a>
                        </li>
                        <li><a href="<?php echo site_url('MainControler/RegistrasiBendahara');?>"><i class="fa fa-plus"></i>Registrasi Bendahara</a>
                        </li>
                    </ul>
                </li>

                <li id="Jurusan">
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Jurusan dan Prodi</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo site_url('TambahanController/Jurusan');?>"><i class="fa fa-list-alt"></i>Jurusan</a></li>
                        <li><a href="<?php echo site_url('TambahanController/Prodi');?>"><i class="fa fa-list-alt"></i>Prodi</a></li>
                    </ul>
                </li>

                <li id="reportI">
                    <a href="<?php echo site_url('WRController/RekapKegiatan');?>"><i class="fa fa-list"></i> <span class="nav-label">WR I Navigation </span></a>
                </li>
                <li id="reportII">
                	<a href="#"><i class="fa fa-money"></i> <span class="nav-label">WR II Navigation</span><span class="fa arrow"></span></a>
					 <ul class="nav nav-second-level collapse">
                    	<li><a href="<?php echo site_url('WRController/RekapRemun');?>"> <span class="nav-label">SKSR ke Rupiah</span></a></li>
                    	<li><a href="<?php echo site_url('WRController/SisaSKSR');?>"> <span class="nav-label">SKSR SISA</span></a></li>
                    </ul>

                </li>
                <li id="reportII">
                    <a href="<?php echo site_url('TambahanController/Perbaikan');?>"><i class="fa fa-list"></i> <span class="nav-label">Perbaikan Data</span></a>
                </li>
            <?php }else{ ?>
                <li id="reportII">
                    <a href="<?php echo site_url('WRController/RekapRemun');?>"><i class="fa fa-list"></i> <span class="nav-label">Rekap Keuangan</span></a>
                </li>
            <?php } ?>
        </ul>

    </div>
</nav>
<script type="text/javascript">
    var page = "<?php echo @$page; ?>";
    var pagestring = "#" + page;
    $(pagestring).addClass('active');
</script>