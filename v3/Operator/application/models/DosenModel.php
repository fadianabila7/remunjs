<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DosenModel extends CI_Model {

	public function getDosen($data)
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

	public function getDataDosen($data)
	{
		$sql = "SELECT d.*,p.nama as namaprodi, f.nama as namafakultas, s.deskripsi FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas JOIN status_dosen s ON d.id_status_dosen = s.id_status_dosen WHERE d.id_dosen = '".$data['nip']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataDosenByFakultas($data)
	{
		$sql = "SELECT d.nama,d.id_dosen FROM dosen d JOIN program_studi p ON d.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas WHERE f.id_fakultas='".$data."' ORDER by d.nama asc";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function entryDataDosen($data)
	{
		
		$sql = "INSERT INTO dosen VALUES ('".$data['nip']."','".$data['prodi']."','".$data['status']."','".$data['nip']."','".$data['nama']."','".$data['norek']."','".$data['notelepon']."','".$data['email']."','".$data['foto']."')";
		$res = $this->db->query($sql);
		$sql2 = "INSERT INTO user VALUES('".$data['nip']."','3','".md5("123456")."')";
		$res2 = $this->db->query($sql2);
		return $res+$res2;
	}

	public function resetPassDosen($data)
	{
		$sql = "UPDATE user SET password='".md5('123456')."' WHERE id_user = '".$data['nip']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function updateDataDosenIndividu($data)
	{
		$sql = "UPDATE dosen SET id_dosen='".$data['nip']."', id_program_studi='".$data['prodi']."', id_status_dosen='".$data['status']."', nip='".$data['nip']."', nama='".$data['nama']."', no_rekening='".$data['norek']."', telepon='".$data['notelepon']."', email='".$data['email']."', foto='".$data['foto']."' WHERE id_dosen='".$data['nip']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function deleteDataDosenIndividu($data)
	{
		$sql = "DELETE FROM dosen WHERE id_dosen = '".$data['idDosen']."'";
		$res = $this->db->query($sql);
		$sql = "DELETE FROM user WHERE id_user='".$data['idDosen']."'";
		$res = $this->db->query($sql);
		return $res;
	}
}