<div class="right_col" role="main">
          <div class="row wrapper border-bottom white-bg dashboard-header">
            <div class="page-title">
              <div class="title_left">
                <h3>Tambah Kelas Kuliah</h3>
              </div>

            </div>
       

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <h2>Form Tambah Kelas Kuliah</h2>
                 <?php 
                          $jenjangPendidikan;
                          foreach ($data['jenjangPendidikan'] as $key) {
                            $jenjangPendidikan = $key['id_jenjang_pendidikan'];
                          }
                         
                          ?>
                  <div class="x_content" id="sini">

                    <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('pengajaran/do_insertkelaskuliah')?>">

                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Kegiatan</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select autofocus class="select2_single form-control" tabindex="-1" required name="kegiatan" id="kegiatan">   
                          <option value="">Pilih Kegiatan Mengajar</option>
                            <?php
                            // print_r($data['dataKegiatan']);
                              foreach ($data['dataKegiatan'] as $key) {
                                if($jenjangPendidikan==0 or $jenjangPendidikan==1 || $jenjangPendidikan==10 || $jenjangPendidikan==11)
                                { 
                                  if($key['kode_kegiatan'] == 2 or $key['kode_kegiatan'] == 6 or $key['kode_kegiatan']==9 or $key['kode_kegiatan'] == 7 or $key['kode_kegiatan'] == 8 or $key['kode_kegiatan'] == 10 or $key['kode_kegiatan'] == 318 or $key['kode_kegiatan'] == 319 or $key['kode_kegiatan'] == 320){
                                    echo "<option value='".$key['kode_kegiatan']."'>".$key['nama']."</option>";
                                  }
                                }elseif ($jenjangPendidikan==2 or $jenjangPendidikan==4 or $jenjangPendidikan==5) {
                                  if($key['kode_kegiatan']==3 or $key['kode_kegiatan']==4 or $key['kode_kegiatan']==6 or $key['kode_kegiatan']==9 or $key['kode_kegiatan']==10){
                                    echo "<option value='".$key['kode_kegiatan']."'>".$key['nama']."</option>";
                                  }
                                }elseif ($jenjangPendidikan==3 or $jenjangPendidikan==6) {
                                  if($key['kode_kegiatan']==5 or $key['kode_kegiatan']==6 or $key['kode_kegiatan']==10 or $key['kode_kegiatan']==11){
                                    echo "<option value='".$key['kode_kegiatan']."'>".$key['nama']."</option>";
                                  }
                                }
                              }

                            ?>
                          </select> 
                          <input type="hidden" id="kegiatan_hidden" name="kegiatan_hidden">
                        </div>
                      </div>

                      <div id="jenis-extend">

                      </div>
                     

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mata Kuliah</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" autofocus name="matakuliah" id="matakuliah" placeholder="Mata Kuliah" required type="text" autocomplete="off" onfocusout="FunctionChekMK()">
                          <input type="hidden" name="id_matakuliah" id="id_matakuliah">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dosen</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" autofocus data-validate-length-range="30" data-validate-words="2" name="nama_dosen" id="nama_dosen" placeholder="Nama Dosen" required type="text" onfocusout="FunctionChekDosen()">
                            <input type="hidden" name="id_dosen" id="id_dosen" >
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Semester</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_single form-control" required name="semester" id="semester">   
                          <option value="">Pilih Semester</option>>
                          <option value="1">Ganjil</option>
                          <option value="2">Genap</option>
                          </select> 
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">SK Kontrak</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="tahunakademik" class="form-control col-md-7 col-xs-12" name="skkontrak" type="text" required >
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Hari</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <select class="select2_single form-control" required name="hari" id="hari">   
                          <option value="">Hari</option>
                          <option value="2">Senin</option>
                          <option value="3">Selasa</option>
                          <option value="4">Rabu</option>
                          <option value="5">Kamis</option>
                          <option value="6">Jum'at</option>
                          <option value="7">Sabtu</option>
                          </select> 
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Waktu Mulai</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                           <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" class="form-control" required value="09:30" name="waktu_mulai">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">SKS</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input id="sks" class="form-control col-md-7 col-xs-12" data-validate-length-range="4" data-validate-words="1" name="sks" placeholder="SKS" required="required" type="number" onkeyup="FunctionChekSKS()">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ruangan</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input id="ruangan" class="form-control col-md-7 col-xs-12" name="ruangan" placeholder="Ruangan" required="required" type="text">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Peserta</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input id="jumlah_peserta" class="form-control col-md-7 col-xs-12" name="jumlah_peserta" placeholder="Jumlah Peserta" required type="number">
                        </div>
                      </div>

                     
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="button" class="btn btn-primary" id="cancel" name="cancel" onclick="window.history.go(-1); return false;">Cancel</button>
                          <button id="send" type="submit" class="btn btn-success">Submit</button>

                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

    
   
   <br><br>

 <script type="text/javascript">
    function FunctionChekSKS() {
      
    var a = $("#sks").val();
    if(a<1 || a>10){
   
   
     swal({
                title: "Peringatan",
                text: "Jumlah SKS Harus 0 < SKS < 10."
            });
    $("#sks").val("1");
    $("#sks").html("1");
   }
}

