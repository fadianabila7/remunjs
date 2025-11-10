<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainControler extends CI_Controller {


	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
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
		$this->load->model('DashboardModel');
		$this->load->model('User');
		// $this->load->model('DashboardModel');

		if(!$this->session->userdata('sess_master')){
			redirect("VerifyLogin",'refresh');
		}
	}


	public function index(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );

			$data['getfakultas'] = $this->MainModel->getDataFakultas();
			$data['getFungsional'] = $this->DashboardModel->getFungsional();
		
			// print_r($data['getFungsional']);
			for($f=0;$f<count($data['getFungsional']);$f++){
				$fungsional[$data['getFungsional'][$f]['ijf']]= array();
			} 

			foreach($data['getfakultas'] as $df){
				$getDataFungsional[$df['id_fakultas']] = $this->DashboardModel->getDataFungsional($df['id_fakultas']);
				for($f=0;$f<count($data['getFungsional']);$f++){
					$total=0;
					foreach ($getDataFungsional[$df['id_fakultas']] as $key) {
						if($data['getFungsional'][$f]['ijf']==$key->id_jabatan_fungsional){
							$total=(int)$key->total;
						}
					}
					array_push($fungsional[$data['getFungsional'][$f]['ijf']], $total);
				}
			}
			$data['fungsional']=$fungsional;

		$data['page'] = 'home';
		$this->template->view('template/content',$data);
	}
	
	public function logout(){
   		$this->session->unset_userdata('sess_master');
   		session_destroy();
   		redirect('VerifyLogin', 'refresh');
 	}


	public function login(){
		$this->template->loginpage();
	}


	public function getProdi(){
		$session_data = $this->session->userdata('sess_master');
		$dataprodi = $this->MainModel->getDataProdi($session_data['idFakultas']);
		return $dataprodi;
	}


	public function getStatus(){
		$session_data = $this->session->userdata('sess_master');
		$datastatus = $this->MainModel->getDataStatus();
		return $datastatus;
	}


	public function getDosen(){
		$session_data = $this->session->userdata('sess_master');
		$datadosen = $this->DosenModel->getDataDosenByFakultas($session_data['idFakultas']);
		return $datadosen;
	}


	public function allDosen(){
		$d = $this->DosenModel->getAllDosen();
		return $d;
	}


	public function getFakultas(){
		$session_data = $this->session->userdata('sess_master');
		$datafakultas = $this->MainModel->getDataFakultas();
		return $datafakultas;	
	}


	public function getJabatanStruktural(){
		$datastruktural = $this->StrukturalModel->getJabatanStruktural();
		echo json_encode($datastruktural);
	}

