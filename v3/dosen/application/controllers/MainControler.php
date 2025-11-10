<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainControler extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->model('DosenModel');
		$this->load->model('GolonganModel');
		$this->load->model('PendidikanModel');
		$this->load->model('FungsionalModel');
		$this->load->model('StrukturalModel');
    	$this->load->model('PembayaranModel');
		$this->load->model('DashboardModel');
		$this->load->model('ValidasiModel');
		date_default_timezone_set('Asia/Jakarta');

	    if(!$this->session->userdata('sess_dosen')){
	       redirect("VerifyLogin",'refresh');
	    }

	}

	public function index(){
		$session_data = $this->session->userdata('sess_dosen');
		$datakirim = array();
		$data = array('datasession' => $session_data );
		$row['nip'] = $session_data['idDosen'];
		$datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
		$data['menuextend'] = @$datajabatan[0]['id_jabatan_struktural'];
		//$data['menuextend'] = "Jabatan Struktural";
		$row['tahun'] = date('Y');
		$currentmonth = date('m');

		for($i=1;$i<=$currentmonth;$i++){
			$row['bulan'] = $i;
			$datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($row);
			if($datavalidasi!=null){
				$status = $datavalidasi[0]['status'];
				$deskripsi = $datavalidasi[0]['deskripsi'];
			}else{
				$status = 0;
				$deskripsi = "";
			}
			$dataarray = array(
				'bulan' => $i,
				'tahun' => $row['tahun'],
				'status' => $status,
				'deskripsi' => $deskripsi,
				);
			array_push($datakirim, $dataarray);
		}

     	// khusus rektor dan wr2
		if($data['menuextend']<=109 and $data['menuextend']>=101){
			$data['display']="display:block;";
			$data['wr']="display:block;";
			$data['getfakultas'] = $this->DashboardModel->getfakultas();
			$data['getFungsional'] = $this->DashboardModel->getFungsional();
		
			for($f=0;$f<count($data['getFungsional']);$f++){
				$fungsional[$data['getFungsional'][$f]['ijf']]= array();
			} 

			foreach($data['getfakultas'] as $df){
				$getDataFungsional[$df->id_fakultas] = $this->DashboardModel->getDataFungsional($df->id_fakultas);
				for($f=0;$f<count($data['getFungsional']);$f++){
					$total=0;
					foreach ($getDataFungsional[$df->id_fakultas] as $key) {
						if($data['getFungsional'][$f]['ijf']==$key->id_jabatan_fungsional){
							$total=(int)$key->total;
						}
					}
					array_push($fungsional[$data['getFungsional'][$f]['ijf']], $total);
				}
			}
			$data['fungsional']=$fungsional;
			$data['rekap6bulan']=$this->getrekap6bulan();
	    	$data['rekap12bulan']=$this->getrekap12bulan();
		}else{
			$data['wr']="display:none;";
			$data['display']="display:block;";
		}

	    $dataparsing = array('info_kegiatan'=>$datakirim);
	    $this->template->view('template/content',$data, $dataparsing);

	}

  //bagian dari index
	public function getRekap(){
		$session_data  = $this->session->userdata('sess_dosen');
		$data['nip']   = $session_data['idDosen'];
		$maksbulan     = date("m");
		$data['tahun'] = date("Y");
		$totalsksarr   = $datakirim         = array();
		$grandtotalsks = $grandtotalsksgaji = $grandtotalskskinerja =  $grandtotalskssisa    = 0;

		for($i = 1; $i <= $maksbulan; $i++) {
			$data['bulan'] = $i;

			$totalsks       = $this->MainModel->getTotalSKSPerBulanBukanJ4($data);
			$totalsks2      = $this->MainModel->getTotalSKSPerBulanJ4($data);
			$skssementara   = $sisasksbayar = $lebihsksbayar = 0;
			$datastruktural = $this->StrukturalModel->getStrukturalByTMT($data);
			$datafungsional = $this->FungsionalModel->getFungsionalByTMT($data);

			if($datafungsional != null) {
			 	$sksr_kinerja = $datafungsional[0]['sksr_maks_kinerja'];
			 	$sksr_gaji    = $datafungsional[0]['sksr_maks_gaji'];
			}else{
				$sksr_kinerja = $sksr_gaji = 0;
			}

			//if(isset($datastruktural))
			if(count($datastruktural) > 0) {
				$sksr_tugas_tambahan = $datastruktural[0]['bobot_sksr'];
				$namastruktural      = $datastruktural[0]['nama'];
			}else{
				$sksr_tugas_tambahan = 0;
				$namastruktural      = '';
			}

			if (count($totalsks) > 0 || count($totalsks2) > 0) {
				foreach($totalsks2 as $dataloop) {
				    // $jKeg = ($dataloop['keg_bulanan'] == '0') ? $d['dari'] : '1';
					if(!$dataloop['deskripsi']){
						print_r(@$dataloop);
					}
				    $d    = json_decode($dataloop['deskripsi'], true);
				    $jKeg = ($dataloop['keg_bulanan'] == '0') ? ((!isset($d['dari']))? '1':$d['dari']) : '1';
				    $skssementara += $dataloop['bobot_sks'] * $jKeg;
				    // if(!isset($d['dari'])){ print_r($dataloop);}
				}

			 	$total_sks = @$totalsks[0]['total_sks'] + @$skssementara + $sksr_tugas_tambahan;
			} else {
			 	$total_sks = $sksr_tugas_tambahan;
			}

			$sks_remun = $total_sks;

			if ($sks_remun >= $sksr_gaji) {
				$sks_gaji       = $sksr_gaji;
				$sks_remun      = $sks_remun - $sks_gaji;
			} else {
				$sks_gaji       = $sks_remun;
				$sks_remun      = $sks_remun - $sks_gaji;
			}
			if ($sks_remun >= $sksr_kinerja) {
				$sks_kinerja    = $sksr_kinerja;
				$sks_remun      = $sks_remun - $sks_kinerja;
			} else {
				$sks_kinerja    = $sks_remun;
				$sks_remun      = $sks_remun - $sks_kinerja;
			}

			$grandtotalsks        += $total_sks;
			$grandtotalsksgaji    += $sks_gaji;
			$grandtotalskskinerja += $sks_kinerja;
			$grandtotalskssisa    += $sks_remun;

			$dataarray = array(
				'bulan'      => $i,
				'struktural' => $namastruktural,
				'totalsks'   => number_format($total_sks, 2),
				'sksgaji'    => number_format($sks_gaji, 2),
				'skskinerja' => number_format($sks_kinerja, 2),
				'sisasks'    => number_format($sks_remun, 2),
				'skstt'      => number_format($sksr_tugas_tambahan, 2),
				'avggaji'    => number_format($sksr_gaji,2),
				'avgkinerja' => number_format($sksr_kinerja,2),
			);

			//$totalsksarr += [ $i => $totalsks ];
			array_push($datakirim, $dataarray);
		}

		$dataarray = array(
			'bulan'      => 0,
			'struktural' => 'Total SKS',
			'totalsks'   => number_format($grandtotalsks, 2),
			'sksgaji'    => number_format($grandtotalsksgaji, 2),
			'skskinerja' => number_format($grandtotalskskinerja, 2),
			'sisasks'    => number_format($grandtotalskssisa, 2),
			'skstt'      => number_format(0, 2),
		);
		array_push($datakirim, $dataarray);
		echo json_encode($datakirim);

	}

  // ------------------------------------------------------------------------------------------------------------------------------------
  // ------------------------------------------------------------------------------------------------------------------------------------
  // ------------------------------------------------------------------------------------------------------------------------------------
  
	public function getrekap6bulan(){
		$data['tahun'] = date('Y');
		$data['between'] = "1 AND 6";
		$kegiatan1 = $this->DashboardModel->getTotalSKSPerBulanBukanJ4($data);
		if($kegiatan1[9]['id_fakultas']==11){ 
			$tambahan = Array ("id_fakultas"=>10, "total_sks"=>0.00);
			array_splice($kegiatan1, 9, 0, array($tambahan));
		}

		$data['fakultas'] = $this->DashboardModel->getfakultas();
		// for 6 bulan
		$strarray=array();
		$total4 = array();
		for($i=1;$i<=6;$i++){
			$data['bulan'] = $i;
			foreach($data['fakultas'] as $df){
		    	$data['id_fakultas'] = $df->id_fakultas;
		    	$kegiatan2 = $this->DashboardModel->getTotalSKSPerBulanJ4($data);
		    	if(empty($keg4[$data['id_fakultas']-1])){
		      		$keg4[$i][$data['id_fakultas']-1]=0;
		    	}
		    
		    	if($kegiatan2>0){
		      		$e=0;
		      		foreach($kegiatan2 as $dataloop) {
				        $d = json_decode($dataloop['deskripsi'], true);
				        $jKeg = ($dataloop['keg_bulanan'] == '0') ? @$d['dari'] : '1';
				        $e += ($dataloop['bobot_sks'] * $jKeg);
		      		}
		      		$keg4[$i][$data['id_fakultas']-1]=$e;
		    	}
		    
			    $datastruktural = $this->DashboardModel->getStrukturalByTMT($data);
			    $strarray[$i][$data['id_fakultas']-1] = 0;
			    foreach($datastruktural as $a){
				    $strarray[$i][$a['id_fakultas']-1] += $a['bobot_sksr'];
			    }
		    	
		    	if($a['id_fakultas']-1==3){ $strarray[$i][$a['id_fakultas']-1];} 
		  	} 
		}

		$sumarray = array_map(function () {return array_sum(func_get_args());}, $keg4[1], $keg4[2], $keg4[3], $keg4[4], $keg4[5], $keg4[6]);
		$struktural = array_map(function () {return array_sum(func_get_args());}, $strarray[1], $strarray[2], $strarray[3], $strarray[4], $strarray[5], $strarray[6]);
		// print_r($struktural);
		//ditambah
		$totals = $this->getTotalDosen();
		foreach($data['fakultas'] as $k){
			$hasil[($k->id_fakultas)-1] = ($kegiatan1[($k->id_fakultas)-1]['total_sks'] + $struktural[($k->id_fakultas)-1] + $sumarray[($k->id_fakultas)-1]);
			$hasil[($k->id_fakultas)-1] = number_format(($hasil[($k->id_fakultas)-1]<=0)?0: (($hasil[($k->id_fakultas)-1])/$totals[$k->id_fakultas]) ,2);
		}
		return json_encode($hasil);
	}

	public function getrekap12bulan(){
		$data['tahun'] = date('Y');
		$data['between'] = "7 AND 12";
		$kegiatan1 = $this->DashboardModel->getTotalSKSPerBulanBukanJ4($data);
		if($kegiatan1[9]['id_fakultas']==11){ 
			$tambahan = Array ("id_fakultas"=>10, "total_sks"=>0.00);
		 	array_splice($kegiatan1, 9, 0, array($tambahan));
		}
		// $kegiatan1=array_map('intval', $$kegiatan1);

		$data['fakultas'] = $this->DashboardModel->getfakultas();
		// for 6 bulan
		$strarray=array();
		$total4 = array();
		for($i=7;$i<=12;$i++){
			$data['bulan'] = $i;
			foreach($data['fakultas'] as $df){
		    	$data['id_fakultas'] = $df->id_fakultas;
		    	$kegiatan2 = $this->DashboardModel->getTotalSKSPerBulanJ4($data);
			    if(empty($keg4[$data['id_fakultas']-1])){
			    	$keg4[$i][$data['id_fakultas']-1]=0;
			    }
		    
		    	if($kegiatan2>0){
				    $e=0;
				    foreach($kegiatan2 as $dataloop) {
				        $d = json_decode($dataloop['deskripsi'], true);
				        $jKeg = ($dataloop['keg_bulanan'] == '0') ? $d['dari'] : '1';
				        $e += ($dataloop['bobot_sks'] * $jKeg);
		      		}
		      		$keg4[$i][$data['id_fakultas']-1]=$e;
		    	}
		    	
		    	$datastruktural = $this->DashboardModel->getStrukturalByTMT($data);
		    	$strarray[$i][$data['id_fakultas']-1] = 0;
		    	foreach($datastruktural as $a){
		      		$strarray[$i][$a['id_fakultas']-1] += $a['bobot_sksr'];
		    	}
		  	} 
		}

		$sumarray = array_map(function () {return array_sum(func_get_args());}, $keg4[7], $keg4[8], $keg4[9], $keg4[10], $keg4[11], $keg4[12]);
		$struktural = array_map(function () {return array_sum(func_get_args());}, $strarray[7], $strarray[8], $strarray[9], $strarray[10], $strarray[11], $strarray[12]);

		//ditambah
		$totals = $this->getTotalDosen();
		foreach($data['fakultas'] as $k){
			$hasil[($k->id_fakultas)-1] = ($kegiatan1[($k->id_fakultas)-1]['total_sks'] + $struktural[($k->id_fakultas)-1] + $sumarray[($k->id_fakultas)-1]);
		  	$hasil[($k->id_fakultas)-1] = number_format(($hasil[($k->id_fakultas)-1]<=0)?0: (($hasil[($k->id_fakultas)-1])/$totals[$k->id_fakultas]) ,2);
		}
		return json_encode($hasil);
	}


	public function getTotalDosen(){
		$fakultas = $this->DashboardModel->getfakultas();
		$getTotalDosen = $this->DashboardModel->getTotalDosen();

		foreach($fakultas as $a){
			$b[$a->id_fakultas]=0;
			for ($c=0; $c<count($getTotalDosen); $c++) { 
			    if($a->id_fakultas == $getTotalDosen[$c]['id_fakultas']){
			    	$b[$a->id_fakultas] = $getTotalDosen[$c]['total'];
			    }
		  	}
		}
		return ($b);
	}


	public function getKegiatanDosenJenisBulanTahun(){
		$session_data      = $this->session->userdata('sess_dosen');
		$data['tahun']     = (isset($_POST['tahun']))?$_POST['tahun']: date('Y');
		$data['bulan']     = date('m');
		$data['nip']       = $session_data['idDosen'];
		$datakirim         = 0;
		$limit             = $data['bulan'];
		
		// print_r($data['partition']);
		// exit();
		for($l=1;$l<=5;$l++){
			$data['jenis'] = $l;
			$l             = ($l == 3)?$l++: $l;
			
			for($j=1;$j<=$limit;$j++){
			    $data['bulan'] = $j;
			    $kirim[$l][$j] = 0;
			    $res           = $this->DashboardModel->getKegiatanDosenJenisBulanTahun($data);
		      
		      	foreach($res as $row){
			        $namakegiatan          = array();
			        $kode['kode_kegiatan'] = $row['kode_kegiatan'];
			        while ($kode['kode_kegiatan']!=0){
				        $datakegiatan          = $this->KegiatanModel->getKegiatanByKodeKegiatan($kode);
				        $kode['kode_kegiatan'] = $datakegiatan[0]['induk'];
				        array_push($namakegiatan, $datakegiatan[0]['nama']);
			        }

			        $jlh_nama_keg    = count($namakegiatan);
			        $jlh_nama_keg    = $jlh_nama_keg - 1;
			        $nama_keg_string = "";
			        
			        for($i=$jlh_nama_keg;$i>=0;$i--){
			          	$nama_keg_string = $nama_keg_string.$namakegiatan[$i]."#";
			        }

		        	$deskripsi = json_decode($row['deskripsi'],true);
		          	switch ($data['jenis']) {
		            	case '1':
				            $descstring = '';
				            $jKeg = $row['sks'];
			            break;
						case '2':
							$descstring = $deskripsi['judul_penelitian'];
							$jKeg = 1;
						break;
						case '4':
							$descstring = @$deskripsi['judul'];
							$jKeg = (@$deskripsi['keg_perbln'] == '0') ? ((!isset($deskripsi['dari']))? '1':$deskripsi['dari']) : '1';
						break;
						default:
							$descstring = $deskripsi['judul'];
							$jKeg = 1;
						break;
		          	}

			        $pathberkas = "";
			        $kirim[$l][$j] += $row['bobot_sks'] * $jKeg;
		      	}
		  	}
		}
		echo json_encode($kirim);
	}

	public function logout(){
		$this->session->unset_userdata('sess_dosen');
		session_destroy();
		redirect('VerifyLogin', 'refresh');
	}

	public function login(){
		$this->template->loginpage();
	}

	public function getProdi(){
	    $session_data = $this->session->userdata('sess_dosen');
	    $dataprodi = $this->MainModel->getDataProdi($session_data['idFakultas']);
	    return $dataprodi;
	}

	public function getStatus(){
		$session_data = $this->session->userdata('sess_dosen');
		$datastatus = $this->MainModel->getDataStatus();
		return $datastatus;
	}

	public function getDosen(){
		$session_data = $this->session->userdata('sess_dosen');
		$datadosen = $this->DosenModel->getDataDosenByFakultas($session_data['idFakultas']);
		return $datadosen;

	}

