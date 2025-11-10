<script type="text/javascript">
    function submitform() {
        var f = document.getElementsByTagName('form')[0];
        if (f.checkValidity()) {
            f.submit();
        } else {
            alert(document.getElementById('example').validationMessage);
        }
    }
</script>
<!--Start Page Content-->
<div id="page-content">
    <div class="row wrapper border-bottom white-bg dashboard-header">
        <div class="col-lg-10">
            <h2>Riwayat Individu Dosen</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url(); ?>">Home</a>
                </li>
                <li class="active">
                    <strong>Riwayat Individu Dosen</strong>
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
                        <h5>Riwayat Individu Dosen</h5>

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
                        <div class="ibox-content">

                            <div class="row">

                                <div class="tabs-container">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#tab-1">Riwayat Terkini</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-2">Golongan</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-3">Pendidikan</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-4">Jabatan Fungsional</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-5">Jabatan Strukural</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                                                <table width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td>Nama</td>
                                                            <td>:</td>
                                                            <td><?php echo $dosen[0]['nama']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>NIP/NIPUS</td>
                                                            <td>:</td>
                                                            <td><?php echo $dosen[0]['nip']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fakultas/Program Studi</td>
                                                            <td>:</td>
                                                            <td><?php echo $dosen[0]['namafakultas'] . " / " . $dosen[0]['namaprodi']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Status PNS/Non PNS</td>
                                                            <td>:</td>
                                                            <td><?php echo $dosen[0]['deskripsi']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Golongan</td>
                                                            <td>:</td>
                                                            <td><?php if (count($golongan) > 0) echo $golongan[0]['nama']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pendidikan Tertinggi</td>
                                                            <td>:</td>
                                                            <td><?php if (count($pendidikan) > 0) echo $pendidikan[0]['singkatan']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jabatan Fungsional</td>
                                                            <td>:</td>
                                                            <td><?php if (count($fungsional)) echo $fungsional[0]['nama']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jabatan Struktural</td>
                                                            <td>:</td>
                                                            <td><?php if (count($struktural)) echo $struktural[0]['nama']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <tab>Deskripsi Jab. Struktural</tab>
                                                            </td>
                                                            <td>:</td>
                                                            <td><?php if (count($struktural)) echo $struktural[0]['deskripsi']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-pane">
                                            <div class="panel-body">
                                                <button type="button" id="add-gol" data-did="<?php echo $dosen[0]['nip']; ?>" class="btn btn-info"><span class="fa fa-plus"></span> Data Baru</button>
                                                <div class="table-responsive">
                                                    <table id='gol-table' class="table table-striped table-bordered table-hover dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-xs-1">No</th>
                                                                <th>TMT</th>
                                                                <th>Golongan</th>
                                                                <th>PPh</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($golongan as $g) {
                                                                echo "<tr class='gradeX'>";
                                                                echo "<td>" . $i . "</td>";
                                                                echo "<td>" . $g['tmt'] . "</td>";
                                                                echo "<td>" . $g['nama'] . "</td>";
                                                                echo "<td>" . $g['pph'] . "</td>";
                                                                echo "<td><a href='#' data-gid = '" . $g['id_riwayat_golongan'] . "' class='btn-edit'><span class='fa fa-edit fa-2x'></span></a> ";
                                                                echo " <a href='#' data-gid = '" . $g['id_riwayat_golongan'] . "' class='btn-hapus'><span class='fa fa-trash fa-2x'></span></a></td>";
                                                                echo "</tr>";
                                                                $i++;
                                                            }
                                                            ?>
                                                            <!--<tr class="gradeX">
                                                            <td>1</td>
                                                            <td>2009-12-01</td>
                                                            <td>III</td>
                                                            <td>0.5</td>
                                                            <td><a href="#"><span class="fa fa-edit"></span></a></td>
                                                            <td><a href="#"><span class="fa fa-trash"></span></a></td>
                                                        </tr>   -->
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>TMT</th>
                                                                <th>Golongan</th>
                                                                <th>PPh</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-3" class="tab-pane">
                                            <div class="panel-body">
                                                <button class="btn btn-info" type="button" id="add-pend" data-did="<?php echo $dosen[0]['id_dosen']; ?>"><span class="fa fa-plus"></span> Data Baru</button>
                                                <div class="table-responsive">
                                                    <table id="study-table" class="table table-striped table-bordered table-hover dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-xs-1">No</th>
                                                                <th>TMT</th>
                                                                <th>Jenjang Pendidikan</th>
                                                                <th>Gelar</th>
                                                                <th>Institusi</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($pendidikan as $p) {
                                                                echo "<tr class='gradeX'>";
                                                                echo "<td>" . $i . "</td>";
                                                                echo "<td>" . $p['tmt'] . "</td>";
                                                                echo "<td>" . $p['singkatan'] . "</td>";
                                                                echo "<td>" . $p['gelar'] . "</td>";
                                                                echo "<td>" . $p['institusi'] . "</td>";
                                                                echo "<td><a href='#' data-pid='" . $p['id_riwayat_pendidikan'] . "' class='btn-edit' ><span class='fa fa-edit fa-2x'></span></a>";
                                                                echo " <a href='#' data-pid='" . $p['id_riwayat_pendidikan'] . "' class='btn-hapus'><span class='fa fa-trash fa-2x'></span></a></td>";
                                                                echo "</tr>";

                                                                $i++;
                                                            }
                                                            ?>
                                                            <!--
                                                        <tr class="gradeX">
                                                            <td>1</td>
                                                            <td>2008-07-01
                                                            </td>
                                                            <td>S2</td>
                                                            <td>M.T</td>
                                                            <td>ITB</td>
                                                            <td><a href="#"><span class="fa fa-edit"></span></a></td>
                                                            <td><a href="#"><span class="fa fa-trash"></span></a></td> 
                                                        </tr>    -->
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>TMT</th>
                                                                <th>Jenjang Pendidikan</th>
                                                                <th>Gelar</th>
                                                                <th>Institusi</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-4" class="tab-pane">
                                            <div class="panel-body">
                                                <button class="btn btn-info" type="button" id="add-fung" data-did="<?php echo $dosen[0]['id_dosen']; ?>"><span class="fa fa-plus"></span> Data Baru</button>
                                                <div class="table-responsive">
                                                    <table id="fungsional-table" class="table table-striped table-bordered table-hover dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-xs-1">No</th>
                                                                <th>TMT</th>
                                                                <th>Jabatan Fungsional</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($fungsional as $f) {
                                                                echo "<tr class='gradeX'>";
                                                                echo "<td>" . $i . "</td>";
                                                                echo "<td>" . $f['tmt'] . "</td>";
                                                                echo "<td>" . $f['nama'] . "</td>";
                                                                echo "<td><a href='#' data-fid='" . $f['id_riwayat_jabatan_fungsional'] . "' class='btn-edit'><span class='fa fa-edit fa-2x'></span></a> ";
                                                                echo " <a href='#' data-fid='" . $f['id_riwayat_jabatan_fungsional'] . "' class='btn-hapus'><span class='fa fa-trash fa-2x'></span></a></td>";
                                                                echo "</tr>";
                                                                $i++;
                                                            }
                                                            ?>
                                                            <!--<tr class="gradeX">
                                                            <td>1</td>
                                                            <td>2015-02-01
                                                            </td>
                                                            <td>Lektor S2</td>
                                                            <td><a href="#"><span class="fa fa-edit"></span></a></td>
                                                            <td><a href="#"><span class="fa fa-trash"></span></a></td> 
                                                        </tr>   
                                                        <tr class="gradeX">
                                                            <td>2</td>
                                                            <td>2011-01-01
                                                            </td>
                                                            <td>Asisten Ahli S2</td>
                                                            <td><a href="#"><span class="fa fa-edit"></span></a></td>
                                                            <td><a href="#"><span class="fa fa-trash"></span></a></td> 
                                                        </tr>-->
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>TMT</th>
                                                                <th>Jabatan Fungsional</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-5" class="tab-pane">
                                            <div class="panel-body">
                                                <button class="btn btn-info" type="button" id="add-struk" data-did="<?php echo $dosen[0]['id_dosen']; ?>"><span class="fa fa-plus"></span> Data Baru</button>
                                                <div class="table-responsive">
                                                    <table id="struktural-table" class="table table-striped table-bordered table-hover dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-xs-1">No</th>
                                                                <th>TMT</th>
                                                                <th>Jabatan Struktural</th>
                                                                <th>Deskripsi</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($struktural as $s) {
                                                                echo "<tr class='gradeX'>";
                                                                echo "<td>" . $i . "</td>";
                                                                echo "<td>" . $s['tmt'] . "</td>";
                                                                echo "<td>" . $s['nama'] . "</td>";
                                                                echo "<td>" . $s['deskripsi'] . "</td>";
                                                                echo "<td><a href='#' class='btn-edit' data-sid='" . $s['id_riwayat_jabatan_struktural'] . "' ><span class='fa fa-edit fa-2x'></span></a>";
                                                                echo " <a href='#' class='btn-hapus' data-sid='" . $s['id_riwayat_jabatan_struktural'] . "' ><span class='fa fa-trash fa-2x'></span></a></td>";
                                                                echo "</tr>";

                                                                $i++;
                                                            }
                                                            ?>
                                                            <!--<tr class="gradeX">
                                                            <td>1</td>
                                                            <td>2015-09-22
                                                            </td>
                                                            <td>Kepala Lab</td>
                                                            <td>Laboratorium Dasar 1B</td>
                                                            <td><a href="#"><span class="fa fa-edit"></span></a></td>
                                                            <td><a href="#"><span class="fa fa-trash"></span></a></td> 
                                                        </tr>   
                                                        <tr class="gradeX">
                                                            <td>2</td>
                                                            <td>2015-01-01
                                                            </td>
                                                            <td>Dosen Tanpa TT</td>
                                                            <td>Dosen Tetap</td>
                                                            <td><a href="#"><span class="fa fa-edit"></span></a></td>
                                                            <td><a href="#"><span class="fa fa-trash"></span></a></td> 
                                                        </tr> -->
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>TMT</th>
                                                                <th>Jabatan Struktural</th>
                                                                <th>Deskripsi</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal inmodal" id="golmodal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-tasks modal-icon"></i>
                                <h4 class="modal-title">Data Golongan Dosen</h4>
                                <small>Tambah Data Golongan Dosen</small>
                            </div>
                            <div class="modal-body">
                                <form id="formEditGol" onsubmit="return false;">
                                    <input type="hidden" id="idDosGol" name="idDosen">
                                    <input type="hidden" id="idRiwayatGolongan" name="idRiwayatGolongan">

                                    <div class="form-group">
                                        <label class="control-label">Golongan</label>
                                        <select class="form-control" id="gola" name="gola" required>
                                            <option>Pilih Golongan</option>
                                            <option value="I">Golongan I</option>
                                            <option value="II">Golongan II</option>
                                            <option value="III">Golongan III</option>
                                            <option value="IV">Golongan IV</option>
                                            <option value="XII">Golongan XII (PPPK)</option>
                                            <option value="X">Golongan X (PPPK)</option>
                                        </select>
                                    </div>

                                    <div id="gol_extend">
                                        <select class="form-control" id="gol" name="gol" readonly></select>
                                    </div>

                                    <br>
                                    <div class="form-group" id="tmtdate">
                                        <label class="control-label">TMT *</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control" name="tmtgol" id="tmtgol" placeholder="yyyy-mm-dd" required>
                                        </div>
                                        <label class="control-label" style="font-size: 12px;"><i>format date : <code>yyyy-mm-dd</code></i></label>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <input type="submit" data-dismiss="modal" id="btn-update-gol" class="btn btn-primary" value="Save">
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- now -->
                <div class="modal inmodal" id="pendmodal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-tasks modal-icon"></i>
                                <h4 class="modal-title">Data Pendidikan Dosen</h4>
                                <small>Tambah Riwayat Pendidikan Dosen</small>
                            </div>
                            <div class="modal-body">
                                <form id="formEditPend" onsubmit="return false;">
                                    <input type="hidden" id="idDosPend" name="idDosen">
                                    <input type="hidden" id="idRiwayatPendidikan" name="idRiwayatPendidikan">
                                    <div class="form-group">
                                        <label class="control-label">Jenjang Pendidikan</label>
                                        <select class="form-control" id="jenjang" name="jenjang">
                                            <option value="0">Diploma III (D3)</option>
                                            <option value="1">Strata 1 (S1)</option>
                                            <option value="2">Strata 2 (S2)</option>
                                            <option value="3">Strata 3 (S3)</option>
                                            <option value="4">Profesional (Profesional)</option>
                                            <option value="5">Spesialis (Spesialis)</option>
                                            <option value="6">Sub Spesialis (Sub Spesialis)</option>
                                            <option value="8">MPK (MPK)</option>
                                            <option value="9">Rektorat (Rektorat)</option>
                                        </select>

                                    </div>
                                    <div class="form-group" id="tmtdate">
                                        <label class="control-label">TMT *</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control" id="tmtpend" name="tmtpend" placeholder="yyyy-mm-dd" required>
                                        </div>
                                        <label class="control-label" style="font-size: 12px;"><i>format date : <code>yyyy-mm-dd</code></i></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Gelar *</label>
                                        <input class="form-control" type="text" id="gelar" name="gelar" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Institusi *</label>
                                        <input type="text" class="form-control" id="institusi" name="institusi" required>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button type="submit" id="btn-update-pend" data-dismiss="modal" class="btn btn-primary">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal inmodal" id="fungmodal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-tasks modal-icon"></i>
                                <h4 class="modal-title">Jabatan Fungsional Dosen</h4>
                                <small>Tambah Riwayat Jabatan Fungsional Dosen</small>
                            </div>

                            <form id="formEditFung" onsubmit="return false;">
                                <div class="modal-body">
                                    <input type="hidden" id="idDosFung" name="idDosen">
                                    <input type="hidden" id="idRiwayatFungsional" name="idRiwayatFungsional">
                                    <div class="form-group">
                                        <label class="control-label">Jabatan Fungsional</label>
                                        <select class="form-control" id="fungsional" name="fungsional">
                                            <?php
                                            foreach ($lFungsional as $dFungsional) {
                                                echo '<option value="' . $dFungsional['id_jabatan_fungsional'] . '">' . $dFungsional['nama'] . ' :: (Grade : ' . $dFungsional['grade'] . ')</option>';
                                            }
                                            ?>
                                            <!--<option value="0">*: Pilih Jabatan Fungsional Dosen</option>
                                                    <option value="1">1: Guru Besar </option>
                                                    <option value="2">2: Lektor Kepala S3</option>
                                                    <option value="3">3: Lektor Kepala S2</option>
                                                    <option value="4">4: Lektor Kepala S1</option>
                                                    <option value="5">5: Lektor S3</option>
                                                    <option value="6">6: Lektor S2</option>
                                                    <option value="7">7: Lektor S1</option>
                                                    <option value="8">8: Asisten Ahli S3</option>
                                                    <option value="9">9: Asisten Ahli S2</option>
                                                    <option value="10">10: Asisten Ahli S1</option>
                                                    <option value="11">11: Tenaga Pengajar</option>-->
                                        </select>
                                    </div>
                                    <div class="form-group" id="tmtdate">
                                        <label class="control-label">TMT *</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control" name="tmtfung" id="tmtfung" placeholder="yyyy-mm-dd" required>
                                        </div>
                                        <label class="control-label" style="font-size: 12px;"><i>format date : <code>yyyy-mm-dd</code></i></label>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" id="btn-update-fung" data-dismiss="modal" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal inmodal" id="strukmodal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-tasks modal-icon"></i>
                                <h4 class="modal-title">Jabatan Struktural Dosen</h4>
                                <small>Tambah Riwayat Jabatan Struktural Dosen</small>
                            </div>

                            <form id="formEditStruk" onsubmit="return false;">
                                <div class="modal-body">
                                    <input type="hidden" id="idDosStruk" name="idDosen">
                                    <input type="hidden" id="idRiwayatStruktural" name="idRiwayatStruktural">
                                    <div class="form-group">
                                        <label class="control-label">Jabatan Struktural</label>
                                        <select class="form-control" name="struktural" id="struktural">
                                            <?php
                                            foreach ($jabatan_struktural as $row) {
                                                echo "<option value='" . $row['id_jabatan_struktural'] . "'>" . $row['nama'] . "</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="form-group" id="tmtdate">
                                        <label class="control-label">TMT *</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control" name="tmtstruk" id="tmtstruk" placeholder="yyyy-mm-dd" required>
                                        </div>
                                        <label class="control-label" style="font-size: 12px;"><i>format date : <code>yyyy-mm-dd</code></i></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Deskripsi</label>
                                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" data-dismiss="modal" id="btn-update-struk" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal inmodal" id="HapusConfirm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated fadeIn">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-tasks modal-icon"></i>
                                <h4 class="modal-title">Konfirmasi Hapus</h4>
                                <small>Konfirmasi Hapus Data Dosen</small>
                            </div>
                            <form id="formHapus" onsubmit="return false;">
                                <div class="modal-body">
                                    <input type="hidden" id="idDos" name="idDos">
                                    <input type="hidden" id="idRiwayat" name="idRiwayat">
                                    <input type="hidden" id="jenisHapus" name="jenisHapus">
                                    <input type="hidden" id="rowtable" name="rowtable">
                                    <div class="form-group">
                                        <p>Data ini akan dihapus secara permanen</p>
                                        <p>Apakah anda yakin ?</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" data-dismiss="modal" id="btn-hapus" class="btn btn-danger">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


            <!--End of Page Content-->

            <script type="text/javascript">
                var golTable;
                $(document).ready(function() {
                    golTable = $('#gol-table').DataTable();
                    studyTable = $('#study-table').DataTable();
                    fungsionalTable = $('#fungsional-table').DataTable();
                    strukturalTable = $('#struktural-table').DataTable();
                });
            </script>

            <script>
                $('#gol-table').on('click', '.btn-edit', function() {
                    var n = $(this).data('gid');
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Riwayat/getGolonganIndividubByIDRiwayat",
                        type: "GET",
                        data: {
                            idRiwayatGolongan: n
                        },
                        success: function(ajaxData) {
                            var result = JSON.parse(ajaxData);
                            //$('#prodi-edit option:selected').removeAttr('selected');
                            //$('#status-edit option:selected').removeAttr('selected');


                            $("#gol").val(result[0]['id_golongan']);
                            $("#tmtgol").val(result[0]['tmt']);
                            $("#idRiwayatGolongan").val(result[0]['id_riwayat_golongan']);
                            $("#idDosGol").val('');

                            $('#golmodal').modal('show');
                        }
                    });
                });

                $('#add-gol').click(function() {
                    var n = $(this).data('did');

                    $("#idDosGol").val(n);
                    $("#idRiwayatGolongan").val('');
                    $('#golmodal').modal('show');



                })
                //fungsi get golongan

                function getGolonganTurunan(kode_golongan) {

                    var golongan = "";
                    var opt = "";
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/MainControler/getGolonganTurunan",
                        type: "GET",
                        data: {
                            kode: kode_golongan
                        },
                        success: function(ajaxData) {
                            golongan = JSON.parse(ajaxData);

                            opt = opt + "<option value=''>Pilih Golongan</option>";
                            for (i = 0; i < golongan.length; i++) {
                                opt = opt + "<option value='" + golongan[i]['id_golongan'] + "'>" + golongan[i]['nama'] + "</option>";
                            }

                            var golextend = ' <div class="form-group"><div class="input-group col-md-12"><select class="form-control" type="text" id = "gol" name="gol" required>' + opt + '</select>';
                            //console.log(golextend);

                            $('#gol_extend').append(golextend);
                            //reloadJSkegiatan();                         



                        },
                        error: function(status) {

                        }
                    });
                }

                //batas

                $('#gola').on('change', function() {
                    var kode_golongan = $('#gola').val();
                    $('#gol_extend').html('');

                    getGolonganTurunan(kode_golongan);

                });



                $('#btn-update-gol').click(function() {

                    //$('#editModalGol').modal('hide');
                    var updateData = $("#formEditGol").serialize();
                    var idDosen = $('input#idDosGol', '#formEditGol').val();
                    var gol = document.getElementById("gol").value;
                    var gola = document.getElementById("gola").value;
                    var tmtgol = document.getElementById("tmtgol").value;
                    var pattern = /^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/;

                    if (!!gol && !!gola && pattern.test(tmtgol)) {

                        if (idDosen == "") {

                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/Riwayat/updateGolonganIndividu",
                                type: "POST",
                                data: updateData,
                                success: function(data, status, xhr) {

                                    $.notify({
                                        title: "<strong>Update Data Dosen </strong> ",
                                        message: "Success"
                                    }, {
                                        type: 'success',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                    setTimeout(function() {
                                        window.location.reload(1);
                                    }, 2000);

                                },
                                error: function(jqXHR, status, errorThrown) {
                                    //if fail show error and server status

                                    $.notify({
                                        title: "<strong>Update Data Dosen</strong> ",
                                        message: "Failed"
                                    }, {
                                        type: 'danger',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                }
                            });

                        } else {
                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/Riwayat/addGolonganIndividu",
                                type: "POST",
                                data: updateData,
                                success: function(data) {
                                    //if success then just output the text to the status div then clear the form inputs to prepare for new data


                                    $.notify({
                                        title: "<strong>Add Data Dosen </strong> ",
                                        message: "Success"
                                    }, {
                                        type: 'success',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                    setTimeout(function() {
                                        window.location.reload(1);
                                    }, 2000);

                                },
                                error: function(jqXHR, status, errorThrown) {
                                    //if fail show error and server status

                                    $.notify({
                                        title: "<strong>Add Data Dosen</strong> ",
                                        message: "Failed"
                                    }, {
                                        type: 'danger',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                }
                            });
                        }

                    } else {

                        $.notify({
                            message: "Failed",
                            title: "<strong>Lengkapi Data Kosong dan Perhatikan Format Tanggal</strong> "
                        }, {
                            type: 'danger',
                            delay: 7000,
                            placement: {
                                from: "top",
                                align: "center"
                            }
                        });
                    }
                })

                $('#gol-table').on('click', '.btn-hapus', function() {

                    var n = $(this).data('gid');
                    var r = golTable.row($(this).parents('tr')).index();

                    $("#idRiwayat").val(n);
                    $("#jenisHapus").val("golongan");
                    $("#rowtable").val(r);
                    $('#HapusConfirm').modal('show');


                });
            </script>

            <!---------------------Pendidikan Table Javascript--------------------- -->
            <script>
                $('#study-table').on('click', '.btn-edit', function() {

                    var n = $(this).data('pid');

                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Riwayat/getPendidikanIndividubByIDRiwayat",
                        type: "GET",
                        data: {
                            idRiwayatPendidikan: n
                        },
                        success: function(ajaxData) {
                            var result = JSON.parse(ajaxData);
                            //$('#prodi-edit option:selected').removeAttr('selected');
                            //$('#status-edit option:selected').removeAttr('selected');


                            $("#idDosPend").val('');
                            $("#jenjang").val(result[0]['id_jenjang_pendidikan']);
                            $("#tmtpend").val(result[0]['tmt']);
                            $("#idRiwayatPendidikan").val(result[0]['id_riwayat_pendidikan']);
                            $("#gelar").val(result[0]['gelar']);
                            $("#institusi").val(result[0]['institusi']);

                            $('#pendmodal').modal('show');
                        }
                    });


                });

                $('#add-pend').click(function() {
                    var n = $(this).data('did');

                    $("#idDosPend").val(n);
                    $("#idRiwayatPendidikan").val('');
                    $('#pendmodal').modal('show');

                })

                $('#btn-update-pend').click(function() {

                    //$('#editModalGol').modal('hide');
                    var updateData = $("#formEditPend").serialize();
                    var idDosen = $('input#idDosPend', '#formEditPend').val();
                    var gelar = document.getElementById("gelar").value;
                    var tmtpend = document.getElementById("tmtpend").value;
                    var institusi = document.getElementById("institusi").value;
                    var pattern = /^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/;

                    if (!!gelar && pattern.test(tmtpend) && !!institusi) {

                        if (idDosen == "") {

                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/Riwayat/updatePendidikanIndividu",
                                type: "POST",
                                data: updateData,
                                success: function(data, status, xhr) {

                                    $.notify({
                                        title: "<strong>Update Data Pendidikan Dosen</strong> ",
                                        message: "Success"
                                    }, {
                                        type: 'success',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });

                                    setTimeout(function() {
                                        window.location.reload(1);
                                    }, 2000);

                                },
                                error: function(jqXHR, status, errorThrown) {
                                    //if fail show error and server status

                                    $.notify({
                                        title: "<strong>Update Data Pendidikan Dosen</strong> ",
                                        message: "Failed"
                                    }, {
                                        type: 'danger',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                }
                            });

                        } else {

                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/Riwayat/addPendidikanIndividu",
                                type: "POST",
                                data: updateData,
                                success: function(data) {
                                    //if success then just output the text to the status div then clear the form inputs to prepare for new data


                                    $.notify({
                                        title: "<strong>Add Data Dosen </strong> ",
                                        message: "Success"
                                    }, {
                                        type: 'success',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                    setTimeout(function() {
                                        window.location.reload(1);
                                    }, 2000);

                                },
                                error: function(jqXHR, status, errorThrown) {
                                    //if fail show error and server status

                                    $.notify({
                                        title: "<strong>Add Data Dosen</strong> ",
                                        message: "Failed"
                                    }, {
                                        type: 'danger',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                }
                            });
                        }

                    } else {

                        $.notify({
                            message: "Failed",
                            title: "<strong>Lengkapi Data Kosong dan Perhatikan Format Tanggal</strong> "
                        }, {
                            type: 'danger',
                            delay: 7000,
                            placement: {
                                from: "top",
                                align: "center"
                            }
                        });
                    }
                })

                $('#study-table').on('click', '.btn-hapus', function() {

                    var n = $(this).data('pid');
                    var r = studyTable.row($(this).parents('tr')).index();

                    $("#idRiwayat").val(n);
                    $("#jenisHapus").val("pendidikan");
                    $("#rowtable").val(r);
                    $('#HapusConfirm').modal('show');


                });
            </script>

            <!---------------------Jabatan Fungsional Table Javascript--------------------- -->
            <script>
                $('#fungsional-table').on('click', '.btn-edit', function() {

                    var n = $(this).data('fid');

                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Riwayat/getFungsionalIndividubByIDRiwayat",
                        type: "GET",
                        data: {
                            idRiwayatFungsional: n
                        },
                        success: function(ajaxData) {
                            var result = JSON.parse(ajaxData);
                            //$('#prodi-edit option:selected').removeAttr('selected');
                            //$('#status-edit option:selected').removeAttr('selected');


                            $("#idDosFung").val('');
                            $("#fungsional").val(result[0]['id_jabatan_fungsional']);
                            $("#tmtfung").val(result[0]['tmt']);
                            $("#idRiwayatFungsional").val(result[0]['id_riwayat_jabatan_fungsional']);

                            $('#fungmodal').modal('show');
                        }
                    });


                });

                $('#add-fung').click(function() {
                    var n = $(this).data('did');

                    $("#idDosFung").val(n);
                    $("#idRiwayatFungsional").val('');
                    $('#fungmodal').modal('show');

                })

                $('#btn-update-fung').click(function() {

                    //$('#editModalGol').modal('hide');
                    var updateData = $("#formEditFung").serialize();
                    var idDosen = $('input#idDosFung', '#formEditFung').val();
                    var fungsional = document.getElementById("fungsional").value;
                    var tmtfung = document.getElementById("tmtfung").value;
                    var pattern = /^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/;

                    if (pattern.test(tmtfung) && !!fungsional) {
                        if (idDosen == "") {

                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/Riwayat/updateFungsionalIndividu",
                                type: "POST",
                                data: updateData,
                                success: function(data, status, xhr) {

                                    $.notify({
                                        title: "<strong>Update Data Jabatan Fungsional Dosen</strong> ",
                                        message: "Success"
                                    }, {
                                        type: 'success',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                    setTimeout(function() {
                                        window.location.reload(1);
                                    }, 2000);
                                },
                                error: function(jqXHR, status, errorThrown) {
                                    //if fail show error and server status

                                    $.notify({
                                        title: "<strong>Update Data Jabatan Fungsional Dosen</strong> ",
                                        message: "Failed"
                                    }, {
                                        type: 'danger',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                }
                            });

                        } else {

                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/Riwayat/addFungsionalIndividu",
                                type: "POST",
                                data: updateData,
                                success: function(data) {
                                    //if success then just output the text to the status div then clear the form inputs to prepare for new data


                                    $.notify({
                                        title: "<strong>Add Data Jabatan Fungsional Dosen </strong> ",
                                        message: "Success"
                                    }, {
                                        type: 'success',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                    setTimeout(function() {
                                        window.location.reload(1);
                                    }, 2000);
                                },
                                error: function(jqXHR, status, errorThrown) {
                                    //if fail show error and server status

                                    $.notify({
                                        title: "<strong>Add Data Jabatan Fungsional Dosen</strong> ",
                                        message: "Failed"
                                    }, {
                                        type: 'danger',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                }
                            });
                        }

                    } else {

                        $.notify({
                            message: "Failed",
                            title: "<strong>Lengkapi Data Kosong dan Perhatikan Format Tanggal</strong> "
                        }, {
                            type: 'danger',
                            delay: 7000,
                            placement: {
                                from: "top",
                                align: "center"
                            }
                        });
                    }
                })

                $('#fungsional-table').on('click', '.btn-hapus', function() {

                    var n = $(this).data('fid');
                    var r = fungsionalTable.row($(this).parents('tr')).index();

                    $("#idRiwayat").val(n);
                    $("#jenisHapus").val("fungsional");
                    $("#rowtable").val(r);
                    $('#HapusConfirm').modal('show');


                });
            </script>

            <!---------------------Jabatan Struktural Table Javascript--------------------- -->
            <script>
                $('#struktural-table').on('click', '.btn-edit', function() {

                    var n = $(this).data('sid');

                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/Riwayat/getStrukturalIndividubByIDRiwayat",
                        type: "GET",
                        data: {
                            idRiwayatStruktural: n
                        },
                        success: function(ajaxData) {
                            var result = JSON.parse(ajaxData);
                            //$('#prodi-edit option:selected').removeAttr('selected');
                            //$('#status-edit option:selected').removeAttr('selected');
                            $("#idDosStruk").val('');
                            $("#struktural").val(result[0]['id_jabatan_struktural']);
                            $("#tmtstruk").val(result[0]['tmt']);
                            $("#deskripsi").val(result[0]['deskripsi']);
                            $("#idRiwayatStruktural").val(result[0]['id_riwayat_jabatan_struktural']);

                            $('#strukmodal').modal('show');
                        }
                    });


                });

                $('#add-struk').click(function() {
                    var n = $(this).data('did');
                    $("#idDosStruk").val(n);
                    $("#idRiwayatStruktural").val('');
                    $('#strukmodal').modal('show');


                })

                $('#btn-update-struk').click(function() {

                    //$('#editModalGol').modal('hide');
                    var updateData = $("#formEditStruk").serialize();
                    var idDosen = $('input#idDosStruk', '#formEditStruk').val();
                    var struktural = document.getElementById("struktural").value;
                    var tmtstruk = document.getElementById("tmtstruk").value;
                    var deskripsi = document.getElementById("deskripsi").value;

                    if (!!struktural && !!tmtstruk) {

                        if (idDosen == "") {

                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/Riwayat/updateStrukturalIndividu",
                                type: "POST",
                                data: updateData,
                                success: function(data, status, xhr) {
                                    //if success then just output the text to the status div then clear the form inputs to prepare for new data


                                    $.notify({
                                        title: "<strong>Update Data Jabatan Struktural Dosen</strong> ",
                                        message: "Success"
                                    }, {
                                        type: 'success',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                    setTimeout(function() {
                                        window.location.reload(1);
                                    }, 2000);

                                },
                                error: function(jqXHR, status, errorThrown) {
                                    //if fail show error and server status

                                    $.notify({
                                        title: "<strong>Update Data Jabatan Struktural Dosen</strong> ",
                                        message: "Failed"
                                    }, {
                                        type: 'danger',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                }
                            });

                        } else {

                            $.ajax({
                                url: "<?php echo base_url(); ?>index.php/Riwayat/addStrukturalIndividu",
                                type: "POST",
                                data: updateData,
                                success: function(data) {

                                    $.notify({
                                        title: "<strong>Add Data Jabatan Struktural Dosen </strong> ",
                                        message: "Success"
                                    }, {
                                        type: 'success',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                    setTimeout(function() {
                                        window.location.reload(1);
                                    }, 2000);

                                },
                                error: function(jqXHR, status, errorThrown) {
                                    //if fail show error and server status

                                    $.notify({
                                        title: "<strong>Add Data Jabatan Struktural Dosen</strong> ",
                                        message: "Failed"
                                    }, {
                                        type: 'danger',
                                        delay: 3000,
                                        placement: {
                                            from: "top",
                                            align: "center"
                                        }
                                    });
                                }
                            });
                        }

                    } else {

                        $.notify({
                            message: "Failed",
                            title: "<strong>Lengkapi Data Kosong dan Perhatikan Format Tanggal</strong> "
                        }, {
                            type: 'danger',
                            delay: 7000,
                            placement: {
                                from: "top",
                                align: "center"
                            }
                        });
                    }
                })

                $('#struktural-table').on('click', '.btn-hapus', function() {

                    var n = $(this).data('sid');
                    var r = strukturalTable.row($(this).parents('tr')).index();

                    $("#idRiwayat").val(n);
                    $("#jenisHapus").val("struktural");
                    $("#rowtable").val(r);
                    $('#HapusConfirm').modal('show');


                });
            </script>





            <!--------------------------------------------- Konfirmasi Hapus ------------------------------------------- -->
            <script>
                $('#btn-hapus').click(function() {

                    var hapusData = $("#formHapus").serialize();
                    var jenis = $('input#jenisHapus').val();
                    var row = $('input#rowtable').val();
                    if (jenis == "golongan") {

                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/Riwayat/deleteGolonganIndividu",
                            type: "POST",
                            data: hapusData,
                            success: function(data, status, xhr) {
                                //if success then just output the text to the status div then clear the form inputs to prepare for new data


                                $.notify({
                                    title: "<strong>Delete Golongan</strong> ",
                                    message: "Success"
                                }, {
                                    type: 'success',
                                    delay: 3000,
                                    placement: {
                                        from: "top",
                                        align: "center"
                                    }
                                });

                                golTable.row(row).remove().draw();


                            },
                            error: function(jqXHR, status, errorThrown) {
                                //if fail show error and server status

                                $.notify({
                                    title: "<strong>Delete Golongan</strong> ",
                                    message: "Failed"
                                }, {
                                    type: 'danger',
                                    delay: 3000,
                                    placement: {
                                        from: "top",
                                        align: "center"
                                    }
                                });
                            }
                        });
                    } else if (jenis == "pendidikan") {

                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/Riwayat/deletePendidikanIndividu",
                            type: "POST",
                            data: hapusData,
                            success: function(data, status, xhr) {
                                //if success then just output the text to the status div then clear the form inputs to prepare for new data


                                $.notify({
                                    title: "<strong>Delete Pendidikan</strong> ",
                                    message: "Success"
                                }, {
                                    type: 'success',
                                    delay: 3000,
                                    placement: {
                                        from: "top",
                                        align: "center"
                                    }
                                });

                                studyTable.row(row).remove().draw();


                            },
                            error: function(jqXHR, status, errorThrown) {
                                //if fail show error and server status

                                $.notify({
                                    title: "<strong>Delete Pendidikan</strong> ",
                                    message: "Failed"
                                }, {
                                    type: 'danger',
                                    delay: 3000,
                                    placement: {
                                        from: "top",
                                        align: "center"
                                    }
                                });
                            }
                        });
                    } else if (jenis == "fungsional") {

                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/Riwayat/deleteFungsionalIndividu",
                            type: "POST",
                            data: hapusData,
                            success: function(data, status, xhr) {
                                //if success then just output the text to the status div then clear the form inputs to prepare for new data


                                $.notify({
                                    title: "<strong>Delete Riwayat Jabatan Fungsional</strong> ",
                                    message: "Success"
                                }, {
                                    type: 'success',
                                    delay: 3000,
                                    placement: {
                                        from: "top",
                                        align: "center"
                                    }
                                });

                                fungsionalTable.row(row).remove().draw();


                            },
                            error: function(jqXHR, status, errorThrown) {
                                //if fail show error and server status

                                $.notify({
                                    title: "<strong>Delete Riwayat Jabatan Fungsional</strong> ",
                                    message: "Failed"
                                }, {
                                    type: 'danger',
                                    delay: 3000,
                                    placement: {
                                        from: "top",
                                        align: "center"
                                    }
                                });
                            }
                        });
                    } else if (jenis == "struktural") {

                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php/Riwayat/deleteStrukturalIndividu",
                            type: "POST",
                            data: hapusData,
                            success: function(data, status, xhr) {
                                //if success then just output the text to the status div then clear the form inputs to prepare for new data


                                $.notify({
                                    title: "<strong>Delete Riwayat Jabatan Struktural</strong> ",
                                    message: "Success"
                                }, {
                                    type: 'success',
                                    delay: 3000,
                                    placement: {
                                        from: "top",
                                        align: "center"
                                    }
                                });

                                strukturalTable.row(row).remove().draw();


                            },
                            error: function(jqXHR, status, errorThrown) {
                                //if fail show error and server status

                                $.notify({
                                    title: "<strong>Delete Riwayat Jabatan Struktural</strong> ",
                                    message: "Failed"
                                }, {
                                    type: 'danger',
                                    delay: 3000,
                                    placement: {
                                        from: "top",
                                        align: "center"
                                    }
                                });
                            }
                        });
                    }

                });
            </script>