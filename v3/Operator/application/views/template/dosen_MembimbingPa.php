<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>List Kegiatan Dosen</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url();?>">Home</a>
                </li>
                <li>
                    <a href="<?php echo site_url('pengajaran');?>">Pengajaran</a>
                </li>
                <li class="active">
                    <strong>Entry Kegiatan Lainya</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <?php $namaJurusan=""; foreach ($data[ 'namaJurusan'] as $key) { $namaJurusan=$key[ 'nama']; } ?>
                    <h5>Tabel Dosen <?php echo $namaJurusan;?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-3">

                            <button id="tambahBK" type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal'>Tambah Kegiatan Dosen</button>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="table-responsive">

                                <table id="datatable" class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th align='center'>No</th>
                                            <th>NIP</th>
                                            <th width="25%">Nama Dosen</th>
                                            <th>Deskripsi</th>
                                            <th align='center'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                          $no=1;
                                          $idx=0;
                                          foreach ($data['dataMembimbing'] as $d) {
                                            $link = "pengajaran/ubahkegiatandosen/".$d['id_kegiatan_dosen'];
                                            $deskripsi = json_decode($d['deskripsi']);
                                            echo "<tr>
                                                  <td align='center'>".$no."</td>
                                                  <td>".$d['id_dosen']."</td>
                                                  <td>".$d['nama_dosen']."</td>
                                                  <td>".@$deskripsi->deskripsi."</td>
                                                  <td align='center' class='center'>
                                                    <div class='btn-group'>
                                                      <button data-toggle='dropdown' class='btn btn-primary dropdown-toggle'>Action <span class='caret'></span></button>
                                                      <ul class='dropdown-menu'>
                                                          <li><a href='#' class='buttonUbah' data-idx='".$idx."'>Ubah</a></li>
                                                          <li><a href='".site_url("pengajaran/do_deletekegiatandosenMembimbing/".$d['id_kegiatan_dosen'])."'>Hapus</a></li>
                                                      </ul>
                                                    </div>
                                                  </td>
                                              </tr>";
                                            $no++;
                                            $idx++;
                                          }
                                          //$linktambahMembimbing = site_url('pengajaran')
                                        ?>
                                    </tbody>
                                </table>
                                <input type="hidden" name="temp_id_kegiatan_dosen" id="temp_id_kegiatan_dosen">
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
      </div>


  <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">Tambah Aktivitas Dosen</h4>
                <small>Tambah Aktivitas Dosen</small>
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
                    
                    <div id="jenis-extend" name="jenis-extend"></div>

                    <br>

                    <div class="form-group" id="dataTanggal">
                        <label>Tanggal</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input required type="text" id="tanggalKegiatan" class="form-control">
                        </div>
                    </div>

                    <br>

                    <!-- <div class="form-group">

                        <label>SKS</label>

                          <input id="sks" class="form-control" name="sks" placeholder="SKS" required="required" type="number">

                    </div> -->

                    <br>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input id="deskripsi" class="form-control" name="deskripsi" placeholder="Deskripsi" type="text" required>
                        <p><i id="formatisian" name="formatisian"></i></p>
                    </div>

                    <br>
                    <div class="form-group">
                        <label>No SK Kontrak</label>
                        <input id="no_sk_kontrak" class="form-control" name="no_sk_kontrak" placeholder="Nomor SK Kontrak" required="required" type="text" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button id="buttonsimpan" name="buttonsimpan" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                        <br>

                        <div class="form-group">
                            <label>Kegiatan</label>
                            <select class="form-control" required name="kegiatanubah" id="kegiatanubah">
                                <?php foreach ($data[ 'dataKegiatan'] as $key) { echo "<option value='".$key[ 'kode_kegiatan']. "'>".$key[ 'nama']. "</option>"; } ?>
                            </select>
                        </div>
                        
                        <div id="jenis-extendubah" name="jenis-extendubah">

                        </div>
                        <br>

                        <div class="form-group" id="dataTanggal">
                            <label>Tanggal</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" required id="tanggalKegiatanubah" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" id="kode_kegiatanubah" name="kode_kegiatanubah">
                        <!--
                        <div class="form-group">
                          <label>SKS</label>
                          <input id="sksubah" class="form-control" name="sksubah" required="required" type="number">
                        </div> 
                        -->
                        <br>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input id="deskripsiubah" class="form-control" name="deskripsiubah" type="text">
                            <p><i id="formatisianubah" name="formatisianubah"></i>
                            </p>
                        </div>
                        <br>

                        <div class="form-group">
                            <label>No SK Kontrak</label>
                            <input id="no_sk_kontrakubah" class="form-control" name="no_sk_kontrakubah" required="required" type="text">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button id="buttonsimpanubah" name="buttonsimpanubah" type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  $('#datatable').DataTable();
    $('#dataTanggal .input-group.date').datepicker({
      todayBtn: 'linked',
      keyboardNavigation: false,
      forceParse: false,
      calendarWeeks: true,
      autoclose: true,
      format:'yyyy-mm-dd'
    })
    var datajsondosen;
    post = $.post("<?php echo site_url("pengajaran/json_search_dosen")?>", { });
    post.done(function( datad ){
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
            // for (k=0;k<datajsondosen.length;k++)
            // if (datajsondosen[k].nama==ui) id=datajsondosen[k].id_dosen;
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
                if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
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
       document.getElementById("formatisian").innerHTML = "Format isian : "+info;

    });

    $('#kegiatanubah').change(function(){

        kode_kegiatan = $('#kegiatanubah').val();
        $('#kode_kegiatanubah').val(kode_kegiatan);
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
       document.getElementById("formatisianubah").innerHTML = "Format isian : "+info;
    });

             
    $('#buttonsimpan').click(function(){
      $('#form-tambah').validate({

        submitHandler: function(form){
          id_dosen = $('#id_dosen').val();
          tgl_kegiatan = $('#tanggalKegiatan').val();
          kode_kegiatan = $('#kode_kegiatan').val();
          sks = $('#sks').val();
          deskripsi = $('#deskripsi').val();
          no_sk_kontrak = $('#no_sk_kontrak').val();

          post = $.post('<?php echo site_url('pengajaran/do_insertMembimbingPa'); ?>', {
            id_dosen : id_dosen,
            tgl_kegiatan : tgl_kegiatan,
            kode_kegiatan : kode_kegiatan,
            sks : sks,
            deskripsi : deskripsi,
            no_sk_kontrak : no_sk_kontrak,
          });

          post.done(function( data ){
            $('#nama_dosen').val('');
            $('#id_dosen').val('');
            $('#tanggalKegiatan').val('');
            $('#kode_kegiatan').val('');
            $('#kegiatan').val('placeholder');
            $('#sks').val('');
            $('#deskripsi').val('');
            $('#no_sk_kontrak').val('');
          
            if(data=='1'){ swal({title:'Data Berhasil Dimasukan!',text:'',type:'success'});
              location.reload();
            }else{
              swal({title:'Data Gagal Dimasukan!', text:data, type:'warning'});
              //location.reload();
            }
          });
        }
      });
    });

              
    $('#buttonsimpanubah').click(function(){
      $('#form-ubah').validate({
        submitHandler: function(form){
          temp_id_kegiatan_dosen = $('#temp_id_kegiatan_dosen').val();
          id_dosenubah = $('#id_dosenubah').val();
          tgl_kegiatanubah = $('#tanggalKegiatanubah').val();
          kode_kegiatanubah = $('#kode_kegiatanubah').val();
          sksubah = $('#sksubah').val();
          deskripsiubah = $('#deskripsiubah').val();
          no_sk_kontrakubah = $('#no_sk_kontrakubah').val();

          post = $.post('<?php echo site_url('pengajaran/do_ubahMembimbingTa'); ?>', {
            temp_id_kegiatan_dosen : temp_id_kegiatan_dosen,
            id_dosenubah : id_dosenubah,
            tgl_kegiatanubah : tgl_kegiatanubah,
            kode_kegiatanubah : kode_kegiatanubah,
            sksubah : sksubah,
            deskripsiubah : deskripsiubah,
            no_sk_kontrakubah : no_sk_kontrakubah,
          });
          
          post.done(function( data ){
            $('#nama_dosenubah').val('');
            $('#id_dosenubah').val('');
            $('#tanggalKegiatanubah').val('');
            $('#kode_kegiatanubah').val('');
            $('#kegiatanubah').val('');
            $('#sksubah').val('');
            $('#deskripsiubah').val('');
            $('#no_sk_kontrakubah').val('');
            
            if(data=='1'){ 
              swal({title:'Data Berhasil Diubah!', text:'', type:'success'});
              location.reload();
            }else{
              swal({title:'Data Gagal Diubah!', text:'', type:'warning'});
              location.reload();
            }
          });
        }
      });
    });


    function getKegiatanTurunan(kode_induk){
      var idxjenis=0;
      var kegiatan="";
      var opt="";
        $.ajax({
            url: "<?php echo base_url();?>index.php/pengajaran/getKegiatanByInduk",
            type: "GET",
            data : {kode: kode_induk},
            
            success: function(ajaxData){

                if(ajaxData!="1"){
                  kegiatan = JSON.parse(ajaxData);
                  opt = opt+"<option value=''>Pilih Kegiatan</option>";
                  for(i=0;i<kegiatan.length;i++){
                    opt = opt+"<option value='"+kegiatan[i]['kode_kegiatan']+"'>"+kegiatan[i]['nama']+"</option>";
                  }

                  var jenisextend = ' <div class="form-group"><div class="col-md-12 col-xs-12 col-sm-12"><select class="form-control jenis_kegiatan" type="text" id ="jenis_keg'+idxjenis+'" name="jenis_keg'+idxjenis+'" required>'+opt+'</select></div></div>';
                  console.log(jenisextend);
                  idxjenis++;
                  $('#jenis-extend').append(jenisextend);
                  //reloadJSkegiatan();
                }else{
                  $('#kode_kegiatan').val(kode_induk);
                }
            },
            error: function(status){}
        });
    }
    $('#kegiatan').on('change',function(){
          var kode_induk = $(this).val();
          $('#jenis-extend').html('');

          console.log('induk'+kode_induk);
          getKegiatanTurunan(kode_induk);
      });

      $('#jenis-extend').on('change','.jenis_kegiatan',function(){
          var kode_induk = $(this).val();

          console.log('extend'+kode_induk);
          getKegiatanTurunan(kode_induk);
      });


    function getKegiatanTurunanubah(kode_induk){

      var idxjenis=0;
      var kegiatan="";
      var opt="";
        $.ajax({
          url: "<?php echo base_url();?>index.php/pengajaran/getKegiatanByInduk",
          type: "GET",
          data : {kode: kode_induk},
          success: function(ajaxData){

              if(ajaxData!="1"){
                kegiatan = JSON.parse(ajaxData);
                opt = opt+"<option value=''>Pilih Kegiatan</option>";
                for(i=0;i<kegiatan.length;i++){
                  opt = opt+"<option value='"+kegiatan[i]['kode_kegiatan']+"'>"+kegiatan[i]['nama']+"</option>";
                }

                var jenisextend = ' <div class="form-group"><div class="col-md-12 col-xs-12 col-sm-12"><select class="form-control jenis_kegiatanubah" type="text" id ="jenis_keg'+idxjenis+'" name="jenis_keg'+idxjenis+'" required>'+opt+'</select></div></div>';
                console.log(jenisextend);
                idxjenis++;
                $('#jenis-extendubah').append(jenisextend);
                //reloadJSkegiatan();
              }else{
                $('#kode_kegiatanubah').val(kode_induk);
              }
            },
            error: function(status){}
        });
    }

    $('#kegiatanubah').on('change', function() {
        var kode_induk = $(this).val();
        $('#jenis-extendubah').html('');
        console.log('induk' + kode_induk);
        getKegiatanTurunanubah(kode_induk);
    });

    $('#jenis-extendubah').on('change', '.jenis_kegiatanubah', function() {
        var kode_induk = $(this).val();
        console.log('extend' + kode_induk);
        getKegiatanTurunanubah(kode_induk);
    });