/*-------------------------------------------------- View Controller ------------------------------------*/

	public function DataDosen(){
	    $session_data = $this->session->userdata('sess_dosen');
	    $data = array('datasession' => $session_data );
	    $dataprodi = $this->getProdi();
	    $datastatus = $this->getStatus();
	    $dataisi = array('prodi' => $dataprodi,'status' => $datastatus);
	    $datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($data);
	    if($datajabatan[0]['id_jabatan_struktural'] == 116){
	      $data['menuextend'] = $this->load->view('template/wd1/nav_wd1',null,true);
	    }
	    $this->template->view('template/listdosen',$data,$dataisi);
	
	}

	public function riwayatkegiatan1(){
	    $session_data = $this->session->userdata('sess_dosen');
	    $data = array('datasession' => $session_data );
	    $datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($data);
	    if($datajabatan[0]['id_jabatan_struktural'] == 116){
	      $data['menuextend'] = $this->load->view('template/wd1/nav_wd1',null,true);
	    }
	    $this->template->view('template/riwayatkegiatan',$data);

	}

	public function RegistrasiDosen(){
	    $session_data = $this->session->userdata('sess_dosen');
	    $data = array('datasession' => $session_data );
	    $dataprodi = $this->getProdi();
	    $datastatus = $this->getStatus();
	    $dataisi = array('prodi' => $dataprodi,'status' => $datastatus);
	    $this->template->view('template/entrydosen',$data,$dataisi);

	}

	public function DataOperator(){
	    $dataprodi = $this->getProdi();
	    $session_data = $this->session->userdata('sess_dosen');
	    $data = array('datasession' => $session_data );
	    $dataisi = array('prodi' => $dataprodi);
	    $this->template->view('template/listoperator',$data,$dataisi);

	}

	public function RegistrasiOperator(){
	    $dataprodi = $this->getProdi();
	    $session_data = $this->session->userdata('sess_dosen');
	    $data = array('datasession' => $session_data );

	    $dataisi = array('prodi' => $dataprodi);
	    $this->template->view('template/entryoperator', $data, $dataisi);

	}

	public function DataRiwayat(){
	    $session_data = $this->session->userdata('sess_dosen');
	    $data = array('datasession' => $session_data );

	    $dataprodi = $this->getProdi();
	    $datastatus = $this->getStatus();

	    $dataisi = array('prodi' => $dataprodi,'status' => $datastatus);
	    $datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($data);
	    if($datajabatan[0]['id_jabatan_struktural'] == 116){
	      $data['menuextend'] = $this->load->view('template/wd1/nav_wd1',null,true);
	    }
	    $this->template->view('template/listriwayat',$data,$dataisi);

	}

	public function RekapRemunIndividu(){
	    $session_data = $this->session->userdata('sess_dosen');
	    $data = array('datasession' => $session_data );
	    $datadosen = $this->getDosen();
	    $dataisi = array('dosen' => $datadosen);
	    $this->template->view('template/rekapremun',$data,$dataisi);

	}
	
  	public function BiodataView(){
		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );

		$data['nip'] = $nip;
		$datadosen = $this->DosenModel->getDataDosen($data);

		$datagolongan = $this->GolonganModel->getGolonganByIDDosen($data);
		$datapendidikan = $this->PendidikanModel->getPendidikanByIDDosen($data);
		$datafungsional = $this->FungsionalModel->getFungsionalByIDDosen($data);
		$datastruktural = $this->StrukturalModel->getStrukturalByIDDosen($data);

		$dataisi = array
		(
			'dosen' => $datadosen,
			'golongan' => $datagolongan,
			'pendidikan' => $datapendidikan,
			'fungsional' => $datafungsional,
			'struktural' => $datastruktural
		);
    	$this->template->view('template/riwayatindividu',$data,$dataisi);

	}
	
	public function RekapPembayaran(){
		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );
		$row['nip'] = $session_data['idDosen'];
		$datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
		$data['menuextend'] = @$datajabatan[0]['id_jabatan_struktural'];
		$this->template->view('template/rekapremun',$data,NULL);

	}

	public function Profile(){
 		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );
		$row['nip'] = $session_data['idDosen'];
		$datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
		$data['menuextend'] = @$datajabatan[0]['id_jabatan_struktural'];	

		$this->template->view('template/profile',$data,NULL);
	}

