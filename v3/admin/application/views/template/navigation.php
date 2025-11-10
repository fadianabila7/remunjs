		<nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
					<div class="dropdown profile-element">
						<span>
					      <img alt="image" class="img-circle" src="<?php echo base_url('assets');?>/img/profile_small.jpg" />
					    </span>
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<span class="clear"> 
					          <span class="block m-t-xs"> 
					            <strong class="font-bold"><?php echo $datasession['name']; ?></strong>
					          </span>
					          <span class="text-muted text-xs block">
					            <?php echo $datasession['namafakultas']; ?><b class="caret"></b>
					          </span>
							</span>
						</a>
						<ul class="dropdown-menu animated fadeInRight m-t-xs">
							<li>
								<a href="<?php echo site_url('MainControler/Profile');?>">Profile</a>
							</li>
							<li class="divider"></li>
							<li><a href="<?php echo site_url('MainControler/logout');?>">Logout</a>
							</li>
						</ul>
					</div>	
                        <div class="logo-element">
                            UNRI 
                        </div>
                    </li>
                    <li id="home">
                        <a href="<?php echo site_url('MainControler');?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>                        
                    </li>
	                    <?php
	                    if($datasession['idFakultas']==0){ 
	                    	echo '<li id="riwayat">
		                        <a href="'. site_url('MainControler/DataRiwayat') .'"><i class="fa fa-institution"></i> <span class="nav-label">Entry Riwayat Dosen</span></a>                   
		                    </li>
		                    <li id="dosen">
		                        <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Dosen</span><span class="fa arrow"></span></a>
		                        <ul class="nav nav-second-level collapse">
		                            <li><a href="'. site_url('MainControler/DataDosen').'"><i class="fa fa-list-ul"></i> Tabel Data Dosen</a></li>
		                            <li><a href="'. site_url('MainControler/RegistrasiDosen').'"><i class="fa fa-plus"></i>Registrasi Dosen</a></li>
		                        </ul>
		                    </li>';
	                    }else{
	                    ?>
	                    
		                    <li id="operator">
		                        <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Operator</span><span class="fa arrow"></span></a>
		                        <ul class="nav nav-second-level collapse">
		                            <li><a href="<?php echo site_url('MainControler/DataOperator');?>"><i class="fa fa-list-ul"></i>Tabel Data Operator</a></li>
		                            <li><a href="<?php echo site_url('MainControler/RegistrasiOperator');?>"><i class="fa fa-plus"></i>Registrasi Operator</a></li>
		                        </ul>
		                    </li>
		                    <!-- <li id="riwayat">
		                        <a href="<?php echo site_url('MainControler/DataRiwayat');?>"><i class="fa fa-institution"></i> <span class="nav-label">Entry Riwayat Dosen</span></a>    
		                    </li> -->
		                    <li id="kegiatan">
		                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Kegiatan Dosen</span><span class="fa arrow"></span></a>
		                        <ul class="nav nav-second-level collapse">
		                            <li><a href="<?php echo site_url('MainControler/RekapRemunIndividu');?>">Rekap per Individu</a></li>
		                        </ul>
		                        <ul class="nav nav-second-level collapse">
		                            <li><a href="<?php echo site_url('MainControler/ValidasiWD1');?>">Rekap per Fakultas</a></li>
		                        </ul>
		                    </li>
		                    <li id="penunjang">
		                        <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Bidang Penunjang</span><span class="fa arrow"></span></a>
		                        <ul class="nav nav-second-level collapse">
		                            <li>
		                                <a href="<?php echo site_url('Penunjang/EntrySK');?>">Entry Surat Keputusan</a>
		                            </li>
		                            <li>
		                                <a href="<?php echo site_url('Penunjang/ListSK');?>">List Surat Keputusan</a>
		                            </li>
		                        </ul>
		                    </li>
		                    <li id="tambahan">
		                        <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Tugas Tambahan Non Struktural</span><span class="fa arrow"></span></a>
		                        <ul class="nav nav-second-level collapse">
		                            <li>
		                                <a href="<?php echo site_url('Tambahan/EntrySK');?>">Entry Surat Keputusan</a>
		                            </li>
		                            <li>
		                                <a href="<?php echo site_url('Tambahan/ListSK');?>">List Surat Keputusan</a>
		                            </li>
		                        </ul>
		                    </li>
	                	<?php } ?>

                    <li id="exit" style="border-left: 4px solid #ed5565;">
                        <a href="<?php echo site_url('MainControler/logout');?>"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>                   
                    </li>
                </ul>

            </div>
        </nav>
<script type="text/javascript">
    var page = "<?php echo @$page; ?>";
    var pagestring = "#"+page;
    $(pagestring).addClass('active');
</script>