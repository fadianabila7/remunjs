<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tambahan extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->model('DosenModel');
		$this->load->model('GolonganModel');
		$this->load->model('PendidikanModel');
		$this->load->model('FungsionalModel');
		$this->load->model('StrukturalModel');
		$this->load->model('KegiatanModel');
		$this->load->model('TambahanModel');
		date_default_timezone_set("Asia/Jakarta");

		if(!$this->session->userdata('sess_admin')){
			redirect("VerifyLogin",'refresh');
		}
	}

	public function index()
	{
	
		$session_data = $this->session->userdata('sess_admin');
		$data = array('datasession' => $session_data );

		$this->template->view('template/content',$data);
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
		$dataprodi = $this->MainModel->getDataProdi($session_data['idFakultas']);
		return $dataprodi;
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

/*-------------------------------------------------- View Controller ------------------------------------*/

	public function DataDosen()
	{

		$session_data = $this->session->userdata('sess_admin');
		$data = array('datasession' => $session_data );

		$dataprodi = $this->getProdi();
		$datastatus = $this->getStatus();

		$dataisi = array
		(
			'prodi' => $dataprodi,
			'status' => $datastatus
		 );
		
		$this->template->view('template/listdosen',$data,$dataisi);		
	}

	public function EntrySK()
	{
		$session_data = $this->session->userdata('sess_admin');
		$data = array('datasession' => $session_data );
		$data['page'] = 'tambahan';
		$datakegiatan = $this->TambahanModel->getTugasTambahan();
		$datakirim = array('kegiatan' => $datakegiatan);
		
		$this->template->view('template/entryskTambahan',$data,$datakirim);	
	}

	public function ListSK()
	{
		$session_data = $this->session->userdata('sess_admin');
		$data = array('datasession' => $session_data );
		$data['page'] = 'tambahan';
		$this->template->view('template/listsktambahan',$data,null);		
	}
	
	
	public function submitDataSK()
	{

		$session_data = $this->session->userdata('sess_admin');

		$nip = $_POST['nip'];
		$kegiatan = $_POST['kegiatan'];
		$no_sk = $_POST['sk'];
		$tgl_sk = $_POST['tgl_sk'];
		$nama_keg = $_POST['nama_keg'];
		$tgl_keg = $_POST['tgl_keg'];
		$tgl_entry = date("Y-m-d h:m:s");
		$jml_keg = $_POST['jml_keg'];
		$keg_bln = $_POST['keg_bln'];
		$jumlah = count($nip);
		

		for($i=0; $i<$jumlah; $i++){
			$data['nip'] = $_POST['nip'][$i];
			$datadosen = $this->DosenModel->getDataDosen($data);
			$data['tgl_entry'] = $tgl_entry;
			$data['id_user'] = $session_data['name'];
			$data['id_prodi'] = $datadosen[0]['id_program_studi'];

			$pTglKeg = explode("-", $tgl_keg);
			$yyyy = $pTglKeg[0]; $mm = $pTglKeg[1]; $dd = ($pTglKeg[2] > 25) ? 25 : $pTglKeg[2];

			$data['kode_kegiatan'] = $_POST['kegiatan'][$i];
			$data['sks'] = 1;
			$datakegiatan = $this->KegiatanModel->getKegiatanByKodeKegiatan($data);
			$deskripsi['posisi'] = $datakegiatan[0]['nama'];
			$data['no_sk'] = $no_sk;

			$q = $this->db->query("select UUID_SHORT() as uuid");
			$dUuid = $q->result_array();

			//Kondisi jika kegiatan dilakukan rutin tiap bulan
			if($keg_bln == "1"){
				for($x=0;$x<$jml_keg;$x++){
					$deskripsi = array(
	   				'judul' => $nama_keg,
	   				'tgl_sk' => $tgl_sk,
	   				'nilai' => 0,
	   				'nama_berkas' => null,
	   				'bln_ke' => ($x+1),
	   				'dari'	=> $jml_keg,
	   				'keg_perbln' => 1,
	   				'uuid_tambahan' => $dUuid[0]['uuid']
	   				);
					$data['deskripsi'] = json_encode($deskripsi);

					$yyyy = ($mm<=12)? $yyyy : $yyyy+1;
					$mm = ($mm<=12)? $mm : 1;
					$data['tgl_keg'] = $yyyy."-".$mm++."-".$dd;
					$res = $this->TambahanModel->entryTambahan($data);
				}
			}else{
				$deskripsi = array(
	   				'judul' => $nama_keg,
	   				'tgl_sk' => $tgl_sk,
	   				'nilai' => 0,
	   				'nama_berkas' => null,
	   				'bln_ke' => 1,
	   				'dari'	=> $jml_keg,
	   				'keg_perbln' => 0,
	   				'uuid_tambahan' => $dUuid[0]['uuid']
	   				);
				$data['deskripsi'] = json_encode($deskripsi);
				$data['tgl_keg'] = $tgl_keg;
				$res = $this->TambahanModel->entryTambahan($data);
			}	
		}

		redirect('Tambahan/ListSK','refresh');
	}

	public function getDataSKBulanTahun()
	{
		if($this->session->userdata('sess_admin'))
   		{
   			$session_data = $this->session->userdata('sess_admin');
   			$data['fakultas'] = $session_data['idFakultas'];
   			
   			$data['tahun'] = $_GET['tahun'];
   			$data['bulan'] = $_GET['bulan'];
   			$datakirim = array();
   			$datakegiatan = $this->TambahanModel->getSKTambahanBulanTahun($data);
   			$deskripsi = array();
   			foreach($datakegiatan as $row)
   			{
   				$deskripsi = json_decode($row['desk'],true);
   				
   				$descstring = @$deskripsi['judul']."#".@$deskripsi['tgl_sk']."#".@$deskripsi['nilai'];

   				$dataarray = array(
   					//'id_kegiatan_dosen' => $row['id_kegiatan_dosen'],
   					'no_sk' => @$row['no_kontrak'],
   					'tgl_sk' => @$deskripsi['tgl_sk'],
   					'judul_keg' => @$deskripsi['judul'],
   					//'nama_dosen' => $row['nama'],
   					//'nip'	=> $row['nip'],
   					'jml'	=> @$deskripsi['dari'],
   					'satuan' => @$row['satuan'],
   					'uuid'	=> @$deskripsi['uuid_tambahan']
   					);

   				array_push($datakirim, $dataarray);
   			}

   			echo json_encode($datakirim);

   			//redirect('MainControler','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
	}

	public function getDataKegiatanByNoSK()
	{
		$data['no_sk'] = $_GET['no_sk'];
		
		$datakegiatan = $this->TambahanModel->getSKNoSK($data);
		$deskripsi = array();
		$datakirim = array();
		foreach($datakegiatan as $row)
		{
			$data['nip'] = $row['id_dosen'];
			$datadosen = $this->DosenModel->getDataDosen($data);
			$data['kode_kegiatan'] = $row['kode_kegiatan'];
			$kegiatan = $this->TambahanModel->getTambahanByKodeKegiatan($data);
			$deskripsi = json_decode($row['deskripsi'],true);

			$dataarray = array(
				'nama_dosen' => @$datadosen[0]['nama'],
				'nip' => $row['id_dosen'],
				'kode_keg' => $row['kode_kegiatan'],
				'nama_keg' => $kegiatan[0]['nama'],
				'judul_keg' => @$deskripsi['judul'],
				'no_sk' => $data['no_sk'],
				'tgl_sk' => @$deskripsi['tgl_sk'],
				'tgl_keg' => $row['tanggal_kegiatan'],
				);

			array_push($datakirim, $dataarray);
		}

		echo json_encode($datakirim);

	}

	public function deleteDataSK()
	{
		$data['uuid'] = $_POST['id_kegiatan_dosen'];

		$res = $this->TambahanModel->deleteKegiatanDosenBySK($data);

		echo $res;
	}

	public function updateDataSK()
	{
		$session_data = $this->session->userdata('sess_admin');	
		$data['no_sk'] = $_POST['no_sk'];
		$data['tgl_sk'] = $_POST['tgl_sk'];
		$data['judul_keg'] = $_POST['judul_keg'];
		$data['tgl_keg'] = $_POST['tgl_keg'];
		$data['tgl_entry'] = date("Y-m-d h:m:s");
		$nip = $_POST['nip'];
		$jumlahNew = count($nip);
		$datalama = $this->KegiatanModel->getSKNoSK($data);
		$niplama = array();
		
		foreach($datalama as $row)
		{
			array_push($niplama, $row['id_dosen']);
		}
		$jumlahOld = count($niplama);
		if($jumlahNew<$jumlahOld)
		{			
			$datahapus = array();
			$result = array_diff($niplama, $nip);
			
			foreach($result as $res)
			{
				foreach($datalama as $row)
				{
					if($row['id_dosen']==$res)
					{
						$data['riwayat'] = $row['id_kegiatan_dosen'];
						$statusdelete = $this->KegiatanModel->deleteKegiatanDosenByRiwayat($data);
					}
				}
			}
			
			$databaru = $this->KegiatanModel->getSKNoSK($data);
			foreach($databaru as $row)
			{
				$data['riwayat'] = $row['id_kegiatan_dosen'];
				
				$data['id_user'] = $session_data['name'];
				$data['kode_kegiatan'] = $row['kode_kegiatan'];
				$data['sks'] = $row['sks'];
				$deskripsilama = json_decode($row['deskripsi'],true);
				
				//update script by UR
				$deskripsi = array(
			   				'judul' => $data['judul_keg'],
			   				'tgl_sk' =>$data['tgl_sk'],
			   				'nilai' => 0,
			   				'nama_berkas' => $deskripsilama['nama_berkas'],
			   				'bln_ke' =>$deskripsilama['bln_ke'],
			   				'dari'	=> $deskripsilama['dari'],
			   				'keg_perbln' => $deskripsilama['keg_perbln'],
			   				'uuid_tambahan' => $deskripsilama['uuid_tambahan'],
			   				);

				/*$deskripsi = array(
						'judul' => $data['judul_keg'],
						'tgl_sk' => $data['tgl_sk'],
						'nilai' => $deskripsilama['nilai'],
						'nama_berkas' => $deskripsilama['nama_berkas'],
						'posisi' => $deskripsilama['posisi'],

					);*/

				$data['deskripsi'] = json_encode($deskripsi);
				$data['nip'] = $row['id_dosen'];
				$data['prodi'] = $row['id_program_studi'];
				$updatestatus = $this->KegiatanModel->updateKegiatanDosenByRiwayat($data);
			}
		}
		else
		{
			foreach($datalama as $row)
			{
				$data['riwayat'] = $row['id_kegiatan_dosen'];
				$data['id_user'] = $session_data['name'];
				$data['kode_kegiatan'] = $row['kode_kegiatan'];
				$data['sks'] = $row['sks'];
				$deskripsilama = json_decode($row['deskripsi'],true);

				//update script by UR
				$deskripsi = array(
			   				'judul' => $data['judul_keg'],
			   				'tgl_sk' =>$data['tgl_sk'],
			   				'nilai' => 0,
			   				'nama_berkas' => $deskripsilama['nama_berkas'],
			   				'bln_ke' =>$deskripsilama['bln_ke'],
			   				'dari'	=> $deskripsilama['dari'],
			   				'keg_perbln' => $deskripsilama['keg_perbln'],
			   				'uuid_tambahan' => $deskripsilama['uuid_tambahan'],
			   				);
				/*$deskripsi = array(
						'judul' => $data['judul_keg'],
						'tgl_sk' => $data['tgl_sk'],
						'nilai' => $deskripsilama['nilai'],
						'nama_berkas' => $deskripsilama['nama_berkas'],
						'posisi' => $deskripsilama['posisi'],
					);*/
				$data['deskripsi'] = json_encode($deskripsi);
				$data['nip'] = $row['id_dosen'];
				$data['prodi'] = $row['id_program_studi'];
				$updatestatus = $this->KegiatanModel->updateKegiatanDosenByRiwayat($data);
			}
		}

		return $updatestatus;
	}

	public function getKegiatanByInduk()
	{
		$data['induk'] = $_GET['kode'];
		$data['kode_kegiatan'] = $_GET['kode'];
		$datakirim = array();

		$datakegiatan = $this->KegiatanModel->getKegiatanByKodeKegiatan($data);
		if($datakegiatan[0]['bobot_sks']==null || $datakegiatan[0]['bobot_sks']=='0')
		{
			$kegiatan = $this->KegiatanModel->getKegiatanByKodeInduk($data);
			echo json_encode($kegiatan);
		}
		else
		{
			echo json_encode($datakegiatan);
		}
	}

	public function uploadBerkasSK()
	{
		$data['no_sk'] = $_POST['no_sk'];
		$kegiatan = $this->KegiatanModel->getSKNoSK($data);
		$deskripsi = json_decode($kegiatan[0]['deskripsi'],true);
		$tgl_sk = explode("-", $deskripsi['tgl_sk']);
		$pathfiles = "assets/files/".$tgl_sk[0]."/";
		if(!is_dir($pathfiles)) //create the folder if it's not already exists
		    {
		      mkdir($pathfiles,0755,TRUE);
		    } 
		$filenamearray = explode("/", $data['no_sk']);
		$filename = implode("_", $filenamearray);
		$filename = $filename."_"."TTambahan.pdf";
		
		$pathsave = $pathfiles.$filename;
		if(file_exists($pathsave))
		{
			unlink($pathsave);
		}

		if(move_uploaded_file($_FILES['berkas_sk']["tmp_name"], $pathsave))
		{
			$datakegiatan = $this->KegiatanModel->getSKNoSK($data);
			foreach($datakegiatan as $row)
			{
				$deskripsilama = json_decode($row['deskripsi'],true);
				$data['riwayat'] = $row['id_kegiatan_dosen'];
				$deskripsibaru = array(
			   				'judul' => $deskripsilama['judul'],
			   				'tgl_sk' =>$deskripsilama['tgl_sk'],
			   				'nilai' => $deskripsilama['nilai'],
			   				'nama_berkas' => $filename,
			   				'bln_ke' =>$deskripsilama['bln_ke'],
			   				'dari'	=> $deskripsilama['dari'],
			   				'keg_perbln' => $deskripsilama['keg_perbln'],
			   				'uuid_tambahan' => $deskripsilama['uuid_tambahan'],
			   				);
				/*$deskripsibaru = array(
					'judul' => $deskripsilama['judul'],
					'tgl_sk' => $deskripsilama['tgl_sk'],
					'nilai' => $deskripsilama['nilai'],
					'nama_berkas' => $filename,
					'posisi' => $deskripsilama['posisi'],
					);*/
				$data['deskripsi'] = json_encode($deskripsibaru);
				$res = $this->KegiatanModel->updateDeskripsiKegiatanDosenByRiwayat($data);
			}

			
		}
		else
		{
			
		}
		redirect('Penunjang/ListSK','refresh');
	}

	public function getBerkasSK()
	{
		$data['no_sk'] = $_GET['no_sk'];
		$kegiatan = $this->KegiatanModel->getSKNoSK($data);
		$deskripsi = json_decode($kegiatan[0]['deskripsi'],true);
		$tgl_sk = explode("-", $deskripsi['tgl_sk']);
		$pathfiles = "assets/files/".$tgl_sk[0]."/";
		if(!is_dir($pathfiles)) //create the folder if it's not already exists
		    {
		      mkdir($pathfiles,0755,TRUE);
		    } 
		$filenamearray = explode("/", $data['no_sk']);
		$filename = implode("_", $filenamearray);
		$filename = $filename."_"."Penunjang.pdf";
		$pathsave = $pathfiles.$filename;
		$pathberkas = base_url().$pathfiles.$filename;
		if (file_exists($pathsave))
		{
			$dataarray = array(
				'filename' => $filename,
				'path_berkas' => $pathberkas,
				);
		}
		else
		{
			$dataarray = array(
				'filename' => "Belum Ada Berkas",
				'path_berkas' => "#",
				);
		}

		echo json_encode($dataarray);
	}


	// pengecekan tanggal kosong pada Database
	public function cekTanggalKosong()
	{
		$session_data = $this->session->userdata('sess_admin');

   			$tanggalKosong = $this->TambahanModel->getTanggal();
   			//print_r($tanggalKosong);

			foreach($tanggalKosong as $row){
	   			$deskripsi = json_decode($row['deskripsi'],true);
	   			$data['id_kegiatan_dosen']=$row['id_kegiatan_dosen'];
	   			
	   			
	   			if(empty($deskripsi['keg_perbln'])){

	   				if($deskripsi['bln_ke']=='1' and $deskripsi['dari']=='1'){
			   	
				   		$data['tanggal_kegiatan']=$deskripsi['tgl_sk'];
		   			
		   			}elseif($deskripsi['dari']>'1'){

		   				$a=explode('-',$deskripsi['tgl_mulai']);

			   			if(empty($a[2])){
			   				$a=explode('/',$deskripsi['tgl_mulai']);
			   			}

			   			if(strlen($a[0])=="4"){
			   				$data['tanggal_kegiatan']=$a[0].'-'.($a[1]+($deskripsi['bln_ke']-1)).'-'.$a[2];
			   			}elseif(strlen($a[0])=="2"){
							$data['tanggal_kegiatan']=$a[2].'-'.($a[1]+($deskripsi['bln_ke']-1)).'-'.$a[0];
			   			}elseif(strlen($a[0])=="0"){
							$data['tanggal_kegiatan']=$a[3].'-'.($a[1]+($deskripsi['bln_ke']-1)).'-'.$a[2];
			   			}

					}

	   			}elseif($deskripsi['keg_perbln']==0){
	   				
	   				if(!empty($deskripsi['tgl_sk'])){
			   			$a=explode('-',$deskripsi['tgl_sk']);

			   			if(empty($a[2])){
			   				$a=explode('/',$deskripsi['tgl_sk']);
			   			}

			   			if(strlen($a[2])=="4"){
			   				$data['tanggal_kegiatan']=$a[2].'-'.$a[1].'-'.$a[0];	
			   			}else{
			   				$data['tanggal_kegiatan']=$deskripsi['tgl_sk'];
			   			}
					}else{
						$data['tanggal_kegiatan']=$deskripsi['tgl_mulai'];
					}

	   			}elseif($deskripsi['keg_perbln']==1){

	   				$a=explode('-',$deskripsi['tgl_sk']);

		   			if(empty($a[2])){
		   				$a=explode('/',$deskripsi['tgl_sk']);
		   			}

		   			if(strlen($a[2])=="4"){
						$data['tanggal_kegiatan']=$a[2].'-'.($a[1]+($deskripsi['bln_ke']-1)).'-'.$a[0];
		   			}else{
		   				$data['tanggal_kegiatan']=$a[0].'-'.($a[1]+($deskripsi['bln_ke']-1)).'-'.$a[2];
		   			}

	   			}
				$updatestatus = $this->TambahanModel->updateTanggal($data);
	   			//print_r($deskripsi);
			}
   			
	
	}

	public function formatdesc(){
		$kosong= $this->TambahanModel->deskripsikosong();
		foreach($kosong as $d){
			$perubahan = array('deskripsi' => $d['deskripsi'],);
			$data['deskripsi'] = json_encode($perubahan);
			$data['id_kegiatan_dosen'] = $d['id_kegiatan_dosen'];
			$hasil = $this->TambahanModel->updatedeskripsi($data);
			if ($hasil) {
				echo "<br>1";
			}else{
				echo "<br>".$data['id_kegiatan_dosen'];
			}
		}
	}

}
