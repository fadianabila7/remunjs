
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
                            <a href="<?php echo site_url('penelitian');?>">Penelitian</a>
                        </li>
                        <li class="active">
                            <strong>Entry Penunjang Dosen</strong>
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
                                            <li><a href="#">Config option 1</a>
                                            </li>
                                            <li><a href="#">Config option 2</a>
                                            </li>
                                        </ul>
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                        
                                </div>
                                <div class="ibox-content">

                                <div class="table-responsive">

                               <table class="table table-striped table-bordered table-hover dataTables-example">
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
                                    foreach ($data['dataPenunjang'] as $d) {
                                    
                                        echo "<tr>
                                                    <td align='center'>".$no."</td>
                                                    <td>".$d['nipD']."</td>
                                                    <td>".$d['namaD']."</td>
                                                    <td>".$d['deskripsi']."</td>
                                                     <td align='center' class='center'>
                                                     <div class='btn-group'>
                            <button data-toggle='dropdown' class='btn btn-primary dropdown-toggle'>Action <span class='caret'></span></button>
                            <ul class='dropdown-menu'>
                                <li><a href='#' data-toggle='modal' data-target='#myModalubah' id='id".$d['id_kegiatan_dosen']."'>Ubah</a></li>
                                <li><a href='";
                                echo site_url("penunjang/do_deletePenunjang/".$d['id_kegiatan_dosen']);
                                echo "'>Hapus</a></li>
                               
                            </ul>
                        </div>
                        </td>
                                                     </tr>";
                                                     $no++;
                                    }
                                    //$linktambahMembimbing = site_url('pengajaran')
                                ?>
                               
                                </table>
                                <input type="hidden" name="temp_id_kegiatan_dosen" id="temp_id_kegiatan_dosen">
                                    </div>
                                     <div class="nav navbar-right panel_toolbox">
                          <button id="tambahBK" type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal'>Tambah Kegiatan Penunjang</button>
                      </div>
                        <br>
                        <br> 

                                </div>
                            </div>
                        </div>
                        </div>
                        
                


            </div>

            <script type="text/javascript">
              <?php
                foreach ($data['dataPenunjang'] as $dosen) {
                   $tanggal =  explode("-", $dosen['tanggal']);
                  $tgl_kegiatan = $tanggal[1]."/".$tanggal[2]."/".$tanggal[0];
               echo "$('#id".$dosen['id_kegiatan_dosen']."').click(function(){

                      $('#temp_id_kegiatan_dosen').val('".$dosen['id_kegiatan_dosen']."');
                      a = $('#temp_id_kegiatan_dosen').val();
                    
                      $('#nama_dosenubah').val('".$dosen['namaD']."');
                      $('#id_dosenubah').val('".$dosen['id_dosen']."');
                      $('#optionkegiatanubah').html('<option id=".'"'."optionkegiatanubah".'"'." name=".'"'."optionkegiatanubah".'"'." value=".'"'.$dosen['kode_kegiatan'].'"'.">".$dosen['namakegiatan']."</option>');
                      $('#kode_kegiatanubah').val('".$dosen['kode_kegiatan']."');


                      $('#tanggalKegiatanubah').val('". $tgl_kegiatan."');
                      $('#sksubah').val('".$dosen['sks']."');
                      $('#deskripsiubah').val(".'"'.$dosen['deskripsi'].'"'.");
                      $('#no_sk_kontrakubah').val(".'"'.$dosen['no_sk_kontrak'].'"'.");


                 });";
               }
              ?>

            </script>
                     
            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-tasks modal-icon"></i>
                                            <h4 class="modal-title">Update Aktivitas Dosen</h4>
                                            <small>Update Aktivitas Dosen per Bulan</small>
                                            
                                            
                                        </div>
                                         


                                        
                                        <div class="modal-body"> 

                                         <div class="form-group">
                        <label>Dosen</label>
                       
                          <input class="form-control" autofocus data-validate-length-range="30" data-validate-words="2" name="nama_dosen" id="nama_dosen" placeholder="Nama Dosen" required="required" type="text">
                            <input type="hidden" name="id_dosen" id="id_dosen">
                       
                      </div>
                      <br>


                                          <div class="form-group">
                                        <label>Kegiatan</label>
                                            <select autofocus class="form-control" name="kegiatan" id="kegiatan">   
                          <option value="placeholder">Pilih Kegiatan</option>
                           <?php
                                 foreach ($data['dataKegiatan'] as $key) {
                                  echo "<option value='".$key['kode_kegiatan']."'>".$key['nama']."</option>";
                                  }
                          ?>

                          
                          </select> 
                          </div>
                           <br>

                      <div class="form-group" id="dataTanggal">
                                <label>Tanggal</label>

                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tanggalKegiatan" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" id="kode_kegiatan" name="kode_kegiatan">
                            <br>

                             <div class="form-group">
                    
                        <label>SKS</label>
                        
                          <input id="sks" class="form-control" name="sks" placeholder="SKS" required="required" type="number">
                        
                    </div>
                    <br>
                     <div class="form-group">
                    
                        <label>Deskripsi</label>
                        
                          <input id="deskripsi" class="form-control" name="deskripsi" placeholder="Deskripsi" required="required" type="text">
                          <p><i id="formatisian" name="formatisian"></i></p>


                        

                        
                    </div>
                    <br>
                    <div class="form-group">
                    
                        <label>No SK Kontrak</label>
                        
                          <input id="no_sk_kontrak" class="form-control" name="no_sk_kontrak" placeholder="Nomor SK Kontrak" required="required" type="text">
                        
                    </div>



                                                                              
                                                                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button id="buttonsimpan" name="buttonsimpan" type="button" class="btn btn-primary">Simpan</button>
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>

              <div class="modal inmodal" id="myModalubah" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-tasks modal-icon"></i>
                                            <h4 class="modal-title">Update Aktivitas Dosen</h4>
                                            <small>Update Aktivitas Dosen per Bulan</small>
                                            
                                            
                                        </div>
                                         


                                        
                                        <div class="modal-body"> 

                                         <div class="form-group">
                        <label>Dosen</label>
                       
                          <input class="form-control" autofocus data-validate-length-range="30" data-validate-words="2" name="nama_dosenubah" id="nama_dosenubah" required="required" type="text">
                            <input type="hidden" name="id_dosenubah" id="id_dosenubah">
                       
                      </div>
                      <br>


                                          <div class="form-group">
                                        <label>Kegiatan</label>
                                            <select autofocus class="form-control" name="kegiatanubah" id="kegiatanubah">   
                          <option id="optionkegiatanubah" name="optionkegiatanubah" value="placeholder">Pilih Kegiatan</option>
                              <?php
                                 foreach ($data['dataKegiatan'] as $key) {
                                  echo "<option value='".$key['kode_kegiatan']."'>".$key['nama']."</option>";
                                  }
                          ?>

                          
                          </select> 
                          </div>
                           <br>

                      <div class="form-group" id="dataTanggal">
                                <label>Tanggal</label>

                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tanggalKegiatanubah" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" id="kode_kegiatanubah" name="kode_kegiatanubah">
                            <br>

                             <div class="form-group">
                    
                        <label>SKS</label>
                        
                          <input id="sksubah" class="form-control" name="sksubah" required="required" type="number">
                        
                    </div>
                    <br>
                     <div class="form-group">
                    
                        <label>Deskripsi</label>
                        
                          <input id="deskripsiubah" class="form-control" name="deskripsiubah" required="required" type="text">
                          <p><i id="formatisianubah" name="formatisianubah"></i></p>


                        

                        
                    </div>
                    <br>
                    <div class="form-group">
                    
                        <label>No SK Kontrak</label>
                        
                          <input id="no_sk_kontrakubah" class="form-control" name="no_sk_kontrakubah" required="required" type="text">
                        
                    </div>



                                                                              
                                                                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button id="buttonsimpanubah" name="buttonsimpanubah" type="button" class="btn btn-primary">Simpan</button>
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>

            </div>
      

    



         <script type="text/javascript">

                $('#dataTanggal .input-group.date').datepicker({
                todayBtn: 'linked',
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            })
                 var datajsondosen;
              post = $.post("<?php echo site_url("pengajaran/json_search_dosen")?>", {
                    });
               post.done(function( datad ){
                    datajsondosen = JSON.parse(datad);
                    
                });

            $('#nama_dosen').autoComplete({
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
                    
                   document.getElementById("formatisian").innerHTML = "Format isian : "+"Jumlah Bimbingan";
                   
                 });  

                 $('#kegiatanubah').change(function(){

                    kode_kegiatan = $('#kegiatanubah').val();
                    $('#kode_kegiatanubah').val(kode_kegiatan);
                   
                   document.getElementById("formatisianubah").innerHTML = "Format isian : "+"Jumlah Bimbingan";
                   
                 });   

             <?php
                 $linkInsert = site_url('penunjang/do_insertPenunjang');
                 echo "$('#buttonsimpan').click(function(){

              id_dosen = $('#id_dosen').val();
              tgl_kegiatan = $('#tanggalKegiatan').val();
              kode_kegiatan = $('#kode_kegiatan').val();
              sks = $('#sks').val();
              deskripsi = $('#deskripsi').val();
              no_sk_kontrak = $('#no_sk_kontrak').val();
             

           
              post = $.post(".'"'.$linkInsert.'"'.", {
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
                swal({
                title: 'Data Berhasil Dimasukan!',
                text: '',
                type: 'success'
                });

                location.reload();
                }
                else{

            swal({
                title: 'Data Gagal Dimasukan!',
                text: '',
                type: 'warning'
            });
              location.reload();
          }

                
            });
            
          });";


                 ?>   

                  <?php
                 $linkUbah = site_url('penunjang/do_ubahPenunjang');
                 echo "$('#buttonsimpanubah').click(function(){
                  
              temp_id_kegiatan_dosen = $('#temp_id_kegiatan_dosen').val();
              id_dosenubah = $('#id_dosenubah').val();
              tgl_kegiatanubah = $('#tanggalKegiatanubah').val();
              kode_kegiatanubah = $('#kode_kegiatanubah').val();
              sksubah = $('#sksubah').val();
              deskripsiubah = $('#deskripsiubah').val();
              no_sk_kontrakubah = $('#no_sk_kontrakubah').val();
             

           
              post = $.post(".'"'.$linkUbah.'"'.", {
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
                swal({
                title: 'Data Berhasil Diubah!',
                text: '',
                type: 'success'
                });

                location.reload();
                }
                else{

            swal({
                title: 'Data Gagal Diubah!',
                text: '',
                type: 'warning'
            });
            location.reload();
          }

                
            });
            
          });";


                 ?>        
     

            </script>


        <!--End of Page Content-->

        
