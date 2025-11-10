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
      $this->load->model('FungsionalModel');
      $this->load->model('ValidasiModel');
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
      $data['fakultas'] = $this->MainModel->getDataFakultas();
      $data['page'] = 'report';

      //array_push($datakirim, $dataarray);
      $row['nip'] = $session_data['idDosen'];
      $datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
      $data['menuextend'] = $datajabatan[0]['id_jabatan_struktural'];

      $this->template->view('template/wr2/rekapremununri', $data);
   }

   public function getDataRekapRemunBulanTahunStatusFakultas()
   {
      if ($this->session->userdata('sess_dosen')) {
         $session_data = $this->session->userdata('sess_dosen');
         $datakirim = array();

         $data['bulan'] = $_GET['bulan'];
         $data['tahun'] = $_GET['tahun'];
         $data['fakultas'] = $_GET['fakultas'];
         $data['prodi'] = 0;
         $data['status'] = $_GET['status_dosen'];
         $datadosen = $this->DosenModel->getDosen($data);

         foreach ($datadosen as $dosen) {

            $data['nip'] = $dosen['id_dosen'];
            $datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);
            if ($datavalidasi != null) {
               $statusvalidasi = $datavalidasi[0]['status'];
            } else {
               $statusvalidasi = 0;
            }
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
               $totalsks4 = $totalsks4 + ($row['sks'] * $row['bobot_sks']);
            }

            $tarif = 0;
            $datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);
            $datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);
            if ($datafungsional != null) {
               $sksr_gaji = $datafungsional[0]['sksr_maks_gaji'];
               $sksr_kinerja = $datafungsional[0]['sksr_maks_kinerja'];
            }

            if ($datastruktural != null) {
               if ($datastruktural[0]['id_jabatan_struktural'] == 0) {
                  $tarif_gaji = $datafungsional[0]['gaji_tambahan_maks'];
                  $tarif_kinerja = $datafungsional[0]['insentif_kinerja'];
               } else {
                  $tarif_gaji = $datastruktural[0]['gaji_tambahan_maks'];
                  $tarif_kinerja = $datastruktural[0]['insentif_kinerja'];
               }
               $sksr_tugas_tambahan = $datastruktural[0]['bobot_sksr'];
            }
            $datagolongan = $this->GolonganModel->getGolonganByTMT($data);
            if ($datagolongan != null) {
               $pph = $datagolongan[0]['pph'];
            } else {
               $pph = 0;
            }


            if ($statusvalidasi > 0) {
               $totalsks1 = $datavalidasi[0]['jumlah_sks_bid_1'];
               $totalsks2 = $datavalidasi[0]['jumlah_sks_bid_2'];
               $totalsks3 = $datavalidasi[0]['jumlah_sks_bid_3'];
               $totalsks4 = $datavalidasi[0]['jumlah_sks_bid_4'];
               if ($statusvalidasi == 1) {
                  $status = "Kegiatan Tidak Valid";
               } else if ($statusvalidasi == 2) {
                  $status = "Kegiatan Valid";
               } else if ($statusvalidasi == 3) {
                  $status = "Pembayaran Valid";
               }
               $sks_remun = $datavalidasi[0]['sks_remun'];
            } else {
               $status = "Belum di Validasi";
               $sks_remun = 0;
            }
            $total_sks = $totalsks1 + $totalsks2 + $totalsks3 + $totalsks4;
            $pajak = $sks_remun * $tarif * $pph;

            $total_jumlah = ($sks_remun * $tarif) - $pajak;
            $dataarray = array(
               'nama_dosen' => $dosen['nama'],
               'nip' => $data['nip'],
               'pengajaran' => number_format($totalsks1, 2, ",", "."),
               'penelitian' => number_format($totalsks2, 2, ",", "."),
               'pengabdian' => number_format($totalsks3, 2, ",", "."),
               'penunjang' => number_format($totalsks4, 2, ",", "."),
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
      } else {
         redirect('VerifyLogin', 'refresh');
      }
   }

   public function RekapKegiatan()
   {
      if ($this->session->userdata('sess_dosen')) {
         $session_data = $this->session->userdata('sess_dosen');
         $data = array('datasession' => $session_data);
         $datakirim = array();
         $data['fakultas'] = $this->MainModel->getDataFakultas();
         $data['page'] = 'report';

         //array_push($datakirim, $dataarray);
         $row['nip'] = $session_data['idDosen'];
         $datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
         $data['menuextend'] = $datajabatan[0]['id_jabatan_struktural'];

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

         for ($j = 1; $j <= $maxBulan - 1; $j++) {
            $data['bulan'] = $j;
            $totalsks = $this->MainModel->getTotalSKSPerBulan($data);
            $jabStruktural = $this->MainModel->getJabStrukturalPerBulanTahun($data);
            $datapembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);
            $jabfungsional = $this->MainModel->getJabFungsionalPerBulanTahun($data);
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

            if ($totalsks == null) {
               $total_sks = $sksr_tugas_tambahan;
            } else {
               $total_sks = $totalsks[0]['total_sks'] + $sksr_tugas_tambahan;
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

         $data['bulan'] = $maxBulan;
         $datariwayatgolongan = $this->GolonganModel->getGolonganByTMT($data);
         $datariwayatfungsional = $this->FungsionalModel->getFungsionalByTMT($data);
         $datariwayatpendidikan = $this->PendidikanModel->getPendidikanByTMT($data);
         $datariwayatstruktural = $this->StrukturalModel->getStrukturalByTMT($data);
         $data['jenis'] = 1;
         $datapendidikan = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         $data['jenis'] = 2;
         $datapenelitian = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         $data['jenis'] = 3;
         $datapengabdian = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         $data['jenis'] = 4;
         $datapenunjang = $this->KegiatanModel->getKegiatanDosenJenisBulanTahun($data);
         $totalsksbulan = $this->MainModel->getTotalSKSPerBulan($data);
         $grandtotalskspendidikan = 0;
         $grandtotalskspenelitian = 0;
         $grandtotalskspengabdian = 0;
         $grandtotalskspenunjang = 0;

         if ($datariwayatgolongan == null) {
            $datariwayatgolongan[0]['nama'] = "";
         }

         if ($datariwayatfungsional == null) {
            $datariwayatfungsional[0]['nama'] = "";
            $datariwayatfungsional[0]['jobvalue'] = 0;
            $datariwayatfungsional[0]['grade'] = 0;
            $datariwayatfungsional[0]['id_jabatan_fungsional'] = 0;
            $sksr_gaji = 0;
            $sksr_kinerja = 0;
         } else {
            $sksr_gaji = $datariwayatfungsional[0]['sksr_maks_gaji'];
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
            $grandtotalskspenunjang = $grandtotalskspenunjang + ($skskegiatan * $bobotsks);
         }



         if ($totalsksbulan != null) {
            $totalsksbulantemp = $totalsksbulan[0]['total_sks'];
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



         $dataarray = array(
            'nip' => $datadosen[$i]['nip'],
            'namadosen' => $datadosen[$i]['nama'],
            'prodi'  => $datadosen[$i]['namaprodi'],
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
            'totalsks' => $totalsksbulantemp,
            'sks_gaji_sebelumnya' => $grandtotalsksgajibayarsebelumnya,
            'sks_kinerja_sebelumnya' => $grandtotalskskinerjabayarsebelumnya,
            'sks_sisa_sebelumnya' => $grandtotalskssisa,
            'grandtotalsks' => $grandtotalsksbulan,
            'sks_gaji' => $sks_gaji_bulan,
            'sks_kinerja' => $sks_kinerja_bulan,
            'sisa_sks' => $sks_remun_bulan,
         );

         array_push($datakirim, $dataarray);
      }





      return $datakirim;
   }


   public function getDataRekapKegiatanBulanTahunStatusFakultas()
   {
      if ($this->session->userdata('sess_dosen')) {
         $session_data = $this->session->userdata('sess_dosen');
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
}