function FunctionChekMK() {

    var a = $("#id_matakuliah").val();

    if(a==""){
   
   
     swal({
                title: "Peringatan",
                text: "Anda Haru Memilih Mata Kuliah!!"
            });
    $("#matakuliah").val("");
    $("#matakuliah").html("");
   }
}

function FunctionChekDosen() {
    var a = $("#id_dosen").val();

    if(a==""){
   
   
     swal({
                title: "Peringatan",
                text: "Anda Harus Memilih Dosen!!."
            });
    $("#nama_dosen").val("");
    $("#nama_dosen").html("");
   }
}
         $(document).ready(function(e){
            var datajsonmk;
                post = $.post("<?php echo site_url("pengajaran/json_search_matakuliah")?>", { 
                    });
                  post.done(function(datamk){
                    datajsonmk = JSON.parse(datamk);
                });  
         

              $('#matakuliah').autoComplete({
                minChars: 1,
                source: function(term, suggest){
                    term = term.toLowerCase();       
                    var choices=[];
                    for(i=0;i<datajsonmk.length;i++){
                        choices.push(datajsonmk[i].nama);
                    }
                   var suggestions = []; 
                    for (i=0;i<choices.length;i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);     
                },
                onSelect: function(event,ui){
                    var id="";
                     for (i=0;i<datajsonmk.length;i++)
                     {
                       
                            if (datajsonmk[i].nama == ui) 
                            {
                            id=datajsonmk[i].id_matakuliah;
                           }
                     }
                 
                     $('#id_matakuliah').val(id);
                } 
            });


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
                      choices.push(datajsondosen[i].nama+"::"+datajsondosen[i].nip);
                  }
                  var suggestions = [];
                  for (i=0;i<choices.length;i++)
                      if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                  suggest(suggestions);
              },
              onSelect: function(event,ui){
                  var id="";
                  var temp=ui.split("::");
                   for (k=0;k<datajsondosen.length;k++)
                      if (datajsondosen[k].nama==temp[0]) id=datajsondosen[k].id_dosen;
                    $('#id_dosen').val(id);
                    console.log(ui);
              }
            });



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

        function getKegiatanTurunan(kode_induk){
          var idxjenis=0;
            var kegiatan="";
            var opt="";
            $.ajax({
                url: "<?php echo base_url();?>index.php/pengajaran/getKegiatanByInduk",
                type: "GET",
                data : {kode: kode_induk},
                success: function(ajaxData)
                {               
                  if(ajaxData!="1"){
                    kegiatan = JSON.parse(ajaxData);
                    opt = opt+"<option value=''>Pilih Kegiatan</option>";
                    for(i=0;i<kegiatan.length;i++){
                      opt = opt+"<option value='"+kegiatan[i]['kode_kegiatan']+"'>"+kegiatan[i]['nama']+"</option>";
                    }

                    var jenisextend = ' <div class="form-group"><label for="jenis_keg" class="col-md-3 control-label"> </label><div class="col-md-6 col-xs-12 col-sm-6"><select class="form-control jenis_kegiatan" type="text" id ="jenis_keg'+idxjenis+'" name="jenis_keg'+idxjenis+'" required>'+opt+'</select>';
                    console.log(jenisextend);
                    idxjenis++;
                    $('#jenis-extend').append(jenisextend);
                    //reloadJSkegiatan();                         
                  }else{
                    $('#kegiatan_hidden').val(kode_induk);
                  } 
                    
                },
                error: function(status)
                {

                }
            });
        }
    });
 </script>
   
 

