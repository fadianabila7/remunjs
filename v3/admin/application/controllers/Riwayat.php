<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->model('DosenModel');
		$this->load->model('GolonganModel');
		$this->load->model('PendidikanModel');
		$this->load->model('FungsionalModel');
		$this->load->model('StrukturalModel');
	}

	/*------------------------------------------- Data Riwayat Controller -------------------------------------*/

	// public function getDataRiwayat()
	// {
	// 	$data['prodi'] = $_GET['prodi'];
	// 	$data['status'] = $_GET['status'];		
	// 	$session_data = $this->session->userdata('sess_admin');
	// 	$data['fakultas'] = $session_data['idFakultas'];
	// 	$res = $this->MainModel->getRiwayat($data);

	// 	echo json_encode($res);

	// }

	public function getDataRiwayat()
	{
		$data['prodi'] = 0;
		$data['status'] = $_GET['status'];
		$data['fakultas'] = $_GET['fakultas'];
		$res = $this->MainModel->getRiwayat($data);
		echo json_encode($res);
	}

	/* -------------------------------------- Riwayat Golongan Controller --------------------------------------*/

	public function addGolonganIndividu()
	{
		$data['golongan'] = $_POST['gol'];
		$data['tmt'] = $_POST['tmtgol'];
		$data['idDosen'] = $_POST['idDosen'];

		$nip = $this->GolonganModel->getIdDosen($data);
		$data['id_dosen'] = $nip[0]['id_dosen'];
		$res = $this->GolonganModel->addGolonganIndividu($data);
		if ($res) {
			echo json_encode("Tambah Golongan Berhasil");
		} else {
			echo json_encode("Tambah Golongan Gagal");
		}
	}

	public function getGolonganIndividubByIDRiwayat()
	{
		$data['idRiwayatGolongan'] = $_GET['idRiwayatGolongan'];
		$res = $this->GolonganModel->getGolonganByIDRiwayat($data);

		echo json_encode($res);
	}

	public function updateGolonganIndividu()
	{
		$data['idgolongan'] = $_POST['idRiwayatGolongan'];
		$data['golongan'] = $_POST['gol'];
		$data['tmtgolongan'] = $_POST['tmtgol'];

		if (
			!empty($data['idgolongan']) || $data['idgolongan'] != "" || $data['idgolongan'] != "0" ||
			!empty($data['golongan']) || $data['golongan'] != "" || $data['golongan'] != "0" ||
			!empty($data['tmtgolongan']) || $data['tmtgolongan'] != "" || $data['tmtgolongan'] != "0"
		) {
			$res = $this->GolonganModel->updateGolonganIndividu($data);
			if ($res) {
				echo json_encode("Update Berhasil");
			} else {
				echo json_encode($data['tmtgolongan']);
			}
		} else {
			echo json_encode('');
		}
	}

	public function deleteGolonganIndividu()
	{
		$data['idgolongan'] = $_POST['idRiwayat'];

		$res = $this->GolonganModel->deleteGolonganIndividu($data);

		if ($res) {
			echo json_encode("Delete Berhasil");
		} else {
			echo json_encode("Delete Gagal");
		}
	}

	/*------------------------------------------- Riwayat Pendidikan Controller --------------------------------------*/

	public function getPendidikanIndividubByIDRiwayat()
	{
		$data['idRiwayatPendidikan'] = $_GET['idRiwayatPendidikan'];
		$res = $this->PendidikanModel->getPendidikanByIDRiwayat($data);

		echo json_encode($res);
	}

	public function addPendidikanIndividu()
	{
		$data['jenjang'] = $_POST['jenjang'];
		$data['tmt'] = $_POST['tmtpend'];
		$data['idDosen'] = $_POST['idDosen'];
		$data['gelar'] = $_POST['gelar'];
		$data['institusi'] = $_POST['institusi'];

		$res = $this->PendidikanModel->addPendidikanIndividu($data);
		if ($res) {
			echo json_encode("Tambah Pendidikan Berhasil");
		} else {
			echo json_encode("Tambah Pendidikan Gagal");
		}
	}

	public function updatePendidikanIndividu()
	{
		$data['idpendidikan'] = $_POST['idRiwayatPendidikan'];
		$data['jenjang'] = $_POST['jenjang'];
		$data['tmt'] = $_POST['tmtpend'];
		$data['gelar'] = $_POST['gelar'];
		$data['institusi'] = $_POST['institusi'];

		$res = $this->PendidikanModel->updatePendidikanIndividu($data);

		if ($res) {
			echo json_encode("Update Berhasil");
		} else {
			echo json_encode("Update Gagal");
		}
	}

	public function deletePendidikanIndividu()
	{
		$data['idpendidikan'] = $_POST['idRiwayat'];

		$res = $this->PendidikanModel->deletePendidikanIndividu($data);

		if ($res) {
			echo json_encode("Delete Berhasil");
		} else {
			echo json_encode("Delete Gagal");
		}
	}

	/*------------------------------------------- Riwayat Jabatan Fungsional Controller ---------------------------*/

	public function getFungsionalIndividubByIDRiwayat()
	{
		$data['idRiwayatFungsional'] = $_GET['idRiwayatFungsional'];
		$res = $this->FungsionalModel->getFungsionalByIDRiwayat($data);

		echo json_encode($res);
	}

	public function addFungsionalIndividu()
	{
		$data['fungsional'] = $_POST['fungsional'];
		$data['tmt'] = $_POST['tmtfung'];
		$data['idDosen'] = $_POST['idDosen'];

		$res = $this->FungsionalModel->addFungsionalIndividu($data);
		if ($res) {
			echo json_encode("Tambah Jabatan Fungsional Berhasil");
		} else {
			echo json_encode("Tambah Jabatan Fungsional Gagal");
		}
	}

	public function updateFungsionalIndividu()
	{
		$data['idfungsional'] = $_POST['idRiwayatFungsional'];
		$data['fungsional'] = $_POST['fungsional'];
		$data['tmt'] = $_POST['tmtfung'];

		$res = $this->FungsionalModel->updateFungsionalIndividu($data);

		if ($res) {
			echo json_encode("Update Berhasil");
		} else {
			echo json_encode("Update Gagal");
		}
	}

	public function deleteFungsionalIndividu()
	{
		$data['idRiwayatFungsional'] = $_POST['idRiwayat'];

		$res = $this->FungsionalModel->deleteFungsionalIndividu($data);

		if ($res) {
			echo json_encode("Delete Berhasil");
		} else {
			echo json_encode("Delete Gagal");
		}
	}

	/* -------------------------------------------- Riwayat Jabatan Struktural Controller -------------------------------*/

	public function getStrukturalIndividubByIDRiwayat()
	{
		$data['idRiwayatStruktural'] = $_GET['idRiwayatStruktural'];
		$res = $this->StrukturalModel->getStrukturalByIDRiwayat($data);

		echo json_encode($res);
	}
	public function addStrukturalIndividu()
	{
		$data['struktural'] = $_POST['struktural'];
		$data['tmt'] = $_POST['tmtstruk'];
		$data['deskripsi'] = $_POST['deskripsi'];
		$data['idDosen'] = $_POST['idDosen'];

		$res = $this->StrukturalModel->addStrukturalIndividu($data);
		if ($res) {
			echo json_encode("Tambah Jabatan Struktural Berhasil");
		} else {
			echo json_encode("Tambah Jabatan Struktural Gagal");
		}
	}
	public function updateStrukturalIndividu()
	{
		$data['idstruktural'] = $_POST['idRiwayatStruktural'];
		$data['struktural'] = $_POST['struktural'];
		$data['tmt'] = $_POST['tmtstruk'];
		$data['deskripsi'] = $_POST['deskripsi'];

		$res = $this->StrukturalModel->updateStrukturalIndividu($data);

		if ($res) {
			echo json_encode("Update Berhasil");
		} else {
			echo json_encode("Update Gagal");
		}
	}
	public function deleteStrukturalIndividu()
	{
		$data['idRiwayatStruktural'] = $_POST['idRiwayat'];

		$res = $this->StrukturalModel->deleteStrukturalIndividu($data);

		if ($res) {
			echo json_encode("Delete Berhasil");
		} else {
			echo json_encode("Delete Gagal");
		}
	}
}
