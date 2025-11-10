<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penunjang extends CI_Controller {

	

	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
	}

	public function index()
	{
		if($this->session->userdata('sess_kegiatan'))
   		{
   			$session_data = $this->session->userdata('sess_kegiatan');
   			$data = array('datasession' => $session_data );	
			$this->template->view('template/infoPenunjang','template/nav_penunjang',$data);
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
	}

	public function EntryPenunjangDosen()
	{
		if($this->session->userdata('sess_kegiatan'))
   		{
			$session_data  = $this->session->userdata('sess_kegiatan');
			$dataDosen     = $this->db_model->get_Dosen($session_data['id_program_studi']);
			$namaJurusan   = $this->db_model->get_Nama_Prodi($session_data['id_program_studi']);
			$dataPenunjang = $this->db_model->get_Penunjang($session_data['id_program_studi']);
			$dataKegiatan  = $this->db_model->get_Data_Kegiatan("4");
			$data          = array('dataDosen' => $dataDosen , 'namaJurusan' => $namaJurusan, 'dataKegiatan' => $dataKegiatan, 'datasession' => $session_data, 'dataPenunjang' => $dataPenunjang );	
			$this->template->view('template/dosen_penunjang','template/nav_penunjang',$data);
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
		

	}

	public function do_insertPenunjang()
	{
		$session_data  = $this->session->userdata('sess_kegiatan');
		$id_dosen      = $_POST['id_dosen'];
		$kode_kegiatan = $_POST['kode_kegiatan'];
		$tgl_kegiatan  = $_POST['tgl_kegiatan'];
		$tanggal       =  explode("/", $tgl_kegiatan);
		$tgl_kegiatan  = $tanggal[2]."-".$tanggal[0]."-".$tanggal[1];
		$sks           = $_POST['sks'];
		$deskripsi     = $_POST['deskripsi'];
		$no_sk_kontrak = $_POST['no_sk_kontrak'];
		$id_operator   = $session_data['name'];
		$tanggal       = date("Y-m-d H:i:s");
		
		$data_insert   = array(
			'tanggal_entry'    => $tanggal,
			'id_operator'      => $id_operator,
			'id_dosen'         => $id_dosen,
			'tanggal_kegiatan' => $tgl_kegiatan,
			'kode_kegiatan'    => $kode_kegiatan,
			'id_program_studi' => $session_data['id_program_studi'],
			'sks'              => $sks,
			'deskripsi'        => $deskripsi,
			'no_sk_kontrak'    =>$no_sk_kontrak,
			'tarif'            => '0',
			'id_pembayaran'    => '0',
		);

		try{
			$res = $this->db->insert('kegiatan_dosen',$data_insert);
			//echo $this->db->_error_message(); 
		}catch (Exception $e){
			echo "aa";
		}

		echo ($res>=1)? "1" : "gagal";

	}

	public function do_ubahPenunjang()
	{
		 if($this->session->userdata('sess_kegiatan'))
		 {
		 $session_data = $this->session->userdata('sess_kegiatan');
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

	public function do_deletePenunjang($id_kegiatandosen)
	{
		if($this->session->userdata('sess_kegiatan'))
   		{
   		
   			
		
		try{
		
		$this->db->where('id_kegiatan_dosen', $id_kegiatandosen);
		$this->db->delete('kegiatan_dosen'); 
		//echo $this->db->_error_message(); 
		}catch (Exception $e){
			echo "aa";
		}
		
		
			redirect('penunjang/EntryPenunjangDosen');
		}		
		else
		{
			redirect("VerifyLogin",'refresh');
		}
	
	}


}
