
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Daftar Jurusan Universitas Riau</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Daftar Kegiatan Dosen</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">    
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Tabel Daftar Kegiatan Dosen</h5>
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
                                    <div class="hr-line-dashed"></div>                                        
                                    <form id="formTampil" onsubmit="return false;">
                                        <div class="form-group" id="data_4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="form-control m-b" name="fakultas" required="required">
                                                        <option value="0">SEMUA FAKULTAS</option>
                                                        <?php 
                                                            foreach ($fakultas as $d) {
                                                                echo "<option value='".$d['id_fakultas']."'>".$d['nama']."</option>";
                                                            }
                                                        ?>
                                                    </select>                                            
                                                </div>
                                            
                                                <div class="col-md-1">
                                                    <button type="submit" class="btn btn-info btnsubmit" onclick="getDaftarKegiatan();" id="btn-submit" ><span class="fa fa-search"></span>Tampilkan</button>
                                                </div>

                                                <div class="col-md-2">
                                                   <button id="tambahJurusan" type="button" class="btn btn-success" data-toggle='modal' data-target='#myModalTambah'>Tambah Fakultas</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table id='datatable' class="table table-striped table-bordered table-hover display dataTables-example" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">NO</th>
                                                <th class="col-md-4">Fakultas</th>
                                                <th>Jurusan</th>                                                
                                                <th class="col-md-1">Singkatan</th>
                                                <th class="col-md-1">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal inmodal" id="myModalTambah" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content animated fadeIn">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                          </button>
                          <i class="fa fa-tasks modal-icon"></i>
                          <h4 class="modal-title">Tambah Jurusan</h4>
                          <small>Tambah Aktivitas Dosen Menguji</small>
                      </div>

                      <div class="modal-body">
                          <form id='form-tambah' role='form' onsubmit="return false;">
                              <div class="form-group">
                                  <label>Fakultas</label>
                                  <select autofocus class="form-control" name="fakultas" id="fakultas" required="required">
                                      <option value="">Pilih Fakultas</option>
                                      <?php foreach ($fakultas as $key){ echo "<option value='".$key[ 'id_fakultas']. "'>".$key[ 'nama']. "</option>"; } ?>
                                  </select>
                              </div>

                              <div class="form-group">
                                  <label>Nama Jurusan</label>
                                  <input id="namajurusan" class="form-control" name="namajurusan" placeholder="Jurusan" type="text" required>
                              </div>

                              <div class="form-group">
                                  <label>Singkatan</label>
                                  <input id="singkatan" class="form-control" name="singkatan" placeholder="Singkatan" required="required" type="text">
                              </div>

                              <div class="modal-footer">
                                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                  <button id="buttonsimpan" name="buttonsimpan" type="submit" class="btn btn-primary">Simpan</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
            </div>
        </div>
        <!--End of Page Content-->

<script type="text/javascript">
    var t = $("#datatable").DataTable({"bSort":false});

    function getDaftarKegiatan()
    {
        postData = $('#formTampil').serialize();

            $.ajax(
            {
               url: "<?php echo base_url();?>index.php/TambahanController/getDaftarJurusan",
               type: "GET",
               data : postData,                   
               success: function (ajaxData)
               {
                    
                    t.clear().draw();
                    var result = JSON.parse(ajaxData);
                    var column1, column2, column3, column4;
                    var j=1;

                    for(var i=0; i<result.length; i++){
                        column1 = result[i]['nama_fakultas'];
                        column2 = result[i]['nama'];
                        column3 = result[i]['singkatan'];
                        column4 = "<a href='TambahanController/hapusJurusan/"+result[i]['id_jurusan']+"'><i style='font-size: 19px;' class='fa fa-trash'></i></a>";
                        
                            t.row.add( [
                                j++,
                                column1,
                                column2,                                 
                                column3,                                 
                                column4,                                 
                            ] ).draw();
                    }
                    
                },
                error: function(status)
                {
                    t.clear().draw();
                }
        });
    }


    $('#buttonsimpan').click(function(){
      $('#form-tambah').validate({
        submitHandler: function (form){
          fakultas = $('#fakultas').val();
          namajurusan = $('#namajurusan').val();
          singkatan = $('#singkatan').val();

          if(fakultas || namajurusan || singkatan){
            post = $.post('<?php echo site_url('TambahanController/tambahJurusan'); ?>', {
              fakultas : fakultas,
              namajurusan : namajurusan,
              singkatan : singkatan,
            });

            post.done(function( data ){
              $('#fakultas').val('');
              $('#namajurusan').val('');
              $('#singkatan').val('');
              if(data=='1'){
                swal({title: 'Data Berhasil Dimasukan!', text: '', type: 'success'});
                location.reload();
              }else{
                swal({title: 'Data Gagal Dimasukan!',text: '',type: 'warning'});
                location.reload();
              }
            });
          }else{
            swal({title:'Data Gagal Dimasukan!', text:'Perhatikan data.', type:'warning'});
          }
        }
      });
    });
</script>