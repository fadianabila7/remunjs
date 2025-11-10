<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->model('OperatorModel');
		
	}

	public function entryDataOperator()
	{
		$data['user'] = $_POST['iduser'];
		$data['nama'] = $_POST['nama'];
		$data['prodi'] = $_POST['prodi'];
		$data['notelepon'] = $_POST['notelepon'];
		$data['email'] = $_POST['email'];
		$data['foto'] = $_POST['foto'];

		$res = $this->OperatorModel->entryDataOperator($data);

		if($res)
		{
			redirect('MainControler/dataoperator', 'refresh');
		}
		else
		{
			echo "error";
		}

	}
	public function getDataOperator()
	{
		$data['prodi'] = $_GET['prodi'];
		

		$session_data = $this->session->userdata('sess_master');
		$data['fakultas'] = $session_data['idFakultas'];	

		$res = $this->OperatorModel->getOperator($data);

		echo json_encode($res);
		
	}
	public function getDataOperatorIndividu()
	{
		$data['operator'] = $_GET['operator'];	

		$res = $this->OperatorModel->getDataOperator($data);

		echo json_encode($res);
	
	}
	public function updateDataOperatorIndividu()
	{
		$data['user'] = $_POST['idUser'];
		$data['nama'] = $_POST['nama'];
		$data['operator'] = $_POST['idOperator'];
		$data['prodi'] = $_POST['prodi'];
		
		$data['notelepon'] = $_POST['notelepon'];
		$data['email'] = $_POST['email'];
		$data['foto'] = $_POST['foto'];

		$res = $this->OperatorModel->updateDataOperatorIndividu($data);
		if($res)
		{
			echo "Update Berhasil";
		}
		else
		{
			echo "Update Gagal";
		}
	}
	public function deleteDataOperatorIndividu()
	{
		$data['operator'] = $_POST['operator'];
		$data['user'] = $_POST['user'];
		$res= $this->OperatorModel->deleteDataOperatorIndividu($data);

		if($res)
		{
			echo json_encode("Delete Berhasil");
		}
		else
		{
			echo json_encode("Delete Gagal");
		}
	}

	public function resetPassOperator()
	{
		$data['idUser'] = $_POST['idOperatorReset'];
		$res = $this->OperatorModel->resetPassOperator($data);

		echo json_encode($res);
	}

}