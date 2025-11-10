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
    <style>
        canvas{display: block;vertical-align: bottom;}
        #particles-js {
          position: absolute;
          width: 100%; height: 100%;
          background-color: #fff;
          background-image: url("");
          background-repeat: no-repeat;
          background-size: cover;
          background-position: 50% 50%;
        }
        .count-particles{
          background: #000022;
          position: absolute;
          top: 48px; left: 0; width: 80px;
          color: #13E8E9; font-size: .8em;
          text-align: left; text-indent: 4px;
          line-height: 14px; padding-bottom: 2px;
          font-family: Helvetica, Arial, sans-serif;
          font-weight: bold;
        }
        .js-count-particles{font-size: 1.1em;}
        #stats,.count-particles{-webkit-user-select: none;}
        #stats{border-radius: 3px 3px 0 0; overflow: hidden;}
        .count-particles{border-radius: 0 0 3px 3px;}
    </style>
</head>
<body class="gray-bg" id="particles">
    <div id="particles-js"></div>
    <div>
        <div class="middle-box text-center loginscreen animated fadeInDown" style="padding-top:10px;">
            <div id="intro" style="margin-top:40%;">
                <div class="row">
                <div class="col-md-3 col-lg-3">

                </div>
                    <div class="col-md-6 col-xs-12 col-lg-6">
                        <img class="col-xs-12 col-lg-12" src="<?php echo base_url('assets');?>/img/unri.png">
                    </div>
                <div class="col-lg-3 col-md-3">

                </div>

                </div>
                <div class="row">
                <h3>Selamat Datang di Sistem Remunerasi<br>Universitas Riau</h3>
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
        <script type='text/javascript' src='<?php echo base_url('assets');?>/js/particles.min.js'></script>
        <script type='text/javascript' src='<?php echo base_url('assets');?>/js/cycle.js'></script>

    </div>
</body>
</html>
