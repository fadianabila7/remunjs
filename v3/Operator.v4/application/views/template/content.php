 <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Halaman Operator</h2>
        <ol class="breadcrumb">
            <li class="active">
                <strong onClick="buka()">Dashboards</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<!--     <div class="row">
        <div class="col-md-12">
            <div class="widget style1 red-bg" style="font-size:16px;">
                Terkait dengan ada perubahan yang tidak konsisten kami mohon maaf.<br>
                Kegiatan dibawah di input setiap bulannya agar mempermudah dosen mengetahui sksr kegiatannya perbulan.
                <ul style="margin:0px;">
                    <li style="font-size:16px;"><u>Menyusun paket kurikulm (Silabus, RPP, GBPP)</u> di input 6X setiap semesternya.</li>
                    <li style="font-size:16px;"><u>Menyusun buku, blok, pedoman praktikum dll</u> di input 6X setiap semesternya.</li>
                </ul>
                
            </div>
        </div>
    </div> -->
    <div class="row">
        <a href="<?php echo site_url('Pengajaran')?>">    
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-graduation-cap fa-4x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <h2 class="font-bold">Bidang <br>Pengajaran</h2>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="<?php echo site_url('Penelitian')?>">   
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget style1 blue-bg">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-flask fa-4x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                          <h2 class="font-bold">Bidang Penelitian & Pengabdian</h2>
                        </div>
                    </div>
                </div>
            </div>
        </a>     
    </div>

</div>

<div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onClick="tutup()">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Pemberitahuan</h4>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Pada bagian <strong>Pengajaran</strong> proses <u>edit</u> dan <u>delete</u> sudah bisa digunakan.</li>
                    <li>Dan melanjutkan surat yang telah dikirimkan oleh rektorat, mohon untuk mengingatkan <b>Ketua Jurusan</b> untuk validasi setiap kegiatan dosen perbulannya secara berurutan.</li>
                </ul>
                <p align="center">Mohon maaf atas keterlambatannya.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal" onClick="tutup()">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function(){
    //     $('#myModal2').show();
    // });

    function tutup(){
        $('#myModal2').modal('toggle');
    };
</script>