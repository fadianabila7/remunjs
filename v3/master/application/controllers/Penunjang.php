<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penunjang extends CI_Controller {


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
		
	}
	public function index()
	{
		if($this->session->userdata('sess_master'))
   		{			
   			$session_data = $this->session->userdata('sess_master');
   			$data = array('datasession' => $session_data );

			$this->template->view('template/content',$data);
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
	}
	
	public function logout()
 	{
   		$this->session->unset_userdata('sess_master');
   		session_destroy();
   		redirect('VerifyLogin', 'refresh');
 	}
	public function login()
	{
		$this->template->loginpage();
	}

	public function getProdi()
	{
		$session_data = $this->session->userdata('sess_master');


   			$dataprodi = $this->MainModel->getDataProdi($session_data['idFakultas']);
   			return $dataprodi;
	}
	public function getStatus()
	{
		$session_data = $this->session->userdata('sess_master');

   			$datastatus = $this->MainModel->getDataStatus();
   			return $datastatus;
	}
	public function getDosen()
	{
		$session_data = $this->session->userdata('sess_master');
		$datadosen = $this->DosenModel->getDataDosenByFakultas($session_data['idFakultas']);
		return $datadosen;
	}

/*-------------------------------------------------- View Controller ------------------------------------*/

	public function DataDosen()
	{

		if($this->session->userdata('sess_master'))
   		{
   			$session_data = $this->session->userdata('sess_master');
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
		else
		{
			redirect('VerifyLogin','refresh');
		}
		
	}

	public function EntrySK()
	{

		if($this->session->userdata('sess_master'))
   		{
   			$session_data = $this->session->userdata('sess_master');
   			$data = array('datasession' => $session_data );
   			$data['page'] = 'penunjang';
   			$datakegiatan = $this->KegiatanModel->getKegiatanPenunjang();
   			$datakirim = array 
   			(
   				'kegiatan' => $datakegiatan
   			);
   			
			$this->template->view('template/entrysk',$data,$datakirim);
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
		
	}

	public function ListSK()
	{

		if($this->session->userdata('sess_master'))
   		{
   			$session_data = $this->session->userdata('sess_master');
   			$data = array('datasession' => $session_data );
   			$data['page'] = 'penunjang';
			$this->template->view('template/listsk',$data,null);
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
		
	}
	
	
	public function submitDataSK()
	{
		if($this->session->userdata('sess_master'))
   		{
   			$session_data = $this->session->userdata('sess_master');

   			$nip = $_POST['nip'];
   			$kegiatan = $_POST['kegiatan'];
   			$no_sk = $_POST['sk'];
   			$tgl_sk = $_POST['tgl_sk'];
   			$nama_keg = $_POST['nama_keg'];
   			$tgl_keg = $_POST['tgl_keg'];
   			$tgl_entry = date("Y-m-d h:m:s");
   			
   			
   			$jumlah = count($nip);
   			$deskripsi = array(
   				'judul' => $nama_keg,
   				'tgl_sk' => $tgl_sk,
   				'nilai' => 0,
   				'nama_berkas' => null,
   				);

   			for($i=0; $i<$jumlah; $i++)
   			{

   				$data['nip'] = $_POST['nip'][$i];
   				$datadosen = $this->DosenModel->getDataDosen($data);
   				$data['tgl_entry'] = $tgl_entry;
   				$data['id_user'] = $session_data['name'];
   				$data['id_prodi'] = $datadosen[0]['id_program_studi'];
   				$data['tgl_keg'] = $tgl_keg;
   				$data['kode_kegiatan'] = $_POST['kegiatan'][$i];
   				$data['sks'] = 1;
   				$datakegiatan = $this->KegiatanModel->getKegiatanByKodeKegiatan($data);
   				$deskripsi['posisi'] = $datakegiatan[0]['nama'];
   				$data['deskripsi'] = json_encode($deskripsi);
   				$data['no_sk'] = $no_sk;

   				$res = $this->KegiatanModel->entryKegiatan($data);   				
   			}

   			redirect('Penunjang/ListSK','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}	
	}

	public function getDataSKBulanTahun()
	{
		if($this->session->userdata('sess_master'))
   		{
   			$session_data = $this->session->userdata('sess_master');
   			
   			$data['tahun'] = $_GET['tahun'];
   			$data['bulan'] = $_GET['bulan'];
   			$datakirim = array();
   			$datakegiatan = $this->KegiatanModel->getSKBulanTahun($data);
   			$deskripsi = array();
   			foreach($datakegiatan as $row)
   			{

   				$deskripsi = json_decode($row['deskripsi'],true);
   				
   				$descstring = $deskripsi['judul']."#".$deskripsi['tgl_sk']."#".$deskripsi['nilai'];

   				$dataarray = array(
   					'no_sk' => $row['no_sk_kontrak'],
   					'tgl_sk' => $deskripsi['tgl_sk'],
   					'judul_keg' => $deskripsi['judul']

   					);

   				array_push($datakirim, $dataarray);
   			}

   			echo json_encode($datakirim);

   			redirect('MainControler','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
	}

	public function getDataKegiatanByNoSK()
	{
		$data['no_sk'] = $_GET['no_sk'];
		
		$datakegiatan = $this->KegiatanModel->getSKNoSK($data);
		$deskripsi = array();
		$datakirim = array();
		foreach($datakegiatan as $row)
		{
			$data['nip'] = $row['id_dosen'];
			$datadosen = $this->DosenModel->getDataDosen($data);
			$data['kode_kegiatan'] = $row['kode_kegiatan'];
			$kegiatan = $this->KegiatanModel->getKegiatanByKodeKegiatan($data);
			$deskripsi = json_decode($row['deskripsi'],true);

			$dataarray = array(
				'nama_dosen' => $datadosen[0]['nama'],
				'nip' => $row['id_dosen'],
				'kode_keg' => $row['kode_kegiatan'],
				'nama_keg' => $kegiatan[0]['nama'],
				'judul_keg' => $deskripsi['judul'],
				'no_sk' => $data['no_sk'],
				'tgl_sk' => $deskripsi['tgl_sk'],
				'tgl_keg' => $row['tanggal_kegiatan'],
				);

			array_push($datakirim, $dataarray);
		}

		echo json_encode($datakirim);

	}

	public function deleteDataSK()
	{
		$data['no_sk'] = $_POST['no_sk'];

		$res = $this->KegiatanModel->deleteKegiatanDosenBySK($data);

		echo $res;
	}

	public function updateDataSK()
	{
		$session_data = $this->session->userdata('sess_master');	
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
				$deskripsi = array(
						'judul' => $data['judul_keg'],
						'tgl_sk' => $data['tgl_sk'],
						'nilai' => $deskripsilama['nilai'],
						'nama_berkas' => $deskripsilama['nama_berkas'],
						'posisi' => $deskripsilama['posisi'],

					);
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
				$deskripsi = array(
						'judul' => $data['judul_keg'],
						'tgl_sk' => $data['tgl_sk'],
						'nilai' => $deskripsilama['nilai'],
						'nama_berkas' => $deskripsilama['nama_berkas'],
						'posisi' => $deskripsilama['posisi'],
					);
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
		if($datakegiatan[0]['bobot_sks']==null)
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
		$filename = $filename."_"."Penunjang.pdf";
		
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
					'tgl_sk' => $deskripsilama['tgl_sk'],
					'nilai' => $deskripsilama['nilai'],
					'nama_berkas' => $filename,
					'posisi' => $deskripsilama['posisi'],
					);
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

}