/*------------------------------------------ Data Rekap COntroller -----------------------------------*/

	public function getDataRekapPembayaran(){
		$session_data = $this->session->userdata('sess_dosen');
		$data['nip'] = $session_data['idDosen'];
		$data['tahun'] = $_GET['tahun'];
		$dosen = $this->DosenModel->getDataDosen($data);
		$datakirim = array();

		for($i=1;$i<=12;$i++){
			$data['bulan'] = $i;
			$datapembayaran = $this->PembayaranModel->getPembayaranPerBulanTahun($data);
			$datavalidasi = $this->ValidasiModel->getDataValidasiBulanTahunByIDDosen($data);

			if($datapembayaran==null){

		        $statusvalidasi = ($datavalidasi!=null)?$datavalidasi[0]['status']:0;
		        $tarif_gaji=0;
		        $tarif_kinerja = 0;
		        $sks_gaji = 0;
		        $sks_kinerja = 0;
		        $pph = 0;

		        if($statusvalidasi>0){
		          if($statusvalidasi==1){
		            $status = -1;
		          }elseif($statusvalidasi==2){
		            $status = -2;
		          }elseif($statusvalidasi == 3){
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
		        $status_bayar = ($id_status_bayar == 1)?"Belum Dibayar":"Sudah Dibayar";

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

	public function ubahPassword(){
		$data['pass'] = $_POST['passbaru'];
		$session_data = $this->session->userdata('sess_dosen');
		$data['user'] = $session_data['name'];
		$data['idDosen'] = $session_data['idDosen'];
		$res = $this->User->ubahPassword($data);
		// echo json_decode($res);
		print_r($res);
	
  	}

  	public function myvalidasi()
  	{
 		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );
		$row['nip'] = $session_data['idDosen'];
		$datajabatan = $this->StrukturalModel->getStrukturalByIDDosen($row);
		$data['menuextend'] = @$datajabatan[0]['id_jabatan_struktural'];	

		$this->template->view('template/rekapvalidasidosen',$data,NULL);
  	}


  	public function getvalidasi()
  	{
  		$data['tahun'] = $_POST['id'];
  		$data['bulan'] = ((isset($_POST['bulan']))?$_POST['bulan']:'0');
  		$data['session'] = $this->session->userdata('sess_dosen');
		$dataisi = $this->MainModel->getValidasi($data);

		echo json_encode($dataisi);
  		// print_r($dataisi);
  	}

  	public function detailsKegiatan()
  	{
  		$data['session'] = $this->session->userdata('sess_dosen');
  		$data['tipe'] = $_POST['tipe'];
  		$data['bulan'] = $_POST['bulan'];
  		$data['tahun'] = $_POST['tahun'];

  		$dataisi = $this->MainModel->validasiKegiatan($data);
  		echo json_encode($dataisi);
  	}


}
