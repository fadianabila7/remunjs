<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DosenModel extends CI_Model {

	public function getDataDosenProdiStatus($data)
	{
		if($data['prodi'] == 0)
		{
			if($data['status'] == 0)
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen where p.id_fakultas = '".$data['fakultas']."'";
			}
			else
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen where p.id_fakultas = '".$data['fakultas']."' AND d.id_status_dosen='".$data['status']."'";
			}
		}
		else
		{
			if($data['status']==0)
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen where d.id_program_studi='".$data['prodi']."'";
			}
			else
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen where d.id_program_studi='".$data['prodi']."' AND d.id_status_dosen='".$data['status']."'";
			}
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataDosenFakultasStatus($data)
	{
		if($data['status'] == 0)
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen where p.id_fakultas = '".$data['fakultas']."'";
			}
			else
			{
				$sql = "SELECT d.*,p.nama as namaprodi, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen where p.id_fakultas = '".$data['fakultas']."' AND d.id_status_dosen='".$data['status']."'";
			}
			$res = $this->db->query($sql);
			return $res->result_array();
	}

	public function getDataDosenByFakultas($data)
	{
		$sql = "SELECT d.* FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas WHERE f.id_fakultas='".$data."' ORDER by d.nama asc";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataDosen($data)
	{
		$sql = "SELECT d.*,p.nama as namaprodi, f.nama as namafakultas, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen WHERE d.id_dosen = '".$data['nip']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

}
