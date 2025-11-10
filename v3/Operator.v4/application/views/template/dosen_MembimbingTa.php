<!--Start Page Content-->
<link href="<?php echo base_url('assets');?>/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets');?>/js/plugins/ladda/spin.min.js"></script>
<script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.min.js"></script>
<script src="<?php echo base_url('assets');?>/js/plugins/ladda/ladda.jquery.min.js"></script>
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>List Dosen Membimbing</h2>
            <ol class="breadcrumb">
                <li> <a href="<?php echo site_url();?>">Home</a> </li>
                <li> <a href="<?php echo site_url('pengajaran');?>">Pengajaran</a> </li>
                <li class="active"> <strong>Entry Membimbing</strong> </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <?php $namaJurusan="" ; foreach ($data[ 'namaJurusan'] as $key) { $namaJurusan=$key[ 'nama']; } ?>
                    <h5>Tabel Dosen <?php echo $namaJurusan;?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-2">
                            <select class="form-control m-b" name="tahun" id="pilihtahun">
                                <?php
                                    $currentYear = date('Y');
                                    $lowestYear = 2016;
                                    for($i=$currentYear; $i>=$lowestYear; $i--){
                                        echo "<option>".$i."</option>";
                                    }
                                ?>                                          
                            </select>                                            
                        </div>
                        <div class="col-md-4">
                            <select class="form-control m-b" name="id_kegiatan" id="id_kegiatan">
                                <option value="0">Semua</option>
                                <?php foreach ($data[ 'dataKegiatan'] as $key) { echo "<option value='".$key[ 'kode_kegiatan']. "'>".$key[ 'nama']. " </option>"; } ?>
                            </select>
                        </div>
                        <div class="col-md-6" style="float:right;">
                            <button type="submit" onclick="filterTable();" class="btn btn-info ladda-button" id="flx" data-style="expand-right"><span class="fa fa-search"></span> Tampilkan</button>
                            <button id="tambahBK" type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal'>Tambah Dosen Membimbing</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="table-responsive">

                                <table id="datatable" class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th align='center' width="5%">No</th>
                                            <th width="10%">NIP</th>
                                            <th width="25%">Nama Dosen</th>
                                            <th>Deskripsi</th>
                                            <th align='center' width="10%">Action</th>
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
    </div>
</dib>

<!-- next -->
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">Tambah Aktivitas Dosen Membimbing</h4>
                <div style="color:red;font-weight: bold;">
                    <h3>Membimbing maksimum 10 mahasiswa per kegiatan / bulan</h3>
                </div>
            </div>

            <div class="modal-body">
                <form role='form' id='form-tambah' onsubmit="return false;">
                    <div class="form-group">
                        <label>Dosen</label>
                        <input class="form-control" autofocus data-validate-length-range="30" data-validate-words="2" name="nama_dosen" id="nama_dosen" placeholder="Nama Dosen" required="required" type="text">
                        <input type="hidden" name="id_dosen" id="id_dosen">
                    </div>
                    <br>

                    <div class="form-group">
                        <div>
                            <label>Kegiatan</label>
                            <select autofocus class="form-control" name="kegiatan" id="kegiatan" required>
                                <option value="">Pilih Kegiatan</option>
                                <?php foreach ($data[ 'dataKegiatan'] as $key) { echo "<option value='".$key[ 'kode_kegiatan']. "'>".$key[ 'nama']. "</option>"; } ?>
                            </select>
                        </div>
                        <input type="hidden" id="kode_kegiatan" name="kode_kegiatan" required>
                    </div>

                    <div id="jenis-extend" name="jenis-extend">
                    </div>

                    <div class="form-group col-md-5" id="dataTanggal">
                        <label>Tanggal</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input required type="text" id="tanggalKegiatan" name="tanggalKegiatan" placeholder="Tanggal" class="form-control" data-date-format='yy-mm-dd' readonly>
                        </div>
                    </div>

                    <div class="form-group col-md-7">
                        <label>Lama Kegiatan</label>
                        <div class="input-group">
                            <input type="number" min="1" class="form-control" id="jml_bulan" name="jml_bulan" value="1" required>
                            <span class="input-group-addon">minimal 1 bulan kegiatan</span>
                        </div>
                        <label class="col-md-12"><code></code></label>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input id="deskripsi" class="form-control" name="deskripsi" placeholder="Deskripsi" type="text">
                        <p><i id="formatisian" name="formatisian"></i></p>
                    </div>

                    <div class="form-group">
                        <label>No SK Kontrak</label>
                        <input id="no_sk_kontrak" class="form-control" minlength="8" name="no_sk_kontrak" placeholder="Nomor SK Kontrak" required="required" type="text" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button id="buttonsimpan" name="buttonsimpan" type="submit" class="ladda-button btn btn-primary" data-style="expand-right" style="margin-left:10px;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end next -->