</script>

<script type="text/javascript">
  $('.buttonUbah').on('click',function(){
    var idx = $(this).data('idx');
    $.ajax({
        url: "<?php echo base_url();?>index.php/pengajaran/GetLainya",
        type: "GET",
        data : {idx: idx},
        success: function(ajaxData){

          kegiatan = JSON.parse(ajaxData);
          temp_tanggal = kegiatan[idx]['tanggal_kegiatan'].split("-");
          tanggal = temp_tanggal[1]+'/'+temp_tanggal[2]+'/'+temp_tanggal[0];
          $('#temp_id_kegiatan_dosen').val(kegiatan[idx]['id_kegiatan_dosen']);
          $('#nama_dosenubah').val(kegiatan[idx]['nama_dosen']);
          $('#id_dosenubah').val(kegiatan[idx]['id_dosen']);
          $('#kegiatanubah').val(kegiatan[idx]['kode_kegiatan']);
          $('#kegiatanubah').prepend('<option value="'+kegiatan[idx]['kode_kegiatan']+'">'+kegiatan[idx]['nama_kegiatan']+'</option>');
          $('#kode_kegiatanubah').val(kegiatan[idx]['kode_kegiatan']);
          $('#tanggalKegiatanubah').val(tanggal);
          $('#sksubah').val(kegiatan[idx]['sks']);
          $('#deskripsiubah').val(kegiatan[idx]['deskripsi']);
          $('#no_sk_kontrakubah').val(kegiatan[idx]['no_sk_kontrak']);
          $('#myModalubah').modal('show');
        },
        error: function(status){}
    });
      $('#myModalubah').modal('show');
  });
</script>


        <!--End of Page Content-->
