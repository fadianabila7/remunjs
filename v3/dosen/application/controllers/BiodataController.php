<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BiodataController extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->model('DosenModel');
		$this->load->model('GolonganModel');
		$this->load->model('PendidikanModel');
		$this->load->model('FungsionalModel');
		$this->load->model('StrukturalModel');

		if(!$this->session->userdata('sess_dosen')){
			redirect('VerifyLogin','refresh');
		}
		
	}

	/*------------------------------------------- Data Riwayat Controller -------------------------------------*/

	public function getDataRiwayat()
	{
		$data['prodi'] = $_GET['prodi'];
		$data['status'] = $_GET['status'];
		$session_data = $this->session->userdata('sess_dosen');
		$data['fakultas'] = $session_data['idFakultas'];
		$res = $this->MainModel->getRiwayat($data);

		echo json_encode($res);

	}

	public function BiodataTerkini(){
		$session_data = $this->session->userdata('sess_dosen');
		$data = array('datasession' => $session_data );

		// print_r($data);

		$session_data = $this->session->userdata('sess_dosen');
		$data['nip'] = $session_data['idDosen'];

		$datadosen = $this->DosenModel->getDataDosen($data);
		$datagolongan = $this->GolonganModel->getGolonganByIDDosen($data);
		$datapendidikan = $this->PendidikanModel->getPendidikanByIDDosen($data);
		$datafungsional = $this->FungsionalModel->getFungsionalByIDDosen($data);
		$datastruktural = $this->StrukturalModel->getStrukturalByIDDosen($data);

		$data['menuextend'] = @$datastruktural[0]['id_jabatan_struktural'];
		if(!isset($data['menuextend'])){
			$data['menuextend'] = "Data Struktural Belum Di Entry";
		}
		$dataisi = array(
				'dosen' => $datadosen,
				'golongan' => $datagolongan,
				'pendidikan' => $datapendidikan,
				'fungsional' => $datafungsional,
				'struktural' => $datastruktural,
			 );

		$this->template->view('template/biodata',$data,$dataisi);
	}

}
