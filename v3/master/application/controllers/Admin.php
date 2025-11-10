<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->library('excel');
		$this->load->model('AdminModel');
	}

	public function getDataAdmin()
	{
		$data['id_fakultas'] = $_GET['fakultas'];
		$res = $this->AdminModel->getAdmin($data);

		echo json_encode($res);
	}

	public function getDataAdminIndividu()
	{
		$data['id_admin'] = $_GET['id_admin'];
		$dataadmin = $this->AdminModel->getDataAdmin($data);

		echo json_encode($dataadmin);
	}
	public function entryDataAdmin()
	{
		$data['id_user'] = $_POST['id_user'];
		$data['nama_admin'] = $_POST['nama_admin'];
		$data['id_fakultas'] = $_POST['fakultas'];
		$data['no_telepon'] = $_POST['no_telepon'];
		$data['email'] = $_POST['email'];
		$data['foto'] = $_POST['foto'];

		$res = $this->AdminModel->entryDataAdmin($data);
		if ($res) {
			redirect('MainControler/dataadmin', 'refresh');
		} else {
			echo "error";
		}
	}
	public function updateDataAdminIndividu()
	{
		$data['id_user'] = $_POST['id_user'];
		$data['id_admin'] = $_POST['id_admin'];
		$data['nama_admin'] = $_POST['nama_admin'];
		$data['id_fakultas'] = $_POST['fakultas'];
		$data['no_telepon'] = $_POST['no_telepon'];
		$data['email'] = $_POST['email'];
		$data['foto'] = $_POST['foto'];

		$res = $this->AdminModel->updateDataAdminIndividu($data);
		if ($res) {
			echo "Update Berhasil";
		} else {
			echo "Update Gagal";
		}
	}
	public function deleteDataAdminIndividu()
	{
		$data['id_admin'] = $_POST['id_admin'];
		$dataadmin = $this->AdminModel->getDataAdmin($data);
		$data['id_user'] = $dataadmin[0]['id_user'];
		$res = $this->AdminModel->deleteDataAdminIndividu($data);
		if ($res) {
			echo json_encode("Delete Berhasil");
		} else {
			echo json_encode("Delete Gagal");
		}
	}
	public function resetPassAdmin()
	{
		$data['id_admin'] = $_POST['id_admin'];
		$dataadmin = $this->AdminModel->getDataAdmin($data);
		$data['id_user'] = $dataadmin[0]['id_user'];

		$res = $this->AdminModel->resetPassAdmin($data);

		echo json_encode($res);
	}

	/*------------------------------------------- Export Data to Excel Controller -----------------------------------*/

	public function ExportDataDosen()
	{
		$data['prodi'] = $_GET['prodi'];
		$data['status'] = $_GET['status'];
		$session_data = $this->session->userdata('sess_master');
		$data['fakultas'] = $session_data['idFakultas'];
		$fakultas = $this->MainModel->getDataFakultasByID($data['fakultas']);
		$singkatan = $fakultas[0]['singkatan'];
		$datadosen = $this->DosenModel->getDosen($data);

		foreach ($datadosen as $key => $row) {
			$prodi[$key]  = $row['namaprodi'];
			$status[$key] = $row['deskripsi'];
			$nama[$key] = $row['nama'];
		}

		array_multisort($prodi, SORT_DESC, $status, SORT_DESC, $nama, SORT_ASC, $datadosen);

		$objPHPExcel = new PHPExcel();

		$this->setDataDosentoExcel($objPHPExcel, $datadosen, $singkatan);

		if ($data['status'] == 1) {
			$status = "PNS";
		} else if ($data['status'] == 2) {
			$status = "NON_PNS";
		}

		if ($data['prodi'] == 0) {
			if ($data['status'] == 0) {
				$filename = "Data_Dosen_" . $singkatan . ".xlsx";
			} else {
				$filename = "Data_Dosen_" . $status . "_" . $singkatan . ".xlsx";
			}
		} else {
			if ($data['status'] == 0) {
				$filename = "Data_Dosen_" . $singkatan . "_" . $datadosen[0]['namaprodi'] . ".xlsx";
			} else {
				$filename = "Data_Dosen_" . $status . "_" . $singkatan . "_" . $datadosen[0]['namaprodi'] . ".xlsx";
			}
		}

		/*header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0');*/

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//$url = APPPATH."/files/".$filename;

		$path = "assets/files/" . date('Y');

		if (!is_dir($path)) //create the folder if it's not already exists
		{
			mkdir($path, 0755, TRUE);
		}

		$urlsave = $path . '/' . $filename;

		$objWriter->save($urlsave);


		echo $urlsave;
	}

	public function setDataDosentoExcel($objPHPExcel, $datadosen, $namafakultas)
	{
		$objPHPExcel->getActiveSheet()->setTitle('Data');

		$rowCount = 1;

		$objPHPExcel->getActiveSheet()
			->getStyle('A:B')
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()
			->getStyle('C')
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()
			->getStyle('E:F')
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Id_dosen');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'NIP');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Nama Dosen');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Fakultas');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Program Studi');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Status');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);

		$objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount)->getFont()->setBold(true);



		foreach ($datadosen as $dosen) {

			$rowCount++;
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 1);

			$objPHPExcel->getActiveSheet()->setCellValueExplicit(
				'B' . $rowCount,
				$dosen['id_dosen'],
				PHPExcel_Cell_DataType::TYPE_STRING
			);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit(
				'C' . $rowCount,
				$dosen['nip'],
				PHPExcel_Cell_DataType::TYPE_STRING
			);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $dosen['nama']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $namafakultas);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $dosen['namaprodi']);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $dosen['deskripsi']);
		}
	}
}
