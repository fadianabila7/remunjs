<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Remunerasi | Admin Page</title>
    <link href="<?php echo base_url('assets'); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets'); ?>/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url('assets'); ?>/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url('assets'); ?>/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div class="row">
                <div class="col-md-3 col-lg-3">

                </div>
                <div class="col-md-6 col-xs-12 col-lg-6">
                    <h1 class="logo-name"><img class="col-xs-12 col-lg-12" src="<?php echo base_url('assets'); ?>/img/unri.png"></h1>
                </div>
                <div class="col-lg-3 col-md-3">

                </div>

            </div>
            <div class="row">
                <h3>Selamat Datang di Sistem Remunerasi Universitas Riau</h3>
                <h2>Operator Login</h2>
            </div>
            <!-- <form class="m-t" role="form" method="post" action="<?php //echo site_url('MainControler/loginverifikasi');
                                                                        ?>">-->
            <?php echo validation_errors(); ?>
            <form id="logForm" class="kt-form" method="post" onsubmit="return false;">
                <div class="form-group">
                    <input class="form-control" name="username" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required="">
                </div>

                <div class="form-group row">
                    <div class="col-md-3 col-xs-3" style="padding:0px;"></div>
                    <div class="col-md-6 col-xs-6" style="padding:0px;">
                        <span id="captImg" style="height:35px;"><?php echo @$imgCaptcha; ?></span>
                    </div>
                    <div class="col-md-3 col-xs-3" style="margin-left:-8px;">
                        <a id="gantiCaptcha" href="javascript:void(0);" class="btn btn-xl btn-info">Ganti</a>
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" name="captcha" class="form-control" placeholder="Inputkan Captcha" id="captcha">
                </div>

                <button type="submit" id="kt_login_signin_submit" class="btn btn-primary block full-width m-b m-t">Login</button>

            </form>
            <p class="m-t"> <small>Universitas Riau &copy; 2017</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url('assets'); ?>/js/jquery-2.1.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script src="<?php echo base_url('assets'); ?>/js/bootstrap.min.js"></script>
    <script>
        "use strict";

        function getBaseUrl() {
            let url = location.href;
            let index = url.search("/\*");
            let base_url = url.substr(0, index);
            return base_url;
        }
        $('#gantiCaptcha').on('click', function() {
            $.get(getBaseUrl() + 'VerifyLogin/reload', function(data) {
                $('#captImg').html(data);
            });
        });
        var KTLoginGeneral = function() {

            var login = $('#kt_login');

            var showErrorMsg = function(form, type, msg) {
                var alert = $('<div class="kt-alert kt-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                    <span></span>\
                </div>');

                form.find('.alert').remove();
                alert.prependTo(form);
                //alert.animateClass('fadeIn animated');
                alert.find('span').html(msg);
            }

            // Private Functions

            var displaySignInForm = function() {
                login.removeClass('kt-login--forgot');
                login.removeClass('kt-login--signup');
                login.addClass('kt-login--signin');
            }


            var handleSignInFormSubmit = function() {
                $('#kt_login_signin_submit').click(function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    var form = $(this).closest('form');

                    form.validate({
                        rules: {
                            username: {
                                required: true,
                                minlength: 4
                            },
                            password: {
                                required: true,
                                minlength: 4
                            },
                            captcha: {
                                required: true,
                                minlength: 4
                            }
                        },
                        messages: {
                            username: {
                                required: "Username harus diisi !",
                                minlength: "Minimal {0} karakter"
                            },
                            password: {
                                required: "Password harus diisi !",
                                minlength: "Minimal {0} karakter"
                            },
                            captcha: {
                                required: "Captcha harus diisi !",
                                minlength: "Minimal {0} karakter"
                            }
                        }
                    });

                    if (!form.valid()) {
                        return;
                    }

                    btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

                    form.ajaxSubmit({
                        url: window.location.href + "/cek_login",
                        type: 'POST',
                        dataType: 'text',
                        data: $('#logForm').serialize(),
                        success: function(data) {
                            var msg = JSON.parse(data);
                            // console.log(msg.error);
                            if ($.isEmptyObject(msg.error)) {
                                var url = $(location).attr('href').split("/").splice(0, 4).join("/");
                                window.location.href = url + "/Operator";
                            } else {
                                btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                showErrorMsg(form, 'danger', msg.error);
                            }
                        },
                        error: function(data) {}
                    });
                });
            }

            var handleSignUpFormSubmit = function() {
                $('#kt_login_signup_submit').click(function(e) {
                    e.preventDefault();

                    var btn = $(this);
                    var form = $(this).closest('form');

                    form.validate({
                        rules: {
                            fullname: {
                                required: true
                            },
                            email: {
                                required: true,
                                email: true
                            },
                            password: {
                                required: true
                            },
                            rpassword: {
                                required: true
                            },
                            agree: {
                                required: true
                            }
                        }
                    });

                    if (!form.valid()) {
                        return;
                    }

                    btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

                    form.ajaxSubmit({
                        url: '',
                        success: function(response, status, xhr, $form) {
                            // similate 2s delay
                            setTimeout(function() {
                                btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                                form.clearForm();
                                form.validate().resetForm();
                                // display signup form
                                displaySignInForm();
                                var signInForm = login.find('.kt-login__signin form');
                                signInForm.clearForm();
                                signInForm.validate().resetForm();

                                showErrorMsg(signInForm, 'success', 'Thank you. To complete your registration please check your email.');
                            }, 2000);
                        }
                    });
                });
            }
            return {
                init: function() {
                    handleSignInFormSubmit();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTLoginGeneral.init();
        });
    </script>
</body>

</html>