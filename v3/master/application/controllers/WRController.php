<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WRController extends CI_Controller
{


   public function __construct()
   {
      parent::__construct();
      $this->load->library('template');
      $this->load->library('session');
      $this->load->model('MainModel');
      $this->load->model('StrukturalModel');
      $this->load->model('KegiatanModel');
      $this->load->model('DosenModel');
      $this->load->model('GolonganModel');
      $this->load->model('PendidikanModel');
      $this->load->model('PembayaranModel');
      $this->load->model('FungsionalModel');
      $this->load->model('ValidasiModel');
      $this->load->library('excel');

      if ($this->session->userdata('sess_master')) {
         $session_data = $this->session->userdata('sess_master');
         $data = array('datasession' => $session_data);
      } else {
         redirect('VerifyLogin', 'refresh');
      }
   }

   public function RekapRemun()
   {
      $session_data = $this->session->userdata('sess_master');
      $data = array('datasession' => $session_data);
      // $datakirim = array();   
      $data['fakultas'] = $this->MainModel->getDataFakultas();
      $data['page'] = 'report';

      // //array_push($datakirim, $dataarray);
      // $row['nip'] = $session_data['idDosen'];
      // $datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
      // $data['menuextend'] = $datajabatan[0]['id_jabatan_struktural'];

      $this->template->view('template/wr2/rekapremununri', $data);
   }

   public function getDataRekapRemunBulanTahunStatusFakultas()
   {
      $datakirim        = array();

      $data['bulan']    = $_GET['bulan'];
      $data['tahun']    = $_GET['tahun'];
      $data['fakultas'] = $_GET['fakultas'];
      $data['prodi']    = 0;
      $data['status']   = $_GET['status_dosen'];
      $datadosen        = $this->DosenModel->getDosen($data);
      // $datadosen[] = [
      //    'id_dosen'              => '197704242008011003',
      //    'id_program_studi'      => 4,
      //    'id_status_dosen'       => 1,
      //    'nip'                   => '197704242008011003',
      //    'nama'                  => 'Ilmu Komunikasi',
      //    'no_rekening'           => '0032301580001867',
      //    'id_bank'               => 2,
      //    'telepon'               => '0812-7563-545',
      //    'email'                 => 'suyantomsc@gmail.com',
      //    'foto'                  => '',
      //    'npwp'                  => '696447325216000',
      //    'id_fakultas'           => 1,
      //    'id_jurusan'            => 4,
      //    'id_jenjang_pendidikan' => 1,
      //    'kode_program_studi'    => '70201',
      //    'singkatan'             => '',
      //    'deskripsi'             => 'PNS',
      //    'nama_dosen'            => 'DR. SUYANTO, S.Sos, M.Sc'
      // ];

      foreach ($datadosen as $dosen) {

         $data['nip']    = $dosen['id_dosen'];
         $datavalidasi   = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);
         $statusvalidasi = ($datavalidasi != null) ? $datavalidasi[0]['status'] : 0;

         $data['jenis']  = 1;
         $datakegiatan1  = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);
         $totalsks1      = 0;
         foreach ($datakegiatan1 as $row) {
            $totalsks1 = $totalsks1 + ($row['sks'] * $row['bobot_sks']);
         }


         $data['jenis'] = 2;
         $totalsks2 = 0;
         $datakegiatan2 = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan2 as $row) {
            $totalsks2 = $totalsks2 + ($row['sks'] * $row['bobot_sks']);
         }


         $data['jenis'] = 3;
         $totalsks3 = 0;
         $datakegiatan3 = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan3 as $row) {
            $totalsks3 = $totalsks3 + ($row['sks'] * $row['bobot_sks']);
         }


         $data['jenis'] = 5;
         $totalsks5 = 0;
         $datakegiatan5 = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan5 as $row) {
            $totalsks5 = $totalsks5 + ($row['sks'] * $row['bobot_sks']);
         }

         $data['jenis'] = 4;
         $totalsks4 = 0;
         $datakegiatan4 = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);
         foreach ($datakegiatan4 as $row) {
            $d = json_decode($row['deskripsi'], true);
            $jKeg = ($row['keg_bulanan'] == '0') ? ((!isset($d['dari'])) ? '1' : $d['dari']) : '1';
            $totalsks4 += $row['bobot_sks'] * $jKeg;
         }


         $tarif = 0;
         $datafungsional = $this->FungsionalModel->getFungsionalByTMTWR($data);
         $datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);

         $sksr_gaji = ($datafungsional != null) ? $datafungsional[0]['sksr_maks_gaji'] : 2;
         $sksr_kinerja = ($datafungsional != null) ? $datafungsional[0]['sksr_maks_kinerja'] : 3;

         if (
            $datastruktural == null
            || $datastruktural[0]['id_jabatan_struktural'] == 1
            || $datastruktural[0]['id_jabatan_struktural'] == 301
            || $datastruktural[0]['id_jabatan_struktural'] == 302
         ) {
            $tarif_gaji = @$datafungsional[0]['gaji_tambahan_maks'];
            $tarif_kinerja = @$datafungsional[0]['insentif_kinerja'];
            $sksr_tugas_tambahan = 0;
         } else {
            $tarif_gaji = $datastruktural[0]['gaji_tambahan_maks'];
            $tarif_kinerja = $datastruktural[0]['insentif_kinerja'];
            $sksr_tugas_tambahan = $datastruktural[0]['bobot_sksr'];
         }

         $datagolongan = $this->GolonganModel->getGolonganByTMT($data);
         $pph = ($datagolongan != null) ? $datagolongan[0]['pph'] : 0;

         if ($statusvalidasi > 0) {
            // sisa sksr sebelumnya
            $datavalidasisisa = $this->ValidasiModel->getDataValidasiBulansebelunya($data);
            $totalsks1 = $datavalidasi[0]['jumlah_sks_bid_1'];
            $totalsks2 = $datavalidasi[0]['jumlah_sks_bid_2'];
            $totalsks3 = $datavalidasi[0]['jumlah_sks_bid_3'];
            $totalsks4 = $datavalidasi[0]['jumlah_sks_bid_4'];
            $totalsks5 = $datavalidasi[0]['jumlah_sks_bid_5'];
            if ($statusvalidasi == 1) {
               $status = "Kegiatan Tidak Valid";
            } else if ($statusvalidasi == 2) {
               $status = "Kegiatan Valid";
            } else if ($statusvalidasi == 3) {
               $status = "Pembayaran Valid";
            }
            $sks_remun1 = $datavalidasi[0]['sksr_gaji'];
            $sks_remun2 = $datavalidasi[0]['sksr_kinerja'];
            $sks_remun = $sks_remun1 + $sks_remun2;
            $datavalidasisisa = @$datavalidasisisa[0]['sksr_sisa'];
         } else {
            $status = "Belum di Validasi";
            $sks_remun1 = 0;
            $sks_remun2 = 0;
            $sks_remun = 0;
            $datavalidasisisa = 0;
         }

         $total_sks = $totalsks1 + $totalsks2 + $totalsks3 + $totalsks4 + $totalsks5 + $sksr_tugas_tambahan;
         $pajak = (($sks_remun1 / $sksr_gaji * $tarif_gaji) + ($sks_remun2 / $sksr_kinerja * $tarif_kinerja)) * $pph;

         $total_jumlah = (($sks_remun1 / $sksr_gaji * $tarif_gaji) + ($sks_remun2 / $sksr_kinerja * $tarif_kinerja)) - $pajak;
         $dataarray = array(
            'nama_dosen' => $dosen['nama_dosen'],
            'nip' => $dosen['nip'],
            'sisa' => number_format($datavalidasisisa, 2, ",", "."),
            'pengajaran' => number_format($totalsks1, 2, ",", "."),
            'penelitian' => number_format($totalsks2, 2, ",", "."),
            'pengabdian' => number_format($totalsks3, 2, ",", "."),
            'penunjang' => number_format($totalsks4, 2, ",", "."),
            'nonstruktural' => number_format($totalsks5, 2, ",", "."),
            'struktural' => number_format($sksr_tugas_tambahan, 2, ",", "."),
            'total_sks' => number_format($total_sks, 2, ",", "."),
            'sks_remun' => number_format($sks_remun, 2, ",", "."),
            'tarif_gaji' => number_format($tarif_gaji, 2, ",", "."),
            'tarif_kinerja' => number_format($tarif_kinerja, 2, ",", "."),
            'pph' => $pph,
            'total' => number_format($total_jumlah, 2, ",", "."),
            'status' => $status,
         );
         array_push($datakirim, $dataarray);
      }
      echo json_encode($datakirim);
   }


   public function RekapKegiatan()
   {
      if ($this->session->userdata('sess_master')) {
         $session_data = $this->session->userdata('sess_master');
         $data = array('datasession' => $session_data);
         $datakirim = array();
         $data['fakultas'] = $this->MainModel->getDataFakultas();
         $data['page'] = 'report';

         // array_push($datakirim, $dataarray);
         // $row['nip'] = $session_data['idDosen'];
         // $datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
         // $data['menuextend'] = $datajabatan[0]['id_jabatan_struktural'];

         $this->template->view('template/wr1/rekapkegunri', $data);
      } else {
         redirect('VerifyLogin', 'refresh');
      }
   }

   public function getDataValidasi($data)
   {
      $maxBulan = $data['bulan'];
      $datakirim = array();
      $datadosen = $this->DosenModel->getDosen($data);

      for ($i = 0; $i < count($datadosen); $i++) {
         $data['nip'] = $datadosen[$i]['id_dosen'];

         $grandtotalsksgaji = 0;
         $grandtotalskskinerja = 0;
         $grandtotalskslebih = 0;
         $grandtotalsksbayar = 0;
         $grandtotalskssisa = 0;
         $grandtotalsks = 0;
         $grandtotalsksgajibayarsebelumnya = 0;
         $grandtotalskskinerjabayarsebelumnya = 0;

         //print_r($data);
         for ($j = 1; $j <= $maxBulan - 1; $j++) {
            $data['bulan'] = $j;
            $totalsks = $this->MainModel->getTotalSKSPerBulanBukanJenis4($data); //perubahan
            $jabStruktural = $this->MainModel->getJabStrukturalPerBulanTahun($data);
            $datapembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);
            $jabfungsional = $this->MainModel->getJabFungsionalPerBulanTahun($data);

            //print_r($jabStruktural);

            if ($jabfungsional != null) {
               $sksr_gaji = $jabfungsional[0]['sksr_maks_gaji'];
               $sksr_kinerja = $jabfungsional[0]['sksr_maks_kinerja'];
            } else {
               $sksr_gaji = 0;
               $sksr_kinerja = 0;
            }

            if ($jabStruktural != null) {
               $sksr_tugas_tambahan = $jabStruktural[0]['bobot_sksr'];
            } else {
               $sksr_tugas_tambahan = 0;
            }


            if ($datapembayaran != null) {
               $grandtotalsksgajibayarsebelumnya = $grandtotalsksgajibayarsebelumnya + $datapembayaran[0]['sksr_gaji'];
               $grandtotalskskinerjabayarsebelumnya = $grandtotalskskinerjabayarsebelumnya + $datapembayaran[0]['sksr_kinerja'];
               $status = (int)$datapembayaran[0]['status'];
               $idBayar = $datapembayaran[0]['id_pembayaran'];
               $sks_gaji_bayar = $datapembayaran[0]['sksr_gaji'];
               $sks_kinerja_bayar = $datapembayaran[0]['sksr_kinerja'];
            } else {
               $grandtotalsksgajibayarsebelumnya = $grandtotalsksgajibayarsebelumnya + 0;
               $grandtotalskskinerjabayarsebelumnya = $grandtotalskskinerjabayarsebelumnya + 0;
               $status = 0;
               $idBayar = 0;
               $sks_gaji_bayar = 0;
               $sks_kinerja_bayar = 0;
            }

            // tambahan untuk mendapatkan total sks sebelumnya
            $data['jenis'] = 4;
            $totalsks4 = 0;
            $datakegiatan4 = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);
            foreach ($datakegiatan4 as $row) {
               $d = json_decode($row['deskripsi'], true);
               // $jKeg = ($row['keg_bulanan']=='0') ? $d['dari'] : '1';
               $jKeg = ($row['keg_bulanan'] == '0') ? ((!isset($d['dari'])) ? '1' : $d['dari']) : '1';
               @$totalsks4 += $row['bobot_sks'] * $jKeg;
            }
            // end tambahan
            // 

            if ($totalsks == null and $totalsks4 == 0) {
               $total_sks = $sksr_tugas_tambahan;
            } else {
               $total_sks = @$totalsks[0]['total_sks'] + $totalsks4 + $sksr_tugas_tambahan;
            }
            $sks_remun = $total_sks;
            $grandtotalsks += $total_sks;

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

            if ($datapembayaran == null) {
               $sks_sisa = $total_sks;
            } else {
               $sks_sisa = $total_sks - ($sks_gaji_bayar + $sks_kinerja_bayar);
               $sks_gaji = $sks_gaji_bayar;
               $sks_kinerja = $sks_kinerja_bayar;
            }

            $grandtotalsksgaji += $sks_gaji;
            $grandtotalskskinerja += $sks_kinerja;
            $grandtotalskssisa = $grandtotalskssisa + $sks_sisa;
         }

         $data['bulan']         = $maxBulan;
         $datariwayatgolongan   = $this->GolonganModel->getGolonganByTMT($data);
         $datariwayatfungsional = $this->FungsionalModel->getFungsionalByTMTWR($data);
         $datariwayatpendidikan = $this->PendidikanModel->getPendidikanByTMT($data);
         $datariwayatstruktural = $this->StrukturalModel->getStrukturalByTMT($data);
         $data['jenis']         = 1;
         $datapendidikan        = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);
         $data['jenis']         = 2;
         $datapenelitian        = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);
         $data['jenis']         = 3;
         $datapengabdian        = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);
         $data['jenis']         = 4;
         $datapenunjang         = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);

         $totalsksbulan         = $this->MainModel->getTotalSKSPerBulanBukanJenis4($data);
         // $totalsksbulan1 = $this->MainModel->getTotalSKSPerBulanJenis4($data);

         $grandtotalskspendidikan = 0;
         $grandtotalskspenelitian = 0;
         $grandtotalskspengabdian = 0;
         $grandtotalskspenunjang  = 0;

         if ($datariwayatgolongan == null) {
            $datariwayatgolongan[0]['nama'] = "";
         }

         if ($datariwayatfungsional == null) {
            $datariwayatfungsional[0]['nama']                  = "";
            $datariwayatfungsional[0]['jobvalue']              = 0;
            $datariwayatfungsional[0]['grade']                 = 0;
            $datariwayatfungsional[0]['id_jabatan_fungsional'] = 0;
            $sksr_gaji                                         = 0;
            $sksr_kinerja                                      = 0;
         } else {
            $sksr_gaji    = $datariwayatfungsional[0]['sksr_maks_gaji'];
            $sksr_kinerja = $datariwayatfungsional[0]['sksr_maks_kinerja'];
         }

         if ($datariwayatpendidikan == null) {
            $datariwayatpendidikan[0]['singkatan'] = "";
         }

         foreach ($datapendidikan as $d) {
            $skskegiatan = 0;
            $bobotsks = 0;
            if (isset($d['sks'])) {
               $skskegiatan = $d['sks'];
            }
            if (isset($d['bobot_sks'])) {
               $bobotsks = $d['bobot_sks'];
            }
            $grandtotalskspendidikan = $grandtotalskspendidikan + ($skskegiatan * $bobotsks);
         }
         foreach ($datapenelitian as $d) {
            $skskegiatan = 0;
            $bobotsks = 0;
            if (isset($d['sks'])) {
               $skskegiatan = $d['sks'];
            }
            if (isset($d['bobot_sks'])) {
               $bobotsks = $d['bobot_sks'];
            }
            $grandtotalskspenelitian = $grandtotalskspenelitian + ($skskegiatan * $bobotsks);
         }
         foreach ($datapengabdian as $d) {
            $skskegiatan = 0;
            $bobotsks = 0;
            if (isset($d['sks'])) {
               $skskegiatan = $d['sks'];
            }
            if (isset($d['bobot_sks'])) {
               $bobotsks = $d['bobot_sks'];
            }
            $grandtotalskspengabdian = $grandtotalskspengabdian + ($skskegiatan * $bobotsks);
         }
         foreach ($datapenunjang as $d) {
            $skskegiatan = 0;
            $bobotsks = 0;
            if (isset($d['sks'])) {
               $skskegiatan = $d['sks'];
            }
            if (isset($d['bobot_sks'])) {
               $bobotsks = $d['bobot_sks'];
            }

            $dP = json_decode($d['deskripsi'], true);
            $jKeg = ($d['keg_bulanan'] == '0') ? $dP['dari'] : '1';
            $grandtotalskspenunjang += $bobotsks * $jKeg;
            // $grandtotalskspenunjang = $grandtotalskspenunjang + ($skskegiatan * $bobotsks);
         }


         if ($totalsksbulan != null or $grandtotalskspenunjang != null) {
            $totalsksbulantemp = @$totalsksbulan[0]['total_sks'] + $grandtotalskspenunjang;
         } else {
            $totalsksbulantemp = 0;
         }


         $namastruktural = '';
         $deskripsistruktural = '';
         $sksr_tugas_tambahan = 0;
         if ($datariwayatstruktural != null) {
            $sksr_tugas_tambahan = $datariwayatstruktural[0]['bobot_sksr'];
            $namastruktural = $datariwayatstruktural[0]['nama'];
            $deskripsistruktural = $datariwayatstruktural[0]['deskripsi'];
         }
         $totalsksbulantemp += $sksr_tugas_tambahan;
         $grandtotalsksbulan = $grandtotalskssisa + $totalsksbulantemp;

         $sks_remun_bulan = $grandtotalsksbulan;

         if ($sks_remun_bulan >= $sksr_gaji) {
            $sks_gaji_bulan = $sksr_gaji;
            $sks_remun_bulan = $sks_remun_bulan - $sks_gaji_bulan;
         } else {
            $sks_gaji_bulan = $sks_remun_bulan;
            $sks_remun_bulan = $sks_remun_bulan - $sks_gaji_bulan;
         }

         if ($sks_remun_bulan >= $sksr_kinerja) {
            $sks_kinerja_bulan = $sksr_kinerja;
            $sks_remun_bulan = $sks_remun_bulan - $sks_kinerja_bulan;
         } else {
            $sks_kinerja_bulan = $sks_remun_bulan;
            $sks_remun_bulan = $sks_remun_bulan - $sks_kinerja_bulan;
         }

         $id_bank = $datadosen[$i]['id_bank'];
         $bank = $this->DosenModel->bank($id_bank);

         $dataarray = array(
            'nip' => $datadosen[$i]['nip'],
            'namadosen' => $datadosen[$i]['nama_dosen'],
            'prodi'  => $datadosen[$i]['nama'],
            'golongan' => $datariwayatgolongan[0]['nama'],
            'idFungsional' => $datariwayatfungsional[0]['id_jabatan_fungsional'],
            'jabFungsional' => $datariwayatfungsional[0]['nama'],
            'jobvalue' => $datariwayatfungsional[0]['jobvalue'],
            'grade' => $datariwayatfungsional[0]['grade'],
            'pendidikan' => $datariwayatpendidikan[0]['singkatan'],
            'jabStruktural' => $namastruktural,
            'descStruktural' => $deskripsistruktural,
            'sksr_tt' => $sksr_tugas_tambahan,
            'sksr_gaji' => $sksr_gaji,
            'sksr_kinerja' => $sksr_kinerja,
            'skspendidikan' => $grandtotalskspendidikan,
            'skspenelitian' => $grandtotalskspenelitian,
            'skspengabdian' => $grandtotalskspengabdian,
            'skspenunjang' => $grandtotalskspenunjang,
            'totalsks' => number_format($totalsksbulantemp, 2),
            'sks_gaji_sebelumnya' => $grandtotalsksgajibayarsebelumnya,
            'sks_kinerja_sebelumnya' => $grandtotalskskinerjabayarsebelumnya,
            'sks_sisa_sebelumnya' => number_format($grandtotalskssisa, 2),
            'grandtotalsks' => number_format($grandtotalsksbulan, 2),
            'sks_gaji' => number_format($sks_gaji_bulan, 2),
            'sks_kinerja' => number_format($sks_kinerja_bulan, 2),
            'sisa_sks' => $sks_remun_bulan,
            'bank' => @$bank[0]['singkatan'],
            'rek' => $datadosen[$i]['no_rekening'],
            'npwp' => $datadosen[$i]['npwp'],
         );

         array_push($datakirim, $dataarray);
      }

      return $datakirim;
   }


   public function getDataRekapKegiatanBulanTahunStatusFakultas()
   {
      if ($this->session->userdata('sess_master')) {
         $session_data = $this->session->userdata('sess_master');
         $datakirim = array();
         $maxBulan = $_GET['bulan'];

         $data['tahun'] = $_GET['tahun'];
         $data['fakultas'] = $_GET['fakultas'];
         $data['prodi'] = 0;
         $data['status'] = $_GET['status_dosen'];
         $data['bulan'] = $_GET['bulan'];
         $datavalidasi = $this->getDataValidasi($data);
         echo json_encode($datavalidasi);
      } else {
         redirect('VerifyLogin', 'refresh');
      }
   }

   public function SisaSKSR()
   {
      $session_data = $this->session->userdata('sess_master');
      $data = array('datasession' => $session_data);

      $data['fakultas'] = $this->MainModel->getDataFakultas();
      $data['page'] = 'report';

      $this->template->view('template/wr2/sisasksr', $data);
   }

   public function getDataRekapRemunBulanTahunStatusFakultasRange()
   {
      $datakirim = array();

      $data['bulan'] = $_GET['bulan'];
      $data['endbulan'] = $_GET['endbulan'];
      $data['tahun'] = $_GET['tahun'];
      $data['fakultas'] = $_GET['fakultas'];
      $data['prodi'] = 0;
      $data['status'] = $_GET['status_dosen'];
      $datadosen = $this->DosenModel->getDosen($data);
      $max_kegiatan = $this->KegiatanModel->max_kegiatan(($data['endbulan'] + $data['bulan']) - 1);
      $max_bidang_2 = $max_kegiatan[0]['jumlah'];
      $max_bidang_4 = $max_kegiatan[1]['jumlah'];

      // print_r($max_kegiatan);
      foreach ($datadosen as $dosen) {

         $data['nip'] = $dosen['id_dosen'];

         // get struktural
         $sksr_tugas_tambahan = 0;
         $sksr_max = 0;
         for ($i = $data['bulan']; $i <= $data['endbulan']; $i++) {
            $datariwayatstruktural = @$this->StrukturalModel->getStrukturalByRange($data, $i);
            $datariwayatfungsional = @$this->FungsionalModel->getFungsionalByRange($data, $i);
            $sksr_tugas_tambahan += (empty($datariwayatstruktural)) ? 0 : $datariwayatstruktural[0]['bobot_sksr'];
            $sksr_max += (empty($datariwayatfungsional)) ? 0 : $datariwayatfungsional[0]['sksr_max'];
         }

         $datakegiatan1 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunRange($data, '1');
         $datakegiatan2 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunRange($data, '2');
         $datakegiatan3 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunRange($data, '3');
         $datakegiatan5 = $this->KegiatanModel->getKegiatanDosenJenisBulanTahunRange($data, '5');
         $totalsks1 = (empty($datakegiatan1)) ? 0 : $datakegiatan1[0]['total'];
         $totalsks2 = (empty($datakegiatan2)) ? 0 : $datakegiatan2[0]['total'];
         $totalsks3 = (empty($datakegiatan3)) ? 0 : $datakegiatan3[0]['total'];
         $totalsks5 = (empty($datakegiatan5)) ? 0 : $datakegiatan5[0]['total'];

         $data['jenis'] = 4;
         $totalsks4 = 0;
         $x = $data['bulan'];
         for ($i = $x; $i <= $data['endbulan']; $i++) {
            $data['bulan'] = $i;
            $datakegiatan4 = $this->ValidasiModel->getKegiatanDosenJenisBulanTahun($data);

            foreach ($datakegiatan4 as $row) {
               $d = json_decode($row['deskripsi'], true);
               // $jKeg = ($row['keg_bulanan']=='0') ? $d['dari'] : '1';
               $jKeg = ($row['keg_bulanan'] == '0') ? ((!isset($d['dari'])) ? '1' : $d['dari']) : '1';
               $totalsks4 += $row['bobot_sks'] * $jKeg;
            }
         }
         $data['bulan'] = $x;


         $total_sks = $totalsks1 + $totalsks2 + $totalsks3 + $totalsks4 + $totalsks5 + $sksr_tugas_tambahan;
         $total_ext = $totalsks1 + min($max_bidang_2, $totalsks2) + $totalsks3 + min($max_bidang_4, $totalsks4) + $totalsks5 + $sksr_tugas_tambahan;

         $bonus = ($total_ext <= $sksr_max) ? 0 : ($total_ext - $sksr_max);

         $dataarray = array(
            'nama_dosen' => $dosen['nama_dosen'],
            'nip' => $dosen['nip'],
            'pengajaran' => number_format($totalsks1, 2, ",", "."),
            'penelitian' => number_format($totalsks2, 2, ",", "."),
            'pengabdian' => number_format($totalsks3, 2, ",", "."),
            'penunjang' => number_format($totalsks4, 2, ",", "."),
            'nonstruktural' => number_format($totalsks5, 2, ",", "."),
            'total_sks' => number_format($total_sks, 2, ",", "."),
            'total_ext' => number_format($total_ext, 2, ",", "."),
            'max_bidang_2' => number_format(min($max_bidang_2, $totalsks2), 2, ",", "."),
            'max_bidang_4' => number_format(min($max_bidang_4, $totalsks4), 2, ",", "."),
            'sksr_tugas_tambahan' => number_format($sksr_tugas_tambahan, 2, ",", "."),
            'sksr_max' => number_format($sksr_max, 2, ",", "."),
            'bonus' => number_format($bonus, 2, ",", "."),
         );
         array_push($datakirim, $dataarray);
      }
      echo json_encode($datakirim);
   }


   public function detailsKegiatan()
   {
      $namaBulan = array("", "Januari", "Februaru", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
      $data['session'] = $this->session->userdata('sess_dosen');
      $data['tipe']    = $_POST['tipe'];
      $data['bulan']   = $namaBulan[$_POST['bulan']];
      $data['tahun']   = $_POST['tahun'];
      $data['nip']     = $_POST['nip'];

      $dataisi = $this->MainModel->validasiKegiatan($data);
      echo json_encode($dataisi);
   }
}
