<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penelitian extends CI_Controller {

	

	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		if(!$this->session->userdata('sess_operator')){
			redirect("VerifyLogin",'refresh');
		}
	}


	public function index(){

		$session_data = $this->session->userdata('sess_operator');
		$data = array('datasession' => $session_data );	
		$data['page'] = 'dashboard';
		$this->template->view('template/infoPenelitian','template/nav_penelitian',$data);	
	}


	public function EntryPenelitianMandiri(){

		$session_data = $this->session->userdata('sess_operator');
		$datakegiatan = $this->Db_model->getKegiatanPenelitian();
		$data = array('datasession' => $session_data, 'kegiatan' => $datakegiatan,);
		$data['page'] = 'PenelitianMandiri';
		$this->template->view('template/EntryMandiri','template/nav_penelitian',$data);				
	}

	

	public function getBerkasAPBN(){
		$data['no_sk'] = $_GET['no_sk'];
		$kegiatan = $this->Db_model->getSKNoSK($data);
		$deskripsi = json_decode($kegiatan[0]['deskripsi'],true);
		$tgl_sk = explode("-", $deskripsi['tgl_sk']);
		$pathfiles = "assets/files/".$tgl_sk[0]."/";
		//create the folder if it's not already exists
		if(!is_dir($pathfiles)){
			mkdir($pathfiles,0755,TRUE);
		}

		$filenamearray = explode("/", $data['no_sk']);
		$filename = implode("_", $filenamearray);
		$filename = $filename."_"."PenelitianAPBN.pdf";
		$pathsave = $pathfiles.$filename;
		$pathberkas = base_url().$pathfiles.$filename;
		if (file_exists($pathsave)){
			$dataarray = array('filename' => $filename,'path_berkas' => $pathberkas,);
		}else{
			$dataarray = array('filename' => "Belum Ada Berkas",'path_berkas' => "#",);
		}

		echo json_encode($dataarray);
	}

	public function uploadBerkasPenelitianMandiri()
	{
		$data['no_sk'] = $_POST['no_sk'];
		$kegiatan = $this->Db_model->getSKNoSK($data);
		$deskripsi = json_decode($kegiatan[0]['deskripsi'],true);
		$tgl_sk = explode("-", $deskripsi['tgl_sk']);
		$pathfiles = "assets/files/".$tgl_sk[0]."/";
		if(!is_dir($pathfiles)) //create the folder if it's not already exists
		    {
		      mkdir($pathfiles,0777,TRUE);
		    } 
		$filenamearray = explode("/", $data['no_sk']);
		$filename = implode("_", $filenamearray);
		$filename = $filename."_"."Penelitian.pdf";
		
		$pathsave = $pathfiles.$filename;
		if(file_exists($pathsave))
		{
			unlink($pathsave);
		}

		if(move_uploaded_file($_FILES['berkas_sk']["tmp_name"], $pathsave))
		{
			$datakegiatan = $this->Db_model->getSKNoSK($data);
			foreach($datakegiatan as $row)
			{
				$deskripsilama = json_decode($row['deskripsi'],true);
				$data['riwayat'] = $row['id_kegiatan_dosen'];
				$deskripsibaru = array(
					'judul_penelitian' => $deskripsilama['judul_penelitian'],
					'tgl_sk' => $deskripsilama['tgl_sk'],
					'nama_berkas' => $filename,
					);
				$data['deskripsi'] = json_encode($deskripsibaru);
				$res = $this->Db_model->updateDeskripsiKegiatanDosenByRiwayat($data);
			}

			
		}
		else
		{
			
		}
		redirect('Penelitian/ListPenelitianMandiri','refresh');
	}

	public function uploadBerkasPenelitianAPBN()
	{
		$data['no_sk'] = $_POST['no_sk'];
		$kegiatan = $this->Db_model->getSKNoSK($data);
		$deskripsi = json_decode($kegiatan[0]['deskripsi'],true);
		$tgl_sk = explode("-", $deskripsi['tgl_sk']);
		$pathfiles = "assets/files/".$tgl_sk[0]."/";
		if(!is_dir($pathfiles)) //create the folder if it's not already exists
		    {
		      mkdir($pathfiles,0777,TRUE);
		    } 
		$filenamearray = explode("/", $data['no_sk']);
		$filename = implode("_", $filenamearray);
		$filename = $filename."_"."PenelitianAPBN.pdf";
		
		$pathsave = $pathfiles.$filename;
		if(file_exists($pathsave))
		{
			unlink($pathsave);
		}

		if(move_uploaded_file($_FILES['berkas_sk']["tmp_name"], $pathsave))
		{
			$datakegiatan = $this->Db_model->getSKNoSK($data);
			foreach($datakegiatan as $row)
			{
				$deskripsilama = json_decode($row['deskripsi'],true);
				$data['riwayat'] = $row['id_kegiatan_dosen'];
				$deskripsibaru = array(
					'judul_penelitian' => $deskripsilama['judul_penelitian'],
					'tgl_sk' => $deskripsilama['tgl_sk'],
					'skema_penelitian' => $deskripsilama['skema_penelitian'],
					'nama_berkas' => $filename,
					);
				$data['deskripsi'] = json_encode($deskripsibaru);
				$res = $this->Db_model->updateDeskripsiKegiatanDosenByRiwayat($data);
			}

			
		}
		else
		{
			
		}
		redirect('Penelitian/ListPenelitianApbn','refresh');
	}


	public function ListPenelitianMandiri()
	{

		if($this->session->userdata('sess_operator'))
   		{
   			$session_data = $this->session->userdata('sess_operator');
   			$data = array('datasession' => $session_data );
   			
   			$data['page'] = 'PenelitianMandiri';
			$this->template->view('template/ListPenelitianMandiri','template/nav_penelitian',$data);
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
		
	}

	public function getDataMandiriBulanTahun()
	{
		if($this->session->userdata('sess_operator'))
   		{
   			$session_data = $this->session->userdata('sess_operator');
   			$data['fakultas'] = $session_data['idFakultas'];
   			
   			$data['tahun'] = $_GET['tahun'];
   			$data['bulan'] = $_GET['bulan'];
   			$data['jurusan'] = $_GET['jurusan'];
   			$datakirim = array();
   			$datakegiatan = $this->Db_model->getDataMandiri($data);
   			$deskripsi = array();
   			foreach($datakegiatan as $row)
   			{

   				$deskripsi = json_decode($row['deskripsi'],true);
   				
   				$descstring = $deskripsi['judul_penelitian']."#".$deskripsi['tgl_sk'];

   				$dataarray = array(
					'id_kegiatan'       => $row['id_kegiatan_dosen'],
					//'id_kegiatan'     => 'id',
					'no_sk'             => addslashes($row['no_sk_kontrak']),
					//'no_sk'           => 'no sk',
					'tgl_sk'            => $deskripsi['tgl_sk'],
					//'tgl_sk'          => 'tgl_sk',
					'judul_keg'         => $deskripsi['judul_penelitian'],
					//'judul_keg'       => 'judul',
					'nip'               => $row['nip'],
					//'nip'             => 'nip',
					'nama_dosen'        => $row['nama'],
					//'nama_dosen'      => 'nama',
					'induk_kegiatan'    => $row['nama_induk'],
					//'induk_kegiatan'  => 'induk',
					'kode_kegiatan'     => $row['kode_kegiatan'],
					'tgl_entry'         => $row['tanggal_entry']
					//'uuid_penelitian' => 'uuid'
   					);

   				array_push($datakirim, $dataarray);
   			}

   			echo json_encode($datakirim);

   			//redirect('penelitian/ListPenelitianMandiri','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
	}
	
	public function getDataPenelitianMandiri()
	{
		$data['id_kegiatan'] = $_GET['id_kegiatan'];
		
		$datakegiatan = $this->Db_model->getPenelitianidKeg($data);
		$deskripsi = array();
		$datakirim = array();
		foreach($datakegiatan as $row)
		{
			$data['nip'] = $row['id_dosen'];
			$datadosen = $this->Db_model->getDataDosen($data);
			$data['kode_kegiatan'] = $row['kode_kegiatan'];
			$kegiatan = $this->Db_model->getKegiatanByKodeKegiatan($data);
			$deskripsi = json_decode($row['deskripsi'],true);

			$dataarray = array(
				'nama_dosen' => $datadosen[0]['nama'],
				'nip'        => $row['id_dosen'],
				'kode_keg'   => $row['kode_kegiatan'],
				'nama_keg'   => $kegiatan[0]['nama'],
				'judul_keg'  => $deskripsi['judul_penelitian'],
				'no_sk'      => $row['no_sk_kontrak'],
				'tgl_sk'     => $deskripsi['tgl_sk'],
				'tgl_keg'    => $row['tanggal_kegiatan'],
				'jml_bulan'  => $deskripsi['dari'],
				'nama_induk' => $kegiatan[0]['nama_induk'],
				);

			array_push($datakirim, $dataarray);
		}

		echo json_encode($datakirim);

	}

	
	public function EntryPenelitianApbn()
	{

		if($this->session->userdata('sess_operator'))
   		{
	   		$session_data = $this->session->userdata('sess_operator');
	   		$datakegiatan = $this->Db_model->getKegiatanPenelitianDibiayai();
	   		$dataSkema 	  = $this->Db_model->getSkemaPenelitian();
	   		$data = array('datasession' => $session_data, 'kegiatan' => $datakegiatan, 'skema'=> $dataSkema);
	   		$data['page'] = 'PenelitianAPBN';
			$this->template->view('template/EntryApbn','template/nav_penelitian',$data);

		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
				
	}

	public function getBerkasMandiri()
	{
		$data['no_sk'] = "SK/asasklk";
		$kegiatan      = $this->Db_model->getSKNoSK($data);
		$deskripsi     = json_decode($kegiatan[0]['deskripsi'],true);
		$tgl_sk        = explode("-", $deskripsi['tgl_sk']);
		$pathfiles     = "assets/files/".$tgl_sk[0]."/";
		if(!is_dir($pathfiles)) //create the folder if it's not already exists
		    {
		      mkdir($pathfiles,0777,TRUE);
		    } 
		$filenamearray = explode("/", $data['no_sk']);
		$filename      = implode("_", $filenamearray);
		$filename      = $filename."_"."Penelitian.pdf";
		$pathsave      = $pathfiles.$filename;
		$pathberkas    = base_url().$pathfiles.$filename;
		if (file_exists($pathsave))
		{
			$dataarray = array(
				'filename'    => $filename,
				'path_berkas' => $pathberkas,
				);
		}
		else
		{
			$dataarray = array(
				'filename'    => "Belum Ada Berkas",
				'path_berkas' => "#",
				);
		}

		echo json_encode($dataarray);
	}

	public function ListPenelitianApbn()
	{

		if($this->session->userdata('sess_operator'))
   		{
			$session_data = $this->session->userdata('sess_operator');
			$dataSkema    = $this->Db_model->getSkemaPenelitian();
			$data         = array('datasession' => $session_data,'skema'=> $dataSkema );
			
			$data['page'] = 'PenelitianAPBN';
			$this->template->view('template/ListPenelitianApbn','template/nav_penelitian',$data);
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
		
	}

	public function tesGetdataAPBN()
	{
		$data['bulan'] = 0;
		$data['tahun'] = 2017;
		print_r($this->Db_model->getDataApbnBulanTahun($data));
	}

	public function getDataPApbnBulanTahun()
	{
		if($this->session->userdata('sess_operator'))
   		{
   			$session_data = $this->session->userdata('sess_operator');
   			
   			$data['tahun'] = $_GET['tahun'];
   			$data['bulan'] = $_GET['bulan'];
   			$datakirim = array();
   			$datakegiatan = $this->Db_model->getDataApbnBulanTahun($data);
   			$deskripsi = array();
   			foreach($datakegiatan as $row)
   			{
   				$deskripsi = json_decode($row['deskripsi'],true);
   				$descstring = $deskripsi['judul_penelitian']."#".$deskripsi['skema_penelitian']."#".$deskripsi['tgl_sk'];
   				$dataarray = array(
					'id_kegiatan' => $row['id_kegiatan_dosen'],
					'no_sk'       => $row['no_sk_kontrak'],
					'tgl_sk'      => $deskripsi['tgl_sk'],
					'judul_keg'   => $deskripsi['judul_penelitian']
   					);

   				array_push($datakirim, $dataarray);
   			}
   			echo json_encode($datakirim);
   			redirect('penelitian/ListPenelitianApbn','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
	}
	
	public function getDataPenelitianApbn()
	{
		$data['no_sk']   = $_GET['noSK'];
		//$data['no_sk'] = "SK/Dibiayai";
		$datakegiatan    = $this->Db_model->getPenelitianbyNoSK($data);
		$deskripsi       = array();
		$datakirim       = array();

		foreach($datakegiatan as $row)
		{
			$data['nip']           = $row['id_dosen'];
			$datadosen             = $this->Db_model->getDataDosen($data);
			$data['kode_kegiatan'] = $row['kode_kegiatan'];
			$kegiatan              = $this->Db_model->getKegiatanByKodeKegiatan($data);
			$deskripsi             = json_decode($row['deskripsi'],true);

			$dataarray = array(
				'nama_dosen'       => $datadosen[0]['nama'],
				'nip'              => $row['id_dosen'],
				'kode_keg'         => $row['kode_kegiatan'],
				'nama_keg'         => $kegiatan[0]['nama'],
				'judul_keg'        => $deskripsi['judul'],
				'no_sk'            => $data['no_sk'],
				'tgl_sk'           => $deskripsi['tgl_sk'],
				'skema_penelitian' => $deskripsi['skema_penelitian'],
				'tgl_keg'          => $row['tanggal_kegiatan'],
				);

			array_push($datakirim, $dataarray);
		}
		echo json_encode($datakirim);

	}


	public function deleteData()
	{
		$session_data          = $this->session->userdata('sess_operator');
		$data['id_user']       =$session_data['name'];
		$d                     = explode("#-#",$_POST['id_kegiatan']);
		$data['no_sk_kontrak'] =$d[0];
		$data['kode_kegiatan'] =$d[1];
		$data['tanggal_entry'] =$d[2];

		$res = $this->Db_model->deleteKegiatanDosenByid($data);

		echo $res;
	}
	
	

	public function getKegiatanByInduk()
	{
		$data['induk'] = $_GET['kode'];
		$data['kode_kegiatan'] = $_GET['kode'];
		$datakirim = array();
		$datakegiatan = $this->Db_model->getKegiatanByKodeKegiatan($data);
		if($datakegiatan[0]['bobot_sks']==null)
		{
			$kegiatan = $this->Db_model->getKegiatanByKodeInduk($data);
			echo json_encode($kegiatan);
		}
		else
		{
			echo json_encode($datakegiatan);
		}

		
	}

	public function getDataDosenByFakultas()
	{
		$session_data = $this->session->userdata('sess_operator');
		$data['fakultas'] = $session_data['idFakultas'];
		$res = $this->Db_model->getDataDosenByFakultas($data['fakultas']);

		echo json_encode($res);
	}

	public function SubmitDataMandiri()
	{
		if($this->session->userdata('sess_operator'))
   		{
			$session_data     = $this->session->userdata('sess_operator');
			date_default_timezone_set('Asia/Jakarta');
			$nip              = $_POST['nip'];
			//$kegiatan       = $_POST['kegiatan'];
			$no_sk            = $_POST['sk'];
			$tgl_sk           = $_POST['tgl_sk'];
			$judul_penelitian = $_POST['judul_penelitian'];
			$tgl_keg          = explode('-',$_POST['tgl_mulai']);
			$jml_bulan        = $_POST['jml_bulan'];
			$tgl_entry        = date("Y-m-d h:m:s");
			$jumlah           = count($nip);
   			
   			$q = $this->db->query("select UUID_SHORT() as uuid");
			$dUuid = $q->result_array();

   			for($i=0; $i<$jumlah; $i++){
   				for($x=0;$x<$jml_bulan;$x++){
   					if(($tgl_keg[1]+$x) > 12){
   						$thn = $tgl_keg[0]+1;
   						$bln = ($tgl_keg[1]+$x) - 12;
   					}else{
   						$bln = $tgl_keg[1]+$x;
   						$thn = $tgl_keg[0];
   					}

	   				$deskripsi = array(
						'judul_penelitian' => $judul_penelitian,
						'tgl_sk'           => $tgl_sk,
						'bln_ke'           => ($x+1),
						'dari'             => $jml_bulan,
						'tgl_mulai'        => $_POST['tgl_mulai'],
						'uuid_penelitian'  => $dUuid[0]['uuid']
	   				);
					$data['nip']           = $_POST['nip'][$i];
					$datadosen             = $this->Db_model->getDataDosen($data);
					$data['tgl_entry']     = $tgl_entry;
					$data['id_user']       = $session_data['name'];
					$data['id_prodi']      = $datadosen[0]['id_program_studi'];
					$data['tgl_keg']       = $thn.'-'.$bln.'-'.$tgl_keg[2];
					$data['kode_kegiatan'] = $_POST['kegiatan'][$i];
					$data['sks']           = 1;
					$data['deskripsi']     = json_encode($deskripsi);
					$data['no_sk']         = $no_sk;
					$data['status']        = 0;

	   				$res = $this->Db_model->entryKegiatan($data);  
	   			} 				
   			}

   			redirect('Penelitian/ListPenelitianMandiri','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}	
	}

	public function SubmitDataAPBN()
	{
		if($this->session->userdata('sess_operator'))
   		{
			$session_data     = $this->session->userdata('sess_operator');
			$nip              = $_POST['nip'];
			$judul_penelitian = $_POST['judul_penelitian'];
			$no_sk            = $_POST['sk'];
			$tgl_sk           = $_POST['tgl_sk'];
			$skema_penelitian = $_POST['skema_penelitian'];
			$tgl_keg          = $_POST['tgl_mulai'];
			$tgl_entry        = date("Y-m-d h:m:s");
			$jumlah           = count($nip);
   			$deskripsi = array(
				'judul_penelitian' => $judul_penelitian,
				'skema_penelitian' => $skema_penelitian,
				'tgl_sk'           => $tgl_sk,
   				);

   			for($i=0; $i<$jumlah; $i++)
   			{
				$data['nip']           = $_POST['nip'][$i];
				$datadosen             = $this->Db_model->getDataDosen($data);
				$data['tgl_entry']     = $tgl_entry;
				$data['id_user']       = $session_data['name'];
				$data['id_prodi']      = $datadosen[0]['id_program_studi'];
				$data['tgl_keg']       = $tgl_keg;
				$data['kode_kegiatan'] = $_POST['kegiatan'][$i];
				$data['sks']           = 1;
				$data['deskripsi']     = json_encode($deskripsi);
				$data['no_sk']         = $no_sk;
				$data['status']        = 0;
				$res                   = $this->Db_model->entryKegiatan($data);   				
   			}
   			redirect('Penelitian/ListPenelitianApbn','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}	
	}

	public function UpdatePenelitianMandiri()
	{
		$session_data      = $this->session->userdata('sess_operator');	
		$data['no_sk']     = $_POST['no_sk'];
		$data['tgl_sk']    = $_POST['tgl_sk'];
		$data['judul_keg'] = $_POST['nama_penelitian'];
		$data['tgl_keg']   = $_POST['tgl_keg'];
		$data['tgl_entry'] = date("Y-m-d h:m:s");
		$nip               = $_POST['nip'];
		$jumlahNew         = count($nip);
		$datalama          = $this->Db_model->getPenelitianbyNoSK($data);
		$niplama           = array();
		
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
						$statusdelete = $this->Db_model->deletePenelitianDosenMandiri($data);
					}
				}
			}
			$databaru = $this->Db_model->getPenelitianbyNoSK($data);
			
			foreach($databaru as $row)
			{
				$data['riwayat']       = $row['id_kegiatan_dosen'];
				$data['id_user']       = $session_data['name'];
				$data['kode_kegiatan'] = $row['kode_kegiatan'];
				$data['sks']           = $row['sks'];
				$deskripsilama         = json_decode($row['deskripsi'],true);
				$deskripsi             = array(
				'judul_penelitian'     => $data['judul_keg'],
				'tgl_sk'               => $data['tgl_sk'],
				);
				$data['deskripsi']     = json_encode($deskripsi);
				$data['nip']           = $row['id_dosen'];
				$data['prodi']         = $row['id_program_studi'];
				$updatestatus          = $this->Db_model->updatePenelitianDosenMandiri($data);
			}
		}
		else
		{
			foreach($datalama as $row)
			{
				$data['riwayat']       = $row['id_kegiatan_dosen'];
				$data['id_user']       = $session_data['name'];
				$data['kode_kegiatan'] = $row['kode_kegiatan'];
				$data['sks']           = $row['sks'];
				$deskripsilama         = json_decode($row['deskripsi'],true);
				$deskripsi             = array(
				'judul_penelitian'     => $data['judul_keg'],
				'tgl_sk'               => $data['tgl_sk'],
				);
				$data['deskripsi']     = json_encode($deskripsi);
				$data['nip']           = $row['id_dosen'];
				$data['prodi']         = $row['id_program_studi'];
				$updatestatus          = $this->Db_model->updatePenelitianDosenMandiri($data);
			}
		}

		return $updatestatus;
	}

	public function UpdatePenelitianAPBN()
	{
		$session_data             = $this->session->userdata('sess_operator');	
		$data['no_sk']            = $_POST['no_sk'];
		$data['tgl_sk']           = $_POST['tgl_sk'];
		$data['judul_keg']        = $_POST['nama_penelitian'];
		$data['tgl_keg']          = $_POST['tgl_keg'];
		$data['skema_penelitian'] = $_POST['skema_penelitian_modal'];
		$data['tgl_entry']        = date("Y-m-d h:m:s");
		$nip                      = $_POST['nip'];
		$jumlahNew                = count($nip);
		$datalama                 = $this->Db_model->getPenelitianbyNoSK($data);
		$niplama                  = array();
		
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
						$statusdelete = $this->Db_model->deletePenelitianDosenMandiri($data);
					}
				}
			}
			$databaru = $this->Db_model->getPenelitianbyNoSK($data);
			foreach($databaru as $row)
			{
				$data['riwayat'] = $row['id_kegiatan_dosen'];
				
				$data['id_user'] = $session_data['name'];
				$data['kode_kegiatan'] = $row['kode_kegiatan'];
				$data['sks'] = $row['sks'];
				//$deskripsilama = json_decode($row['deskripsi'],true);
				$deskripsi = array(
						
						'judul' => $data['judul_keg'],
						'skema_penelitian' => $data['skema_penelitian'],
   						'tgl_sk' => $data['tgl_sk'],

					);
				$data['deskripsi'] = json_encode($deskripsi);
				$data['nip'] = $row['id_dosen'];
				$data['prodi'] = $row['id_program_studi'];
				$updatestatus = $this->Db_model->updatePenelitianDosenDibiayai($data);
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
				//$deskripsilama = json_decode($row['deskripsi'],true);
				$deskripsi = array(
						'judul' => $data['judul_keg'],
						'skema_penelitian' => $data['skema_penelitian'],
   						'tgl_sk' => $data['tgl_sk'],

					);
				$data['deskripsi'] = json_encode($deskripsi);
				$data['nip'] = $row['id_dosen'];
				$data['prodi'] = $row['id_program_studi'];
				$updatestatus = $this->Db_model->updatePenelitianDosenDibiayai($data);
			}
		}

		return $updatestatus;
	}


	
}
/*
public function EntryPenelitianDosen()
	{

		if($this->session->userdata('sess_operator'))
   		{
   		$session_data = $this->session->userdata('sess_operator');
   		$dataDosen = $this->Db_model->get_Dosen($session_data['id_program_studi']);
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$dataPenelitian = $this->Db_model->get_Penelitian($session_data['id_program_studi']);
		$dataKegiatan = $this->Db_model->get_Data_Kegiatan("2");


		$data =  array('dataDosen' => $dataDosen , 'namaJurusan' => $namaJurusan, 'dataKegiatan' => $dataKegiatan, 'datasession' => $session_data, 'dataPenelitian' => $dataPenelitian);
		$this->template->view('template/dosen_penelitian','template/nav_penelitian',$data);
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
				
	}

	public function do_insertPenelitian()
	{
		$session_data = $this->session->userdata('sess_operator');
		 $id_dosen = $_POST['id_dosen'];
         $kode_kegiatan = $_POST['kode_kegiatan'];
         $tgl_kegiatan = $_POST['tgl_kegiatan'];
         $tanggal =  explode("/", $tgl_kegiatan);
		 $tgl_kegiatan = $tanggal[2]."-".$tanggal[0]."-".$tanggal[1];
         $sks = $_POST['sks'];
         $deskripsi = $_POST['deskripsi'];
         $no_sk_kontrak = $_POST['no_sk_kontrak'];
         $id_operator = $session_data['name'];

         $tanggal = date("Y-m-d H:i:s");

         $data_insert = array(
				
				'tanggal_entry' => $tanggal,
				'id_operator' => $id_operator,
				'id_dosen' => $id_dosen,
				'tanggal_kegiatan' => $tgl_kegiatan,
				'kode_kegiatan' => $kode_kegiatan,
				'id_program_studi' => $session_data['id_program_studi'],
				'sks' => $sks,
				'deskripsi' => $deskripsi,
				'no_sk_kontrak' =>$no_sk_kontrak,
				'tarif' => '0',
				'id_pembayaran' => '0',
			);

		try{
		$res = $this->db->insert('kegiatan_dosen',$data_insert);
		//echo $this->db->_error_message(); 
		}catch (Exception $e){
			echo "aa";
		}
		if($res>=1)
		{
			echo "1";
			//redirect('pengajaran/EntryMataKuliah');
   		
		}
		else
		{
			echo "gagal";
			//redirect('pengajaran/tambahmk');
		}

	}

	public function do_ubahPenelitian()
	{
		 if($this->session->userdata('sess_operator'))
		 {
		 $session_data = $this->session->userdata('sess_operator');
		 $id_dosen = $_POST['id_dosenubah'];
		 $temp_id_kegiatan_dosen = $_POST['temp_id_kegiatan_dosen'];
         $kode_kegiatan = $_POST['kode_kegiatanubah'];
         $tgl_kegiatan = $_POST['tgl_kegiatanubah'];
         $tanggal =  explode("/", $tgl_kegiatan);
		 $tgl_kegiatan = $tanggal[2]."-".$tanggal[0]."-".$tanggal[1];
         $sks = $_POST['sksubah'];
         $deskripsi = $_POST['deskripsiubah'];
         $no_sk_kontrak = $_POST['no_sk_kontrakubah'];
         $id_operator = $session_data['name'];

         $tanggal = date("Y-m-d H:i:s");

         $data_insert = array(
				
				'tanggal_entry' => $tanggal,
				'id_operator' => $id_operator,
				'id_dosen' => $id_dosen,
				'tanggal_kegiatan' => $tgl_kegiatan,
				'kode_kegiatan' => $kode_kegiatan,
				'id_program_studi' => $session_data['id_program_studi'],
				'sks' => $sks,
				'deskripsi' => $deskripsi,
				'no_sk_kontrak' =>$no_sk_kontrak,
				'tarif' => '0',
				'id_pembayaran' => '0',
			);

		try{

		$this->db->where('id_kegiatan_dosen',$temp_id_kegiatan_dosen);
		$this->db->update('kegiatan_dosen',$data_insert);
		//echo $this->db->_error_message(); 
		echo "1";
		}catch (Exception $e){
			echo "aa";
		}
		
			
			//redirect('pengajaran/EntryMataKuliah');
   		
		

		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}

		

	}

	public function do_deletePenelitian($id_kegiatandosen)
	{
		if($this->session->userdata('sess_operator'))
   		{
   		
   			
		
		try{
		
		$this->db->where('id_kegiatan_dosen', $id_kegiatandosen);
		$this->db->delete('kegiatan_dosen'); 
		//echo $this->db->_error_message(); 
		}catch (Exception $e){
			echo "aa";
		}
		
		
			redirect('penelitian/EntryPenelitianDosen');
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
	
	}

	public function EntryPublikasiKaryaIlmiah()
	{

		if($this->session->userdata('sess_operator'))
   		{
   		$session_data = $this->session->userdata('sess_operator');
   		/*$dataDosen = $this->Db_model->get_Dosen($session_data['id_program_studi']);
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$dataPenelitian = $this->Db_model->get_Penelitian($session_data['id_program_studi']);
		$dataKegiatan = $this->Db_model->get_Data_Kegiatan("2");*/


		/*$data =  array('dataDosen' => $dataDosen , 'namaJurusan' => $namaJurusan, 'dataKegiatan' => $dataKegiatan, 'datasession' => $session_data, 'dataPenelitian' => $dataPenelitian);*/
	/*		$datakegiatan = $this->Db_model->getKegiatanPenelitian();
   			$data = array('datasession' => $session_data, 'kegiatan' => $datakegiatan,);


   			
   			
		//echo json_encode($datakegiatan);

		$this->template->view('template/EntryPublikasiKaryaIlmiah','template/nav_penelitian',$data);
		//$this->template->view('template/entrySK',$data,$datakirim);
		

		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
				
	}
	

	public function EntryKonferensiIlmiah()
	{

		if($this->session->userdata('sess_operator'))
   		{
   		$session_data = $this->session->userdata('sess_operator');
   	
		$datakegiatan = $this->Db_model->getKegiatanPenelitian();
		$data = array('datasession' => $session_data, 'kegiatan' => $datakegiatan,);


		$this->template->view('template/EntryKonferensiIlmiah','template/nav_penelitian',$data);
		//$this->template->view('template/entrySK',$data,$datakirim);
		

		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
				
	}

	public function EntryMenulisKaryailmiah()
	{

		if($this->session->userdata('sess_operator'))
   		{
   		$session_data = $this->session->userdata('sess_operator');
   		/*$dataDosen = $this->Db_model->get_Dosen($session_data['id_program_studi']);
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$dataPenelitian = $this->Db_model->get_Penelitian($session_data['id_program_studi']);
		$dataKegiatan = $this->Db_model->get_Data_Kegiatan("2");*/


		/*$data =  array('dataDosen' => $dataDosen , 'namaJurusan' => $namaJurusan, 'dataKegiatan' => $dataKegiatan, 'datasession' => $session_data, 'dataPenelitian' => $dataPenelitian);*/
			/*$datakegiatan = $this->Db_model->getKegiatanPenelitian();
   			$data = array('datasession' => $session_data, 'kegiatan' => $datakegiatan,);


   			
   			
		//echo json_encode($datakegiatan);

		$this->template->view('template/EntryMenulisKaryailmiah','template/nav_penelitian',$data);
		//$this->template->view('template/entrySK',$data,$datakirim);
		

		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
				
	}
public function submitDataPublikasiKarya()
	{
		if($this->session->userdata('sess_operator'))
   		{
   			$session_data = $this->session->userdata('sess_operator');
   			
   			$nip = $_POST['nip'];
   			$kegiatan = $_POST['kegiatan'];
   			$no_sk = $_POST['sk'];
   			$tgl_sk = $_POST['tgl_sk'];
   			$nama_keg = $_POST['nama_kegiatan'];
   			$tempat_publikasi = $_POST['tempat_publikasi'];
   			$tgl_entry = date("Y-m-d h:m:s");
   			$jumlah = count($nip);
   			$deskripsi = array(
   				'judul' => $nama_keg,
   				'tempat_publikasi' => $tempat_publikasi,
   				);

   			for($i=0; $i<$jumlah; $i++)
   			{

   				$data['nip'] = $_POST['nip'][$i];
   				$datadosen = $this->Db_model->getDataDosen($data);
   				$data['tgl_entry'] = $tgl_entry;
   				$data['id_user'] = $session_data['name'];
   				$data['id_prodi'] = $datadosen[0]['id_program_studi'];
   				$data['tgl_keg'] = $tgl_keg;
   				$data['kode_kegiatan'] = $_POST['kegiatan'][$i];
   				$data['sks'] = 1;
   				$data['deskripsi'] = json_encode($deskripsi);
   				$data['no_sk'] = $no_sk;

   				$res = $this->Db_model->entryKegiatan($data);   				
   			}

   			redirect('MainControler','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}	
	}

	public function submitDataKonferensiIlmiah()
	{
		if($this->session->userdata('sess_operator'))
   		{
   			$session_data = $this->session->userdata('sess_operator');
   			
   			$nip = $_POST['nip'];
   			$kegiatan = $_POST['kegiatan'];
   			$no_sk = $_POST['sk'];
   			$tgl_sk = $_POST['tgl_sk'];
   			$nama_keg = $_POST['nama_konferensi'];
   			$tempat_konferensi	= $_POST['tempat_konferensi'];
   			$tgl_keg = $_POST['tgl_keg'];
   			$tgl_entry = date("Y-m-d h:m:s");
   			$jumlah = count($nip);
   			$deskripsi = array(
   				'nama_konferensi' => $nama_keg,
   				'tempat_konferensi' => $tempat_konferensi,
   			
   				);

   			for($i=0; $i<$jumlah; $i++)
   			{

   				$data['nip'] = $_POST['nip'][$i];
   				$datadosen = $this->Db_model->getDataDosen($data);
   				$data['tgl_entry'] = $tgl_entry;
   				$data['id_user'] = $session_data['name'];
   				$data['id_prodi'] = $datadosen[0]['id_program_studi'];
   				$data['tgl_keg'] = $tgl_keg;
   				$data['kode_kegiatan'] = $_POST['kegiatan'][$i];
   				$data['sks'] = 1;
   				$data['deskripsi'] = json_encode($deskripsi);
   				$data['no_sk'] = $no_sk;

   				$res = $this->Db_model->entryKegiatan($data);   				
   			}

   			redirect('MainControler','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}	
	}





	*/