/*----------------------------------------- View Controller -----------------------------------------*/

	public function DataAdmin(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'admin';
		$datafakultas = $this->getFakultas();
		$datastatus = $this->getStatus();
		$dataisi = array('fakultas' => $datafakultas,'status' => $datastatus);
		$this->template->view('template/listadmin',$data,$dataisi);
	}
	

	public function riwayatkegiatan(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$this->template->view('template/riwayatkegiatan',$data);
	}
	
	public function RegistrasiAdmin(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'admin';
		$datafakultas = $this->getFakultas();
		$datastatus = $this->getStatus();
		$dataisi = array('fakultas' => $datafakultas,'status' => $datastatus);
		$this->template->view('template/entryadmin',$data,$dataisi);
	}


	public function DataBendahara(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'bendahara';
		$datafakultas = $this->getFakultas();
		$datastatus = $this->getStatus();
		$dataisi = array('fakultas' => $datafakultas,'status' => $datastatus);
		$this->template->view('template/listbendahara',$data,$dataisi);		
	}


	public function RegistrasiBendahara(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'bendahara';
		$datafakultas = $this->getFakultas();
		$datastatus = $this->getStatus();
		$dataisi = array('fakultas' => $datafakultas,'status' => $datastatus);
		$this->template->view('template/entrybendahara',$data,$dataisi);
	}
	

	public function DataOperator(){
		$dataprodi = $this->getProdi();			
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'operator';
		$dataisi = array('prodi' => $dataprodi);
		$this->template->view('template/listoperator',$data,$dataisi);
	}


	public function RegistrasiOperator(){
		$dataprodi = $this->getProdi();
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'operator';
		$dataisi = array('prodi' => $dataprodi);
		$this->template->view('template/entryoperator', $data, $dataisi);
	}


	public function DataRiwayat(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'riwayat';
		$dataprodi = $this->getProdi();
		$datastatus = $this->getStatus();
		$dataisi = array('prodi' => $dataprodi,'status' => $datastatus);
		$this->template->view('template/listriwayat',$data,$dataisi);
	}


	public function RekapRemunIndividu(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'kegiatan';	
		$datadosen = $this->getDosen();
		$dataisi = array('dosen' => $datadosen);
		$this->template->view('template/rekapremun',$data,$dataisi);
	}


	public function RiwayatIndividu($nip){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'riwayat';
		$data['nip'] = $nip;

		$datadosen = $this->DosenModel->getDataDosen($data);   		
		$datagolongan = $this->GolonganModel->getGolonganByIDDosen($data);
		$datapendidikan = $this->PendidikanModel->getPendidikanByIDDosen($data);
		$datafungsional = $this->FungsionalModel->getFungsionalByIDDosen($data);
		$datastruktural = $this->StrukturalModel->getStrukturalByIDDosen($data);
		$struktural = $this->StrukturalModel->getJabatanStruktural();

		$dataisi = array(
			'dosen' => $datadosen,
			'golongan' => $datagolongan, 
			'pendidikan' => $datapendidikan,
			'fungsional' => $datafungsional,
			'struktural' => $datastruktural,
			'jabatan_struktural' => $struktural,
		);

		$this->template->view('template/riwayatindividu',$data,$dataisi);
	}


	public function ValidasiWD1(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$data['page'] = 'kegiatan';	
		$datastatus = $this->getStatus();
		$dataisi = array('status' => $datastatus);
		$this->template->view('template/validasi',$data,$dataisi);
	}

	public function Profile(){
		$session_data = $this->session->userdata('sess_master');
		$data = array('datasession' => $session_data );
		$this->template->view('template/profile',$data,NULL);
	}

