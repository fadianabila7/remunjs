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
                    <li id="home">
                        <a href="<?php echo site_url('MainControler');?>"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>                      
                    </li>
                    <li id="dashboard" class="active">
                        <a href="<?php echo site_url('Penelitian');?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>                      
                    </li>
                    <li id="PenelitianMandiri">
                        <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Data Penelitian/Pengabdian</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo site_url('penelitian/EntryPenelitianMandiri');?>">Entry Penelitian/Pengabdian</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('penelitian/ListPenelitianMandiri');?>">List Penelitian/Pengabdian</a>
                            </li>
                        </ul>    
                    </li>
                    <li><a href="<?php echo site_url('MainControler/logout');?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                   <!--  <li id="PenelitianAPBN">
                        <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Penelitian Dibiayai</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php //echo site_url('penelitian/EntryPenelitianApbn');?>">Entry Penelitian Dibiayai</a>
                            </li>
                            <li>
                                <a href="<?php //echo site_url('penelitian/ListPenelitianApbn');?>">List Penelitian Dibiayai</a>
                            </li>
                        </ul>    
                    </li> -->
                </ul>

            </div>
        </nav>
        <script type="text/javascript">
            var page = "<?php echo $data['page']; ?>";
            var pagestring = "#"+page;
            $(pagestring).addClass('active');
        </script>