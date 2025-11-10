
        <!--Start Page Content-->
        <div id="page-content">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="col-lg-10">
                    <h2>Daftar Dosen</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url();?>">Home</a>
                        </li>
                        <li class="active">
                            <strong>Daftar Admin</strong>
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
                                    <h5>Daftar Admin</h5>
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
                                                    <div class="col-md-3">
                                                        <select class="form-control m-b" name="fakultas" id="fakultas">
                                                            <option value='0'>Pilih Fakultas</option>
                                                            <?php
                                                                foreach ($fakultas as $d) {
                                                                    echo "<option value='".$d['id_fakultas']."''>Fakultas ".$d['nama']." (".$d['singkatan'].")</option>";
                                                                }
                                                            ?>                                               
                                                        </select>                                            
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="submit" class="ladda-button ladda-button-load btn btn-info btnsubmit" data-style="expand-right" id="btn-submit" ><span class="fa fa-search"></span>Tampilkan</button>
                                                        <!-- <button class="btn btn-info" id="btn-export" onclick="ExportDataDosen();"><span class="fa fa-file-excel-o"></span>Export</button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </form> 
                                    </div>
                                    <div class="ibox-content">
                                        <div class="table-responsive">
                                            <form action="#" method="post">
                                                <table id='datatables' class="table table-striped table-bordered table-hover display dataTables-example" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" width="1%">No</th>
                                                            <th rowspan="2">ID Dosen</th>                                        
                                                            <th rowspan="2">Dosen</th>                                        
                                                            <th colspan="2">Bulan 1 - 6</th>
                                                            <th colspan="2">Bulan 7</th>
                                                            <th colspan="2">Bulan 8</th>
                                                            <th colspan="2">Bulan 9</th>
                                                            <th colspan="2">Bulan 10</th>
                                                            <th colspan="2">Bulan 11</th>
                                                            <th colspan="2">Bulan 12</th>
                                                            <th width="3%">Action</th>
                                                        </tr>
                                                        <tr>
                                                            <th>sksr</th>
                                                            <th>sisa</th>
                                                            <!-- <th>#</th> -->
                                                            <th>sksr</th>
                                                            <th>sisa</th>
                                                            <!-- <th>#</th> -->
                                                            <th>sksr</th>
                                                            <th>sisa</th>
                                                            <!-- <th>#</th> -->
                                                            <th>sksr</th>
                                                            <th>sisa</th>
                                                            <!-- <th>#</th> -->
                                                            <th>sksr</th>
                                                            <th>sisa</th>
                                                            <!-- <th>#</th> -->
                                                            <th>sksr</th>
                                                            <th>sisa</th>
                                                            <!-- <th>#</th> -->
                                                            <th>sksr</th>
                                                            <th>sisa</th>
                                                            <!-- <th>#</th> -->
                                                            <th><input type="checkbox" onclick="toggle(this);" checked="checked" /></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body">                        
                                                    </tbody>
                                                </table>
                                                <button type="button" class="btn btn-info" onclick="xxx();"> Update </button>
                                            </form> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
            
        <!--End of Page Content-->
        <script>
            function toggle(source) {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i] != source)
                        checkboxes[i].checked = source.checked;
                }
            }
            var t = $('.ladda-button-load').ladda();
            var table = $("#datatables").DataTable(
                    {"pageLength": 200,"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 200]]}
                );
            t.click(function(){
                var e = document.getElementById("fakultas");
                var d = e.options[e.selectedIndex].value;
                table.clear().draw();
                if(d>0){
                    t.ladda('start');
                    $.ajax({
                        url: "<?php echo base_url();?>index.php/TambahanController/getallsksr16",
                        type: "POST",
                        data : { data:d},
                        success: function(ajaxData){
                            table.clear().draw();
                            var result = JSON.parse(ajaxData);
                            for(var i=0; i<result.length; i++){
                                sisa6 = (result[i][0]['jum'] > result[i][5])? result[i][0]['jum']-result[i][5] : 0;
                                sisa6 = Math.max(0, sisa6);
                                calc7 = ((eval(result[i][1][0]['jum'])+eval(sisa6))-5);
                                sisa7 = (calc7>0)?calc7:0;
                                calc8 = ((eval(result[i][2][0]['jum'])+eval(sisa7))-5);
                                sisa8 = (calc8>0)?calc8:0;
                                calc9 = ((eval(result[i][3][0]['jum'])+eval(sisa8))-5);
                                sisa9 = (calc9>0)?calc9:0;

                                calc10 = ((eval(result[i][6][0]['jum'])+eval(sisa9))-5);
                                sisa10 = (calc10>0)?calc10:0;

                                calc11 = ((eval(result[i][7][0]['jum'])+eval(sisa10))-5);
                                sisa11 = (calc11>0)?calc11:0;

                                calc12 = ((eval(result[i][8][0]['jum'])+eval(sisa11))-5);
                                sisa12 = (calc12>0)?calc12:0;
                                send = result[i][0]['id_dosen']+'ff'+sisa6+'ff'+sisa7+'ff'+sisa8+'ff'+sisa9+'ff'+sisa10+'ff'+sisa11+'ff'+sisa12;
                                checkbox = '<input type="checkbox" name="type" checked value="'+send+'">';


                                table.row.add( [
                                    i+1,
                                    result[i][0]['id_dosen'],
                                    result[i][9],
                                    parseFloat(result[i][0]['jum']).toFixed(2),
                                    parseFloat(result[i][4][0]['sksr_sisa']).toFixed(2),
                                    // ((result[i][4][0]['sksr_sisa']==sisa6)? sisa6.toFixed(2) : "<b style='color:#ff0000'>"+sisa6.toFixed(2)+"</b>"),

                                    parseFloat(result[i][1][0]['jum']).toFixed(2),
                                    parseFloat(result[i][1][0]['sksr_sisa']).toFixed(2),
                                    // ((result[i][1][0]['sksr_sisa']==sisa7)? sisa7.toFixed(2) : "<b style='color:#ff0000'>"+sisa7.toFixed(2)+"</b>"),

                                    parseFloat(result[i][2][0]['jum']).toFixed(2),
                                    parseFloat(result[i][2][0]['sksr_sisa']).toFixed(2),
                                    // ((result[i][2][0]['sksr_sisa']==sisa8)? sisa8.toFixed(2) : "<b style='color:#ff0000'>"+sisa8.toFixed(2)+"</b>"),

                                    parseFloat(result[i][3][0]['jum']).toFixed(2),
                                    parseFloat(result[i][3][0]['sksr_sisa']).toFixed(2),
                                    // ((result[i][3][0]['sksr_sisa']==sisa9)? sisa9.toFixed(2) : "<b style='color:#ff0000'>"+sisa9.toFixed(2)+"</b>"),

                                    parseFloat(result[i][6][0]['jum']).toFixed(2),
                                    parseFloat(result[i][6][0]['sksr_sisa']).toFixed(2),
                                    // ((result[i][6][0]['sksr_sisa']==sisa10)? sisa10.toFixed(2) : "<b style='color:#ff0000'>"+sisa10.toFixed(2)+"</b>"),

                                    parseFloat(result[i][7][0]['jum']).toFixed(2),
                                    parseFloat(result[i][7][0]['sksr_sisa']).toFixed(2),
                                    // ((result[i][7][0]['sksr_sisa']==sisa11)? sisa11.toFixed(2) : "<b style='color:#ff0000'>"+sisa11.toFixed(2)+"</b>"),

                                    parseFloat(result[i][8][0]['jum']).toFixed(2),
                                    parseFloat(result[i][8][0]['sksr_sisa']).toFixed(2),
                                    // ((result[i][8][0]['sksr_sisa']==sisa12)? sisa12.toFixed(2) : "<b style='color:#ff0000'>"+sisa12.toFixed(2)+"</b>"),
                                    checkbox,
                                ]).draw();
                            }
                            
                        }
                    });
                    setTimeout(function(){ t.ladda('stop'); },3000);
                }
            });
            
            function xxx(){
                var yourArray = $("input:checkbox[name=type]:checked").map(function(){return $(this).val()}).get();
                console.log(yourArray);
            }
        </script>