<!-- modal -->
<div class="modal inmodal" id="myModalubah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">Update Aktivitas Dosen</h4>
                <small>Update Aktivitas Dosen per Bulan</small>
            </div>
            <div class="modal-body">

                <form id='form-ubah' role='form' onsubmit="return false;">
                    <div class="form-group">
                        <label>Dosen</label>
                        <input class="form-control" autofocus data-validate-length-range="30" data-validate-words="2" name="nama_dosenubah" id="nama_dosenubah" required="required" type="text">
                        <input type="hidden" name="id_dosenubah" id="id_dosenubah">
                    </div>

                    <div class="form-group">
                        <label>Kegiatan</label>
                        <select class="form-control" required id="kegiatanubah" name="kegiatanubah">
                            
                        </select>
                    </div>
                    <div id="jenis-extendubah" name="jenis-extendubah">
                    </div>
                    <input type="hidden" id="kode_kegiatanubah" name="kode_kegiatanubah">

                    <div class="form-group col-md-5" id="dataTanggal">
                        <label>Tanggal</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input required type="text" id="tanggalKegiatanubah" class="form-control" placeholder="YYYY-MM-DD">
                        </div>
                    </div>

                    <div class="form-group col-md-7">
                        <label>Lama Kegiatan</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="jml_bulanUbah" name="jml_bulanUbah" value="1" required>
                            <span class="input-group-addon">minimal 1 bulan kegiatan</span>
                        </div>
                    </div>

                    <br>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input id="deskripsiubah" class="form-control" name="deskripsiubah" type="text">
                        <p><i id="formatisianubah" name="formatisianubah"></i>
                        </p>
                    </div>

                    <div class="form-group">
                        <label>No SK Kontrak</label>
                        <input id="no_sk_kontrakubah" class="form-control" name="no_sk_kontrakubah" required="required" type="text">
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="sksubah" id="sksubah">
                        <input type="hidden" name="temp_id_kegiatan_dosen" id="temp_id_kegiatan_dosen">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button id="buttonsimpanubah" name="buttonsimpanubah" type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="detail-bimbingan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">Update Aktivitas Dosen</h4>
                <small>Update Aktivitas Dosen per Bulan</small>
            </div>
            <div class="modal-body">

            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                    <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
            
            </div>
        </div>
    </div>
</div>
<!-- end modal -->

