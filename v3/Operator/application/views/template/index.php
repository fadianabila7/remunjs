<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Remunerasi Dosen</title>

    <link href="<?php echo base_url('assets');?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets');?>/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url('assets');?>/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="<?php echo base_url('assets');?>/css/plugins/toastr/toastr.min.css" rel="stylesheet">

   <link href="<?php echo base_url('assets');?>/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <!-- Gritter -->
    <link href="<?php echo base_url('assets');?>/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">



    <link href="<?php echo base_url('assets');?>/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="<?php echo base_url('assets');?>/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url('assets');?>/css/style.css" rel="stylesheet">

    <link href="<?php echo base_url('assets');?>/js/jquery.auto-complete.css" rel="stylesheet">

      <!-- Sweet Alert -->
    <link href="<?php echo base_url('assets');?>/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">


  <script src="<?php echo base_url('assets');?>/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url('assets');?>/js/bootstrap.min.js"></script>
     <script src="<?php echo base_url('assets');?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>
     <script src="<?php echo base_url('assets');?>/js/plugins/jquery-validate/jquery.validate.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/bootstrap-notify-master/bootstrap-notify.min.js"></script>
      <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url('assets');?>/js/inspinia.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/pace/pace.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/sweetalert/sweetalert.min.js"></script>
       <script src="<?php echo base_url('assets');?>/js/jquery.auto-complete.js"></script>
     <script src="<?php echo base_url('assets');?>/js/plugins/dataTables/datatables.min.js"></script>
</head>
<body>
    <div id="wrapper">
        <?php  echo $navigation; ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <?php  echo $nav_header;?>
            </div>

            <!--Start Page Content-->
            <?php  echo $content;?>

            <!--End of Page Content-->

            <div class="clearfix">
            </div>
               <div class="footer">
                    <div>
                        <strong>Copyright</strong> Universitas Riau &copy; 2016
                    </div>
                </div>
        </div>

    </div>

  <!-- Mainly scripts -->

    <script src="<?php echo base_url('assets');?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/jeditable/jquery.jeditable.js"></script>
        <!-- Clock picker -->
    <script src="<?php echo base_url('assets');?>/js/plugins/clockpicker/clockpicker.js"></script>
    <!-- Flot -->
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.pie.js"></script>
    <!-- Peity -->
    <script src="<?php echo base_url('assets');?>/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/demo/peity-demo.js"></script>
    <!-- jQuery UI -->
    <!-- GITTER -->
    <script src="<?php echo base_url('assets');?>/js/plugins/gritter/jquery.gritter.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url('assets');?>/js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- Sparkline demo data  -->
    <script src="<?php echo base_url('assets');?>/js/demo/sparkline-demo.js"></script>
    <!-- ChartJS-->
    <script src="<?php echo base_url('assets');?>/js/plugins/chartJs/Chart.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url('assets');?>/js/plugins/toastr/toastr.min.js"></script>
    <script>
         $(document).ready(function(e){

            $('.clockpicker').clockpicker();
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
               // toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

            }, 1300);


            /* Init DataTables */
            var oTable = $('#editable').DataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( '../example_ajax.php', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },

                "width": "90%",
                "height": "100%"
            } );
 });
    </script>
</body>
</html>
