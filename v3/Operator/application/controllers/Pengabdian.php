<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengabdian extends CI_Controller {

	

	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
	}

	public function index()
	{

		if($this->session->userdata('sess_operator'))
   		{
   		$session_data = $this->session->userdata('sess_operator');
   			$data = array('datasession' => $session_data );	
		
		$this->template->view('template/infoPengabdian','template/nav_pengabdian',$data);
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
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

	public function EntryPengabdian()
	{

		if($this->session->userdata('sess_operator'))
   		{
	   		$session_data = $this->session->userdata('sess_operator');
	  		$datakegiatan = $this->Db_model->getKegiatanPengabdian();
	  	/*	$dataSkema	  = $this->Db_model->getSkemaPengabdian();*/
	   		$data = array('datasession' => $session_data, 'kegiatan' => $datakegiatan);
			$this->template->view('template/EntryPengabdianKepadaMasyarakat','template/nav_pengabdian',$data);
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
				
	}

	public function ListPengabdian()
	{
		if($this->session->userdata('sess_operator'))
   		{
   			$session_data = $this->session->userdata('sess_operator');
   			$data = array('datasession' => $session_data );
			$this->template->view('template/ListPengabdian','template/nav_pengabdian',$data);
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
	}

	public function getDataPengabdianBulanTahun()
	{
		if($this->session->userdata('sess_operator'))
   		{
   			$session_data = $this->session->userdata('sess_operator');
   			
   			$data['tahun'] = $_GET['tahun'];
   			$data['bulan'] = $_GET['bulan'];
   			$datakirim = array();
   			$datakegiatan = $this->Db_model->getDataPengabdianBulanTahun($data);
   			$deskripsi = array();
   			foreach($datakegiatan as $row)
   			{

   				$deskripsi = json_decode($row['deskripsi'],true);
   				
   				$descstring = $deskripsi['nama_keg']."#".$deskripsi['tgl_sk'];

   				$dataarray = array(
   					'id_kegiatan' => $row['id_kegiatan_dosen'],
   					'no_sk' => $row['no_sk_kontrak'],
   					'tgl_sk' => $deskripsi['tgl_sk'],
   					'judul_keg' => $deskripsi['nama_keg']

   					);

   				array_push($datakirim, $dataarray);
   			}
   			echo json_encode($datakirim);
   			redirect('pengabdian/ListPengabdian','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}
	}
	
	public function getDataPengabdian()
	{
		$data['no_sk'] = $_GET['noSK'];
		$datakegiatan  = $this->Db_model->getPenelitianbyNoSK($data);
		$deskripsi     = array();
		$datakirim     = array();
		foreach($datakegiatan as $row)
		{
			$data['nip']           = $row['id_dosen'];
			$datadosen             = $this->Db_model->getDataDosen($data);
			$data['kode_kegiatan'] = $row['kode_kegiatan'];
			$kegiatan              = $this->Db_model->getKegiatanByKodeKegiatan($data);
			$deskripsi             = json_decode($row['deskripsi'],true);
			$dataarray             = array(
				'nama_dosen' => $datadosen[0]['nama'],
				'nip'        => $row['id_dosen'],
				'kode_keg'   => $row['kode_kegiatan'],
				'nama_keg'   => $kegiatan[0]['nama'],
				'judul_keg'  => $deskripsi['nama_keg'],
				'no_sk'      => $data['no_sk'],
				'tgl_sk'     => $deskripsi['tgl_sk'],
				'tgl_keg'    => $row['tanggal_kegiatan'],
				);
			array_push($datakirim, $dataarray);
		}
		echo json_encode($datakirim);
	}

	public function updatePengabdian()
	{
		$session_data      = $this->session->userdata('sess_operator');	
		$data['no_sk']     = $_POST['no_sk'];
		$data['tgl_sk']    = $_POST['tgl_sk'];
		$data['judul_keg'] = $_POST['judul_keg'];
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
				$data['riwayat'] = $row['id_kegiatan_dosen'];
				
				$data['id_user'] = $session_data['name'];
				$data['kode_kegiatan'] = $row['kode_kegiatan'];
				$data['sks'] = $row['sks'];
				$deskripsilama = json_decode($row['deskripsi'],true);
				$deskripsi = array(
						
						'nama_keg' => $data['judul_keg'],
   						'tgl_sk' => $data['tgl_sk'],

					);
				$data['deskripsi'] = json_encode($deskripsi);
				$data['nip'] = $row['id_dosen'];
				$data['prodi'] = $row['id_program_studi'];
				$updatestatus = $this->Db_model->updatePenelitianDosenMandiri($data);
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
						'nama_keg' => $data['judul_keg'],
   						'tgl_sk' => $data['tgl_sk'],

					);
				$data['deskripsi'] = json_encode($deskripsi);
				$data['nip'] = $row['id_dosen'];
				$data['prodi'] = $row['id_program_studi'];
				$updatestatus = $this->Db_model->updatePenelitianDosenMandiri($data);
			}
		}

		return $updatestatus;
	}


	public function deleteData()
	{
		$data['id_kegiatan'] = $_POST['id_kegiatan'];

		$res = $this->Db_model->deleteKegiatanDosenByid($data);

		echo $res;
	}

	public function submitDataPengabdian()
	{
		if($this->session->userdata('sess_operator'))
   		{
			$session_data = $this->session->userdata('sess_operator');
			date_default_timezone_set('Asia/Jakarta');
			$nip          = $_POST['nip'];
			//$kegiatan   = $_POST['kegiatan'];
			$no_sk        = $_POST['sk'];
			$tgl_sk       = $_POST['tgl_sk'];
			$nama_keg     = $_POST['nama_keg'];
			$tgl_keg      = $_POST['tgl_keg'];
			$tgl_entry    = date("Y-m-d h:m:s");
			$jumlah       = count($nip);
			$deskripsi    = array(
				'nama_keg' => $nama_keg,
				'tgl_sk'   => $tgl_sk,
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

   			redirect('Pengabdian/ListPengabdian','refresh');
		}
		else
		{
			redirect('VerifyLogin','refresh');
		}	
	}


}
/*

public function EntryPengabdianDosen()
	{


		if($this->session->userdata('sess_operator'))
   		{
   		$session_data = $this->session->userdata('sess_operator');
   		$dataDosen = $this->Db_model->get_Dosen($session_data['id_program_studi']);
		$namaJurusan = $this->Db_model->get_Nama_Prodi($session_data['id_program_studi']);
		$dataPengabdian = $this->Db_model->get_Pengabdian($session_data['id_program_studi']);

   			$data = array('dataDosen' => $dataDosen , 'namaJurusan' => $namaJurusan, 'datasession' => $session_data, 'dataPengabdian' => $dataPengabdian );	
		
		$this->template->view('template/dosen_pengabdian','template/nav_pengabdian',$data);
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
		
		
	}

	public function do_insertPengabdian()
	{
		if($this->session->userdata('sess_operator'))
   		{
		 $session_data = $this->session->userdata('sess_operator');
		 $id_dosen = $_POST['id_dosen'];
         $kode_kegiatan = '79';
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
	else
	{
			redirect("VerifyLogin",'refresh');
	}


	}

	public function do_ubahPengabdian()
	{
		 if($this->session->userdata('sess_operator'))
		 {
		 $session_data = $this->session->userdata('sess_operator');
		 $id_dosen = $_POST['id_dosenubah'];
		 $temp_id_kegiatan_dosen = $_POST['temp_id_kegiatan_dosen'];
         //$kode_kegiatan = $_POST['kode_kegiatanubah'];
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
				'kode_kegiatan' => "79",
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

	public function do_deletePengabdian($id_kegiatandosen)
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
		
		
			redirect('pengabdian/EntryPengabdianDosen');
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
	
	}


	public function submitDataPelayanan()
	{
		if($this->session->userdata('sess_operator'))
   		{
   			$session_data = $this->session->userdata('sess_operator');
   			
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

	public function submitDataPenyuluh()
	{
		if($this->session->userdata('sess_operator'))
   		{
   			$session_data = $this->session->userdata('sess_operator');
   			
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