<script type="text/javascript">

    $('.ladda-button').ladda();
    $('#datatable').DataTable({
        "language": {
            "emptyTable": "Silihkan klik tombol <b><u>Tampilkan</u></b> terlebih dahulu."
        }
    });
    $('#tanggalKegiatan').datepicker({
        todayBtn: 'linked',
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'yyyy-mm-dd'
    }),$('#tanggalKegiatanubah').datepicker({
        todayBtn: 'linked',
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'yyyy-mm-dd'
    });

    var datajsondosen;
    post = $.post("<?php echo site_url("pengajaran/json_search_dosen")?>");
    post.done(function(datad){
        datajsondosen = JSON.parse(datad);
    });

    $('#nama_dosen').autoComplete({
        minChars: 1,
        source: function(term, suggest){
            term = term.toLowerCase();
            var choices=[];
            for(i=0;i<datajsondosen.length;i++){
                choices.push(datajsondosen[i].nama+"::"+datajsondosen[i].id_dosen);
            }
            var suggestions = [];
            for (i=0;i<choices.length;i++)
                if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                suggest(suggestions);
        },
        onSelect: function(event,ui){
            var temp = ui.split("::");
            var id=temp[1];
            $('#id_dosen').val(id);
        }
    });

    $('#nama_dosenubah').autoComplete({
        minChars: 1,
        source: function(term, suggest){
            term = term.toLowerCase();
            var choices=[];
            for(i=0;i<datajsondosen.length;i++){
                choices.push(datajsondosen[i].nama);
            }
            
            var suggestions = [];
            for (i=0;i<choices.length;i++)
                if(~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);
        },
        onSelect: function(event,ui){
            var id="";
            for (k=0;k<datajsondosen.length;k++)
                if (datajsondosen[k].nama==ui) id=datajsondosen[k].id_dosen;
            $('#id_dosenubah').val(id);
        }
    });


    $('#kegiatan').change(function(){
        kode_kegiatan = $('#kegiatan').val();
        $('#kode_kegiatan').val(kode_kegiatan);
        if(kode_kegiatan==""){return false;}
        var arr = <?php echo json_encode($data['dataKegiatan'])?>;
        var info;
        var ketemu = 0;
        var i=0;
        while(ketemu!=1 && i<arr.length){
            if(arr[i]['kode_kegiatan']==kode_kegiatan){
                info = arr[i]['isian_deskripsi'];
                ketemu = 1;
            }
            i++;
        }
        document.getElementById("formatisian").innerHTML = "<span style='color:red'>Format isian : "+info+"</span>";
    });

            
    $('#kegiatanubah').change(function(){
        kode_kegiatan = $('#kegiatanubah').val();
        $('#kode_kegiatanubah').val(kode_kegiatan);
        var arr = <?php echo json_encode($data['dataKegiatan'])?>;
        var info, ketemu = 0,i=0;
        while(ketemu!=1 && i<arr.length){
            if(arr[i]['kode_kegiatan']==kode_kegiatan){
                info = arr[i]['isian_deskripsi'];
                ketemu = 1;
            }
            i++;
        }
        document.getElementById("formatisianubah").innerHTML = "Format isian : "+info;
    });


    // do_insertMembimbingTa
    $('#form-tambah').on('submit', function() {
        $('.ladda-button').ladda('start');
        $.ajax({
            type: "POST",
            data: $("#form-tambah").serialize(),
            url: "<?php echo site_url('pengajaran/do_insertMembimbingTa'); ?>",
            success: function(data) {
                if (data == '1') {
                    swal({
                        title: 'Data Berhasil Dimasukan!',
                        text: '',
                        type: 'success'
                    });
                    $('#nama_dosen').val('');
                    $('#id_dosen').val('');
                    $('#tanggalKegiatan').val('');
                    $('#kode_kegiatan').val('');
                    $('#kegiatan').val('placeholder');
                    $('#sks').val('');
                    $('#deskripsi').val('');
                    $('#no_sk_kontrak').val('');
                    setTimeout(location.reload.bind(location), 2000);
                } else {
                    swal({
                        title: 'Data Gagal Dimasukan!',
                        text: 'Perhatikan data dan format tanggal.',
                        type: 'warning'
                    });
                    $('.ladda-button').ladda('stop');
                }
            }
        });
    });


            
    $('#buttonsimpanubah').click(function() {
        $('#form-ubah').validate({
            submitHandler: function(form) {
                temp_id_kegiatan_dosen = $('#temp_id_kegiatan_dosen').val();
                id_dosenubah = $('#id_dosenubah').val();
                tgl_kegiatanubah = $('#tanggalKegiatanubah').val();
                kode_kegiatanubah = $('#kode_kegiatanubah').val();
                sksubah = $('#sksubah').val();
                deskripsiubah = $('#deskripsiubah').val();
                no_sk_kontrakubah = $('#no_sk_kontrakubah').val();
                jml_bulanUbah = $('#jml_bulanUbah').val();

                post = $.post("<?php echo site_url('pengajaran/do_ubahMembimbingTa'); ?>", {
                    temp_id_kegiatan_dosen: temp_id_kegiatan_dosen,
                    id_dosenubah: id_dosenubah,
                    tgl_kegiatanubah: tgl_kegiatanubah,
                    kode_kegiatanubah: kode_kegiatanubah,
                    sksubah: sksubah,
                    deskripsiubah: deskripsiubah,
                    no_sk_kontrakubah: no_sk_kontrakubah,
                    jml_bulanUbah: jml_bulanUbah,
                });

                post.done(function(data) {
                    if (data == '1') {
                        $('#nama_dosenubah').val('');
                        $('#id_dosenubah').val('');
                        $('#tanggalKegiatanubah').val('');
                        $('#kode_kegiatanubah').val('');
                        $('#kegiatanubah').val('');
                        $('#sksubah').val('');
                        $('#deskripsiubah').val('');
                        $('#jml_bulanUbah').val('');
                        $('#no_sk_kontrakubah').val('');
                        swal({title: 'Data Berhasil Diubah!',text: '',type: 'success'});
                    } else {
                        swal({title: 'Data Gagal Diubah!',text: '',type: 'warning'});
                    }
                    location.reload();
                });
            }
        });
    });


    function filterTable(){
        $('#flx').ladda('start');
        $('#datatable').DataTable().clear().draw(); 
        post = $.post("GetDataMembimbing", {
            tahun : $('#pilihtahun').val(),
            id_kegiatan : $('#id_kegiatan').val(),
        });
        post.done(function( data ){
            array = JSON.parse(data);
            $('#scripAlert').html('');
            if(array != null){
                for(i=0; i<array.length; i++){
                    link = "pengajaran/ubahkegiatandosen/"+array[i].id_kegiatan_dosen;
                    deskripsi = JSON.parse(array[i].deskripsi.replace(/\s+/g, " "));
                    // if(array[i].status_kegiatan==0){ // untuk sementara di matikan
                    button = '<center><button class="btn btn-info" onclick=detail_bimbingan("'+array[i].id_kegiatan_dosen+"-"+deskripsi.uuid_bimbing+'");><i class="fa fa-exclamation-circle"></i></button></center>';

                    $('#datatable').DataTable().row.add( [
                        (i+1),
                        array[i].nipD,
                        array[i].namaD,
                        "<u>"+array[i].namakegiatan+"</u><br>"+
                        deskripsi.nama+"<br>"+
                        "Tanggal : "+array[i].tanggal+"<br>"+
                        "Selama : "+deskripsi.dari+" bulan",
                        button,
                    ] ).draw();
                }

            }else{
                msg = $("<td colspan='3' style='text-align: center;'> <h2>Data Kosong</h2> </td>");
                tr = $("<tr></tr>");
                tr.append(msg);
                $('#tabelBody').append(tr);
            }
        });
        $('#flx').ladda('stop');
    }

    function detail_bimbingan(e){
        $.ajax({
            type: "POST",
            data: {data:e},
            url: "<?php echo base_url('index.php/pengajaran/detail_bimbingan');?>",
            success: function (data) {
                var data = JSON.parse(data);
                if(data['result']=='success'){

                    $('#detail-bimbingan').modal('show');
                }else{
                    toastr.error('terjadi kesalahan'); 
                }
            }
        });
    }

</script>
