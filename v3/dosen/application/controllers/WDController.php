<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WDController extends CI_Controller
{


   public function __construct()
   {
      parent::__construct();
      $this->load->library('template');
      $this->load->library('session');
      $this->load->model('StrukturalModel');
      $this->load->model('KegiatanModel');
      $this->load->model('DosenModel');
      $this->load->model('FungsionalModel');
      $this->load->model('ValidasiModel');
      $this->load->model('PembayaranModel');
      $this->load->library('excel');
      if (!$this->session->userdata('sess_dosen')) {
         redirect('VerifyLogin', 'refresh');
      }
   }

   public function RekapRemun()
   {
      $session_data = $this->session->userdata('sess_dosen');
      $data = array('datasession' => $session_data);
      $datakirim = array();
      $data['page'] = 'validasi';

      //array_push($datakirim, $dataarray);
      $row['nip'] = $session_data['idDosen'];
      $datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
      $data['menuextend'] = $datajabatan[0]['id_jabatan_struktural'];

      $this->template->view('template/wd2/rekapremun', $data);
   }

   public function RekapKegiatan()
   {
      $session_data = $this->session->userdata('sess_dosen');
      $data = array('datasession' => $session_data);
      $datakirim = array();
      $data['page'] = 'validasi';

      //array_push($datakirim, $dataarray);
      $row['nip'] = $session_data['idDosen'];
      $datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
      $data['menuextend'] = $datajabatan[0]['id_jabatan_struktural'];

      $this->template->view('template/wd1/rekapkegiatan', $data);
   }

   public function getDataRekapRemunBulanTahunStatus()
   {
      $session_data     = $this->session->userdata('sess_dosen');
      $datakirim        = array();
      $data['bulan']    = $_GET['bulan'];
      $data['tahun']    = $_GET['tahun'];
      $data['fakultas'] = $session_data['idFakultas'];
      $data['prodi']    = 0;
      $data['status']   = $_GET['status_dosen'];
      $datadosen        = $this->DosenModel->getDosen($data);

      foreach ($datadosen as $dosen) {
         $data['nip'] = $dosen['id_dosen'];
         $datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);

         $statusvalidasi = ($datavalidasi != null) ? $datavalidasi[0]['status'] : 0;

         $data['jenis'] = 1;
         $datakegiatan1 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         $totalsks1 = 0;
         foreach ($datakegiatan1 as $row) {
            $totalsks1 = $totalsks1 + ($row['sks'] * $row['bobot_sks']);
         }


         $data['jenis'] = 2;
         $totalsks2 = 0;
         $datakegiatan2 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan2 as $row) {
            $totalsks2 = $totalsks2 + ($row['sks'] * $row['bobot_sks']);
         }

         $data['jenis'] = 3;
         $totalsks3 = 0;
         $datakegiatan3 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan3 as $row) {
            $totalsks3 = $totalsks3 + ($row['sks'] * $row['bobot_sks']);
         }

         $data['jenis'] = 4;
         $totalsks4 = 0;
         $datakegiatan4 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan4 as $row) {
            $d = json_decode($row['deskripsi'], true);
            $jKeg = ($row['keg_bulanan'] == '0') ? ((!isset($d['dari'])) ? '1' : $d['dari']) : '1';
            $totalsks4 = $totalsks4 + ($jKeg * $row['bobot_sks']);
         }

         $data['jenis'] = 5;
         $totalsks5 = 0;
         $datakegiatan5 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan5 as $row) {
            $totalsks5 = $totalsks5 + ($row['sks'] * $row['bobot_sks']);
         }

         $tarif_gaji = 0;
         $tarif_kinerja = 0;
         $sksr_gaji = 0;
         $sks_kinerja = 0;
         $sksr_tugas_tambahan = 0;
         $datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);
         $datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);

         if ($datafungsional != null) {
            $sksr_gaji = $datafungsional[0]['sksr_maks_gaji'];
            $sksr_kinerja = $datafungsional[0]['sksr_maks_kinerja'];
         }

         if ($datastruktural == null || $datastruktural[0]['id_jabatan_struktural'] == 301 || $datastruktural[0]['id_jabatan_struktural'] == 302) {
            $tarif_gaji = @$datafungsional[0]['gaji_tambahan_maks'];
            $tarif_kinerja = @$datafungsional[0]['insentif_kinerja'];
            if (@empty($datafungsional[0]['gaji_tambahan_maks']) and @$datafungsional[0]['gaji_tambahan_maks'] <> 0) {
               $tarif_gaji = '<code> Data <br> Struktural <br> Kosong. </code>';
               $tarif_kinerja = '<code> Mohon <br> di input <br> oleh <br> admin. </code>';
            }
         } else {
            $tarif_gaji = $datastruktural[0]['gaji_tambahan_maks'];
            $tarif_kinerja = $datastruktural[0]['insentif_kinerja'];
            $sksr_tugas_tambahan = $datastruktural[0]['bobot_sksr'];
         }

         $datagolongan = $this->GolonganModel->getGolonganByTMT($data);

         $pph = ($datagolongan != null) ? $datagolongan[0]['pph'] : 0;

         if ($statusvalidasi > 0) {

            $totalsks1 = number_format(($datavalidasi[0]['jumlah_sks_bid_1']), 2);
            $totalsks2 = number_format(($datavalidasi[0]['jumlah_sks_bid_2']), 2);
            $totalsks3 = number_format(($datavalidasi[0]['jumlah_sks_bid_3']), 2);
            $totalsks4 = number_format(($datavalidasi[0]['jumlah_sks_bid_4']), 2);
            $totalsks5 = number_format(($datavalidasi[0]['jumlah_sks_bid_5']), 2);
            $sksr_tugas_tambahan = number_format($datavalidasi[0]['sksr_tugas_tambahan'], 2);

            if ($statusvalidasi == 1) {
               $status = "Kegiatan Tidak Valid";
            } elseif ($statusvalidasi == 2) {
               $status = "Kegiatan Valid";
            } elseif ($statusvalidasi == 3) {
               $status = "Pembayaran Valid";
            }

            $sks_gaji = $datavalidasi[0]['sksr_gaji'];
            $sks_kinerja = $datavalidasi[0]['sksr_kinerja'];
         } else {

            $status = "Belum di Validasi";
            $sks_gaji = 0;
            $sks_kinerja = 0;
         }

         $total_sks = $totalsks1 + $totalsks2 + $totalsks3 + $totalsks4 + $totalsks5 + $sksr_tugas_tambahan;
         $total = ($sksr_gaji == 0 or $sksr_kinerja == 0) ? 0 : (($sks_gaji / $sksr_gaji) * $tarif_gaji) + (($sks_kinerja / $sksr_kinerja) * $tarif_kinerja);
         $pajak = $total * $pph;

         $dataarray = array(
            'nama_dosen' => $dosen['nama'],
            'nip' => $data['nip'],
            'pengajaran' => number_format($totalsks1, 2),
            'penelitian' => number_format($totalsks2, 2),
            //'pengabdian' => $totalsks3,
            'penunjang' => number_format($totalsks4, 2),
            'tugas_tambahan_non_struktural' => number_format($totalsks5, 2),
            'tugas_tambahan_struktural' => $sksr_tugas_tambahan,
            'sks_gaji' => $sks_gaji,
            'sks_kinerja' => $sks_kinerja,
            'tarif_gaji' => ((is_numeric($tarif_gaji)) ? number_format($tarif_gaji, 0, ",", ".") : $tarif_gaji),
            'tarif_kinerja' => ((is_numeric($tarif_kinerja)) ? number_format($tarif_kinerja, 0, ",", ".") : $tarif_kinerja),
            'pph' => $pph,
            'total' => number_format($total - $pajak, 0, ",", "."),
            'status' => $status,
         );
         array_push($datakirim, $dataarray);
      }
      echo json_encode($datakirim);
   }

   public function getDataRekapRemunBulanTahunStatusTester()
   {
      $session_data     = $this->session->userdata('sess_dosen');
      $datakirim        = array();
      $data['bulan']    = $_GET['bulan'];
      $data['tahun']    = $_GET['tahun'];
      $data['fakultas'] = $session_data['idFakultas'];
      $data['prodi']    = 0;
      $data['status']   = $_GET['status_dosen'];
      $datadosen        = $this->DosenModel->getDosen($data);

      foreach ($datadosen as $dosen) {
         $data['nip'] = $dosen['id_dosen'];
         $datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);

         $statusvalidasi = ($datavalidasi != null) ? $datavalidasi[0]['status'] : 0;

         $data['jenis'] = 1;
         $datakegiatan1 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         $totalsks1 = 0;
         foreach ($datakegiatan1 as $row) {
            $totalsks1 = $totalsks1 + ($row['sks'] * $row['bobot_sks']);
         }


         $data['jenis'] = 2;
         $totalsks2 = 0;
         $datakegiatan2 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan2 as $row) {
            $totalsks2 = $totalsks2 + ($row['sks'] * $row['bobot_sks']);
         }

         $data['jenis'] = 3;
         $totalsks3 = 0;
         $datakegiatan3 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan3 as $row) {
            $totalsks3 = $totalsks3 + ($row['sks'] * $row['bobot_sks']);
         }

         $data['jenis'] = 4;
         $totalsks4 = 0;
         $datakegiatan4 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan4 as $row) {
            $d = json_decode($row['deskripsi'], true);
            $jKeg = ($row['keg_bulanan'] == '0') ? ((!isset($d['dari'])) ? '1' : $d['dari']) : '1';
            $totalsks4 = $totalsks4 + ($jKeg * $row['bobot_sks']);
         }

         $data['jenis'] = 5;
         $totalsks5 = 0;
         $datakegiatan5 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan5 as $row) {
            $totalsks5 = $totalsks5 + ($row['sks'] * $row['bobot_sks']);
         }

         $tarif_gaji = 0;
         $tarif_kinerja = 0;
         $sksr_gaji = 0;
         $sks_kinerja = 0;
         $sksr_tugas_tambahan = 0;
         $datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);
         $datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);

         if ($datafungsional != null) {
            $sksr_gaji = $datafungsional[0]['sksr_maks_gaji'];
            $sksr_kinerja = $datafungsional[0]['sksr_maks_kinerja'];
         }

         if ($datastruktural == null || $datastruktural[0]['id_jabatan_struktural'] == 301 || $datastruktural[0]['id_jabatan_struktural'] == 302) {
            $tarif_gaji = @$datafungsional[0]['gaji_tambahan_maks'];
            $tarif_kinerja = @$datafungsional[0]['insentif_kinerja'];
            if (@empty($datafungsional[0]['gaji_tambahan_maks']) and @$datafungsional[0]['gaji_tambahan_maks'] <> 0) {
               $tarif_gaji = '<code> Data <br> Struktural <br> Kosong. </code>';
               $tarif_kinerja = '<code> Mohon <br> di input <br> oleh <br> admin. </code>';
            }
         } else {
            $tarif_gaji = $datastruktural[0]['gaji_tambahan_maks'];
            $tarif_kinerja = $datastruktural[0]['insentif_kinerja'];
            $sksr_tugas_tambahan = $datastruktural[0]['bobot_sksr'];
         }

         $datagolongan = $this->GolonganModel->getGolonganByTMT($data);

         $pph = ($datagolongan != null) ? $datagolongan[0]['pph'] : 0;

         if ($statusvalidasi > 0) {

            $totalsks1 = number_format(($datavalidasi[0]['jumlah_sks_bid_1']), 2);
            $totalsks2 = number_format(($datavalidasi[0]['jumlah_sks_bid_2']), 2);
            $totalsks3 = number_format(($datavalidasi[0]['jumlah_sks_bid_3']), 2);
            $totalsks4 = number_format(($datavalidasi[0]['jumlah_sks_bid_4']), 2);
            $totalsks5 = number_format(($datavalidasi[0]['jumlah_sks_bid_5']), 2);
            $sksr_tugas_tambahan = number_format($datavalidasi[0]['sksr_tugas_tambahan'], 2);

            if ($statusvalidasi == 1) {
               $status = "Kegiatan Tidak Valid";
            } elseif ($statusvalidasi == 2) {
               $status = "Kegiatan Valid";
            } elseif ($statusvalidasi == 3) {
               $status = "Pembayaran Valid";
            }

            $sks_gaji = $datavalidasi[0]['sksr_gaji'];
            $sks_kinerja = $datavalidasi[0]['sksr_kinerja'];
         } else {

            $status = "Belum di Validasi";
            $sks_gaji = 0;
            $sks_kinerja = 0;
         }

         $total_sks = $totalsks1 + $totalsks2 + $totalsks3 + $totalsks4 + $totalsks5 + $sksr_tugas_tambahan;
         $total = ($sksr_gaji == 0 or $sksr_kinerja == 0) ? 0 : (($sks_gaji / $sksr_gaji) * $tarif_gaji) + (($sks_kinerja / $sksr_kinerja) * $tarif_kinerja);
         $pajak = $total * $pph;

         $dataarray = array(
            'nama_dosen' => $dosen['nama'],
            'nip' => $data['nip'],
            'pengajaran' => number_format($totalsks1, 2),
            'penelitian' => number_format($totalsks2, 2),
            //'pengabdian' => $totalsks3,
            'penunjang' => number_format($totalsks4, 2),
            'tugas_tambahan_non_struktural' => number_format($totalsks5, 2),
            'tugas_tambahan_struktural' => $sksr_tugas_tambahan,
            'sks_gaji' => $sks_gaji,
            'sks_kinerja' => $sks_kinerja,
            'tarif_gaji' => ((is_numeric($tarif_gaji)) ? number_format($tarif_gaji, 0, ",", ".") : $tarif_gaji),
            'tarif_kinerja' => ((is_numeric($tarif_kinerja)) ? number_format($tarif_kinerja, 0, ",", ".") : $tarif_kinerja),
            'pph' => $pph,
            'total' => number_format($total - $pajak, 0, ",", "."),
            'status' => $status,
         );
         array_push($datakirim, $dataarray);
      }
      echo json_encode($datakirim);
   }


   public function getDataRekapKegiatanBulanTahunStatus()
   {
      $session_data     = $this->session->userdata('sess_dosen');
      $datakirim        = array();
      $maxBulan         = $_GET['bulan'];
      $datadosen1       = $this->DosenModel->getDosenJurusan($session_data);

      $data['tahun']    = $_GET['tahun'];
      $data['fakultas'] = $session_data['idFakultas'];
      $data['jurusan']  = $datadosen1[0]['id_jurusan'];
      // $data['prodi'] = ($prodi==49)?$prodi="49,50": $prodi;
      $data['status']   = $_GET['status_dosen'];
      $datadosen        = $this->DosenModel->DosenJurusan($data);

      foreach ($datadosen as $dosen) {
         $catatanExtend  = "";

         $data['nip']    = $dosen['id_dosen'];
         $data['bulan']  = $maxBulan;
         $datavalidasi   = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);

         $statusvalidasi = ($datavalidasi != null) ? $datavalidasi[0]['status'] : 0;

         //--------------------- Hitung Total Kegiatan Bidang 1 / Pengajaran sampai Bulan Berikut ----------------//
         $data['jenis'] = 1;
         $totalsks1 = 0;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan1 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
               foreach ($datakegiatan1 as $row) {
                  $totalsks1 += ($row['sks'] * $row['bobot_sks']);
               }
            } else {
               $datakegiatan1 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
               foreach ($datakegiatan1 as $row) {
                  $totalsks1 += ($row['sks'] * $row['bobot_sks']);
               }
            }
         }

         if ($statusvalidasi > 0 and $statusvalidasi < 3) {
            if ($totalsks1 != $datavalidasi[0]['jumlah_sks_bid_1']) {
               $catatanExtend = $catatanExtend . "Ada Perubahan Kegiatan Pengajaran. ";
            }
         }

         //--------------------- Hitung Total Kegiatan Bidang 2 / penelitian dan pengabdian sampai Bulan Berikut ----------------//
         $data['jenis'] = 2;
         $totalsks2 = 0;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan2 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
               foreach ($datakegiatan2 as $row) {
                  $totalsks2 = $totalsks2 + ($row['sks'] * $row['bobot_sks']);
               }
            } else {
               $datakegiatan2 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
               foreach ($datakegiatan2 as $row) {
                  $totalsks2 = $totalsks2 + ($row['sks'] * $row['bobot_sks']);
               }
            }
         }

         if ($statusvalidasi > 0 and $statusvalidasi < 3) {
            if ($totalsks2 != $datavalidasi[0]['jumlah_sks_bid_2']) {
               $catatanExtend = $catatanExtend . "Ada Perubahan Kegiatan Penelitian. ";
            }
         }

         //--------------------- Hitung Total Kegiatan Bidang 4 / Penunjang sampai Bulan Berikut ----------------//
         $data['jenis'] = 4;
         $totalsks4 = 0;
         $jKeg = 1;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan4 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
               foreach ($datakegiatan4 as $row) {
                  //$totalsks4 = $totalsks4 + ($row['sks']*$row['bobot_sks']);
                  //------------------by UR---------------------//
                  $deskripsi4 = json_decode($row['deskripsi'], true);
                  $jKeg = ($deskripsi4['keg_perbln'] == '0') ? $deskripsi4['dari'] : '1';
                  $totalsks4 = $totalsks4 + ($jKeg * $row['bobot_sks']);
               }
            } else {
               $datakegiatan4 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
               foreach ($datakegiatan4 as $row) {
                  //$totalsks4 = $totalsks4 + ($row['sks']*$row['bobot_sks']);
                  //------------------by UR---------------------//
                  $deskripsi4 = json_decode($row['deskripsi'], true);
                  // if(empty($deskripsi4['keg_perbln']=='0')) {}
                  $jKeg = (@$deskripsi4['keg_perbln'] == '0') ? $deskripsi4['dari'] : '1';
                  $totalsks4 = $totalsks4 + ($jKeg * $row['bobot_sks']);
               }
            }
         }
         if ($statusvalidasi > 0 and $statusvalidasi < 3) {
            if ($totalsks4 != $datavalidasi[0]['jumlah_sks_bid_4']) {
               $catatanExtend = $catatanExtend . "Ada Perubahan Kegiatan Penunjang. ";
            }
         }

         //--------------------- Hitung Total Kegiatan Bidang 5 / Tugas Tambahan Non Struktural sampai Bulan Berikut ----------------//
         $data['jenis'] = 5;
         $totalsks5 = 0;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan5 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
               foreach ($datakegiatan5 as $row) {
                  $totalsks5 = $totalsks5 + ($row['sks'] * $row['bobot_sks']);
               }
            } else {
               $datakegiatan5 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
               foreach ($datakegiatan5 as $row) {
                  $totalsks5 = $totalsks5 + ($row['sks'] * $row['bobot_sks']);
               }
            }
         }
         if ($statusvalidasi > 0 and $statusvalidasi < 3) {
            if ($totalsks5 != $datavalidasi[0]['jumlah_sks_bid_5']) {
               $catatanExtend = $catatanExtend . "Ada Perubahan Kegiatan Tugas Tambahan Non Struktural. ";
            }
         }


         // looping struktural
         $data['bulan'] = $maxBulan;
         $sksr_tugas_struktural = 0;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            $datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);

            foreach ($datastruktural as $row) {
               $sksr_tugas_struktural = (($datastruktural != null) ? $datastruktural[0]['bobot_sksr'] : 0);
            }
         }


         $data['bulan'] = $maxBulan;
         $datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);

         if ($datafungsional != null) {
            $sksr_kinerja = $datafungsional[0]['sksr_maks_kinerja'];
            $sksr_gaji = $datafungsional[0]['sksr_maks_gaji'];
            $xxc = $datafungsional[0]['id_jabatan_fungsional'];
         } else {
            $sksr_kinerja = 0;
            $sksr_gaji = 0;
         }


         if ($statusvalidasi > 0) {
            $totalsks1 = $datavalidasi[0]['jumlah_sks_bid_1'];
            $totalsks2 = $datavalidasi[0]['jumlah_sks_bid_2'];
            //$totalsks3 = $datavalidasi[0]['jumlah_sks_bid_3'];
            $totalsks4 = $datavalidasi[0]['jumlah_sks_bid_4'];
            $totalsks5 = $datavalidasi[0]['jumlah_sks_bid_5'];
         }
         //$total_sks = $totalsks1 + $totalsks2 + $totalsks3 + $totalsks4 + $sksr_tugas_tambahan;
         $total_sks = $totalsks1 + $totalsks2 + $totalsks4 + $totalsks5 + $sksr_tugas_struktural;

         $total_sks = ($xxc == 212 || $xxc == 213) ? 2 : $total_sks;

         $total_sks = ($sksr_tugas_struktural > 0) ? 5 : $total_sks;

         $dataarray = array(
            'nama_dosen' => $dosen['nama'],
            'nip' => $dosen['nip'],
            'pengajaran' => $totalsks1,
            'penelitian' => $totalsks2,
            'penunjang' => $totalsks4,
            'tugas_tambahan_non_struktural' => $totalsks5,
            'tugas_tambahan_struktural' => $sksr_tugas_struktural,
            'status' => $statusvalidasi,
            'total_sks' => $total_sks,
            'catatan_extend' => $catatanExtend,
         );
         array_push($datakirim, $dataarray);
      }

      echo json_encode($datakirim);
   }

   public function getDataKegiatanDosenBulanTahunJenis()
   {

      $data['nip'] = $_GET['nip'];
      $maxBulan = $_GET['bulan'];
      $data['bulan'] = $_GET['bulan'];
      $data['tahun'] = $_GET['tahun'];

      $datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);
      if ($datavalidasi != null) {
         $statusvalidasi = $datavalidasi[0]['status'];
      } else {
         $statusvalidasi = 0;
      }

      /*----------------------------------- Detail Kegiatan Bidang 1 Sampai Bulan Berikut ------------------*/
      $totalsks1 = 0;
      $datakirim = array();
      $data['jenis'] = 1;
      for ($i = 1; $i <= $maxBulan; $i++) {
         $data['bulan'] = $i;
         if ($i < $maxBulan) {
            $data['status'] = 0;
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
         } else {
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         }

         foreach ($datakegiatan as $row) {
            $deskripsi = json_decode($row['deskripsi'], true);
            $totalsks1 = $totalsks1 + ($row['sks'] * $row['bobot_sks']);
            $dataarray = array(
               'no_sk' => $row['no_sk_kontrak'],
               'kode_keg' => $row['kode_kegiatan'],
               'tgl_keg' => $row['tanggal_kegiatan'],
               //'judul_keg' => $deskripsi['judul'],
               'judul_keg' => (array_shift($deskripsi)),
               'jenis_keg' => $data['jenis'],
               'nama_keg' => $row['namakegiatan'],
               'sksr' => ($row['bobot_sks'] * $row['sks']),
            );
            array_push($datakirim, $dataarray);
         }
      }

      /*----------------------------------- Detail Kegiatan Bidang 2 Sampai Bulan Berikut ------------------*/
      $totalsks2 = 0;
      $data['jenis'] = 2;
      for ($i = 1; $i <= $maxBulan; $i++) {
         $data['bulan'] = $i;
         if ($i < $maxBulan) {
            $data['status'] = 0;
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
         } else {
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         }

         foreach ($datakegiatan as $row) {
            $deskripsi = json_decode($row['deskripsi'], true);
            if (empty($deskripsi)) {
               $a = "";
            } else {
               $a = ucwords(strtolower(array_shift($deskripsi)));
            }

            $totalsks2 = $totalsks2 + ($row['sks'] * $row['bobot_sks']);
            $dataarray = array(
               'no_sk' => $row['no_sk_kontrak'],
               'kode_keg' => $row['kode_kegiatan'],
               'tgl_keg' => $row['tanggal_kegiatan'],
               'judul_keg' => $a,
               'jenis_keg' => $data['jenis'],
               'nama_keg' => $row['namakegiatan'],
               'sksr' => ($row['bobot_sks'] * $row['sks']),
            );
            array_push($datakirim, $dataarray);
         }
      }

      /*----------------------------------- Detail Kegiatan Bidang 3 Sampai Bulan Berikut ------------------*/
      $totalsks3 = 0;
      $data['jenis'] = 3;
      for ($i = 1; $i <= $maxBulan; $i++) {
         $data['bulan'] = $i;
         if ($i < $maxBulan) {
            $data['status'] = 0;
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
         } else {
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         }
         foreach ($datakegiatan as $row) {
            $deskripsi = json_decode($row['deskripsi'], true);
            $totalsks3 = $totalsks3 + ($row['sks'] * $row['bobot_sks']);
            $dataarray = array(
               'no_sk' => $row['no_sk_kontrak'],
               'kode_keg' => $row['kode_kegiatan'],
               'tgl_keg' => $row['tanggal_kegiatan'],
               'judul_keg' => ucwords(strtolower(array_shift($deskripsi))),
               'jenis_keg' => $data['jenis'],
               'nama_keg' => $row['namakegiatan'],
               'sksr' => ($row['bobot_sks'] * $row['sks']),

            );
            array_push($datakirim, $dataarray);
         }
      }

      /*----------------------------------- Detail Kegiatan Bidang 5 Sampai Bulan Berikut ------------------*/
      $totalsks5 = 0;
      $data['jenis'] = 5;
      for ($i = 1; $i <= $maxBulan; $i++) {
         $data['bulan'] = $i;
         if ($i < $maxBulan) {
            $data['status'] = 0;
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
         } else {
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         }

         foreach ($datakegiatan as $row) {
            $deskripsi = json_decode($row['deskripsi'], true);
            $totalsks5 = $totalsks5 + ($row['sks'] * $row['bobot_sks']);
            $dataarray = array(
               'no_sk' => $row['no_sk_kontrak'],
               'kode_keg' => $row['kode_kegiatan'],
               'tgl_keg' => $row['tanggal_kegiatan'],
               'judul_keg' => ucwords(strtolower(array_shift($deskripsi))),
               'jenis_keg' => $data['jenis'],
               'nama_keg' => $row['namakegiatan'],
               'sksr' => ($row['bobot_sks'] * $row['sks']),
            );
            array_push($datakirim, $dataarray);
         }
      }

      // print_r($datakirim);

      /*----------------------------------- Detail Kegiatan Bidang 4 Sampai Bulan Berikut ------------------*/
      $totalsks4 = 0;
      $data['jenis'] = 4;
      for ($i = 1; $i <= $maxBulan; $i++) {
         $data['bulan'] = $i;
         if ($i < $maxBulan) {
            $data['status'] = 0;
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
         } else {
            $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         }
         foreach ($datakegiatan as $row) {
            $deskripsi = json_decode($row['deskripsi'], true);
            $jKeg = (@$row['keg_bulanan'] == '0') ? $deskripsi['dari'] : '1';
            $totalsks4 = $totalsks4 + ($row['bobot_sks'] * $jKeg);
            $dataarray = array(
               'no_sk' => $row['no_sk_kontrak'],
               'kode_keg' => $row['kode_kegiatan'],
               'tgl_keg' => $row['tanggal_kegiatan'],
               'judul_keg' => ucwords(strtolower(array_shift($deskripsi))),
               'jenis_keg' => $data['jenis'],
               'nama_keg' => $row['namakegiatan'],
               'sksr' => ($row['bobot_sks'] * $jKeg),
            );
            array_push($datakirim, $dataarray);
         }
      }



      $catatanExtend = "";
      $catatan = "";
      if ($statusvalidasi > 0 and $statusvalidasi < 3) {
         if ($totalsks1 <> $datavalidasi[0]['jumlah_sks_bid_1']) {
            $catatanExtend = $catatanExtend . "Ada Perubahan Kegiatan Pengajaran. ";
         }
         if ($totalsks2 <> $datavalidasi[0]['jumlah_sks_bid_2']) {
            $catatanExtend = $catatanExtend . "Ada Perubahan Kegiatan Penelitian. ";
         }
         if ($totalsks3 <> $datavalidasi[0]['jumlah_sks_bid_3']) {
            $catatanExtend = $catatanExtend . "Ada Perubahan Kegiatan Pengabdian. ";
         }
         if ($totalsks4 <> $datavalidasi[0]['jumlah_sks_bid_4']) {
            $catatanExtend = $catatanExtend . "Ada Perubahan Kegiatan Penunjang. ";
         }
         if ($totalsks5 <> $datavalidasi[0]['jumlah_sks_bid_5']) {
            $catatanExtend = $catatanExtend . "Ada Perubahan Kegiatan Non Struktural. ";
         }

         if ($statusvalidasi == 1) {
            $catatan = $datavalidasi[0]['deskripsi'];
         }
      }
      $datacatatan = array("catatan" => $catatan, "catatan_extend" => $catatanExtend,);
      array_push($datakirim, $datacatatan);
      echo json_encode($datakirim);
   }

   public function submitCatatan()
   {
      if ($this->session->userdata('sess_dosen')) {
         $data['nip'] = $_POST['id_dosen'];
         $data['catatan'] = $_POST['note'];
         $data['tahun'] = $_POST['tahun'];
         $maxBulan = $_POST['bulan'];
         $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');

         /* ------------------------------ Hitung Kegiatan Bidang 1 Sampai Bulan ----------------- */
         $totalsks1 = 0;
         $data['jenis'] = 1;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }
            foreach ($datakegiatan as $row) {
               $totalsks1 = $totalsks1 + ($row['sks'] * $row['bobot_sks']);
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];
               $dataupdate['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $dataupdate['deskripsi'] = json_encode($deskripsi);
               $dataupdate['status'] = 1;
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($dataupdate);
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($data);
            }
         }

         /* ------------------------------ Hitung Kegiatan Bidang 2 Sampai Bulan ----------------- */
         $totalsks2 = 0;
         $data['jenis'] = 2;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }
            foreach ($datakegiatan as $row) {
               $totalsks2 = $totalsks2 + ($row['sks'] * $row['bobot_sks']);
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];
               $dataupdate['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $dataupdate['deskripsi'] = json_encode($deskripsi);
               $dataupdate['status'] = 1;
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($dataupdate);
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($data);
            }
         }

         /* ------------------------------ Hitung Kegiatan Bidang 3 Sampai Bulan ----------------- */
         $totalsks3 = 0;
         $data['jenis'] = 3;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }
            foreach ($datakegiatan as $row) {
               $totalsks3 = $totalsks3 + ($row['sks'] * $row['bobot_sks']);
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];
               $dataupdate['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $dataupdate['deskripsi'] = json_encode($deskripsi);
               $dataupdate['status'] = 1;
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($dataupdate);
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($data);
            }
         }

         /* ------------------------------ Hitung Kegiatan Bidang 4 Sampai Bulan ----------------- */
         $totalsks4 = 0;
         $data['jenis'] = 4;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }

            foreach ($datakegiatan as $row) {
               $jKeg = ($row['keg_bulanan'] == '0') ? $deskripsi['dari'] : '1';
               $totalsks4 = $totalsks4 + ($row['bobot_sks'] * $jKeg);
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];

               $dataupdate['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $dataupdate['deskripsi'] = json_encode($deskripsi);
               $dataupdate['status'] = 1;
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($dataupdate);
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($data);
            }
         }

         /* ------------------------------ Hitung Kegiatan Bidang 5 Sampai Bulan ----------------- */
         $totalsks5 = 0;
         $data['jenis'] = 5;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }

            foreach ($datakegiatan as $row) {
               $totalsks5 = $totalsks5 + ($row['sks'] * $row['bobot_sks']);
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];

               $dataupdate['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $dataupdate['deskripsi'] = json_encode($deskripsi);
               $dataupdate['status'] = 1;
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($dataupdate);
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($data);
            }
         }
         /* ------------------------------ Hitung Kegiatan Bidang 5 Sampai Bulan ----------------- */



         $data['bulan'] = $maxBulan;
         $datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);
         $datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);

         if ($datafungsional != null) {
            $sksr_kinerja = $datafungsional[0]['sksr_maks_kinerja'];
            $sksr_gaji = $datafungsional[0]['sksr_maks_gaji'];
         } else {
            $sksr_kinerja = 0;
            $sksr_gaji = 0;
         }
         if (isset($datastruktural)) {
            $sksr_tugas_tambahan = $datastruktural[0]['bobot_sksr'];
         } else {
            $sksr_tugas_tambahan = 0;
         }

         $totalsks = $totalsks1 + $totalsks2 + $totalsks3 + $totalsks4 + $sksr_tugas_tambahan;


         if ($maxBulan > 1) {
            $prev_valid_data['nip'] = $data['nip'];
            $prev_valid_data['tahun'] = $data['tahun'];
            $prev_valid_data['bulan'] = $maxBulan - 1;
            $prevdatavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($prev_valid_data);
            $sks_remun = ($totalsks + $prevdatavalidasi[0]['sksr_sisa']);
         } else {
            $sks_remun = $totalsks;
         }

         if ($sks_remun >= $sksr_gaji) {
            $sks_gaji = $sksr_gaji;
            $sks_remun = $sks_remun - $sks_gaji;
         } else {
            $sks_gaji = $sks_remun;
            $sks_remun = $sks_remun - $sks_gaji;
         }

         if ($sks_remun >= $sksr_kinerja) {
            $sks_kinerja = $sksr_kinerja;
            $sks_remun = $sks_remun - $sks_kinerja;
         } else {
            $sks_kinerja = $sks_remun;
            $sks_remun = $sks_remun - $sks_kinerja;
         }

         $sisa_sks = $sks_remun;
         $data['bulan'] = $maxBulan;
         $datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);

         $submitdata = array(
            'nip' => $data['nip'],
            'bulan' => $data['bulan'],
            'tahun' => $data['tahun'],
            'sks_bid_1' => $totalsks1,
            'sks_bid_2' => $totalsks2,
            'sks_bid_3' => $totalsks3,
            'sks_bid_4' => $totalsks4,
            'sksr_tugas_tambahan' => $sksr_tugas_tambahan,
            'sksr_gaji' => $sks_gaji,
            'sksr_kinerja' => $sks_kinerja,
            'sksr_sisa' => $sisa_sks,
            'deskripsi' => $data['catatan'] . '#' . $sks_remun,
            'status' => 1,
         );
         if ($datavalidasi == null) {

            $res = $this->ValidasiModel->submitValidasiTriDharma($submitdata);
            $response = "insert";
         } else {
            $res = $this->ValidasiModel->updateValidasiTriDharma($submitdata);
            $response = "update";
         }
         echo $response;
      } else {
         redirect('VerifyLogin', 'refresh');
      }
   }
   public function ValidasiKegiatan()
   {
      $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
      $nip = $_POST['nip'];
      $jlhnip = count($nip);
      $maxBulan = $_POST['bulan'];

      $data['tahun'] = $_POST['tahun'];
      $total_sks = 0;
      for ($j = 0; $j < $jlhnip; $j++) {
         $data['nip'] = $nip[$j];
         $data['bulan'] = $maxBulan;
         $datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);

         /*------------------------------- Hitung Kegiatan Bidang 1 Sampai Bulan -----------------------*/
         $data['jenis'] = 1;
         $totalsks1 = 0;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan1 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan1 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }
            foreach ($datakegiatan1 as $row) {
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];
               $updateData['deskripsi'] = json_encode($deskripsi);
               $updateData['status'] = 2;
               $updateData['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($updateData);
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($updateData);
               $totalsks1 = $totalsks1 + ($row['sks'] * $row['bobot_sks']);
            }
         }


         /*------------------------------- Hitung Kegiatan Bidang 2 Sampai Bulan -----------------------*/
         $data['jenis'] = 2;
         $totalsks2 = 0;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan2 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan2 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }
            foreach ($datakegiatan2 as $row) {
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];
               $updateData['deskripsi'] = json_encode($deskripsi);
               $updateData['status'] = 2;
               $updateData['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($updateData);
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($updateData);
               $totalsks2 = $totalsks2 + ($row['sks'] * $row['bobot_sks']);
            }
         }

         /*------------------------------- Hitung Kegiatan Bidang 3 Sampai Bulan -----------------------*/
         $data['jenis'] = 3;
         $totalsks3 = 0;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan3 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan3 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }
            foreach ($datakegiatan3 as $row) {
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];
               $updateData['deskripsi'] = json_encode($deskripsi);
               $updateData['status'] = 2;
               $updateData['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($updateData);
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($updateData);
               $totalsks3 = $totalsks3 + ($row['sks'] * $row['bobot_sks']);
            }
         }

         /*------------------------------- Hitung Kegiatan Bidang 4 Sampai Bulan -----------------------*/
         $data['jenis'] = 4;
         $totalsks4 = 0;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan4 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan4 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }

            foreach ($datakegiatan4 as $row) {
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];
               $updateData['deskripsi'] = json_encode($deskripsi);
               $updateData['status'] = 2;
               $updateData['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($updateData);
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($updateData);
               $jKeg = ($row['keg_bulanan'] == '0') ? $deskripsi['dari'] : '1';
               $totalsks4 = $totalsks4 + ($row['bobot_sks'] * $jKeg);
            }
         }

         /*------------------------------- Hitung Kegiatan Bidang 5 Sampai Bulan -----------------------*/
         $data['jenis'] = 5;
         $totalsks5 = 0;
         for ($i = 1; $i <= $maxBulan; $i++) {
            $data['bulan'] = $i;
            if ($i < $maxBulan) {
               $data['status'] = 0;
               $datakegiatan5 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunStatus($data);
            } else {
               $datakegiatan5 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
            }
            foreach ($datakegiatan5 as $row) {
               $deskripsi = json_decode($row['deskripsi'], true);
               $deskripsi['catatan'] = "Validasi di Bulan " . $nama_bulan[$maxBulan];
               $updateData['deskripsi'] = json_encode($deskripsi);
               $updateData['status'] = 2;
               $updateData['id_keg_dosen'] = $row['id_kegiatan_dosen'];
               $res = $this->KegiatanModel->updateStatusKegiatanDosenByIDKegiatan($updateData);
               $res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByIDKegiatan($updateData);
               $totalsks5 = $totalsks5 + ($row['sks'] * $row['bobot_sks']);
            }
         }

         /*------------------------------- END Hitung Kegiatan Bidang 5 Sampai Bulan -----------------------*/




         $data['bulan'] = $maxBulan;
         $datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);

         if ($datafungsional != null) {
            $sksr_kinerja = $datafungsional[0]['sksr_maks_kinerja'];
            $sksr_gaji = $datafungsional[0]['sksr_maks_gaji'];
            $xxc = $datafungsional[0]['id_jabatan_fungsional'];
         } else {
            $sksr_kinerja = 0;
            $sksr_gaji = 0;
         }

         // pencarian sksr tugas tambahan dan set tampilan sksr tugas tambahan
         if (
            isset($datastruktural)
            and @$datastruktural[0]['id_jabatan_struktural'] != 301
            and @$datastruktural[0]['id_jabatan_struktural'] != 302
            and @$datastruktural[0]['id_jabatan_struktural'] != null
            and !empty($datastruktural[0]['id_jabatan_struktural'])
         ) {
            $sksr_tugas_tambahan = @$datastruktural[0]['bobot_sksr'];
            $total_sks = 5;
            $total_sks = ($xxc == "201") ? "5.67" : "5";
         } else {
            $sksr_tugas_tambahan = 0;
            if ($xxc == 212 || $xxc == 213) {
               $total_sks = 2;
            } else {
               $total_sks = $totalsks1 + $totalsks2 + $totalsks3 + $totalsks4 + $totalsks5 + $sksr_tugas_tambahan;
            }
         }

         echo $total_sks;
         // $total_sks = $totalsks1 + $totalsks2 + $totalsks3 + $totalsks4 + $totalsks5 + $sksr_tugas_tambahan;

         if ($maxBulan > 1) {
            $prev_valid_data['nip'] = $data['nip'];
            $prev_valid_data['tahun'] = $data['tahun'];
            $prev_valid_data['bulan'] = $maxBulan - 1;
            $prevdatavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($prev_valid_data);
            $sks_remun = ($total_sks + $prevdatavalidasi[0]['sksr_sisa']);
         } else {
            $sks_remun = $total_sks;
         }


         //baca 2
         if ($sks_remun >= $sksr_gaji) {
            $sks_gaji = $sksr_gaji;
            $sks_remun = $sks_remun - $sks_gaji;
         } else {
            $sks_gaji = $sks_remun;
            $sks_remun = $sks_remun - $sks_gaji;
         }
         //baca 3
         if ($sks_remun >= $sksr_kinerja) {
            $sks_kinerja = $sksr_kinerja;
            $sks_remun = $sks_remun - $sks_kinerja;
         } else {
            $sks_kinerja = $sks_remun;
            $sks_remun = $sks_remun - $sks_kinerja;
         }

         $sisa_sks = $sks_remun;
         $datavalidasi = $datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);
         $deskripsi = "Sudah di Validasi oleh Validator Tri Dharma";

         $dataarray = array(
            'nip' => $data['nip'],
            'bulan' => $data['bulan'],
            'tahun' => $data['tahun'],
            'sks_bid_1' => $totalsks1,
            'sks_bid_2' => $totalsks2,
            'sks_bid_3' => $totalsks3,
            'sks_bid_4' => $totalsks4,
            'sks_bid_5' => $totalsks5,
            'sksr_tugas_tambahan' => $sksr_tugas_tambahan,
            'sksr_gaji' => $sks_gaji,
            'sksr_kinerja' => $sks_kinerja,
            'sksr_sisa' => $sisa_sks,
            // 'total_sks_show' => $total_sks_show,
            'deskripsi' => $deskripsi,
            'status' => 2,
         );

         if ($datavalidasi == null) {
            $res = $this->ValidasiModel->submitValidasiTriDharma($dataarray);
         } else {
            $res = $this->ValidasiModel->updateValidasiTriDharma($dataarray);
         }
      }
      // echo $res;
   }



   public function ValidasiPembayaran()
   {
      $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
      $session_data = $this->session->userdata('sess_dosen');
      $maxBulan = $_POST['bulan'];
      $data['bulan'] = $_POST['bulan'];
      $data['tahun'] = $_POST['tahun'];
      $data['fakultas'] = $session_data['idFakultas'];
      $data['prodi'] = 0;
      $data['status']  = $_POST['status_dosen'];
      $datadosen = $this->DosenModel->getDosen($data);

      foreach ($datadosen as $dosen) {
         $data['nip'] = $dosen['nip'];
         $datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);

         if ($datavalidasi != null) {
            if ($datavalidasi[0]['status'] == 2) {
               $data_bayar['nip'] = $datavalidasi[0]['id_dosen'];
               $data_bayar['bulan'] = $datavalidasi[0]['bulan'];
               $data_bayar['tahun'] = $datavalidasi[0]['tahun'];

               $data_bayar['status'] = 1;
               $data_bayar['tgl_bayar'] = date("Y-m-d");
               $data_bayar['idBendahara'] = null;

               $datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);
               $datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);
               $datagolongan = $this->GolonganModel->getGolonganByTMT($data);

               $sks_gaji_maks = 0;
               $sks_kinerja_maks = 0;
               $pph = ($datagolongan != null) ? $datagolongan[0]['pph'] : 0;

               if ($datafungsional != null) {
                  $sks_gaji_maks = $datafungsional[0]['sksr_maks_gaji'];
                  $sks_kinerja_maks = $datafungsional[0]['sksr_maks_kinerja'];
               }


               if ($datastruktural == null || $datastruktural[0]['id_jabatan_struktural'] == 301 || $datastruktural[0]['id_jabatan_struktural'] == 302) {
                  $tarif_gaji = @$datafungsional[0]['gaji_tambahan_maks'];
                  $tarif_kinerja = @$datafungsional[0]['insentif_kinerja'];
               } else {
                  $tarif_gaji = $datastruktural[0]['gaji_tambahan_maks'];
                  $tarif_kinerja = $datastruktural[0]['insentif_kinerja'];
               }


               $data_bayar['sksr_gaji'] = $datavalidasi[0]['sksr_gaji'] / $sks_gaji_maks;
               $data_bayar['sksr_kinerja'] = $datavalidasi[0]['sksr_kinerja'] / $sks_kinerja_maks;

               $data_bayar['tarif_gaji'] = $tarif_gaji;
               $data_bayar['tarif_kinerja'] = $tarif_kinerja;
               $data_bayar['pph'] = $pph;

               $res = $this->PembayaranModel->insertPembayaran($data_bayar);
               if ($res) {
                  $updateData['deskripsi'] = "Sudah Divalidasi oleh Validator Keuangan";
                  $updateData['status'] = 3;
                  $updateData['riwayat'] = $datavalidasi[0]['id_validasi_tridharma'];
                  $res = $this->ValidasiModel->updateDeskripsiByIDRiwayat($updateData);
                  $res2 = $this->ValidasiModel->updateStatusByIDRiwayat($updateData);
               }
               echo $res;
            }
         }
      }
   }

   public function CetakSPTJM()
   {
      $session_data = $this->session->userdata('sess_dosen');
      $nama_bulan = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'Nopember', '12' => 'Desember');

      $this->load->library('word');
      $objPHPWord = new PHPWord();
      //our docx will have 'lanscape' paper orientation
      $document = $objPHPWord->loadTemplate('assets/files/sptjm_template.docx');
      $document->setValue('fakultas', 'Fakultas ' . $session_data['namafakultas']);
      $document->setValue('fakultas_judul', 'FAKULTAS ' . strtoupper($session_data['namafakultas']));
      $document->setValue('email_fakultas', 'unri.ac.id');
      $document->setValue('nama', $session_data['name']);
      $document->setValue('nip', $session_data['idDosen']);
      $document->setValue('bulan', 'Januari');
      $document->setValue('tahun', '2017');
      $document->setValue('grand_total', '22.334.555');
      $document->setValue('terbilang', 'dua puluh dua juta tiga ratus tiga puluh empat ribu lima ratus lima puluh lima rupiah');
      $tgl_sptjm = date('d') . " " . $nama_bulan[date('m')] . " " . date('Y');
      $document->setValue('tgl_sptjm', $tgl_sptjm);

      $document->save('assets/files/SPTJM_Januari_2017.docx');
   }
}
