<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
          <h2>List Dosen</h2>
          <ol class="breadcrumb">
            <li>
              <a href="<?php echo site_url();?>">Home</a>
            </li>
            <li>
              <a href="<?php echo site_url('pengajaran');?>">Pengajaran</a>
            </li>
            <li class="active">
              <strong>Entry Menguji TA</strong>
            </li>
          </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <?php $namaJurusan="";
                        foreach ($data['namaJurusan'] as $key) {
                            $namaJurusan = $key['nama'];
                        }
                    ?>
                    <h5>Tabel Dosen <?php echo $namaJurusan;?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a></li>
                            <li><a href="#">Config option 2</a></li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
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
                            <div class="col-md-2">
                                <select class="form-control m-b" name="bulan" id="pilihbulan">
                                    <?php
                                        $bulan = array('0' => 'SEMUA BULAN', '1' => 'JANUARI','2' => 'FEBRUARI','3' => 'MARET','4' => 'APRIL','5' => 'MEI','6' => 'JUNI','7' => 'JULI','8' => 'AGUSTUS','9' => 'SEPTEMBER','10' => 'OKTOBER','11' => 'NOVEMBER','12' => 'DESEMBER',);
                                        $month = date('m');
                                        for($i=0; $i<=12; $i++){
                                            echo (($i==$month)?"<option value='".$i."' selected>".$bulan[$i]."</option>":"<option value='".$i."'>".$bulan[$i]."</option>");
                                        }
                                    ?>                                          
                                </select>                                            
                            </div>
                            <div class="col-md-6">
                                <button type="submit" onclick="filterTable();" class="btn btn-info"><span class="fa fa-search"></span> Filter Menguji </button>
                                <button id="tambahBK" type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal'>Tambah Dosen Menguji</button>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                        	<div class="col-md-12 col-lg-12 col-xs-12">
                        		<div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th align='center' width="5%">No</th>
                                                <th>NIP</th>
                                                <th width="25%">Nama Dosen</th>
                                                <th>Deskripsi</th>
                                                <th align='center' width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                // $no=1;
                                                // foreach ($data['dataMenguji'] as $d) {
                                                //     $link = "pengajaran/ubahkegiatandosen/".$d['id_kegiatan_dosen'];
                                                //     $deskripsi = json_decode($d['deskripsi'],true);
                                                //     echo "<tr>
                                                //         <td align='center'>".$no."</td>
                                                //         <td>".$d['nipD']."</td>
                                                //         <td>".$d['namaD']."</td>
                                                //         <td><u>". $d['namakegiatan']. "</u>
                                                //         <br>". @$deskripsi['deskripsi'] ."
                                                //         <br><b>Tanggal</b> : ".$d['tanggal']."</td>
                                                //         <td align='center' class='center'>
                                                //           <div class='btn-group'>
                                                //             <button data-toggle='dropdown' class='btn btn-primary dropdown-toggle'>Action <span class='caret'></span></button>
                                                //             <ul class='dropdown-menu' style='margin-left:-80px;'>
                                                //               <li><a href='#' id='buttonUbahx' onClick='buttonUbah(".$d['id_kegiatan_dosen'].")' data-idx='".$d['id_kegiatan_dosen']."'>Ubah</a></li>
                                                //               <li><a href='".site_url("pengajaran/do_deletekegiatandosenMenguji/".$d['id_kegiatan_dosen'])."'>Hapus</a></li>
                                                //             </ul>
                                                //           </div>
                                                //         </td>
                                                //      </tr>";
                                                //     $no++;
                                                // }
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
    </div>

    <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content animated fadeIn">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
              </button>
              <i class="fa fa-tasks modal-icon"></i>
              <h4 class="modal-title">Tambah Aktivitas Dosen</h4>
              <small>Tambah Aktivitas Dosen Menguji</small>
            </div>

            <div class="modal-body">
              <form id='form-tambah' role='form' onsubmit="return false;">
                <div class="form-group">
                  <label>Dosen</label>
                  <input class="form-control" autofocus data-validate-length-range="30" data-validate-words="2" name="nama_dosen" id="nama_dosen" placeholder="Nama Dosen" required="required" type="text">
                  <input type="hidden" name="id_dosen" id="id_dosen">
                </div>

                <div class="form-group">
                  <label>Kegiatan</label>
                  <select autofocus class="form-control" name="kegiatan" id="kegiatan" required="required">
                    <option value="">Pilih Kegiatan</option>
                    <?php foreach ($data[ 'dataKegiatan'] as $key){ echo "<option value='".$key[ 'kode_kegiatan']. "'>".$key[ 'kode_kegiatan']. " :: ".$key[ 'nama']. "</option>"; } ?>
                  </select>
                </div>
                <div id="jenis-extend"></div>

                <div class="form-group" id="dataTanggal">
                  <label>Tanggal</label>
                  <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="tanggalKegiatan" class="form-control" required="required" placeholder="YYYY-MM-DD">
                  </div>
                  <label class="col-md-12">format:<code>yyyy-mm-dd</code></label>
                </div>
                <br>
                <input type="hidden" id="kode_kegiatan" name="kode_kegiatan">

                <div class="form-group">
                  <label>Deskripsi</label>
                  <input id="deskripsi" class="form-control" name="deskripsi" placeholder="Deskripsi" type="text">
                  <p><i id="formatisian" name="formatisian"></i></p>
                </div>

                <div class="form-group">
                  <label>No SK Kontrak</label>
                  <input id="no_sk_kontrak" minlength="8" class="form-control" name="no_sk_kontrak" placeholder="Nomor SK Kontrak" required="required" type="text">
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
                      <form id="form-ubah" onsubmit="return false;">
                          <div class="form-group">
                              <label>Dosen</label>

                              <input class="form-control" autofocus data-validate-length-range="30" data-validate-words="2" name="nama_dosenubah" id="nama_dosenubah" required="required" type="text">
                              <input type="hidden" name="id_dosenubah" id="id_dosenubah">
                          </div>

                          <div class="form-group">
                              <label>Kegiatan</label>
                              <select autofocus class="form-control" required name="kegiatanubah" id="kegiatanubah">
                                  <?php foreach ($data[ 'dataKegiatan'] as $key) { echo "<option value='".$key[ 'kode_kegiatan']. "'>".$key[ 'nama']. "</option>"; } ?>
                              </select>
                          </div>
                          <div id="jenis-extendubah"></div>

                          <div class="form-group" id="dataTanggal">
                              <label>Tanggal</label>
                              <div class="input-group date">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" required id="tanggalKegiatanubah" class="form-control">
                              </div>
                          </div>

                          <input type="hidden" id="kode_kegiatanubah" name="kode_kegiatanubah">

                          <div class="form-group">
                              <label>Deskripsi</label>
                              <input id="deskripsiubah" class="form-control" name="deskripsiubah" type="text">
                              <p><i id="formatisianubah" name="formatisianubah"></i></p>
                          </div>
                          
                          <div class="form-group">
                              <label>No SK Kontrak</label>
                              <input id="no_sk_kontrakubah" class="form-control" name="no_sk_kontrakubah" required="required" type="text">
                          </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button id="buttonsimpanubah" name="buttonsimpanubah" type="submit" class="btn btn-primary">Ubah</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#datatable').DataTable({
        "language": {
          "emptyTable": "<b><u>Wait</u></b>"
        }
    });
    filterTable();
    $('#dataTanggal .input-group.date').datepicker({
        todayBtn: 'linked',
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'yyyy-mm-dd'
    })
    var datajsondosen;
    post = $.post("<?php echo site_url("pengajaran/json_search_dosen")?>", {});
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
        submitHandler: function (form){
          id_dosen = $('#id_dosen').val();
          tgl_kegiatan = $('#tanggalKegiatan').val();
          kode_kegiatan = $('#kode_kegiatan').val();
          sks = $('#sks').val();
          deskripsi = $('#deskripsi').val();
          no_sk_kontrak = $('#no_sk_kontrak').val();
          pattern =/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/;

          if(pattern.test(tgl_kegiatan)){
            post = $.post('<?php echo site_url('pengajaran/do_insertMengujiTa'); ?>', {
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
              if(data=='1'){
                swal({title: 'Data Berhasil Dimasukan!', text: '', type: 'success'});
                location.reload();
              }else{
                swal({title: 'Data Gagal Dimasukan!',text: '',type: 'warning'});
                location.reload();
              }
            });
          }else{
            swal({title:'Data Gagal Dimasukan!', text:'Perhatikan data dan format tanggal.', type:'warning'});
          }
        }
      });
    });

    $('#buttonsimpanubahzz').click(function(){
      $('#form-ubah').validate({
        submitHandler: function(form){
          temp_id_kegiatan_dosen = $('#temp_id_kegiatan_dosen').val();
          id_dosenubah = $('#id_dosenubah').val();
          tgl_kegiatanubah = $('#tanggalKegiatanubah').val();
          kode_kegiatanubah = $('#kode_kegiatanubah').val();
          sksubah = $('#sksubah').val();
          deskripsiubah = $('#deskripsiubah').val();
          no_sk_kontrakubah = $('#no_sk_kontrakubah').val();

          post = $.post('<?php echo site_url("pengajaran/do_ubahMengujiTa"); ?>', {
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
            $('#kegiatanubah').val('placeholder');
            $('#sksubah').val('');
            $('#deskripsiubah').val('');
            $('#no_sk_kontrakubah').val('');
            if(data=='1'){
              swal({title:'Data Berhasil Diubah!', text:'',type:'success'});
              location.reload();
            }else{
              swal({title:'Data Gagal Diubah!',text:'',type:'warning'});
              location.reload();
            }
          });
        }
      });
    });

    function getKegiatanTurunan(kode_induk) {
       var idxjenis = 0;
       var kegiatan = "";
       var opt = "";
       $.ajax({
           url: "<?php echo base_url();?>index.php/pengajaran/getKegiatanByInduk",
           type: "GET",
           data: { kode:kode_induk },
           success: function(ajaxData) {

               if (ajaxData != "1") {
                   kegiatan = JSON.parse(ajaxData);
                   opt = opt + "<option value=''>Pilih Kegiatan</option>";
                   for (i = 0; i < kegiatan.length; i++) {
                       opt = opt + "<option value='" + kegiatan[i]['kode_kegiatan'] + "'>" + kegiatan[i]['nama'] + "</option>";
                   }

                   var jenisextend = ' <div class="form-group"><div class="col-md-12 col-xs-12 col-sm-12"><select class="form-control jenis_kegiatan" type="text" id ="jenis_keg' + idxjenis + '" name="jenis_keg' + idxjenis + '" required>' + opt + '</select></div></div>';
                   console.log(jenisextend);
                   idxjenis++;
                   $('#jenis-extend').append(jenisextend);
                   //reloadJSkegiatan();
               } else {
                   $('#kode_kegiatan').val(kode_induk);
               }

           },
           error: function(status) {

           }
       });
    }

    $('#kegiatan').on('change', function() {
       var kode_induk = $(this).val();
       $('#jenis-extend').html('');
       console.log('induk' + kode_induk);
       getKegiatanTurunan(kode_induk);
    });

    $('#jenis-extend').on('change', '.jenis_kegiatan', function() {
       var kode_induk = $(this).val();
       console.log('extend' + kode_induk);
       getKegiatanTurunan(kode_induk);
    });

    function getKegiatanTurunanubah(kode_induk,id) {
       var idxjenis = 0;
       var kegiatan = "";
       var opt = "";
       $.ajax({
           url: "<?php echo base_url();?>index.php/pengajaran/getKegiatanByInduk",
           type: "GET",
           data: {
               kode: kode_induk
           },
           success: function(ajaxData) {

               if (ajaxData != "1") {
                   kegiatan = JSON.parse(ajaxData);
                   opt = opt + "<option value=''>Pilih Kegiatan</option>";
                   for (i = 0; i < kegiatan.length; i++) {
                      if(kegiatan[i]['kode_kegiatan'] == id){
                        opt = opt + "<option value='" + kegiatan[i]['kode_kegiatan'] + "' selected>" + kegiatan[i]['nama'] + "</option>";
                      }else{
                        opt = opt + "<option value='" + kegiatan[i]['kode_kegiatan'] + "'>" + kegiatan[i]['nama'] + "</option>";
                      }
                   }

                   var jenisextend = ' <div class="form-group"><div class="col-md-12 col-xs-12 col-sm-12"><select class="form-control jenis_kegiatanubah" style="margin-bottom:10px;" type="text" id ="jenis_keg' + idxjenis + '" name="jenis_keg' + idxjenis + '" required>' + opt + '</select></div>';
                   console.log(jenisextend+id);
                   idxjenis++;
                   $('#jenis-extendubah').append(jenisextend);
                   //reloadJSkegiatan();
               } else {
                   $('#kode_kegiatanubah').val(kode_induk);
               }
           },
           error: function(status) {

           }
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

    function buttonUbahzz(idx) {
        $.ajax({
          url: "<?php echo base_url();?>index.php/pengajaran/GetMengujiTaUbah",
          type: "POST",
          data: { idx: idx },
          success: function(ajaxData) {
            kegiatan = JSON.parse(ajaxData);
            var optionkeg = '<option value="">Pilih Kegiatan</option>';
            var keg = <?php print_r(json_encode($data['dataKegiatan'])); ?>;
            var k,idx = 0;

              for (i=0;i<keg.length;i++){ 
                if(kegiatan[idx].kode_kegiatan==44 || kegiatan[idx].kode_kegiatan==45 || kegiatan[idx].kode_kegiatan==46){
                  k = 43;
                }else{
                  k = kegiatan[idx].kode_kegiatan;
                }

                if(keg[i].kode_kegiatan == k){
                    optionkeg += "<option value='"+keg[i].kode_kegiatan+"' selected>"+keg[i].nama+"</option>";
                    if(k==43){ getKegiatanTurunanubah(k,kegiatan[idx].kode_kegiatan); }
                    $('#kode_kegiatanubah').val(kegiatan[idx].kode_kegiatan);
                }else{
                    optionkeg += "<option value='"+keg[i].kode_kegiatan+"'>"+keg[i].nama+"</option>";
                }
              }

              d = JSON.parse(kegiatan[idx]['deskripsi']);
              tanggal = kegiatan[idx]['tanggal'];
              $('#temp_id_kegiatan_dosen').val(kegiatan[idx]['id_kegiatan_dosen']);
              $('#nama_dosenubah').val(kegiatan[idx]['namaD']);
              $('#id_dosenubah').val(kegiatan[idx]['id_dosen']);
              $("#kegiatanubah option").remove();
              $("#jenis-extendubah select").remove();
              $('#kegiatanubah').append(optionkeg);
              $('#tanggalKegiatanubah').val(tanggal);
              $('#sksubah').val(kegiatan[idx]['sks']);
              $('#deskripsiubah').val(d['deskripsi']);
              $('#no_sk_kontrakubah').val(kegiatan[idx]['no_sk_kontrak']);
              $('#myModalubah').modal('show');
          },
          error: function(status) {

          }
        });
        $('#myModalubah').modal('show');
    };

    function filterTable(){
        $('#datatable').DataTable().clear().draw(); 
        post = $.post("GetDataMengujiTA", {
            tahun : $('#pilihtahun').val(),
            bulan : $('#pilihbulan').val(),
        });
        post.done(function( data ){
            array = JSON.parse(data);
            $('#scripAlert').html('');
            if(array != null){
                for(i=0; i<array.length; i++){
                    deskripsi = JSON.parse(array[i].deskripsi);
                    if(array[i].status_kegiatan<=0){ 
                        button = "<center>"+
                                    "<div class='btn-group'>"+
                                        "<button data-toggle='dropdown' class='btn btn-primary dropdown-toggle'>Action <span class='caret'></span></button>"+
                                        "<ul class='dropdown-menu' style='margin-left:-80px;'>"+
                                            "<li><a href='<?php echo site_url("pengajaran/do_deletekegiatandosenMenguji/"); ?>"+array[i].id_kegiatan_dosen+"'>Hapus</a></li>"+
                                        "</ul>"+
                                    "</div>"+
                                "</center>";
                    }else{
                        button = '<center><button class="btn btn-danger"><i class="fa fa-exclamation-circle"></i></button></center>';
                    }

                    $('#datatable').DataTable().row.add( [
                        (i+1),
                        array[i].nipD,
                        array[i].namaD,
                        "<u>"+array[i].namakegiatan+"</u><br>"+
                        deskripsi.deskripsi+"<br>"+
                        "<b>Tanggal : "+array[i].tanggal+"</b><br>"+
                        "No. SK : "+array[i].no_sk_kontrak+" bulan",
                        button,
                    ]).draw();
                }

            }else{
                msg = $("<td colspan='3' style='text-align: center;'> <h2>Data Kosong</h2> </td>");
                tr = $("<tr></tr>");
                tr.append(msg);
                $('#tabelBody').append(tr);
            }
        });
    }

</script>
<!--End of Page Content-->
