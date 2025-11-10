<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>Update Log Remunerasi</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url();?>">Home</a>
                </li>
                <li class="active">
                    <strong>Update Log</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">    
        <div class="row" id="log-id"></div>
    </div>
</div>

<script>
    let doc  = <?php echo $logupdate; ?>;
    let text = '';
    $.each(doc,function(e,x){
        text += `<div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>`+x.judul+`</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Update by `+x.id_user+`</a></li>
                                    <li><a href="#">Tanggal : `+x.waktu+`</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="ibox-content">
                            `+x.deskripsi+`
                        </div>
                    </div>
                </div>`;
    });
    $('#log-id').empty().append(text);
</script>