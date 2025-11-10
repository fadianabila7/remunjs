
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
                            <strong>Entry Dosen Mengajar</strong>
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
                                <div class="row">
                                <div class="col-lg-3 col-md-3 col-xs-3">
                                <select class="form-control" name="tahunajaran" id="tahunajaran">
                                   <?php
                                        $loweryear = 2015;
                                        $currentyear = date('Y');

                                        for($i=$currentyear; $i>=$loweryear; $i--)
                                        {
                                            echo "<option>".$i."</option>";
                                        }
                                    ?>
                                </select>
                                    
                                </div>
                                <div class="col-lg-3 col-md-3 col-xs-3">
                                <select class="form-control" name="semester" id="semester">
                                    <?php
                                        $currentmonth = date('m');
                                        if($currentmonth>=1 && $currentmonth<=5)
                                        {
                                            echo '<option value="1">Ganjil</option>
                                    <option selected value="2">Genap</option>
                                    <option value="3">Antara</option>';
                                        }
                                        else if($currentmonth>=6 && $currentmonth<=7)
                                        {
                                            echo '<option value="1">Ganjil</option>
                                    <option value="2">Genap</option>
                                    <option selected value="3">Antara</option>';
                                        }
                                        else if($currentmonth>=8 && $currentmonth<=12)
                                        {
                                            echo '<option selected value="1">Ganjil</option>
                                    <option value="2">Genap</option>
                                    <option value="3">Antara</option>';
                                        }
                                    ?>
                                      
                                </select>   
                                </div>
                                <div class="col-lg-2 col-md-2 col-xs-2">
                                <button class='btn btn-info' type='button' id="filterTabel" name="filterTabel">Filter</button>
                                </div>
                                </div>
                                <div class="table-responsive">

                                <table id="datatable" class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama Dosen</th>
                                    <th>Update Aktivitas</th>                                    
                                </tr>
                                </thead>
                                <tbody id="tabelBody" name="tabelBody">

                                <?php 
                                    $no=1;
                                    foreach ($data['dataDosen'] as $dosen) {
                                        echo "<tr>
                                                    <td>".$no."</td>
                                                    <td>".$dosen['nip']."</td>
                                                    <td>".$dosen['namadosen']."</td>
                                                     <td align='center' class='center'><button class='btn btn-info' type='button' data-toggle='modal' data-target='#myModal".$dosen['id_dosen']."'><i class='fa fa-edit'></i> Update</button></td>
                                                     </tr>";
                                                     $no++;
                                    }
                                ?>
                               </tbody>
                                </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        </div>
                        
                


            </div>
            <script type="text/javascript">
            $('#datatable').DataTable();
                $('#filterTabel').click(function(){

                tahunajaran = $('#tahunajaran').val();
                semester    = $('#semester').val();

                //alert(tahunajaran);  
                 

              post = $.post("get_Dosen_Mengajar_filter", {
                tahunajaran : tahunajaran,
                semester : semester,
           
            });

              post.done(function( data ){
                //alert(data);
                $('#tampungModal').html('');
                $('#tabelBody').html('');
                array = JSON.parse(data);
                if(typeof array !== 'undefined'){
                    linkInsertdata = "<?php echo site_url("pengajaran/InsertKegiatanDosenMengajar");?>";
                    for(i=0; i<array.dataDosen.length; i++){

                       
                        num     = $('<td>'+(i+1)+'</td>');
                        nip     = $('<td>'+array.dataDosen[i].nip+'</td>');
                        nama    = $('<td>'+array.dataDosen[i].namadosen+'</td>');
                        action  = $('<td align="center" class="center">'+"<button class='btn btn-info' type='button' data-toggle='modal' data-target='#myModal"+array.dataDosen[i].id_dosen+"'><i class='fa fa-edit'></i> Update</button>"+'</td>');


                        tr = $('<tr></tr>');
                        tr.append(num,nip,nama,action);
                        $('#tabelBody').append(tr);

                        modalA = '<div class="modal inmodal" id="myModal'+array.dataDosen[i].id_dosen+'" tabindex="-1" role="dialog"  aria-hidden="true"><div class="modal-dialog"><div class="modal-content animated fadeIn"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><i class="fa fa-tasks fa-3x"></i><h4 class="modal-title">Update Aktivitas Dosen</h4><small>Update Aktivitas Dosen per Bulan</small></div><div class="modal-body"><h2>Pilih Mata Kuliah</h2> <select class="form-control" id="mk'+array.dataDosen[i].id_dosen+'">';
                        modalB = '';

                        for(j=0;j<array.dataKelasKuliah.length;j++){

                                if(array.dataDosen[i].id_dosen==array.dataKelasKuliah[j].id_dosen){
                                    modalB = modalB+'<option value="'+array.dataKelasKuliah[j].id_matakuliah+'">'+array.dataKelasKuliah[j].namamatakuliah+'</option>';
                                }
                        }
                        modalB = modalB + '</select><br><div class="form-group"><label>Deskripsi</label><input id="deskripsi'+array.dataDosen[i].id_dosen+'" class="form-control" name="Deskripsi" placeholder="Deskripsi" required="required" type="text"></div><br><div class="form-group" id="data_'+array.dataDosen[i].id_dosen+'"><label>Tanggal</label><div class="input-group date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tanggal_'+array.dataDosen[i].id_dosen+'" class="form-control"></div></div></div><div class="modal-footer"><button type="button" class="btn btn-white" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary btn-sm" id="button'+array.dataDosen[i].id_dosen+'">Simpan</button></div></div></div></div>';
                        
                        modalC ="<script>$(document).ready(function(e){";
                        modalC = modalC+"$('#data_"+array.dataDosen[i].id_dosen+" .input-group.date').datepicker({todayBtn: 'linked',keyboardNavigation: false,forceParse: false,calendarWeeks: true,autoclose: true});"+"$('#button"+array.dataDosen[i].id_dosen+"').click(function(){id_dosen = '"+array.dataDosen[i].id_dosen+"';   id_mk = $('#mk"+array.dataDosen[i].id_dosen+"').val();              tgl_kegiatan = $('#tanggal_"+array.dataDosen[i].id_dosen+"').val();deskripsi = $('#deskripsi"+array.dataDosen[i].id_dosen+"').val();post = $.post('"+linkInsertdata+"', {                id_dosen: id_dosen,id_mk : id_mk,tgl_kegiatan : tgl_kegiatan,      deskripsi : deskripsi,});post.done(function( data ){if(data=='1'){swal({title: 'Data Berhasil Dimasukan!',text: '',type: 'success'});}else{swal({title: 'Data Gagal Dimasukan!',text: '',type: 'warning' });}});});";
                        modalC = modalC + "});";
                        modalC = modalC + "</"+"script>";

                        modal = $(modalA+modalB+modalC);

                       $('#tampungModal').append(modal);
                                  
                                                  
                    }

                }
                else{

                    msg = $("<td colspan='3' style='text-align: center;'> <h2>Data Kosong</h2> </td>");
                    tr = $("<tr></tr>");
                    tr.append(msg);
                    
                    $('#tabelBody').append(tr);
                    $('#tampungModal').html('');

                }
                                
               

                
            });
            
          });

            </script>
            <div id="tampungModal">

            <?php
            $linkInsert = site_url("pengajaran/InsertKegiatanDosenMengajar");
                foreach($data['dataDosen'] as $dosen){

                    echo '<div class="modal inmodal" id="myModal'.$dosen['id_dosen'].'" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-tasks fa-3x"></i>
                                            <h4 class="modal-title">Update Aktivitas Dosen</h4>
                                            <small>Update Aktivitas Dosen per Bulan</small>
                                            
                                            
                                        </div>
                                        <div class="modal-body"><h2>Pilih Mata Kuliah</h2> <select class="form-control" id="mk'.$dosen['id_dosen'].'">';                                    
                             
                            foreach($data['dataKelasKuliah'] as $datamk){
                                    if($dosen['id_dosen']==$datamk['id_dosen']){
                                  echo '<option value="'.$datamk['id_matakuliah'].'">'.$datamk['namamatakuliah'].'</option>';
                                 }

                                }
                                                                        
                                        echo '</select><br>

                    <div class="form-group">
                    
                        <label>Deskripsi</label>
                        
                          <input id="deskripsi'.$dosen['id_dosen'].'" class="form-control" name="Deskripsi" placeholder="Deskripsi" required="required" type="text">
                        
                    </div>

                      <br>

                      <div class="form-group" id="data_'.$dosen['id_dosen'].'">
                                <label>Tanggal</label>

                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tanggal_'.$dosen['id_dosen'].'" class="form-control">
                                </div>
                            </div>



                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary btn-sm" id="button'.$dosen['id_dosen'].'">Simpan</button>
                                        </div>
                                    </div>
                                </div>
            </div>';


            echo " <script>
         $(document).ready(function(e){";


            echo " $('#data_".$dosen['id_dosen']." .input-group.date').datepicker({
                todayBtn: 'linked',
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });";
            
            echo "$('#button".$dosen['id_dosen']."').click(function(){
                    alert('masuk button  ".$dosen['id_dosen']."');
             id_dosen = '".$dosen['id_dosen']."';
              id_mk = $('#mk".$dosen['id_dosen']."').val();
              tgl_kegiatan = $('#tanggal_".$dosen['id_dosen']."').val();
              deskripsi = $('#deskripsi".$dosen['id_dosen']."').val();
             

           
              post = $.post('".$linkInsert."', {
                id_dosen: id_dosen,
                id_mk : id_mk,
                tgl_kegiatan : tgl_kegiatan,
                deskripsi : deskripsi,
                
           
            });
               
              post.done(function( data ){
                if(data=='1'){
                swal({
                title: 'Data Berhasil Dimasukan!',
                text: '',
                type: 'success'
                });}
                else{

            swal({
                title: 'Data Gagal Dimasukan!',
                text: '',
                type: 'warning'
            });}

                
            });
            
          });";

            echo " });
    </script>";

                }

            ?>
       </div>    
      
</div>
</div>
        
        <!--End of Page Content-->

        
               