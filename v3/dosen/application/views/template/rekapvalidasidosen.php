        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Rekapitulasi Validasi Remunerasi</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Validasi</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">    
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Kegiatan yang divalidasi</h5>
                            </div>
                                                
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-3" style="padding-bottom:12px;">
                                        <select name="tahun" id="tahun" class="form-control" onchange="proses();">
                                            <?php $f = 2017; 
                                                for($i=date('Y'); $i>=$f; $i--){
                                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table table-bordered" id="luna">
                                            <thead>
                                                <tr>
                                                    <th width="1%">No</th>
                                                    <th>Bulan</th>
                                                    <th>Pengajaran</th>
                                                    <th>Penelitian <br>Pengabdian</th>
                                                    <th>Penunjang</th>
                                                    <th>Non Struktural</th>
                                                    <th>Struktural</th>
                                                    <th>Tugas Tambahan</th>
                                                    <th>SKSR GAJI</th>
                                                    <th>SKSR KINERJA</th>
                                                    <th>SKSR SISA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                            <!-- end ibox -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal inmodal" id="myModalubah" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-tasks modal-icon"></i>
                        <h4 class="modal-title">Detail Aktivitas Dosen</h4>
                        <small>Detail Aktivitas Dosen per Bulan</small>
                    </div>

                    <div class="modal-body">
                        <div class="panel-body" style="padding:0px;">
                            <div class="table-responsive col-md-12">
                                <table id="showDetail" class="table table-striped table-bordered table-hover responsive display dataTables-example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                           <th width="1%">No</th>
                                           <th>Nama Kegiatan</th>
                                           <th width="20%">Tanggal</th>
                                           <th width="5%">SKSR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script type="text/javascript">
            var t = $('#luna').DataTable({aLengthMenu: [[3,6, 12],[3,6,12]],iDisplayLength: 12});
            proses();
            function proses(){
                $.ajax({
                    url: "<?php echo base_url();?>index.php/mainControler/getvalidasi",
                    type: "POST",
                    data: {id: document.getElementById("tahun").value},
                    success: function(data){
                        t.clear().draw();
                        var result = JSON.parse(data);
                        var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
                        for(var i=0; i<result.length; i++){
                            var lastrow = t.row.add([
                                i+1,
                                '<b>' + bulan[i] + '</b>',
                                '<span class="label label-success" style="cursor: pointer;" onclick="detail(1,\''+bulan[i]+'\');">' + koma(result[i]['jumlah_sks_bid_1']) + '</span>',
                                '<span class="label label-success" style="cursor: pointer;" onclick="detail(2,\''+bulan[i]+'\');">' + koma(result[i]['jumlah_sks_bid_2']) + '</span>',
                                '<span class="label label-success" style="cursor: pointer;" onclick="detail(3,\''+bulan[i]+'\');">' + koma(result[i]['jumlah_sks_bid_3']) + '</span>',
                                '<span class="label label-success" style="cursor: pointer;" onclick="detail(4,\''+bulan[i]+'\');">' + koma(result[i]['jumlah_sks_bid_4']) + '</span>',
                                '<span class="label label-success" style="cursor: pointer;" onclick="detail(5,\''+bulan[i]+'\');">' + koma(result[i]['jumlah_sks_bid_5']) + '</span>',
                                '<span class="label label-warning">' + koma(result[i]['sksr_tugas_tambahan']) + '</span>',
                                '<span class="label label-primary">' + koma(result[i]['sksr_gaji']) + '</span>',
                                '<span class="label label-primary">' + koma(result[i]['sksr_kinerja']) + '</span>',
                                '<span class="label label-primary">' + koma(result[i]['sksr_sisa']) + '</span>',
                            ]).node().id = result[i]['id_validasi_tridharma'];
                            t.draw(false);
                        }
                    },error: function(status){

                    }
                });
            }
            function koma(a){
                var a  = parseFloat(a);

                hasil = parseFloat(a).toFixed(2);
                return (hasil);
            }

            function detail(tipe,bulan)
            {
                post = $.post('<?php echo site_url('mainControler/detailsKegiatan'); ?>', {
                    tipe : tipe,
                    bulan : bulan,
                    tahun : $('select[name=tahun]').val(),
                });

                var t = $('#showDetail').DataTable();
                var total = 0;
                post.done(function(data){
                    t.clear().draw();
                    var result = JSON.parse(data);

                    for(var i=0; i<result.length; i++){
                        var data='';
                        var a = JSON.parse(result[i].deskripsi);

                        for(var n in a){  
                            if(n==="keg_perbln" || n==="uuid_penelitian" || n==="uuid_bimbing" || n==="bln_ke" || n==="nilai" || n==="nama_berkas" ||  n==="uuid_tambahan" || 
                               n==="dari" || n==="tgl_mulai" || n==="uuid_penunjang" || n==="uuid Tambahan" || n==="catatan"){
                            }else{
                                data+=(('<b>'+n+'</b> = '+a[n]+'<br>').replace("_", " ")).replace(/\b\w/g, l => l.toUpperCase()); 
                            } 
                        }

                        total = eval(total) + eval(result[i].sks*result[i].bobot_sks);
                        var lastrow = t.row.add([
                            i+1,
                            '<b>Kegiatan = </b>'+ result[i].nama + '<br>' + data,
                            result[i].tanggal_kegiatan,
                            result[i].sks*result[i].bobot_sks,
                        ]).draw(false);
                    }
                });
                $('#myModalubah').modal('show');
            }
        </script>