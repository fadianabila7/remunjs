
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Entry Surat Keputusan</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Entry Surat Keputusan</strong>
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
                                    <h5>Entry Surat Keputusan</h5>
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
                                        
                                </div>
                            </div>
                                <div class="ibox-content">
                                    <form class="form-horizontal" id="formEntry" enctype="multipart/form-data" method="POST" action="<?php echo base_url();?>index.php/Penunjang/submitDataSK">

                                        <div class="form-group">
                                        <label for="sk" class="col-md-3 control-label">No SK *</label>
                                        <div class="input-group col-md-6">
                                            <input class="form-control" type="text" name="sk" required>
                                        </div>
                                        </div>
                                        <div class="form-group" id="tmtdate">
                                                <label class="control-label col-md-3">Tanggal SK *</label>
                                                <div class="input-group date col-md-6">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="tgl_sk" name="tgl_sk" placeholder="Tanggal SK" required>
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <label for="jenis_keg" class="col-md-3 control-label">Jenis Kegiatan *</label>
                                            <div class="input-group col-md-6">
                                                <select class="form-control" type="text" id = "jenis_keg" name="jenis_keg" required>
                                                    <option value="">Pilih Jenis Kegiatan</option>
                                                    <?php
                                                        foreach ($kegiatan as $keg)
                                                        {
                                                            echo "<option value='".$keg['kode_kegiatan']."'>".$keg['nama']."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="jenis-extend">

                                        </div>
                                        <div class="form-group">
                                        <label for="nama_keg" class="col-md-3 control-label">Nama Kegiatan *</label>
                                        <div class="input-group col-md-6">
                                            <input class="form-control" type="text" name="nama_keg" required>
                                        </div>
                                        </div>
                                        <div class="form-group" id="tmtdate2">
                                                <label class="control-label col-md-3">Tanggal Kegiatan *</label>
                                                <div class="input-group date col-md-6">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="tgl_keg" name="tgl_keg" placeholder="Tanggal Kegiatan" required>
                                                </div>
                                            </div>

                                        
                                        
                                        <div class="form-group" id="btn-add-dosen">
                                            <button type="button" onclick="tambahDosen()" class="btn btn-info"><span class="fa fa-plus"></span>Tambah Dosen</button>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table id='datatable' class="table table-striped table-bordered table-hover display dataTables-example" width="100%" cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        
                                                        <th>Nama Dosen</th>
                                                        <th>NIP</th>
                                                        <th>Peran</th>
                                                        <th>Action</th>

                                                        
                                                    </tr>
                                                    </thead>
                                                    <tbody id="isitabel">
                                                      <!--  <tr>
                                                            <td>
                                                                1
                                                            </td>
                                                            <td>
                                                                <input id="namadosen1" placeholder="Nama Dosen" autofocus data-validate-length-range="30" data-validate-words="2" class="form-control m-b dosen-auto" type="text" required="required" name="namadosen[]">                                                
                                                            </td>
                                                            <td>
                                                                <input type="text" id="nip1" class="form-control m-b" name="nip[]" readonly>
                                                            </td>
                                                            <td>
                                                                <select name="kegiatan[]" id="keg1" class="form-control m-b" required="required">
                                                                    <option value="">Pilih Kegiatan</option>
                                                                    <?php
                                                                       // foreach($kegiatan as $row)
                                                                        //{
                                                                          //  echo "<option value='".$row['kode_kegiatan']."'>".$row['nama']."</option>";
                                                                        //}
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger" onclick="deleteitem();"><span class="fa fa-trash"></span></button>
                                                            </td>
                                                        </tr>               -->
                                                    </tbody>
                                                    
                                                    </table>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="form-group">
                                            <div class="col-md-9">
                                            <center>
                                                <button type="reset" class="btn btn-normal">Reset</button>
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                </center>
                                            </div>
                                        </div>                                                             
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                        
            </div>
            

        </div>
        <!--End of Page Content-->



<script language="javascript">

    var tabel = $('#datatable').DataTable();
    var idxrow=1;
    var idDosen="";
    var datakegiatan="";
    var idxjenis=1;
    var idxselected=10;



    function tambahDosen() 
    {
        var coloumn1;
        var coloumn2;
        var coloumn3;
        var coloumn4;
        var coloumn5;
        var opt="";

        var list = <?php echo json_encode( $kegiatan ); ?>;
        
        for(idx=0;idx<datakegiatan.length;idx++)
        {
            if(datakegiatan[idx]["kode_kegiatan"]!=0)
            {
                opt = opt + '<option value="'+datakegiatan[idx]['kode_kegiatan']+'">'+datakegiatan[idx]['nama']+'</option>';
            }
        }
        coloumn2 = '<input id="'+idxrow+'" placeholder="Nama Dosen" autofocus data-validate-length-range="30" data-validate-words="2" data-rid="'+idxrow+'" class="form-control m-b dosen-auto" type="text" required="required" name="namadosen[]">';
        coloumn3 = '<input type="text" id="nip'+idxrow+'" class="form-control m-b" name="nip[]" value="" readonly>';
        coloumn4 = '<select name="kegiatan[]" id="keg'+idxrow+'" class="form-control m-b" required="required">'+opt+'</select>';
        if(idxrow==1)
            coloumn5='';
        else
            coloumn5 = '<button class="btn btn-danger btn-delete" ><span class="fa fa-trash"></span></button>';
        
        //var row = '<tr><td>'+coloumn1+'</td><td>'+coloumn2+'</td><td>'+coloumn3+'</td><td>'+coloumn4+'</td><td>'+coloumn5+'</td></tr>';
        tabel.row.add( [
                    
                    coloumn2,
                    coloumn3,
                    coloumn4,
                    coloumn5                    
                ] ).draw();
        
        reloadJSauto();
        idxrow++;
    }
    

    function reloadJSauto()
    {    
        
        
       $('.dosen-auto').autoComplete({
            idxselected : $(this).attr('id'),
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
                console.log(suggestions);
                suggest(suggestions);  
            },
            onSelect: function(event,ui){
                
                 for (k=0;k<datajsondosen.length;k++)
                    if (datajsondosen[k].nama==ui) 
                        idDosen=datajsondosen[k].id_dosen;

              // idxselected = $().attr('id');
              
                $('#nip'+idxselected).attr('value',idDosen);
                
            }
        });
    }
    
    //reloadJSauto();

    /*$('#isitabel').on('change','.dosen-auto',function(){
                
                  
                idxselected = $(this).attr('id');
                $('#nip'+idxselected).attr('value',idDosen);
                alert($('#nip'+idxselected).attr('value'));
           });*/
    
    tambahDosen();

     $('#isitabel').on('click','.dosen-auto',function(){
        idxselected = tabel.row( $(this).parents('tr')).index()+1;
        //$('#nip'+idxselected).attr('value',idDosen);
        
    })

    $('#datatable').on('click','.btn-delete',function(){
        tabel
        .row( $(this).parents('tr') )
        .remove()
        .draw();
    });
    

    function getKegiatanTurunan(kode_induk)
    {
        var kegiatan="";
        var opt="";
        $.ajax({
            url: "<?php echo base_url();?>index.php/Penunjang/getKegiatanByInduk",
            type: "GET",
            data : {kode: kode_induk},
            success: function(ajaxData)
            {
                kegiatan = JSON.parse(ajaxData);                   
                if(kegiatan[0]['bobot_sks']==null)
                {
                    opt = opt+"<option value=''>Pilih Kegiatan</option>";
                    for(i=0;i<kegiatan.length;i++)
                    {
                        opt = opt+"<option value='"+kegiatan[i]['kode_kegiatan']+"'>"+kegiatan[i]['nama']+"</option>";
                    }

                    var jenisextend = ' <div class="form-group"><label for="jenis_keg" class="col-md-3 control-label"> </label><div class="input-group col-md-6"><select class="form-control jenis_kegiatan" type="text" id = "jenis_keg'+idxjenis+'" name="jenis_keg'+idxjenis+'" required>'+opt+'</select>';
                    console.log(jenisextend);
                    idxjenis++;
                    $('#jenis-extend').append(jenisextend);
                    //reloadJSkegiatan();                         
                }
                else 
                {
                    datakegiatan=kegiatan;
                    opt = opt+"<option value=''>Pilih Posisi</option>";
                    for(i=0;i<kegiatan.length;i++)
                    {
                        opt = opt+"<option value='"+kegiatan[i]['kode_kegiatan']+"'>"+kegiatan[i]['nama']+"</option>";
                    }
                    for(j=1;j<idxrow;j++)
                        {
                            $('#keg'+j).html(opt);
                        }
                    idxjenis=1;
                }    
                
            },
            error: function(status)
            {

            }
        });
    }

//    function reloadJSkegiatan()
  //  {

 /*   $('#abc1').change(function(){
          alert('masuk');
        idxselected = $(this).attr('id');
              
                $('#nip'+idxselected).val(idDosen);

       });*/

        $('#jenis_keg').on('change',function(){
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
    //}
    //reloadJSkegiatan();

    

    var datajsondosen;
    var n=0;
             
            $.ajax(
        {
           url: "<?php echo base_url();?>index.php/Dosen/getDataDosenByFakultas",
           type: "POST",
           data : {nip: n},                   
           success: function (ajaxData)
           {
                datajsondosen = JSON.parse(ajaxData);
            },
            error: function(status)
            {
                
            }
        });


</script>
