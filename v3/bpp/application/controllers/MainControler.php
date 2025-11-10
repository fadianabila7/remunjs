<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainControler extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->library('excel');
		$this->load->model('DosenModel');
		$this->load->model('PembayaranModel');
		$this->load->model('StrukturalModel');
		$this->load->model('ValidasiModel');
		date_default_timezone_set('Asia/Jakarta');

		if(!$this->session->userdata('sess_bpp')){	
			redirect("VerifyLogin",'refresh');
		}
	}

	public function index(){		
		$session_data = $this->session->userdata('sess_bpp');
		$data = array('datasession' => $session_data );
		$this->template->view('template/content',$data);

	}
	
	public function logout(){
   		$this->session->unset_userdata('sess_bpp');
   		session_destroy();
   		redirect('VerifyLogin', 'refresh');

 	}


 	public function PembayaranRemunerasi(){
		$session_data = $this->session->userdata('sess_bpp');
		$data = array('datasession' => $session_data );
		$dataprodi = $this->getProdi();
		$datastatus = $this->getStatus();
		$dataisi = array('prodi' => $dataprodi,'status' => $datastatus);
		$this->template->view('template/pembayaranremun',$data,$dataisi);	

	}	
	
	public function RekapRemun(){
		$datadosen = $this->getDosen();
		$session_data = $this->session->userdata('sess_bpp');
		$data = array('datasession' => $session_data );
		$dataisi = array('dosen' => $datadosen);
		$this->template->view('template/rekapremun',$data,$dataisi);

	}

	public function SPTJM(){
		$session_data = $this->session->userdata('sess_bpp');
		$data = array('datasession' => $session_data );
		$this->template->view('template/sptjm',$data);

	}

	public function login(){
		$this->template->loginpage();
	}
	
	public function getProdi(){
		$session_data = $this->session->userdata('sess_bpp');
		$dataprodi = $this->MainModel->getDataProdi($session_data['idFakultas']);
		return $dataprodi;

	}

	public function getStatus(){
		$session_data = $this->session->userdata('sess_bpp');
		$datastatus = $this->MainModel->getDataStatus();
		return $datastatus;

	}

	public function getDosen(){
		$session_data = $this->session->userdata('sess_bpp');
		$datadosen = $this->DosenModel->getDataDosenByFakultas($session_data['idFakultas']);
		return $datadosen;

	}
	
	public function getDataDosenByFakultas(){
		$session_data = $this->session->userdata('sess_bpp');
		$datadosen = $this->DosenModel->getDataDosenByFakultas($session_data['idFakultas']);
		echo json_encode($datadosen);

	}
	
	public function getDataRemunPerBulan(){		
		$data['prodi'] = $_GET['prodi'];
		$data['status'] = $_GET['status'];	
		$data['tahun'] = $_GET['tahun'];
		$data['bulan'] = $_GET['bulan'];
		$session_data = $this->session->userdata('sess_bpp');
		$data['fakultas'] = $session_data['idFakultas'];
		$res = $this->MainModel->getDataRemunperBulan($data);
		echo json_encode($res);
		
	}	

	//-----------------------------------------------------------------------------

	public function getDataRekapPerBulan(){
		$data['prodi'] = $_GET['prodi'];
		$data['status'] = $_GET['status'];
		$data['bulan'] = $_GET['bulan'];
		$data['tahun'] = $_GET['tahun'];
		$session_data = $this->session->userdata('sess_bpp');
		$data['fakultas'] = $session_data['idFakultas'];
		$datakirim = array();
		
		$datadosen = $this->DosenModel->getDataDosenProdiStatus($data);
		foreach ($datadosen as $dosen) {
			$data['nip'] = $dosen['id_dosen'];
			$datapembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);
			$datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);
			
			if($datapembayaran==null){
               
               $statusvalidasi = ($datavalidasi!=null) ? $datavalidasi[0]['status'] : 0;
                 
               $tarif_gaji=0;
               $tarif_kinerja = 0;
               $sks_gaji = 0;
               $sks_kinerja = 0;
               
               $pph = 0;

               if($statusvalidasi>0){                  
                  if($statusvalidasi==1){
                     $status = -1;
                  }else if($statusvalidasi==2){
                     $status = -2;
                  }else if($statusvalidasi == 3){
                     $status = -3;
                  }                  
               }else{
                  $status = -4;
               }
               

               $total = 0;
               $pajak = 0;            
               $dataarray = array(
                  'nama_dosen' => $dosen['nama'],
                  'nip' => $data['nip'],                  
                  'sks_gaji' => $sks_gaji,
                  'sks_kinerja' => $sks_kinerja,
                  'tarif_gaji' => $tarif_gaji,
                  'tarif_kinerja' => $tarif_kinerja,                  
                  'total' => $total,
                  'pajak' => $pajak,
                  'status' => $status,
                  'idBayar' => 0,
                  );
               array_push($datakirim, $dataarray);
            }else{

            	$id_status_bayar = (int)$datapembayaran[0]['status'];
            	$status_bayar = ($id_status_bayar == 1) ? "Belum Dibayar" : "Sudah Dibayar";

               	$sks_gaji = $datapembayaran[0]['sksr_gaji'];
               	$sks_kinerja = $datapembayaran[0]['sksr_kinerja'];
               	$tarif_gaji = $datapembayaran[0]['tarif_gaji'];
               	$tarif_kinerja = $datapembayaran[0]['tarif_kinerja'];
               	$pph = $datapembayaran[0]['pph'];
               	$total = ($sks_gaji * $tarif_gaji) + ($sks_kinerja * $tarif_kinerja);
               	$pajak = $total*$pph;

            	$dataarray = array(
            		'nama_dosen' => $dosen['nama'],
            		'nip' => $data['nip'],
            		'sks_gaji' => $sks_gaji,
            		'sks_kinerja' => $sks_kinerja,
            		'tarif_gaji' => $tarif_gaji,
            		'tarif_kinerja' => $tarif_kinerja,
            		'total' => $total,
            		'pajak' => $pajak,
            		'status' => $id_status_bayar,
            		'idBayar' => $datapembayaran[0]['id_pembayaran'],
            		);
            	array_push($datakirim, $dataarray);
            }

		}
		echo json_encode($datakirim);
	}

	public function getDataRekapIndividu(){
		$session_data = $this->session->userdata('sess_bpp');
		$data['nip'] = $_GET['nip'];		
		$data['tahun'] = $_GET['tahun'];
		$dosen = $this->DosenModel->getDataDosen($data);
		
		$datakirim = array();

		for($i=1;$i<=12;$i++){
			$data['bulan'] = $i;
			$datapembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);
			$datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);

			if($datapembayaran==null){
               
               $statusvalidasi = ($datavalidasi!=null) ? $datavalidasi[0]['status'] : 0;
               $tarif_gaji=0;
               $tarif_kinerja = 0;
               $sks_gaji = 0;
               $sks_kinerja = 0;
               
               $pph = 0;

               if($statusvalidasi>0){                  
                  if($statusvalidasi==1){
                     $status = -1;
                  }else if($statusvalidasi==2){
                     $status = -2;
                  }else if($statusvalidasi == 3){
                     $status = -3;
                  }                  
               }else{
                  $status = -4;
               }
               

               $total = 0;
               $pajak = 0;            
               $dataarray = array(
                  'bulan' => $data['bulan'],
                  'bendahara' => ' ',
                  'sks_gaji' => $sks_gaji,
                  'sks_kinerja' => $sks_kinerja,
                  'tarif_gaji' => $tarif_gaji,
                  'tarif_kinerja' => $tarif_kinerja,                  
                  'total' => $total,
                  'pajak' => $pajak,
                  'status' => $status,
                  'idBayar' => 0,
                  );
               array_push($datakirim, $dataarray);

            }else{

            	$id_status_bayar = (int)$datapembayaran[0]['status'];
            	$status_bayar = ($id_status_bayar == 1)? "Belum Dibayar" : "Sudah Dibayar";

               	$sks_gaji = $datapembayaran[0]['sksr_gaji'];
               	$sks_kinerja = $datapembayaran[0]['sksr_kinerja'];
               	$tarif_gaji = $datapembayaran[0]['tarif_gaji'];
               	$tarif_kinerja = $datapembayaran[0]['tarif_kinerja'];
               	$pph = $datapembayaran[0]['pph'];
               	$total = ($sks_gaji * $tarif_gaji) + ($sks_kinerja * $tarif_kinerja);
               	$pajak = $total*$pph;

            	$dataarray = array(
            		'bulan' => $data['bulan'],
            		'bendahara' => $datapembayaran[0]['id_bendahara'],
            		'sks_gaji' => $sks_gaji,
            		'sks_kinerja' => $sks_kinerja,
            		'tarif_gaji' => $tarif_gaji,
            		'tarif_kinerja' => $tarif_kinerja,
            		'total' => $total,
            		'pajak' => $pajak,
            		'status' => $id_status_bayar,
            		'idBayar' => $datapembayaran[0]['id_pembayaran'],
            		);
            	array_push($datakirim, $dataarray);
            }
			
		}
		echo json_encode($datakirim);
	}

	public function HitungRemunIndividuPerBulanTahun($data){
		$maxBulan = $data['bulan'];
		$totalsks=0;
		$sisasks=0;
		$skswajib=0;
		$lebihsksmaks=0;
		$sksbayar=0;
		$sksbulanini = 0;
		
		$datadosen = $this->DosenModel->getDataDosen($data);
		$data['bulan'] = $maxBulan;
		$jabFungsional = $this->MainModel->getJabFungsionalPerBulanTahun($data);
		
		$tarif = ($datadosen[0]['id_status_dosen']==1) ? $jabFungsional[0]['tarif'] : $jabFungsional[0]['tarif_non_pns'];		

		for($i=1; $i<=$maxBulan; $i++){
			$data['bulan'] = $i;
			$sksperbulan = $this->MainModel->getTotalSKSPerBulan($data);
			$jabStruktural = $this->MainModel->getJabStrukturalPerBulanTahun($data);			
			$pembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);

			$totalsks = ($sksperbulan!=null) ? $sksperbulan[0]['total_sks'] : 0;
			
			if($jabStruktural!=null){
				$lebihsksmaks = $jabStruktural[0]['kelebihan_maks']/6;
				$skswajib = $jabStruktural[0]['beban_wajib']/4;
				if($data['bulan']==1 or $data['bulan']==6 or $data['bulan']==7 or $data['bulan']==12){
					$skswajib = 0;
				}
			}

			$totalsks = $totalsks + $sisasks;
			$sisasks = $totalsks - $skswajib;
			
			if($pembayaran != null){
				if($pembayaran[0]['status']==2 or ($pembayaran[0]['status']==1 and $i!=$maxBulan)){
					$sksbayar = $pembayaran[0]['jumlah_sks_dibayar'];
					$sisasks = $sisasks - $sksbayar;
				}
			}

			if($i==$maxBulan){
				if($sisasks > $lebihsksmaks){
					$sksbulanini = $lebihsksmaks;
				}else if($sisasks >0 and $sisasks<$lebihsksmaks){
					$sksbulanini = $sisasks;
				}else{
					$sksbulanini=0;
				}
			}
		}
			
		$jumlah = $sksbulanini * $tarif;
		$dataarray = array(
				'nip' => $datadosen[0]['id_dosen'], 
				'namadosen' => $datadosen[0]['nama'],
				'bulan' => $maxBulan,
				'tahun' => $data['tahun'],
				'sksbelumbayar' => $sisasks,
				'sksbayar'=> $sksbulanini,
				'tarif' => $tarif,
				'jumlah' => $jumlah,
				);

		return $dataarray;
	}

	public function getDataRemunIndividuPerBulanTahun(){
		$data['nip'] = $_GET['nip'];
		$data['bulan'] = $_GET['bulan'];
		$data['tahun'] = $_GET['tahun'];

		$datakirim = array();
		$remun = $this->HitungRemunIndividuPerBulanTahun($data);
		$dataarray = array(
				'nip' => $remun['nip'], 
				'namadosen' => $remun['namadosen'],
				'bulan' => $remun['bulan'],
				'tahun' => $remun['tahun'],
				'sksbelumbayar' => number_format($remun['sksbelumbayar'],2,',','.'),
				'sksbayar'=> number_format($remun['sksbayar'],2,',','.'),
				'tarif' => number_format($remun['tarif'],2,',','.'),
				'jumlah' => number_format($remun['jumlah'],2,',','.'),
			);

		array_push($datakirim, $dataarray);
		echo json_encode($datakirim);
		
	}

	public function tambahPembayaranRemun(){
		$data['nip'] = $_POST['nip'];
		$data['bulan'] = $_POST['bulan'];
		$data['tahun'] = $_POST['tahun'];
		$session_data = $this->session->userdata('sess_bpp');
		$bendahara = $session_data['idBendahara'];

		$dataarray = $this->HitungRemunIndividuPerBulanTahun($data);
		$dataarray['idBendahara'] = $bendahara;
		$res = $this->PembayaranModel->insertPembayaran($dataarray);
		echo json_encode($res);

	}

	public function updatePembayaranRemun(){
		$data['nip'] = $_POST['nip'];
		$data['idBayar'] = $_POST['idPembayaran'];
		$data['bulan'] = $_POST['bulan'];
		$data['tahun'] = $_POST['tahun'];

		$session_data = $this->session->userdata('sess_bpp');
		$bendahara = $session_data['idBendahara'];
		$dataarray = $this->HitungRemunIndividuPerBulanTahun($data);
		$dataarray['idBendahara'] = $bendahara;
		$dataarray['idBayar'] = $data['idBayar'];

		$res = $this->PembayaranModel->updatePembayaran($dataarray);
		echo json_encode($res);

	}

	public function confirmTransferRemun(){
		$data['idBayar'] = $_POST['idBayar'];
		$data['nip'] = $_POST['idDosen'];
		$data['status'] = 2;
		$res = $this->PembayaranModel->updateStatusPembayaran($data);
		echo $res;

	}

	public function confirmProsesRemun(){
		$data['idBayar'] = $_POST['idBayar'];
		$data['nip'] = $_POST['idDosen'];
		$data['status'] = 1;

		$res = $this->PembayaranModel->updateStatusPembayaran($data);
		echo $res;
	}

	private function getDataBPP($data){
		$datakirim = array();
		$datadosen = $this->DosenModel->getDataDosenFakultasStatus($data);

		for($i=0; $i<count($datadosen); $i++){
			$data['nip'] = $datadosen[$i]['nip'];
			$datagolongan = $this->MainModel->getGolonganByTMT($data);
			$datastruktural = $this->MainModel->getStrukturalByTMT($data);
			$datapendidikan = $this->MainModel->getPendidikanByTMT($data);
			$datapembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);
			
			if($datapembayaran==null){
				$tarif_kinerja = 0;
				$tarif_gaji = 0;
				$sks_gaji = 0;
				$sks_kinerja = 0;
				$pph = 0;
			}else{
				$tarif_gaji = $datapembayaran[0]['tarif_gaji'];
				$tarif_kinerja = $datapembayaran[0]['tarif_kinerja'];
				$sks_gaji = $datapembayaran[0]['sksr_gaji'];
				$sks_kinerja = $datapembayaran[0]['sksr_kinerja'];
				$pph = $datapembayaran[0]['pph'];
			}

			if($datagolongan==null){
				$datagolongan[0]['nama'] = "";				
			}

			if($datastruktural==null || $datastruktural[0]['id_jabatan_struktural']==301 || $datastruktural[0]['id_jabatan_struktural']==302 || $datastruktural[0]['id_jabatan_struktural']==0){
				$datafungsional = $this->MainModel->getFungsionalByTMT($data);
				if($datafungsional==null){
					$datafungsional[0]['namaf']="";
					$datafungsional[0]['jobvalue']="";
					$datafungsional[0]['grade']="";
				}
			}else{
				$datafungsional[0]['namaf']=$datastruktural[0]['namaf'];
				$datafungsional[0]['jobvalue']='';
				$datafungsional[0]['grade']=$datastruktural[0]['grade'];
			}

			if($datapendidikan==null){
				$datapendidikan[0]['singkatan']="";
			}

			
			$brutto = ($sks_gaji*$tarif_gaji)+($sks_kinerja*$tarif_kinerja);
			$pajak = $brutto*$pph;
			$netto = $brutto-$pajak;

			$dataarray = array(				
				'namadosen' => $datadosen[$i]['nama'],
				'nip' => $datadosen[$i]['nip'], 
				'golongan' => $datagolongan[0]['nama'],
				'jabFungsional' => $datafungsional[0]['namaf'],
				'pendidikan' => $datapendidikan[0]['singkatan'],
				'jobvalue'=> $datafungsional[0]['jobvalue'],
				'grade' => $datafungsional[0]['grade'],
				'tarif_gaji' => $tarif_gaji,
				'tarif_kinerja' => $tarif_kinerja,
				'sks_gaji' => $sks_gaji,
				'sks_kinerja' => $sks_kinerja,
				'brutto'=> $brutto,
				'pajak'=>$pajak,
				'netto'=>$netto,
				'rekening'=>$datadosen[$i]['no_rekening']
			);

			array_push($datakirim, $dataarray);
		}

		foreach ($datakirim as $key => $row) {
		    $grade[$key]  = $row['grade'];
		    $jobvalue[$key] = $row['jobvalue'];
		    $nama[$key] = $row['namadosen'];
		}

		array_multisort($grade, SORT_DESC, $jobvalue, SORT_DESC, $nama, SORT_ASC, $datakirim);

		return $datakirim;
	}

	private function Terbilang($x){
	  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	  if ($x < 12)
	    return " " . $abil[$x];
	  elseif ($x < 20)
	    return $this->Terbilang($x - 10) . "belas";
	  elseif ($x < 100)
	    return $this->Terbilang($x / 10) . " puluh" . $this->Terbilang($x % 10);
	  elseif ($x < 200)
	    return " seratus" . $this->Terbilang($x - 100);
	  elseif ($x < 1000)
	    return $this->Terbilang($x / 100) . " ratus" . $this->Terbilang($x % 100);
	  elseif ($x < 2000)
	    return " seribu" . $this->Terbilang($x - 1000);
	  elseif ($x < 1000000)
	    return $this->Terbilang($x / 1000) . " ribu" . $this->Terbilang($x % 1000);
	  elseif ($x < 1000000000)
	    return $this->Terbilang($x / 1000000) . " juta" . $this->Terbilang($x % 1000000);
	}

	public function ExportDaftarBPP(){
		set_time_limit(10000);
		$data['prodi'] = $_GET['prodi'];
		$data['status'] = $_GET['status'];	
		$data['tahun'] = $_GET['tahun'];
		$data['bulan'] = $_GET['bulan'];
		
		$session_data = $this->session->userdata('sess_bpp');
		$data['fakultas'] = $session_data['idFakultas'];
		$namafakultas = $session_data['namafakultas'];
		$data['namafakultas'] = $namafakultas;
		$fakultas = $this->MainModel->getDataFakultasByID($data['fakultas']);
		$singkatan = $fakultas[0]['singkatan'];
		$databpp = $this->getDataBPP($data);
		
		$ObjPHPExcel = new PHPExcel();

		if($data['status']==1){
			$tag="PNS";
			$this->setDataBPPtoExcelPNS($ObjPHPExcel, $databpp, $data);
		}else{
			$tag="NON-PNS";
			$this->setDataBPPtoExcelNonPNS($ObjPHPExcel, $databpp, $data);
		}

		$filename="daftar_BPP_".$tag."_".$data['bulan']."_".$data['tahun']."_".$singkatan.".xlsx";
		/*header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0');*/

		$objWriter = PHPExcel_IOFactory::createWriter($ObjPHPExcel, 'Excel2007'); 
		
		$path = "assets/files/".$data['tahun'];

	    if(!is_dir($path)) //create the folder if it's not already exists
	    {
	      mkdir($path,0755,TRUE);
	    } 

		$urlsave = $path.'/'.$filename;
		
		$objWriter->save($urlsave);
		
		
		echo $urlsave;
		

		/*$url = base_url('assets')."/files/".$filename;
		$objWriter = PHPExcel_IOFactory::createWriter($ObjPHPExcel, 'Excel2007');
		$objWriter->save(str_replace(__FILE__,$url,__FILE__));
		//$file = base_url('assets')."/files/".$filename;
		//echo $file;*/
		//$ObjPHPExcel->save(base_url('assets')."/files/".$filename);
		//$ObjPHPExcel->stream($filename);*/
		/*
		
		$url = base_url('assets')."/files/".$filename;
		$objWriter = PHPExcel_IOFactory::createWriter($ObjPHPExcel, 'Excel2007');
		$objWriter->save(str_replace(__FILE__,$url,__FILE__));*/
				
	}

	public function setDataBPPtoExcelPNS($ObjPHPExcel, $databpp, $data){
		set_time_limit(10000);
		$nama_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		$ObjPHPExcel->setActiveSheetIndex(0);
		$ObjPHPExcel->getActiveSheet()->setTitle($nama_bulan[$data['bulan']]);
		$ObjPHPExcel->getActiveSheet()->SetCellValue('A1','DAFTAR PERSEKOT REMUNERASI DOSEN UNIVERSITAS RIAU');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('A2',"FAKULTAS ".strtoupper ($data['namafakultas']));
		$ObjPHPExcel->getActiveSheet()->SetCellValue('A3','Bulan '.$nama_bulan[$data['bulan']]." ".$data['tahun']);

		$ObjPHPExcel->getActiveSheet()
		    ->getStyle('A1:A3')
		    ->getFont()->setBold(true);
		$ObjPHPExcel->getActiveSheet()
		    ->getStyle('A1:A3')
		    ->getFont()->setSize(12);

		$firstRow = 6;

		$ObjPHPExcel->getActiveSheet()
		    ->getStyle("A".$firstRow.":P".$firstRow)
		    ->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$ObjPHPExcel->getActiveSheet()
		    ->getStyle("A".$firstRow.":P".$firstRow)
		    ->getFont()->setBold(true);

		$ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$firstRow,'NO');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$firstRow,'NAMA');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('C'.$firstRow,'NIP');
		
		$ObjPHPExcel->getActiveSheet()->SetCellValue('D'.$firstRow,'GOLONGAN');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('E'.$firstRow,"JABATAN");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('F'.$firstRow,"PENDIDIKAN\nTERTINGGI");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('G'.$firstRow,'JOB VALUE');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('H'.$firstRow,'GRADE');

		$ObjPHPExcel->getActiveSheet()->SetCellValue('I'.$firstRow,"TARIF GAJI \nPER SKS\n(I)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('J'.$firstRow,"TARIF KINERJA \nPER SKS\n(J)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('K'.$firstRow,"SKS GAJI\nDIBAYAR\n(K)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('L'.$firstRow,"SKS KINERJA\nDIBAYAR\n(L)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('M'.$firstRow,"BRUTTO\n(M = (I x K)+(J X L)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('N'.$firstRow,"PAJAK\n(N)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('O'.$firstRow,"NETTO\n(O = M-N)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('P'.$firstRow,"NOMOR REKENING");		
		
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(13);

		$azam=0;
		$total_brutto=0;
		$total_netto=0;
		$total_pajak=0;
		$rowCount = $firstRow;

		foreach ($databpp as $bpp) {
			$rowCount++;
			$azam++;

			
			$ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $azam);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bpp['namadosen']);
			$ObjPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $bpp['nip'], PHPExcel_Cell_DataType::TYPE_STRING);

			$ObjPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $bpp['golongan']);

			$jabfung = $bpp['jabFungsional'];
			$jabfung =  str_replace("S1", "", $jabfung);
			$jabfung =  str_replace("S2", "", $jabfung);
			$jabfung =  str_replace("S3", "", $jabfung);

			$ObjPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $jabfung);

			$ObjPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $bpp['pendidikan']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $bpp['jobvalue']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $bpp['grade']);

			$ObjPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $bpp['tarif_gaji']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $bpp['tarif_kinerja']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $bpp['sks_gaji']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $bpp['sks_kinerja']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $bpp['brutto']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $bpp['pajak']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $bpp['netto']);
			$ObjPHPExcel->getActiveSheet()->setCellValueExplicit('P'.$rowCount, $bpp['rekening'], PHPExcel_Cell_DataType::TYPE_STRING);

			$total_brutto+=$bpp['brutto'];
			$total_netto+=$bpp['netto'];
			$total_pajak+=$bpp['pajak'];
		}

		$rowCount2=$firstRow;

		
		for($idx="A";$idx<="P";$idx++){
			if($idx=='B'||$idx=='E'){
				$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount2+1).":".$idx.$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			}else if($idx=='I'|| $idx=='J'|| $idx=='N'|| $idx=='O'){
				$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount2+1).":".$idx.$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}else{
				$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount2+1).":".$idx.$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
		}

		for($idx="I";$idx<="P";$idx++){
			$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode('#,##0');

		}
		
		$ObjPHPExcel->getActiveSheet()
			    ->getStyle("O".$rowCount2.":"."O".$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

		$ObjPHPExcel->getActiveSheet()
			    ->getStyle("K".$rowCount2.":"."K".$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode('0.00');
		$ObjPHPExcel->getActiveSheet()
			    ->getStyle("L".$rowCount2.":"."L".$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode('0.00');

		$ObjPHPExcel->getActiveSheet()->getStyle('A'.$rowCount2.':P'.$rowCount)->getAlignment()->setWrapText(true); 

		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);

		$ObjPHPExcel->getActiveSheet()->getStyle('A'.$firstRow.':P'.$rowCount)->applyFromArray($styleArray);
		

		$idx_hari = Date('d');
		$idx_hari = $idx_hari*1;
		$idx_bulan = Date('m');
		$idx_bulan = $idx_bulan*1;
		$idx_tahun = Date('Y');

		$ObjPHPExcel->getActiveSheet()->mergeCells("A".($rowCount+1).":J".($rowCount+1));
		$ObjPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1),"TOTAL");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('M'.($rowCount+1),round($total_brutto));
		$ObjPHPExcel->getActiveSheet()->SetCellValue('N'.($rowCount+1),round($total_pajak));
		$ObjPHPExcel->getActiveSheet()->SetCellValue('O'.($rowCount+1),round($total_netto));

		$ObjPHPExcel->getActiveSheet()->getStyle('A'.($rowCount+1).':O'.($rowCount+1))->applyFromArray($styleArray);
		unset($styleArray);

		for($idx="A";$idx<="O";$idx++){
			$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount+1))
			    ->getFont()->setBold(true);
			$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount+1))
			    ->getFont()->setSize(12);
			$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount+1))
			    ->getNumberFormat()
				->setFormatCode('#,##0');
		}

		$ObjPHPExcel->getActiveSheet()
			    ->getStyle('A'.($rowCount+1))
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$azam = $rowCount+4;
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$azam,"terbilang: ".$this->Terbilang(round($total_brutto))." rupiah");

		$ObjPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+2),"Lunas pada tanggal, ");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+3),'Bendahara Pengeluaran Pembantu');   
		$ObjPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+8),"( .............................................. )"); 
		$ObjPHPExcel->getActiveSheet()->SetCellValue('I'.($azam+9),'NIP. '); 

		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+2),'Setuju dibayar,');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+3),'Pejabat Pembuat Komitmen');   
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+8),'(..............................................)'); 
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+9),'NIP. '); 

		$ObjPHPExcel->getActiveSheet()
		    ->getStyle("A".$azam.":"."N".($azam+7))
		    ->getFont()->setSize(13);
	}

	public function setDataBPPtoExcelNonPNS($ObjPHPExcel, $databpp, $data){
		set_time_limit(10000);
		$nama_bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		$ObjPHPExcel->getActiveSheet()->setTitle($nama_bulan[$data['bulan']]);
		
		$ObjPHPExcel->getActiveSheet()->SetCellValue('A1','DAFTAR HONOR KELEBIHAN PENGAJARAN DOSEN TETAP NON PNS');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('A3',"FAKULTAS ".strtoupper ($data['namafakultas']));
		$ObjPHPExcel->getActiveSheet()->SetCellValue('A2','BULAN '.strtoupper($nama_bulan[$data['bulan']])." ".$data['tahun']);   
		$ObjPHPExcel->getActiveSheet()
		    ->getStyle('A1:A3')
		    ->getFont()->setBold(true);
		$ObjPHPExcel->getActiveSheet()
		    ->getStyle('A1:A3')
		    ->getFont()->setSize(12);

		$firstRow = 6; 

		$ObjPHPExcel->getActiveSheet()
		    ->getStyle("A".$firstRow.":M".$firstRow)
		    ->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$ObjPHPExcel->getActiveSheet()
		    ->getStyle("A".$firstRow.":M".$firstRow)
		    ->getFont()->setBold(true);

		$ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$firstRow,'NO');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$firstRow,'NAMA');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('C'.$firstRow,'NIPUS');
		
		$ObjPHPExcel->getActiveSheet()->SetCellValue('D'.$firstRow,'GOLONGAN');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('E'.$firstRow,"JABATAN\nFUNGSIONAL");

		$ObjPHPExcel->getActiveSheet()->SetCellValue('F'.$firstRow,"TARIF GAJI \nPER SKS\n(I)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('G'.$firstRow,"TARIF KINERJA\nPER SKS\n(J)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('H'.$firstRow,"SKS GAJI\nDIBAYAR BULAN INI\n(K)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('I'.$firstRow,"SKS KINERJA\nDIBAYAR BULAN INI\n(L)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('J'.$firstRow,"BRUTTO\n(M = (I x K)+(J X L)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('K'.$firstRow,"PAJAK\n(N)");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('L'.$firstRow,"NETTO\n(O = M-N)");
		//$ObjPHPExcel->getActiveSheet()->SetCellValue('K'.$firstRow,"NOMOR REKENING");		
		$ObjPHPExcel->getActiveSheet()->SetCellValue('M'.$firstRow,"TANDA TANGAN");		
		
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);	
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(13);	
		$ObjPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13);	

		
		$azam=0;
		$total_brutto=0;
		$total_netto=0;
		$total_pajak=0;
		$rowCount = $firstRow;
		
		foreach ($databpp as $bpp)
		{
			$rowCount++;
			$azam++;

			
			$ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $azam);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bpp['namadosen']);
			$ObjPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $bpp['nip'], PHPExcel_Cell_DataType::TYPE_STRING);

			$ObjPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $bpp['golongan']);

			$jabfung = $bpp['jabFungsional'];
			//$jabfung =  str_replace("S1", "", $jabfung);
			//$jabfung =  str_replace("S2", "", $jabfung);
			//$jabfung =  str_replace("S3", "", $jabfung);

			$ObjPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $jabfung);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $bpp['tarif_gaji']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $bpp['tarif_kinerja']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $bpp['sks_gaji']);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $bpp['sks_kinerja']);

			$bruto =  $bpp['brutto'];
			$pajak = $bpp['pajak'];
			$netto = $bpp['netto'];

			$ObjPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $bruto);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $pajak);
			$ObjPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $netto);
			//$ObjPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $data['no_rekening'], PHPExcel_Cell_DataType::TYPE_STRING);
			$ObjPHPExcel->getActiveSheet()->setCellValueExplicit('M'.$rowCount, $azam.".");

			$total_brutto+=$bruto;
			$total_netto+=$netto;
			$total_pajak+=$pajak;
			
		} 
		$rowCount2=$firstRow;

		
		for($idx="A";$idx<="M";$idx++){
			if($idx=='B'||$idx=='E'||$idx=='M'){
				$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount2+1).":".$idx.$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			}
			else if($idx=='F'||$idx=='G'||$idx=='J'||$idx=='M'){
				$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount2+1).":".$idx.$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
			else{
				$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount2+1).":".$idx.$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
		}

		for($idx="F";$idx<="L";$idx++){
			$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.$rowCount2.":".$idx.$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode('#,##0');

		}
		
		$ObjPHPExcel->getActiveSheet()
			    ->getStyle("L".$rowCount2.":"."L".$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

		$ObjPHPExcel->getActiveSheet()
			    ->getStyle("H".$rowCount2.":"."H".$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode('0.00');
		$ObjPHPExcel->getActiveSheet()
			    ->getStyle("I".$rowCount2.":"."I".$ObjPHPExcel->getActiveSheet()->getHighestRow())
			    ->getNumberFormat()
				->setFormatCode('0.00');

		$ObjPHPExcel->getActiveSheet()->getStyle('A'.$rowCount2.':L'.$rowCount)->getAlignment()->setWrapText(true); 
		//$ObjPHPExcel->getActiveSheet()->getStyle('K'.$rowCount2.':K'.$ObjPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);

		$ObjPHPExcel->getActiveSheet()->getStyle('A'.$firstRow.':L'.$rowCount)->applyFromArray($styleArray);
		

		$idx_hari = Date('d');
		$idx_hari = $idx_hari*1;
		$idx_bulan = Date('m');
		$idx_bulan = $idx_bulan*1;
		$idx_tahun = Date('Y');

		$ObjPHPExcel->getActiveSheet()->mergeCells("A".($rowCount+1).":G".($rowCount+1));
		$ObjPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1),"TOTAL");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('J'.($rowCount+1),round($total_brutto));
		$ObjPHPExcel->getActiveSheet()->SetCellValue('K'.($rowCount+1),round($total_pajak));
		$ObjPHPExcel->getActiveSheet()->SetCellValue('L'.($rowCount+1),round($total_netto));

		$ObjPHPExcel->getActiveSheet()->getStyle('A'.($rowCount+1).':L'.($rowCount+1))->applyFromArray($styleArray);
		unset($styleArray);

		for($idx="A";$idx<="L";$idx++){
			$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount+1))
			    ->getFont()->setBold(true);
			$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount+1))
			    ->getFont()->setSize(12);
			$ObjPHPExcel->getActiveSheet()
			    ->getStyle($idx.($rowCount+1))
			    ->getNumberFormat()
				->setFormatCode('#,##0');
		}
		$ObjPHPExcel->getActiveSheet()
			    ->getStyle('A'.($rowCount+1))
			    ->getAlignment()
			    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$azam = $rowCount+4;
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$azam,"terbilang: ".$this->Terbilang(round($total_brutto))." rupiah");

		$ObjPHPExcel->getActiveSheet()->SetCellValue('H'.($azam+2),"Lunas pada tanggal, ");
		$ObjPHPExcel->getActiveSheet()->SetCellValue('H'.($azam+3),'Bendahara Pengeluaran Pembantu');   
		$ObjPHPExcel->getActiveSheet()->SetCellValue('H'.($azam+8),"( .............................................. )"); 
		$ObjPHPExcel->getActiveSheet()->SetCellValue('H'.($azam+9),'NIP. '); 

		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+2),'Setuju dibayar,');
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+3),'Pejabat Pembuat Komitmen');   
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+8),'(..............................................)'); 
		$ObjPHPExcel->getActiveSheet()->SetCellValue('B'.($azam+9),'NIP. '); 

		$ObjPHPExcel->getActiveSheet()
		    ->getStyle("A".$azam.":"."L".($azam+7))
		    ->getFont()->setSize(13);
	}

	public function CetakSPTJM()
   {
      $session_data = $this->session->userdata('sess_bpp');
      $nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
      $nama_bulan2 = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
      $data['bulan'] = $_POST['bulan'];
      $data['tahun'] = $_POST['tahun'];
      $data['fakultas'] = $session_data['idFakultas'];
      $namadekan="";
      $nipdekan="";
      $totalremun=0;
      $datadosen = $this->DosenModel->getDataDosenByFakultas($data['fakultas']);
      foreach($datadosen as $dosen)
      {
      	$data['nip'] = $dosen['nip'];
      	$datapembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);
      	if($datapembayaran!=null)
      	{
      		$totalremun = $totalremun+($datapembayaran[0]['sksr_gaji']*$datapembayaran[0]['tarif_gaji'])+($datapembayaran[0]['sksr_kinerja']*$datapembayaran[0]['tarif_kinerja']);      		
      	}
      	
      	$datastruktural = $this->StrukturalModel->getStrukturalByTMT($data); 
      	if($datastruktural!=null)
      	{
	      	if($datastruktural[0]['id_jabatan_struktural']==3 || $datastruktural[0]['id_jabatan_struktural']==106)    	
	      	{
	      		$namadekan = $dosen['nama'];
	      		$nipdekan = $dosen['nip'];
	      	}
	    }
      }
      $terbilang = $this->Terbilang($totalremun);
      $this->load->library('word');
      $objPHPWord = new PHPWord();
      //our docx will have 'lanscape' paper orientation
      $document = $objPHPWord->loadTemplate('assets/files/sptjm_template.docx');
      $document->setValue('fakultas',$session_data['namafakultas']);
      $document->setValue('fakultas_judul', strtoupper($session_data['namafakultas']));
      $document->setValue('email_fakultas', 'unri.ac.id');
      $document->setValue('nama', $namadekan);
      $document->setValue('nip', $nipdekan);
      $document->setValue('bulan', $nama_bulan2[$data['bulan']]);
      $document->setValue('tahun', $data['tahun']);
      $document->setValue('grand_total', number_format($totalremun,0,',','.'));
      $document->setValue('terbilang', $terbilang);
      $tgl_sptjm = date('d')." ".$nama_bulan[date('m')]." ".date('Y');
      $document->setValue('tgl_sptjm', $tgl_sptjm);
     	
     	$fakultas = $this->MainModel->getDataFakultasByID($data['fakultas']);
     	$singkatan = ($fakultas!=null) ? $fakultas[0]['singkatan'] : "null";
     	$filename="SPTJM_".$nama_bulan2[$data['bulan']]."_".$data['tahun']."_".$singkatan.".docx";
		
		$path = "assets/files/".$data['tahun'];

	    if(!is_dir($path)) //create the folder if it's not already exists
	    {
	      mkdir($path,0755,TRUE);
	    } 

		$urlsave = $path.'/'.$filename;
		
		
      $document->save($urlsave);
      echo $urlsave;
   }
}