/*----------------------------------------- Data Rekap COntroller -----------------------------------*/

	public function getDataRekapIndividu(){
		$data['nip'] = $_GET['nip'];
		$maksbulan = $_GET['bulan'];
		$data['tahun'] = $_GET['tahun'];
		$totalsksarr = array();
		$datakirim = array();
		$grandtotalsks=0;
		$grandtotalskslebih=0;
		$grandtotalsksbayar=0;
		$grandtotalskssisa=0;


		for($i=1;$i<=$maksbulan;$i++){
			$data['bulan'] = $i;
			$totalsks = $this->MainModel->getTotalSKSPerBulan($data);
			$jabStruktural = $this->MainModel->getJabStrukturalPerBulanTahun($data);
			$lebihsksmaks = $jabStruktural[0]['kelebihan_maks']/6;
			$wajibsks = $jabStruktural[0]['beban_wajib']/4;
			$sisasksbayar=0;
			$lebihsksbayar=0;
			
			if($totalsks==null){
				if($i==1 or $i==6 or $i==7 or $i==12){
					$wajibsks=0;
				}

				$dataarray = array(
				'bulan' => $i, 
				'struktural' => $jabStruktural[0]['nama'],
				'totalsks' => number_format(0,2,',','.'),
				'lebihsks' => number_format(0,2,',','.'),
				'lebihsksbayar' => number_format(0,2,',','.'),
				'sisasksbayar' => number_format(0,2,',','.'),
				'wajibsks' => number_format($wajibsks,2,',','.'),
				'lebihsksmaks' => number_format($lebihsksmaks,2,',','.')
				);	
			}else{
				if($i==1 or $i==6 or $i==7 or $i==12){
					$lebihsks = $totalsks[0]['total_sks'];
					$wajibsks=0;
					if($lebihsks<=$lebihsksmaks){
						$sisasksbayar = 0.00;
						$lebihsksbayar = $lebihsks;
					}else{
						$sisasksbayar = $lebihsks-$lebihsksmaks;
						$lebihsksbayar = $lebihsksmaks;
					}
				}else{
					
					$lebihsks = $totalsks[0]['total_sks']-$wajibsks;
					if($lebihsks<0)
						$lebihsks=0;
					if($lebihsks<=$lebihsksmaks){
						$sisasksbayar = 0.00;
						$lebihsksbayar = $lebihsks;
					}else{
						$sisasksbayar = $lebihsks-$lebihsksmaks;
						$lebihsksbayar = $lebihsksmaks;
					}
				}

				$grandtotalsks = $grandtotalsks+$totalsks[0]['total_sks'];
				$grandtotalskslebih = $grandtotalskslebih+$lebihsks;
				$grandtotalsksbayar = $grandtotalsksbayar+$lebihsksbayar;
				$grandtotalskssisa = $grandtotalskssisa+$sisasksbayar;

				$dataarray = array(
					'bulan' => $i, 
					'struktural' => $jabStruktural[0]['nama'],
					'totalsks' => number_format($totalsks[0]['total_sks'],2,',','.'),
					'lebihsks' => number_format($lebihsks,2,',','.'),
					'lebihsksbayar' => number_format($lebihsksbayar,2,',','.'),
					'sisasksbayar' => number_format($sisasksbayar,2,',','.'),
					'wajibsks' => number_format($wajibsks,2,',','.'),
					'lebihsksmaks' => number_format($lebihsksmaks,2,',','.')
					);
			}
			//$totalsksarr += [ $i => $totalsks ];
			array_push($datakirim, $dataarray);
		}

		$dataarray = array(
			'bulan' => 0, 
			'struktural' => 'Total SKS',
			'totalsks' => number_format($grandtotalsks,2,',','.'),
			'lebihsks' => number_format($grandtotalskslebih,2,',','.'),
			'lebihsksbayar' => number_format($grandtotalsksbayar,2,',','.'),
			'sisasksbayar' => number_format($grandtotalskssisa,2,',','.'),
			'wajibsks' => number_format(0,2,',','.'),
			'lebihsksmaks' => number_format(0,2,',','.')
			);
		array_push($datakirim, $dataarray);
		echo json_encode($datakirim);
	}

	public function setDataExportPNSToExcel($objPHPExcel, $dataExcel, $data){
		$nama_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		$objPHPExcel->getActiveSheet()->setTitle($nama_bulan[$data['bulan']]);
		$gdImage = imagecreatefromjpeg('assets/img/unsri.jpg');
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
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C1','KEMENTERIAN RISET, TEKNOLOGI DAN PENDIDIKAN TINGGI');
		$objPHPExcel->getActiveSheet()->SetCellValue('C2','UNIVERSITAS Riau');   
		$objPHPExcel->getActiveSheet()->SetCellValue('C3',"FAKULTAS ".strtoupper ($data['namafakultas']));
		$objPHPExcel->getActiveSheet()->SetCellValue('C4',' ');
		$objPHPExcel->getActiveSheet()->SetCellValue('C5','Telepon (0711)             ,Faksimili (0711)     ');
		$objPHPExcel->getActiveSheet()->SetCellValue('C6','Laman : www.unri.ac.id ');

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

		$objPHPExcel->getActiveSheet()->SetCellValue('B8','Bulan');
		$objPHPExcel->getActiveSheet()->SetCellValue('C8',$nama_bulan[$data['bulan']]." ".$data['tahun']);    
		$objPHPExcel->getActiveSheet()
		    ->getStyle('B8:C8')
		    ->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()
		    ->getStyle('B8:C8')
		    ->getFont()->setSize(14);

		$rowCount = 10; 

		$objPHPExcel->getActiveSheet()
		    ->getStyle("A".$rowCount.":V".$rowCount)
		    ->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()
		    ->getStyle("A".$rowCount.":V".$rowCount)
		    ->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'NO');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'NIP');
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'NAMA');
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'PROGRAM STUDI');
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'GOLONGAN');
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'JABATAN FUNGSIONAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'JOB VALUE');
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,'GRADE');
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,'PENDIDIKAN TERAKHIR');
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,'JABATAN STRUKTURAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,'DESKRIPSI JABATAN STRUKTURAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,"BEBAN WAJIB SKS\n(L)");
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,"KELEBIHAN \nSKS MAKS\n(M)");
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,"JUMLAH SKS BID. PENDIDIKAN\n(N)");
		$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,"JUMLAH SKS BID. PENUNJANG\n(O)");
		$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount,"JUMLAH SKS\n(P)");
		$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount,"TOTAL KELEBIHAN SKS\nSUDAH DIBAYAR\nS.D BULAN SEBELUMNYA\n(Q)");
		$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount,"TOTAL SISA KELEBIHAN SKS\nS.D BULAN SEBELUMNYA\n(R)");
		$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount,"TOTAL SKS\n(S = P + R)");
		$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount,"TOTAL\nKELEBIHAN SKS\n(T = S - L)");
		$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount,"TOTAL KELEBIHAN SKS\nDAPAT DIBAYAR\n(U = MIN(M,T), U >=0)");
		$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount,"TOTAL SISA\nKELEBIHAN SKS\n(V=T-U)");
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
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

		
		$azam=0;
		foreach ($dataExcel as $excel){
			$rowCount++;
			$azam++;			

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rowCount-10);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $excel['nip'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $excel['namadosen']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $excel['prodi']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $excel['golongan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $excel['jabFungsional']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $excel['jobvalue']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $excel['grade']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $excel['pendidikan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $excel['jabStruktural']);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $excel['descStruktural']);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $excel['bebanwajib']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $excel['lebihsksmaks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $excel['skspendidikan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $excel['skspenunjang']);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $excel['totalsks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $excel['totalsksbayarsebelumnya']);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $excel['totalsisaskslebihsebelumnya']);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $excel['grandtotalsks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $excel['lebihsks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $excel['lebihsksbayar']);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $excel['sisalebihsks']);
			
		} 
		$rowCount2=10;
		
		for($idx='A';$idx<='V';$idx++){
			if($idx=='C'||$idx=='J'||$idx=='K'){
				$objPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$objPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			}
			else{
				$objPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$objPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}

		}
		for($idx='L';$idx<='V';$idx++){
			$objPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$objPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode('0.00');

		}

		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount2.':V'.$rowCount)->getAlignment()->setWrapText(true); 
		$objPHPExcel->getActiveSheet()->getStyle('K'.$rowCount2.':K'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);

		$objPHPExcel->getActiveSheet()->getStyle('A10:V'.$rowCount)->applyFromArray($styleArray);
		unset($styleArray);

		$idx_hari = Date('d');
		$idx_hari = $idx_hari*1;
		$idx_bulan = Date('m');
		$idx_bulan = $idx_bulan*1;
		$idx_tahun = Date('Y');

		$session_data = $this->session->userdata('sess_master');

		if($session_data['namaAdmin']==null){
			$nama_admin="..............................................";
		}
		else{
			$nama_admin=$session_data['namaAdmin'];
		}
		$azam = $rowCount+4;

		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$azam,"Palembang, ".$idx_hari." ".$nama_bulan[$idx_bulan]." ".$idx_tahun);
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+1),'Admin Fakultas');   
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+6),"( ".$nama_admin." )"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+7),'NIP. '); 

		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$azam,'Menyetujui,');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+1),'Wakil Dekan Bidang Akademik');   
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+6),'(..............................................)'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+7),'NIP. '); 

		$objPHPExcel->getActiveSheet()
		    ->getStyle("A".$azam.":"."Q".($azam+7))
		    ->getFont()->setSize(13);
	    
	}

	public function setDataExportNonPNStoExcel($objPHPExcel, $dataExcel, $data){
		$nama_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		$objPHPExcel->getActiveSheet()->setTitle($nama_bulan[$data['bulan']]);

		$gdImage = imagecreatefromjpeg('assets/img/unsri.jpg');
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
		
		$objPHPExcel->getActiveSheet()->SetCellValue('C1','KEMENTERIAN RISET, TEKNOLOGI DAN PENDIDIKAN TINGGI');
		$objPHPExcel->getActiveSheet()->SetCellValue('C2','UNIVERSITAS SRIWIJAYA');   
		$objPHPExcel->getActiveSheet()->SetCellValue('C3',"FAKULTAS ".strtoupper ($data['namafakultas']));
		$objPHPExcel->getActiveSheet()->SetCellValue('C4','Jalan Palembang – Prabumulih Km. 32 Indralaya Ogan Ilir Kode Pos 30662');
		$objPHPExcel->getActiveSheet()->SetCellValue('C5','Telepon (0711)             ,Faksimili (0711)     ');
		$objPHPExcel->getActiveSheet()->SetCellValue('C6','Laman : www.unsri.ac.id ');

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

		$objPHPExcel->getActiveSheet()->SetCellValue('B8','Bulan');
		$objPHPExcel->getActiveSheet()->SetCellValue('C8',$nama_bulan[$data['bulan']]." ".$data['tahun']);    
		$objPHPExcel->getActiveSheet()
		    ->getStyle('B8:C8')
		    ->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()
		    ->getStyle('B8:C8')
		    ->getFont()->setSize(14);

		$rowCount = 10; 

		$objPHPExcel->getActiveSheet()
		    ->getStyle("A".$rowCount.":V".$rowCount)
		    ->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()
		    ->getStyle("A".$rowCount.":V".$rowCount)
		    ->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'NO');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'NIPUS');	
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'NAMA');
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'PROGRAM STUDI');
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'GOLONGAN');
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'JABATAN FUNGSIONAL');
		//$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'JOB VALUE');
		//$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,'GRADE');
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,'PENDIDIKAN TERAKHIR');
		//$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,'JABATAN STRUKTURAL');
		//$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,'DESKRIPSI JABATAN STRUKTURAL');
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,"BEBAN WAJIB SKS\n(L)");
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,"KELEBIHAN \nSKS MAKS\n(M)");
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,"JUMLAH SKS BID. PENDIDIKAN\n(N)");
		$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,"JUMLAH SKS BID. PENUNJANG\n(O)");
		$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount,"JUMLAH SKS\n(P)");
		$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount,"TOTAL KELEBIHAN SKS\nSUDAH DIBAYAR\nS.D BULAN SEBELUMNYA\n(Q)");
		$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount,"TOTAL SISA KELEBIHAN SKS\nS.D BULAN SEBELUMNYA\n(R)");
		$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount,"TOTAL SKS\n(S = P + R)");
		$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount,"TOTAL\nKELEBIHAN SKS\n(T = S - L)");
		$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount,"TOTAL KELEBIHAN SKS\nDAPAT DIBAYAR\n(U = MIN(M,T), U >=0)");
		$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount,"TOTAL SISA\nKELEBIHAN SKS\n(V=T-U)");
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(0);
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

		
		$azam=0;
		foreach($dataExcel as $excel)
		{
			$rowCount++;
			$azam++;
			

			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rowCount-10);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $excel['nip'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $excel['namadosen']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $excel['prodi']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $excel['golongan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $excel['jabFungsional']);
			//$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $data['jobvalue']);
			//$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $data['grade']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $excel['pendidikan']);
			//$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $data['nama_jabatan_struktural']);
			//$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $data['deskripsi_jabatan_struktural']);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $excel['bebanwajib']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $excel['lebihsksmaks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $excel['skspendidikan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $excel['skspenunjang']);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $excel['totalsks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $excel['totalsksbayarsebelumnya']);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $excel['totalsisaskslebihsebelumnya']);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $excel['grandtotalsks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $excel['lebihsks']);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $excel['lebihsksbayar']);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $excel['sisalebihsks']);
			
		} 
		$rowCount2=10;
		
		for($idx='A';$idx<='V';$idx++){
			if($idx=='C'||$idx=='J'||$idx=='K'){
				$objPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$objPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			}
			else{
				$objPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$objPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}

		}
		for($idx='L';$idx<='V';$idx++){
			$objPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$objPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode('0.00');

		}

		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount2.':V'.$rowCount)->getAlignment()->setWrapText(true); 
		$objPHPExcel->getActiveSheet()->getStyle('K'.$rowCount2.':K'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);

		$objPHPExcel->getActiveSheet()->getStyle('A10:V'.$rowCount)->applyFromArray($styleArray);
		unset($styleArray);

		$idx_hari = Date('d');
		$idx_hari = $idx_hari*1;
		$idx_bulan = Date('m');
		$idx_bulan = $idx_bulan*1;
		$idx_tahun = Date('Y');

		$admin = $data['admin'];
		if($admin==null){
			$nama_admin="..............................................";
		}
		else{
			$nama_admin=$data['namaadmin'];
		}
		$azam = $rowCount+4;

		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$azam,"Palembang, ".$idx_hari." ".$nama_bulan[$idx_bulan]." ".$idx_tahun);
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+1),'Admin Fakultas');   
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+6),"( ".$nama_admin." )"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+7),'NIP. '); 

		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$azam,'Menyetujui,');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+1),'Wakil Dekan Bidang Akademik');   
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+6),'(..............................................)'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+7),'NIP. '); 

		$objPHPExcel->getActiveSheet()
		    ->getStyle("A".$azam.":"."Q".($azam+7))
		    ->getFont()->setSize(13);
	}

	public function getDataValidasi($data){
		$maxBulan = $data['bulan'];
		$datakirim = array();
		$datadosen = $this->DosenModel->getDataDosenFakultasStatus($data);

		for($i=0; $i<count($datadosen); $i++)
		{
			$data['nip'] = $datadosen[$i]['nip'];
			
			$grandtotalskslebih = 0;
			$grandtotalsksbayar = 0;
			$grandtotalskssisa = 0;
			$grandtotalsks = 0;
			$grandtotalsksbayarsebelumnya=0;

			for($j=1;$j<=$maxBulan-1;$j++)
			{
				$data['bulan'] = $j;
				$totalsks = $this->MainModel->getTotalSKSPerBulan($data);
				$jabStruktural = $this->MainModel->getJabStrukturalPerBulanTahun($data);
				$datapembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);
				if($jabStruktural!=null)
				{
					$lebihsksmaks = $jabStruktural[0]['kelebihan_maks']/6;
					$wajibsks = $jabStruktural[0]['beban_wajib']/4;

				}
				else
				{
					$lebihsksmaks=0;
					$wajibsks=0;
				}
				
				$sisasksbayar=0;
				$lebihsksbayar=0;
				
				if($datapembayaran!=null)	
				{
					$grandtotalsksbayarsebelumnya = $grandtotalsksbayarsebelumnya+$datapembayaran[0]['jumlah_sks_dibayar'];
					$status = (int)$datapembayaran[0]['status'];
					$idBayar = $datapembayaran[0]['id_pembayaran'];
					$sudahdibayar = $datapembayaran[0]['jumlah_sks_dibayar'];
					
				}
				else
				{
					$grandtotalsksbayarsebelumnya = $grandtotalsksbayarsebelumnya+0;
					$status=0;
					$idBayar=0;
					$sudahdibayar = 0;
				}
				if($totalsks==null)
				{
					if($j==1 or $j==6 or $j==7 or $j==12)
					{
						$wajibsks=0;
					}
					$lebihsks=0 - $wajibsks;

					if($datapembayaran==null)
					{
						if($lebihsks<=$lebihsksmaks)
						{
							$lebihsksbayar = $lebihsks;
							$sisasksbayar = 0.0;
						}
						else
						{
							$lebihsksbayar = $lebihsksmaks;
							$sisasksbayar = $lebihsks-$lebihsksmaks;
						}
					}
					else
					{
						$lebihsksbayar = $sudahdibayar;
						$sisasksbayar = $lebihsks - $sudahdibayar;
					}
				}
				else
				{
					$grandtotalsks += $totalsks[0]['total_sks'];
					if($j==1 or $j==6 or $j==7 or $j==12)
					{
						$wajibsks=0;
					}
					$lebihsks = $totalsks[0]['total_sks']-$wajibsks;

					if($datapembayaran==null)
					{
						if($lebihsks<=$lebihsksmaks)
						{
							$lebihsksbayar = $lebihsks;
							$sisasksbayar = 0.0;
						}
						else
						{
							$lebihsksbayar = $lebihsksmaks;
							$sisasksbayar = $lebihsks-$lebihsksmaks;
						}
					}
					else
					{
						$lebihsksbayar = $sudahdibayar;
						$sisasksbayar = $lebihsks - $sudahdibayar;
					}
				}
				
				$grandtotalskslebih = $grandtotalskslebih + $lebihsks;
				$grandtotalsksbayar = $grandtotalsksbayar + $lebihsksbayar;
				$grandtotalskssisa = $grandtotalskssisa + $sisasksbayar;
			}

			$data['bulan'] = $maxBulan;
			$datariwayatgolongan = $this->GolonganModel->getGolonganByTMT($data);
			$datariwayatfungsional = $this->FungsionalModel->getFungsionalByTMT($data);
			$datariwayatpendidikan = $this->PendidikanModel->getPendidikanByTMT($data);
			$datariwayatstruktural = $this->StrukturalModel->getStrukturalByTMT($data);			
			$data['jenis_kegiatan'] = 1;
			$datapendidikan = $this->KegiatanModel->getKegiatanIndividuJenisBulanTahun($data);
			$data['jenis_kegiatan'] = 4;
			$datapenunjang = $this->KegiatanModel->getKegiatanIndividuJenisBulanTahun($data);
			$totalsksbulan = $this->MainModel->getTotalSKSPerBulan($data);
			$grandtotalskspendidikan = 0;
			$grandtotalskspenunjang = 0;

			if($datariwayatgolongan==null)
			{
				$datariwayatgolongan[0]['nama'] = "";
			}
			if($datariwayatfungsional==null)
			{
				
				$datariwayatfungsional[0]['namaf']="";
				$datariwayatfungsional[0]['jobvalue']=0;
				$datariwayatfungsional[0]['grade']=0;
			}
			if($datariwayatpendidikan==null)
			{
				$datapendidikan[0]['singkatan']="";
			}
			foreach($datapendidikan as $d)
			{
				$grandtotalskspendidikan = $grandtotalskspendidikan + ($d['sks']*$d['bobot_sks']);
			}

			foreach($datapenunjang as $d)
			{
				$grandtotalskspenunjang = $grandtotalskspenunjang + ($d['sks'] * $d['bobot_sks']);
			}

			

			if($totalsksbulan!=null)
			{
				$totalsksbulantemp = $totalsksbulan[0]['total_sks'];
			}
			else
			{
				$totalsksbulantemp = 0;
			}

			
			$grandtotalsksbulan = $grandtotalskssisa + $totalsksbulantemp;

			
			$namastruktural='';
			$deskripsistruktural='';
			if($datariwayatstruktural!=null)
			{
				$lebihsksmaks = $datariwayatstruktural[0]['kelebihan_maks']/6;
				$wajibsks = $datariwayatstruktural[0]['beban_wajib']/4;
				$namastruktural = $datariwayatstruktural[0]['nama'];
				$deskripsistruktural = $datariwayatstruktural[0]['deskripsi'];
			}

			$grandtotalskslebihbulan = $grandtotalsksbulan-$wajibsks;
			if($grandtotalskslebihbulan>$lebihsksmaks)
			{
				$totalsksbayarbulan = $lebihsksmaks;
			}
			else if($grandtotalskslebihbulan<=$lebihsksmaks && $grandtotalskslebihbulan>0)
			{
				$totalsksbayarbulan = $grandtotalskslebihbulan;
			}
			else
			{
				$totalsksbayarbulan = 0;
			}

			$dataarray = array(				
				'nip' => $datadosen[$i]['nip'], 
				'namadosen' => $datadosen[$i]['nama'],
				'prodi'	=> $datadosen[$i]['namaprodi'],
				'golongan' => $datariwayatgolongan[0]['nama'],
				'idFungsional' => $datariwayatfungsional[0]['id_jabatan_fungsional'],
				'jabFungsional' => $datariwayatfungsional[0]['namaf'],
				'jobvalue'=> $datariwayatfungsional[0]['jobvalue'],
				'grade' => $datariwayatfungsional[0]['grade'],
				'pendidikan' => $datariwayatpendidikan[0]['singkatan'],
				'jabStruktural' => $namastruktural,
				'descStruktural' => $deskripsistruktural,
				'bebanwajib' => $wajibsks,
				'lebihsksmaks' => $lebihsksmaks,
				'skspendidikan' => $grandtotalskspendidikan,
				'skspenunjang' => $grandtotalskspenunjang,
				'totalsks' => $totalsksbulantemp,
				'totalsksbayarsebelumnya' => $grandtotalsksbayarsebelumnya,
				'totalsisaskslebihsebelumnya' => $grandtotalskssisa,
				'grandtotalsks' => $grandtotalsksbulan,
				'lebihsks' => $grandtotalsksbulan-$wajibsks,
				'lebihsksbayar' => $totalsksbayarbulan,
				'sisalebihsks' => ($grandtotalsksbulan-$wajibsks) - $totalsksbayarbulan				
			);

			array_push($datakirim, $dataarray);
		}

		if($data['status']==1)
		{
			foreach ($datakirim as $key => $row) {
			    $grade[$key]  = $row['grade'];
			    $jobvalue[$key] = $row['jobvalue'];
			    $nama[$key] = $row['namadosen'];
			}
			array_multisort($grade, SORT_DESC, $jobvalue, SORT_DESC, $nama, SORT_ASC, $datakirim);
		}
		else
		{
			foreach ($datakirim as $key => $row) {
			    $idFungsional[$key]  = $row['idFungsional'];
			    
			}
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
		$session_data = $this->session->userdata('sess_master');
		$data['fakultas'] = $session_data['idFakultas'];
		$data['namafakultas'] = $session_data['namafakultas'];
		$data['admin'] = $session_data['idAdmin'];
		$data['namaadmin'] = $session_data['namaAdmin'];

		$datavalidasi = $this->getDataValidasi($data);
		$data['bulan'] = $maxBulan;

		$nama_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle($nama_bulan[$maxBulan]);

		if($data['status']==1){
			$tag="PNS";
			$this->setDataExportPNSToExcel($objPHPExcel, $datavalidasi, $data);
			
		}
		else{
			$tag="NON-PNS";
			$this->setDataExportNonPNStoExcel($objPHPExcel, $datavalidasi, $data);
		}
		
		$fakultas = $this->MainModel->getDataFakultasByID($data['fakultas']);
		$singkatan = $fakultas[0]['singkatan'];
		$filename="REPORT_KEGIATAN_DOSEN_".$tag."_".$nama_bulan[$maxBulan]."_".$data['tahun']."_".$singkatan.".xlsx";
		/*header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0');*/

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
		
		$path = "assets/files/".$data['tahun'];

	    if(!is_dir($path)){
	      mkdir($path,0755,TRUE);
	    } 

		$urlsave = $path.'/'.$filename;
		$objWriter->save($urlsave);
		echo $urlsave;
	}

	public function ubahPassword(){
		$data['pass'] = $_POST['passbaru'];
		$session_data = $this->session->userdata('sess_master');
		$data['user'] = $session_data['name'];
		$res = $this->User->ubahPassword($data);
		echo json_decode($res);
	}

/*----------------------------------------- Dashboard -----------------------------------------------*/
	// json call
	public function getJsonDosen(){
		$d = $this->allDosen();
		$data['tahun'] = date('Y'); $data['bulan'] = date('m'); $n=1;

		for ($g=0; $g<=17; $g++) {
			$grade[$g] = 0;
		}

		for ($i=0; $i<count($d); $i++) { 
			$data['nip'] = $d[$i]['id_dosen'];
			$s = $this->DashboardlModel->getStrukturalByTMT($data);	
			$f = $this->DashboardlModel->getFungsionalByTMT($data);

			if($s && $s[0]['id_jabatan_struktural'] <> 301 && $s[0]['id_jabatan_struktural'] <> 302){
				$grade[$s[0]['grade']] += 1;
			}elseif($f){
				$grade[$f[0]['grade']] += 1;
			}else{
				$grade[0] += 1;
			}
		}
		echo json_encode($grade);
	}


	
}