 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Remunerasi Unri System</title>

    <!-- Bootstrap core CSS -->
    <link href="assetlanding/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="assetlanding/css/animate.css" rel="stylesheet">
    <link href="assetlanding/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assetlanding/css/style.css" rel="stylesheet">
</head>
<body id="page-top" class="landing-page">
<div id="welcome" class="container services" >
    <div class="row">
        <div class="col-lg-12 wow fadeInUp">
            <div class="col-lg-12 wow fadeInUp">
            <div class="col-md-5 col-lg-5">

            </div>
            <div class="col-md-2 col-lg-2 col-xs-12">
                <img src="assetlanding/img/unri.png" class="col-md-12 col-lg-12 col-xs-12">
            </div>
            <div class="col-md-5 col-lg-5">
                
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center wow fadeInLeft">
            <h1>Welcome to Remunerasi Universitas Riau
    </div>
    
</div>

<section id="type" class="container services">
    <div class="row">
        
            <div class="col-lg-3">            
            <a href="admin">
                <div class="widget style1 navy-bg">
                    <div class="row">

                        <div class="col-xs-4">
                            <i class="fa fa-sign-in fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <h2 class="font-bold">Admin Fakultas</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">            
            <a href="bpp">
                <div class="widget style1 navy-bg">
                    <div class="row">

                        <div class="col-xs-4">
                            <i class="fa fa-sign-in fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <!-- <span> Today degrees </span> -->
                            <h2 class="font-bold">BPP</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">            
            <a href="Operator">
                <div class="widget style1 navy-bg">
                    <div class="row">

                        <div class="col-xs-4">
                            <i class="fa fa-sign-in fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <!-- <span> Today degrees </span> -->
                            <h2 class="font-bold">Operator</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">            
            <a href="dosen">
                <div class="widget style1 navy-bg">
                    <div class="row">

                        <div class="col-xs-4">
                            <i class="fa fa-sign-in fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <!-- <span> Today degrees </span> -->
                            <h2 class="font-bold">Dosen</h2>
                        </div>
                    </div>
                </div>
            </a>
            </div>
        
    </div>    
</section>



<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Contact Us</h1>
                <!-- <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p> -->
            </div>
        </div>
        <div class="row m-b-lg">
            <div class="col-lg-3 col-lg-offset-3">
                <address>
                    <strong><span class="navy">Universitas Riau</span></strong><br/>
                    Kampus Bina Widya, Jl. HR Subantas KM 12.5, Simpang Baru, Tampan, <br/>
                    Pekanbaru, Riau 28293<br/>
                    <!-- <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                </address>
            </div>
            <!-- <div class="col-lg-4">
                <p class="text-color">
                    Fully Developed By Universitas Riau,
                </p>
            </div> -->
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="mailto:adminremun@unri.ac.id" class="btn btn-primary">Send us mail</a>
                <p class="m-t-sm">
                    Or follow us on social platform
                </p>
                <ul class="list-inline social-icon">
                    <li><a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                <p><strong>Kolaborasi antara Universitas Sriwijaya dan Universitas Riau, 2017</strong><br/> </p>
            </div>
        </div>
    </div>
</section>

<!-- Mainly scripts -->
<script src="assetlanding/js/jquery-2.1.1.js"></script>
<script src="assetlanding/js/bootstrap.min.js"></script>
<script src="assetlanding/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="assetlanding/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="assetlanding/js/inspinia.js"></script>
<script src="assetlanding/js/plugins/pace/pace.min.js"></script>
<script src="assetlanding/js/plugins/wow/wow.min.js"></script>


<script>

    $(document).ready(function () {

        $('body').scrollspy({
            target: '.navbar-fixed-top',
            offset: 80
        });

        // Page scrolling feature
        $('a.page-scroll').bind('click', function(event) {
            var link = $(this);
            $('html, body').stop().animate({
                scrollTop: $(link.attr('href')).offset().top - 50
            }, 500);
            event.preventDefault();
            $("#navbar").collapse('hide');
        });
    });

    var cbpAnimatedHeader = (function() {
        var docElem = document.documentElement,
                header = document.querySelector( '.navbar-default' ),
                didScroll = false,
                changeHeaderOn = 200;
        function init() {
            window.addEventListener( 'scroll', function( event ) {
                if( !didScroll ) {
                    didScroll = true;
                    setTimeout( scrollPage, 250 );
                }
            }, false );
        }
        function scrollPage() {
            var sy = scrollY();
            if ( sy >= changeHeaderOn ) {
                $(header).addClass('navbar-scroll')
            }
            else {
                $(header).removeClass('navbar-scroll')
            }
            didScroll = false;
        }
        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }
        init();

    })();

    // Activate WOW.js plugin for animation on scrol
    new WOW().init();

</script>

</body>
</html>
