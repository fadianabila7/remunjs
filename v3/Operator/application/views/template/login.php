<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Remunerasi | Admin Page</title>

    <link href="<?php echo base_url('assets');?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets');?>/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url('assets');?>/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url('assets');?>/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div class="row">
            <div class="col-md-3 col-lg-3">

            </div>
                <div class="col-md-6 col-xs-12 col-lg-6">
                <h1 class="logo-name"><img class="col-xs-12 col-lg-12" src="<?php echo base_url('assets');?>/img/unri.png"></h1>
                </div>
            <div class="col-lg-3 col-md-3">

            </div>

            </div>
            <div class="row">
            <h3>Selamat Datang di Sistem Remunerasi Universitas Riau</h3>
            <h2>Operator Login</h2>
            </div>
            
           <!-- <form class="m-t" role="form" method="post" action="<?php //echo site_url('MainControler/loginverifikasi');?>">-->
           <?php echo validation_errors(); ?>
            <?php echo form_open('VerifyLogin'); ?>
            <form>
                <div class="form-group">
                    <input  class="form-control" name="username" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
               
            </form>
            <p class="m-t"> <small>Universitas Riau &copy; 2017</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url('assets');?>/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url('assets');?>/js/bootstrap.min.js"></script>

</body>

</html>
