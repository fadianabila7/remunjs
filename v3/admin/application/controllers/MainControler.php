<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MainControler extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->library('excel');
		$this->load->model('DosenModel');
		$this->load->model('GolonganModel');
		$this->load->model('PendidikanModel');
		$this->load->model('FungsionalModel');
		$this->load->model('StrukturalModel');
		$this->load->model('KegiatanModel');
		$this->load->model('PembayaranModel');
		$this->load->model('MainModel');
		$this->load->model('DashboardModel');
		$this->load->model('User');
		date_default_timezone_set("Asia/Jakarta");
		if (!$this->session->userdata('sess_admin')) {
			redirect("VerifyLogin", 'refresh');
		}
	}
	public function index()
	{

		$session_data = $this->session->userdata('sess_admin');
		$data = array('datasession' => $session_data);
		$data['tahun'] = date("Y");
		$data['fakultas'] = $session_data['idFakultas'];
		$data['totaldosen'] = $this->DashboardModel->count('dosen', $session_data['idFakultas']);
		$data['totalprodi'] = $this->DashboardModel->dosenProdi($session_data['idFakultas']);
		$data['getFungsional'] = $this->DashboardModel->getFungsional($session_data['idFakultas']);
		// $data['getStruktural'] = $this->DashboardModel->getStruktural($session_data['idFakultas']);
		$data['totalPenunjang'] = $this->DashboardModel->getTotalSKPenunjang($data);

		$data['page'] = 'home';
		$this->template->view('template/content', $data);
	}

	public function getChart()
	{
		// total
		$session_data = $this->session->userdata('sess_admin');
		$data['status'] = "1";
		$totaldosen = $_GET['data'];
		$maxBulan = date("m");
		$data['tahun'] = date("Y");
		$data['fakultas'] = $session_data['idFakultas'];
		$data['namafakultas'] = $session_data['namafakultas'];

		for ($i = 1; $i <= $maxBulan; $i++) {
			$data['bulan'] = $i;

			$datavalidasi = $this->getDataValidasi($data);
			$struktural = "";
			$pengajaran = "";
			$penelitian = "";
			$penunjang = "";
			$nonstruktural = "";
			foreach ($datavalidasi as $row) {
				$struktural += $row['sksr_tt'];
				$pengajaran += $row['skspendidikan'];
				$penelitian += $row['skspenelitian'];
				$penunjang += $row['skspenunjang'];
				$nonstruktural += $row['nonstruktural'];
			}

			$data['struktural'][$i] = ($struktural == 0) ? 0 : $struktural / $totaldosen;
			$data['pengajaran'][$i] = ($pengajaran == 0) ? 0 : $pengajaran / $totaldosen;
			$data['penelitian'][$i] = ($penelitian == 0) ? 0 : $penelitian / $totaldosen;
			$data['penunjang'][$i] = ($penunjang == 0) ? 0 : $penunjang / $totaldosen;
			$data['nonstruktural'][$i] = ($nonstruktural == 0) ? 0 : $nonstruktural / $totaldosen;
		}

		echo json_encode($data);
		// print_r($datavalidasi);
	}

	public function logout()
	{
		$this->session->unset_userdata('sess_admin');
		session_destroy();
		redirect('VerifyLogin', 'refresh');
	}

	public function login()
	{
		$this->template->loginpage();
	}

	public function getProdi()
	{
		$session_data = $this->session->userdata('sess_admin');
		$dataprodi    = $this->MainModel->getDataProdi($session_data['idFakultas']);
		return $dataprodi;
	}

	public function getJsonProdi()
	{
		if (isset($_POST['id'])) {
			$dataprodi = $this->MainModel->getDataProdi($_POST['id']);
			echo json_encode($dataprodi);
		}
	}

	public function getFakultas()
	{
		$datafakultas = $this->MainModel->getDataFakultas();
		return $datafakultas;
	}

	public function getStatus()
	{
		$session_data = $this->session->userdata('sess_admin');
		$datastatus = $this->MainModel->getDataStatus();
		return $datastatus;
	}

	public function getDosen()
	{
		$session_data = $this->session->userdata('sess_admin');
		$datadosen = $this->DosenModel->getDataDosenByFakultas($session_data['idFakultas']);
		return $datadosen;
	}

	public function getJabatanStruktural()
	{
		$datastruktural = $this->StrukturalModel->getJabatanStruktural();
		echo json_encode($datastruktural);
	}

	/*-------------------------------------------------- View Controller ------------------------------------*/

	public function DataDosen()
	{
		$session_data = $this->session->userdata('sess_admin');
		if ($session_data['idFakultas'] == 0) {
			$data = array('datasession' => $session_data);
			$data['page'] = 'dosen';
			$dataprodi = $this->getProdi();
			$datastatus = $this->getStatus();
			$datafakultas = $this->getFakultas();
			$databank = $this->MainModel->getDataBank();

			$dataisi = array(
				'fakultas' => $datafakultas,
				'prodi' => $dataprodi,
				'status' => $datastatus,
				'bank' => $databank,
			);
			$this->template->view('template/listdosen', $data, $dataisi);
		} else {
			redirect('MainControler', 'refresh');
		}
	}

	public function riwayatkegiatan()
	{
		if ($this->session->userdata('sess_admin')) {

			$session_data = $this->session->userdata('sess_admin');
			$data = array('datasession' => $session_data);
			$this->template->view('template/riwayatkegiatan', $data);
		} else {
			redirect('VerifyLogin', 'refresh');
		}
	}

	public function RegistrasiDosen()
	{
		$session_data = $this->session->userdata('sess_admin');
		if ($session_data['idFakultas'] == 0) {
			$data = array('datasession' => $session_data);
			$data['page'] = 'dosen';
			$datafakultas = $this->getFakultas();
			$datastatus = $this->getStatus();
			$databank = $this->MainModel->getDataBank();

			$dataisi = array(
				'fakultas' => $datafakultas,
				'status' => $datastatus,
				'bank' => $databank,
			);
			$this->template->view('template/entrydosen', $data, $dataisi);
		} else {
			redirect('MainControler', 'refresh');
		}
	}

	public function DataOperator()
	{
		$dataprodi = $this->getProdi();

		$session_data = $this->session->userdata('sess_admin');
		$data = array('datasession' => $session_data);
		$data['page'] = 'operator';
		$dataisi = array(
			'prodi' => $dataprodi
		);
		$this->template->view('template/listoperator', $data, $dataisi);
	}

	public function RegistrasiOperator()
	{

		if ($this->session->userdata('sess_admin')) {

			$dataprodi = $this->getProdi();

			$session_data = $this->session->userdata('sess_admin');
			$data = array('datasession' => $session_data);
			$data['page'] = 'operator';
			$dataisi = array(
				'prodi' => $dataprodi
			);
			$this->template->view('template/entryoperator', $data, $dataisi);
		} else {
			redirect('VerifyLogin', 'refresh');
		}
	}

	public function DataRiwayat()
	{
		$session_data = $this->session->userdata('sess_admin');
		// cek session kepegawaian
		if ($session_data['idFakultas'] == 0) {
			$data = array('datasession' => $session_data);
			$data['page'] = 'riwayat';
			$datafakultas = $this->getFakultas();
			$datastatus = $this->getStatus();

			$dataisi = array('fakultas' => $datafakultas, 'status' => $datastatus);
			$this->template->view('template/listriwayat', $data, $dataisi);
		} else {
			redirect('MainControler', 'refresh');
		}
	}

	// public function DataRiwayat(){
	// 	$session_data = $this->session->userdata('sess_admin');
	// 		$data = array('datasession' => $session_data);
	// 		$data['page'] = 'riwayat';
	// 		$dataprodi = $this->getProdi();
	// 		$datastatus = $this->getStatus();
	// 		$dataisi = array('prodi' => $dataprodi,'status' => $datastatus);
	// 		$this->template->view('template/listriwayat',$data,$dataisi);
	// }

	public function RekapRemunIndividu()
	{
		$session_data = $this->session->userdata('sess_admin');
		$data = array('datasession' => $session_data);
		$data['page'] = 'kegiatan';

		$datadosen = $this->getDosen();
		$dataisi = array('dosen' => $datadosen);

		$this->template->view('template/rekapremun', $data, $dataisi);
	}

	public function getGolonganTurunan()
	{
		$data['golongan'] = $_GET['kode'];

		$datagolongan = $this->GolonganModel->getGolonganKode($data);
		echo json_encode($datagolongan);
	}

	/*public function cobagolongan()
	{
			$data['nip'] = "09111002051";
			$datagolongan = $this->GolonganModel->getGolonganByIDDosen($data);
			echo $datagolongan[0]['nama'];
	}*/
	public function RiwayatIndividu($nip)
	{

		if ($this->session->userdata('sess_admin')) {
			$session_data = $this->session->userdata('sess_admin');
			$listFungsional = $this->MainModel->getDataFungsional();

			$data = array(
				'datasession' => $session_data,
				'lFungsional'	=> $listFungsional
			);

			$data['nip'] = str_replace('%20', ' ', $nip);
			$datadosen = $this->DosenModel->getDataDosen($data);
			$data['id_dosen'] = $datadosen[0]['id_dosen'];

			$datagolonganall = $this->GolonganModel->getGolongan();
			$datagolongan = $this->GolonganModel->getGolonganByIDDosen($data);
			if (empty($datagolongan)) {
				$golongandosen = 0;
			} else {
				$golongandosen = $datagolongan[0]['golongan'];
			}
			$datapendidikan = @$this->PendidikanModel->getPendidikanByIDDosen($data);
			$datafungsional = @$this->FungsionalModel->getFungsionalByIDDosen($data);
			$datastruktural = @$this->StrukturalModel->getStrukturalByIDDosen($data);
			$struktural = $this->StrukturalModel->getJabatanStrukturalByGolongan($golongandosen);

			$dataisi = array(
				'dosen' => $datadosen,
				'golongan' => $datagolongan,
				'pendidikan' => $datapendidikan,
				'fungsional' => $datafungsional,
				'struktural' => $datastruktural,
				'jabatan_struktural' => $struktural,
				'datagolonganall' => $datagolonganall,
			);

			$this->template->view('template/riwayatindividu', $data, $dataisi);
			//print_r($datagolongan);
		} else {
			redirect('VerifyLogin', 'refresh');
		}
	}
	public function ValidasiWD1()
	{
		if ($this->session->userdata('sess_admin')) {
			$session_data = $this->session->userdata('sess_admin');
			$data = array('datasession' => $session_data);
			$data['page'] = 'kegiatan';
			$datastatus = $this->getStatus();

			$dataisi = array(
				'status' => $datastatus
			);

			$this->template->view('template/validasi', $data, $dataisi);
		} else {
			redirect('VerifyLogin', 'refresh');
		}
	}

	public function Profile()
	{
		if ($this->session->userdata('sess_admin')) {
			$session_data = $this->session->userdata('sess_admin');
			$data = array('datasession' => $session_data);

			$this->template->view('template/profile', $data, NULL);
		} else {
			redirect('VerifyLogin', 'refresh');
		}
	}

	/*------------------------------------------ Data Rekap COntroller -----------------------------------*/

	public function getDataRekapIndividu()
	{
		$data['nip']          = $_GET['nip'];
		$maksbulan            = $_GET['bulan'];
		$data['tahun']        = $_GET['tahun'];
		$totalsksarr          = array();
		$datakirim            = array();
		$grandtotalsks        = 0;
		$grandtotalsksgaji    = 0;
		$grandtotalskskinerja = 0;
		$grandtotalskssisa    = 0;


		for ($i = 1; $i <= $maksbulan; $i++) {
			$data['bulan']   = $i;
			$totalsks        = $this->MainModel->getTotalSKSPerBulanBukanJ4($data);
			$totalsks2 		 = $this->MainModel->getTotalSKSPerBulanJ4($data);
			$skssementara    = 0;
			$sisasksbayar    = 0;
			$lebihsksbayar   = 0;

			$datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);
			$datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);

			if ($datafungsional != null) {
				$sksr_kinerja = $datafungsional[0]['sksr_maks_kinerja'];
				$sksr_gaji = $datafungsional[0]['sksr_maks_gaji'];
			} else {
				$sksr_kinerja = 0;
				$sksr_gaji = 0;
			}

			//if(isset($datastruktural))
			if (count($datastruktural) > 0) {
				$sksr_tugas_tambahan = $datastruktural[0]['bobot_sksr'];
				$namastruktural = $datastruktural[0]['nama'];
			} else {
				$sksr_tugas_tambahan = 0;
				$namastruktural = '';
			}


			if (count($totalsks) > 0 || count($totalsks2) > 0) {
				foreach ($totalsks2 as $dataloop) {
					$d = json_decode($dataloop['deskripsi'], true);
					$jKeg = ($dataloop['keg_bulanan'] == '0') ? $d['dari'] : '1';
					$skssementara += $dataloop['bobot_sks'] * $jKeg;
				}

				$total_sks = @$totalsks[0]['total_sks'] + @$skssementara + $sksr_tugas_tambahan;
			} else {
				$total_sks = $sksr_tugas_tambahan;
			}

			$sks_remun = $total_sks;

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

			$grandtotalsks += $total_sks;
			$grandtotalsksgaji += $sks_gaji;
			$grandtotalskskinerja += $sks_kinerja;
			$grandtotalskssisa += $sks_remun;

			$dataarray = array(
				'bulan' => $i,
				'struktural' => $namastruktural,
				'totalsks' => number_format($total_sks, 2, ',', '.'),
				'sksgaji' => number_format($sks_gaji, 2, ',', '.'),
				'skskinerja' => number_format($sks_kinerja, 2, ',', '.'),
				'sisasks' => number_format($sks_remun, 2, ',', '.'),
				'skstt' => number_format($sksr_tugas_tambahan, 2, ',', '.'),
			);

			//$totalsksarr += [ $i => $totalsks ];
			array_push($datakirim, $dataarray);
		}

		$dataarray = array(
			'bulan' => 0,
			'struktural' => 'Total SKS',
			'totalsks' => number_format($grandtotalsks, 2, ',', '.'),
			'sksgaji' => number_format($grandtotalsksgaji, 2, ',', '.'),
			'skskinerja' => number_format($grandtotalskskinerja, 2, ',', '.'),
			'sisasks' => number_format($grandtotalskssisa, 2, ',', '.'),
			'skstt' => number_format(0, 2, ',', '.'),
		);
		array_push($datakirim, $dataarray);


		echo json_encode($datakirim);
	}

	public function setDataExportPNSToExcel($objPHPExcel, $dataExcel, $data)
	{
		$nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
		$objPHPExcel->getActiveSheet()->setTitle($nama_bulan[$data['bulan']]);

		$gdImage = imagecreatefromjpeg('assets/img/unri_bw.JPG');
		// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$objDrawing->setName('Sample image');
		$objDrawing->setDescription('Sample image');
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		$objDrawing->setHeight(120);
		$objDrawing->setCoordinates('B1');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'KEMENTERIAN RISET, TEKNOLOGI DAN PENDIDIKAN TINGGI');
		$objPHPExcel->getActiveSheet()->SetCellValue('C2', 'UNIVERSITAS RIAU');
		$objPHPExcel->getActiveSheet()->SetCellValue('C3', "FAKULTAS " . strtoupper($data['namafakultas']));
		$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Kampus Bina Widya Km 12,5 Simpang Baru Pekanbaru 28293');
		$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Telepon (0761) 63266, Faksimile (0761) 63279');
		$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Laman : www.unri.ac.id ');

		$objPHPExcel->getActiveSheet()
			->getStyle('C1:C6')
			->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()
			->getStyle('C1')
			->getFont()->setSize(16);
		$objPHPExcel->getActiveSheet()
			->getStyle('C2')
			->getFont()->setSize(16);
		$objPHPExcel->getActiveSheet()
			->getStyle('C3')
			->getFont()->setSize(20);
		$objPHPExcel->getActiveSheet()
			->getStyle('C4')
			->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()
			->getStyle('C5')
			->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()
			->getStyle('C6')
			->getFont()->setSize(12);

		$objPHPExcel->getActiveSheet()->SetCellValue('B8', 'Bulan');
		$objPHPExcel->getActiveSheet()->SetCellValue('C8', $nama_bulan[$data['bulan']] . " " . $data['tahun']);
		$objPHPExcel->getActiveSheet()
			->getStyle('B8:C8')
			->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()
			->getStyle('B8:C8')
			->getFont()->setSize(14);

		$rowCount = 10;

		$objPHPExcel->getActiveSheet()->getStyle("A" . $rowCount . ":Z" . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("AA" . $rowCount . ":AD" . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle("A" . $rowCount . ":Z" . $rowCount)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("AA" . $rowCount . ":AD" . $rowCount)->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'NO');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'NIP');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'NAMA');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'PROGRAM STUDI');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'GOLONGAN');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'JABATAN FUNGSIONAL');
		// $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'JOB VALUE');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'GRADE');
		// $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,'PENDIDIKAN TERAKHIR');
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'JABATAN STRUKTURAL');
		// $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,'DESKRIPSI JABATAN STRUKTURAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, "SKS GAJI MAKS\n(M)");
		$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, "SKS KINERJA\nMAKS\n(N)");
		$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, "SKS STRUKTURAL");
		$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, "JUMLAH SKS BID. PENDIDIKAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, "JUMLAH SKS BID. PENELITIAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, "JUMLAH SKS BID. PENGABDIAN");
		$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "JUMLAH SKS BID. PENUNJANG");
		$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, "JUMLAH SKS BID. NON STRUKTURAL");
		$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, "JUMLAH SKS\n(S)");
		// $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount,"TOTAL SKS GAJI\nS.D BULAN SEBELUMNYA\n(T)");
		// $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount,"TOTAL SKS KINERJA\nS.D BULAN SEBELUMNYA\n(U)");
		$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, "TOTAL SISA SKS\nS.D BULAN SEBELUMNYA\n(V)");
		$objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, "TOTAL SKS\n(W = S + V)");
		$objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, "TOTAL SKS GAJI\n(X = MIN(M,W), X >=0)");
		$objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, "TOTAL SKS KINERJA\n(Y = MIN(N,W), Y >=0)");
		$objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, "TOTAL SISA\nKELEBIHAN SKS\n(Z=W-X-Y)");

		$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, "SKS Gaji MAX \nDari AWAL BULAN\n(W)");
		$objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, "SKS KINERJA MAKS \nDARI AWAL BULAN\n(X)");
		$objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, "TOTAL SKS GAJI\nDARI AWAL BULAN\n(Y=MIN(W,S)");
		$objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, "TOTAL SKS KINERJA\nDARI AWAL BULAN\n(Z=MIN(X,(S-Y))");
		$objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, "SISAKELEBIHAN SKS\nDARI AWAL BULAN\n(AA=S-(SUM(Y,Z)))");
		$objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, "SKS * GAJI");
		$objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, "SKS * KINERJA");
		$objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, "TOTAL\n(AA=AB+AC)");



		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(33);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);


		$azam = 0;
		foreach ($dataExcel as $excel) {
			$rowCount++;
			$azam++;

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 10);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowCount, $excel['nip'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $excel['namadosen']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $excel['prodi']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $excel['golongan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $excel['jabFungsional']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $excel['pendidikan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $excel['jabStruktural']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $excel['sksr_gaji']);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $excel['sksr_kinerja']);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $excel['sksr_tt']);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $excel['skspendidikan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $excel['skspenelitian']);
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $excel['skspengabdian']);
			$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $excel['skspenunjang']);
			$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $excel['nonstruktural']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $excel['totalsks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $excel['sks_sisa_sebelumnya']);
			$objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $excel['grandtotalsks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $excel['sks_gaji']);
			$objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $excel['sks_kinerja']);
			$objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $excel['sisa_sks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, ($excel['sksr_gaji'] * $data['bulan']));
			$objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, ($excel['sksr_kinerja'] * $data['bulan']));
			$objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, ("=MIN(W" . $rowCount . ",S" . $rowCount . ")"));
			$objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, ("=MIN(X" . $rowCount . ",(S" . $rowCount . "-Y" . $rowCount . "))"));
			$objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, ("=S" . $rowCount . "-SUM(Y" . $rowCount . ",Z" . $rowCount . ")"));
			// if($excel['jabStruktural']=="" || $excel['jabStruktural']=="Belum ada jabatan struktural"){
			// 	$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, ("=(Y".$rowCount."/".$excel['sksr_gaji'].")*".$excel['fungsional_gaji_tambahan_maks']));
			// 	$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, ("=(Z".$rowCount."/".$excel['sksr_kinerja'].")*".$excel['fungsional_insentif_kinerja']));
			// }else{
			// 	$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, ("=(Y".$rowCount."/".$excel['sksr_gaji'].")*".$excel['struktural_gaji_tambahan_maks']));
			// 	$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, ("=(Z".$rowCount."/".$excel['sksr_kinerja'].")*".$excel['struktural_insentif_kinerja']));
			// }
			// $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowCount, ("=AB".$rowCount."+AC".$rowCount));

		}
		$rowCount2 = 10;

		for ($idx = 'A'; $idx <= 'Z'; $idx++) { //CEK A - V YG AKAN DI JADIKAN RATA KIRI
			if ($idx == 'C') { //||$idx=='J'||$idx=='K'
				$objPHPExcel->getActiveSheet()->getStyle($idx . $rowCount2 . ":" . $idx . $objPHPExcel->getActiveSheet()->getHighestRow())
					->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			} else {
				$objPHPExcel->getActiveSheet()
					->getStyle($idx . $rowCount2 . ":" . $idx . $objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
		}
		for ($idx = 'AA'; $idx <= 'AD'; $idx++) { //CEK A - V YG AKAN DI JADIKAN RATA KIRI
			$objPHPExcel->getActiveSheet()
				->getStyle($idx . $rowCount2 . ":" . $idx . $objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}




		for ($idx = 'I'; $idx <= 'Z'; $idx++) {
			$objPHPExcel->getActiveSheet()->getStyle($idx . $rowCount2 . ":" . $idx . $objPHPExcel->getActiveSheet()->getHighestRow())->getNumberFormat()->setFormatCode('0.00');
		}

		$objPHPExcel->getActiveSheet()->getStyle('AA' . $rowCount2 . ":AA" . $objPHPExcel->getActiveSheet()->getHighestRow())->getNumberFormat()->setFormatCode('0.00');


		for ($idx = 'AB'; $idx <= 'AD'; $idx++) {
			$objPHPExcel->getActiveSheet()->getStyle($idx . $rowCount2 . ":" . $idx . $objPHPExcel->getActiveSheet()->getHighestRow())->getNumberFormat()->setFormatCode("#,##0.00");
		}

		$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount2 . ':AD' . $rowCount)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('K' . $rowCount2 . ':K' . $objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

		$styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

		$objPHPExcel->getActiveSheet()->getStyle('A10:V' . $rowCount)->applyFromArray($styleArray);

		// tambahan
		$objPHPExcel->getActiveSheet()->getStyle('W10:AD' . $rowCount)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('W10:AA' . $rowCount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('888ce280');
		$objPHPExcel->getActiveSheet()->getStyle('AB10:AD' . $rowCount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('3087CEFA');
		// end tambahan

		unset($styleArray);

		$idx_hari = Date('d');
		$idx_hari = $idx_hari * 1;
		$idx_bulan = Date('m');
		$idx_bulan = $idx_bulan * 1;
		$idx_tahun = Date('Y');

		$session_data = $this->session->userdata('sess_admin');

		if ($session_data['namaAdmin'] == null) {
			$nama_admin = "..............................................";
		} else {
			$nama_admin = $session_data['namaAdmin'];
		}
		$azam = $rowCount + 4;

		$objPHPExcel->getActiveSheet()->SetCellValue('I' . $azam, "Pekanbaru, " . $idx_hari . " " . $nama_bulan[$idx_bulan] . " " . $idx_tahun);
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . ($azam + 1), 'Admin Fakultas');
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . ($azam + 6), "( " . $nama_admin . " )");
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . ($azam + 7), 'NIP. ');

		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $azam, 'Menyetujui,');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($azam + 1), 'Wakil Dekan Bidang Akademik');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($azam + 6), '(..............................................)');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($azam + 7), 'NIP. ');

		$objPHPExcel->getActiveSheet()
			->getStyle("A" . $azam . ":" . "Q" . ($azam + 7))
			->getFont()->setSize(13);
	}



	public function getDataValidasi($data)
	{
		$maxBulan = $data['bulan'];
		$datakirim = array();
		$datadosen = $this->DosenModel->getDataDosenFakultasStatus($data);

		for ($i = 0; $i < count($datadosen); $i++) {
			$data['nip'] = $datadosen[$i]['id_dosen'];

			$grandtotalsksgaji = 0;
			$grandtotalskskinerja = 0;
			$grandtotalskslebih = 0;
			$grandtotalsksbayar = 0;
			$grandtotalskssisa = 0;
			$grandtotalsks = 0;
			$grandtotalskspenunjangold = 0;
			$grandtotalsksgajibayarsebelumnya = 0;
			$grandtotalskskinerjabayarsebelumnya = 0;

			for ($j = 1; $j <= $maxBulan - 1; $j++) {
				$data['bulan'] = $j;
				$grandtotalskspenunjangold = 0;
				$totalsks = $this->MainModel->getTotalSKSPerBulan($data);
				$jabStruktural = $this->MainModel->getJabStrukturalPerBulanTahun($data);
				$datapembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);
				$jabfungsional = $this->MainModel->getJabFungsionalPerBulanTahun($data);
				$data['jenis_kegiatan'] = 4;
				$datapenunjangold = $this->KegiatanModel->getKegiatanIndividuJenisBulanTahun($data);
				foreach ($datapenunjangold as $d) {
					$skskegiatan = 0;
					$bobotsks = 0;
					$desc = json_decode($d['deskripsi'], true);
					if (isset($desc['dari'])) {
						$skskegiatan = ($d['keg_bulanan'] == '0') ? $desc['dari'] : '1';
					}
					if (isset($d['bobot_sks'])) {
						$bobotsks = $d['bobot_sks'];
					}
					$grandtotalskspenunjangold += $bobotsks * $skskegiatan;
				}

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
					$total_sks = $sksr_tugas_tambahan + $grandtotalskspenunjangold;
				} else {
					$total_sks = $totalsks[0]['total_sks'] + $sksr_tugas_tambahan + $grandtotalskspenunjangold;
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

				// if($datapembayaran==null){
				$sks_sisa = $total_sks;
				// }else{
				// 	$sks_sisa = $total_sks-($sks_gaji_bayar+$sks_kinerja_bayar);
				// 	$sks_gaji = $sks_gaji_bayar;
				// 	$sks_kinerja = $sks_kinerja_bayar;
				// }

				$grandtotalsksgaji += $sks_gaji;
				$grandtotalskskinerja += $sks_kinerja;
				$grandtotalskssisa = $grandtotalskssisa + $sks_sisa;
			}


			$data['bulan'] = $maxBulan;
			$datariwayatgolongan = $this->GolonganModel->getGolonganByTMT($data);
			$datariwayatfungsional = @$this->FungsionalModel->getFungsionalByTMT($data);
			$datariwayatpendidikan = @$this->PendidikanModel->getPendidikanByTMT($data);
			$datariwayatstruktural = @$this->StrukturalModel->getStrukturalByTMT($data);
			$data['jenis_kegiatan'] = 1;
			$datapendidikan = $this->KegiatanModel->getKegiatanIndividuJenisBulanTahun($data);
			$data['jenis_kegiatan'] = 2;
			$datapenelitian = $this->KegiatanModel->getKegiatanIndividuJenisBulanTahun($data);
			$data['jenis_kegiatan'] = 3;
			$datapengabdian = $this->KegiatanModel->getKegiatanIndividuJenisBulanTahun($data);
			$data['jenis_kegiatan'] = 4;
			$datapenunjang = $this->KegiatanModel->getKegiatanIndividuJenisBulanTahun($data);
			$data['jenis_kegiatan'] = 5;
			$datanonstruktural = $this->KegiatanModel->getKegiatanIndividuJenisBulanTahun($data);

			$totalsksbulan = $this->MainModel->getTotalSKSPerBulan($data);
			$grandtotalskspendidikan = 0;
			$grandtotalskspenelitian = 0;
			$grandtotalskspengabdian = 0;
			$grandtotalskspenunjang = 0;
			$grandtotalsksnonstruktural = 0;

			if ($datariwayatgolongan == null) {
				$datariwayatgolongan[0]['nama'] = "";
			}

			if ($datariwayatfungsional == null) {
				$datariwayatfungsional[0]['namaf'] = "";
				$datariwayatfungsional[0]['jobvalue'] = 0;
				$datariwayatfungsional[0]['grade'] = 0;
				$datariwayatfungsional[0]['id_jabatan_fungsional'] = 0;
				$datariwayatfungsional[0]['gaji_tambahan_maks'] = 0;
				$datariwayatfungsional[0]['insentif_kinerja'] = 0;
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
				$desc = json_decode($d['deskripsi'], true);
				if (isset($desc['dari'])) {
					$skskegiatan = ($d['keg_bulanan'] == '0') ? $desc['dari'] : '1';
				}
				if (isset($d['bobot_sks'])) {
					$bobotsks = $d['bobot_sks'];
				}
				$grandtotalskspenunjang += $bobotsks * $skskegiatan;
			}
			foreach ($datanonstruktural as $d) {
				$skskegiatan = 0;
				$bobotsks = 0;
				if (isset($d['sks'])) {
					$skskegiatan = $d['sks'];
				}
				if (isset($d['bobot_sks'])) {
					$bobotsks = $d['bobot_sks'];
				}
				$grandtotalsksnonstruktural = $grandtotalsksnonstruktural + ($skskegiatan * $bobotsks);
			}



			if ($totalsksbulan != null || $grandtotalskspenunjang > 0) {
				$totalsksbulantemp = @$totalsksbulan[0]['total_sks'] + $grandtotalskspenunjang;
			} else {
				$totalsksbulantemp = 0 + $grandtotalskspenunjang;
			}





			$namastruktural = '';
			$deskripsistruktural = '';
			$sksr_tugas_tambahan = 0;
			$struktural_gaji_tambahan_maks = 0;
			$struktural_insentif_kinerja = 0;
			if ($datariwayatstruktural != null) {
				$sksr_tugas_tambahan = $datariwayatstruktural[0]['bobot_sksr'];
				$namastruktural = $datariwayatstruktural[0]['nama'];
				$deskripsistruktural = $datariwayatstruktural[0]['deskripsi'];
				$struktural_gaji_tambahan_maks = $datariwayatstruktural[0]['gaji_tambahan_maks'];
				$struktural_insentif_kinerja = $datariwayatstruktural[0]['insentif_kinerja'];
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
				'prodi'	=> $datadosen[$i]['namaprodi'],
				'golongan' => $datariwayatgolongan[0]['nama'],
				'idFungsional' => $datariwayatfungsional[0]['id_jabatan_fungsional'],
				'jabFungsional' => $datariwayatfungsional[0]['namaf'],
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
				'nonstruktural' => $grandtotalsksnonstruktural,
				'totalsks' => $totalsksbulantemp,
				'sks_gaji_sebelumnya' => $grandtotalsksgajibayarsebelumnya,
				'sks_kinerja_sebelumnya' => $grandtotalskskinerjabayarsebelumnya,
				'sks_sisa_sebelumnya' => $grandtotalskssisa,
				'grandtotalsks' => $grandtotalsksbulan,
				'sks_gaji' => $sks_gaji_bulan,
				'sks_kinerja' => $sks_kinerja_bulan,
				'sisa_sks' => $sks_remun_bulan,
				'fungsional_gaji_tambahan_maks' => $datariwayatfungsional[0]['gaji_tambahan_maks'],
				'fungsional_insentif_kinerja' => $datariwayatfungsional[0]['insentif_kinerja'],
				'struktural_gaji_tambahan_maks' => $struktural_gaji_tambahan_maks,
				'struktural_insentif_kinerja' => $struktural_insentif_kinerja,
			);

			array_push($datakirim, $dataarray);
		}

		if ($data['status'] == 1) {
			$i = 0;
			foreach ($datakirim as $key => $row) {
				$grade[$key]  = $row['grade'];
				$jobvalue[$key] = $row['jobvalue'];
				$nama[$key] = $row['namadosen'];
				$i++;
			}
			if ($i > 0)
				array_multisort($grade, SORT_DESC, $jobvalue, SORT_DESC, $nama, SORT_ASC, $datakirim);
		} else {
			$i = 0;
			foreach ($datakirim as $key => $row) {
				$idFungsional[$key]  = $row['idFungsional'];
				$nama[$key] = $row['namadosen'];
				$i++;
			}
			if ($i > 0)
				array_multisort($idFungsional, SORT_ASC, $nama, SORT_ASC, $datakirim);
		}



		return $datakirim;
	}

	public function ExportValidasiWD1()
	{
		$data['status'] = $_POST['status'];
		$data['bulan'] = $_POST['bulan'];
		$data['tahun'] = $_POST['tahun'];
		$maxBulan = $data['bulan'];
		$session_data = $this->session->userdata('sess_admin');
		$data['fakultas'] = $session_data['idFakultas'];
		$data['namafakultas'] = $session_data['namafakultas'];
		$data['admin'] = $session_data['idAdmin'];
		$data['namaadmin'] = $session_data['namaAdmin'];

		$datavalidasi = $this->getDataValidasi($data);
		$data['bulan'] = $maxBulan;

		$nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle($nama_bulan[$maxBulan]);

		if ($data['status'] == 1) {
			$tag = "PNS";
			$this->setDataExportPNSToExcel($objPHPExcel, $datavalidasi, $data);
		} else {
			$tag = "NON-PNS";
			$this->setDataExportNonPNStoExcel($objPHPExcel, $datavalidasi, $data);
		}

		$fakultas = $this->MainModel->getDataFakultasByID($data['fakultas']);
		$singkatan = $fakultas[0]['singkatan'];
		$filename = "REPORT_KEGIATAN_DOSEN_" . $tag . "_" . $nama_bulan[$maxBulan] . "_" . $data['tahun'] . "_" . $singkatan . ".xlsx";
		/*header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0');*/

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$path = "assets/files/" . $data['tahun'];

		if (!is_dir($path)) //create the folder if it's not already exists
		{
			mkdir($path, 0755, TRUE);
		}

		$urlsave = $path . '/' . $filename;

		$objWriter->save($urlsave);


		echo $urlsave;
	}

	public function ubahPassword()
	{
		$data['pass'] = $_POST['passbaru'];
		$session_data = $this->session->userdata('sess_admin');

		$data['user'] = $session_data['name'];

		$res = $this->User->ubahPassword($data);

		echo json_decode($res);
	}
}
