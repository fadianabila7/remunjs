    <div id="page-content">
        <div class="right_col" role="main">
            <div class="row wrapper border-bottom white-bg dashboard-header">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Tambah Mata Kuliah</h3>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <h2>Form Tambah Mata Kuliah</h2>

                            <div class="x_content">

                                <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('pengajaran/do_insertmatakuliah')?>">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Kode Mata Kuliah</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="namLab" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="kode_matkul" id="kode_matkul" placeholder="Id Mata Kuliah" required="required" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Mata Kuliah</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="namaMatkul" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="namaMatkul" id="namaMatkul" placeholder="Nama Mata Kuliah" required="required" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah SKS</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <input id="sks" class="form-control col-md-7 col-xs-12" name="sks" id="sks" placeholder="" min="0" max="10" required="required" type="number" onfocusout="FunctionChekSKS()">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Kurikulum</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <input type="number" name="tahunkurikulum" class="form-control" min="2000" max="2200" required>

                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kondisi">Status
                                          <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_single form-control" tabindex="-1" name="status" id="status">
                                              <option value="1">Aktif</option>
                                              <option value="0">Tidak AKtif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="button" class="btn btn-primary" id="cancel" onclick="window.history.go(-1); return false;" name="cancel">Cancel</button>
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
    </div>
    <script type="text/javascript">
        $('#cancel').on('click', function() {
            window.location.href = '<?php echo site_url("pengajaran/EntryMataKuliah");?>';
        });

        function FunctionChekSKS() {
            var a = $("#sks").val();
            if (a < 1 || a > 10) {
                swal({title: "Peringatan",text: "Jumlah SKS Harus 0 < SKS < 10."});
                $("#sks").val("1");
                $("#sks").html("1");
            }
        }
    </script>