<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OperatorModel extends CI_Model {

	public function getOperator($data)
	{
		if($data['prodi'] == 0)
		{			
				$sql = "SELECT o.*, p.nama as namaprodi, f.nama as namafakultas FROM operator o JOIN program_studi p ON o.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas where p.id_fakultas = '".$data['fakultas']."'";			
		}
		else
		{
			$sql = "SELECT o.*, p.nama as namaprodi, f.nama as namafakultas FROM operator o JOIN program_studi p ON o.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas where o.id_program_studi = '".$data['prodi']."'";
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataOperator($data)
	{
		$sql = "SELECT o.*, p.nama as namaprodi, f.nama as namafakultas, jp.id_jenjang_pendidikan ,jp.nama as namajenjang, jp.singkatan FROM operator o JOIN program_studi p ON o.id_program_studi = p.id_program_studi JOIN fakultas f ON p.id_fakultas = f.id_fakultas JOIN user u ON o.id_user = u.id_user JOIN jenjang_pendidikan jp ON p.id_jenjang_pendidikan = jp.id_jenjang_pendidikan WHERE o.id_operator='".$data['operator']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function entryDataOperator($data)
	{
		$sql = "INSERT INTO operator VALUES ('".$data['user']."','".$data['user']."','".$data['prodi']."','".$data['nama']."','".$data['notelepon']."','".$data['email']."','".$data['foto']."')";
		$res = $this->db->query($sql);
		$sql2 = "INSERT INTO user VALUES('".$data['user']."','1','".md5("123456")."')";
		$res = $this->db->query($sql2);
		return $res;
	}

	public function resetPassOperator($data)
	{
		$sql = "UPDATE user SET password='".md5('123456')."' WHERE id_user = '".$data['idUser']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function updateDataOperatorIndividu($data)
	{
		$sql = "UPDATE operator SET nama='".$data['nama']."', id_program_studi = '".$data['prodi']."', telepon='".$data['notelepon']."', email='".$data['email']."', foto='".$data['foto']."' WHERE id_operator = '".$data['operator']."'";
		$res = $this->db->query($sql);
		$sql2 = "UPDATE user SET id_user = '".$data['user']."' WHERE id_user = '".$data['user']."'";
		$res = $this->db->query($sql2);

		return $res;
	}

	public function deleteDataOperatorIndividu($data)
	{
		$sql = "DELETE FROM operator WHERE id_operator = '".$data['operator']."'";
		$res = $this->db->query($sql);
		$sql2 = "DELETE FROM user WHERE id_user = '".$data['user']."'";
		$res = $this->db->query($sql2);

		return $res;
	}

	public function getDataAdmin($data)
	{
		$sql = "SELECT o.*, f.nama as namafakultas FROM admin o JOIN fakultas f ON o.id_fakultas = f.id_fakultas 
		JOIN user u ON o.id_user = u.id_user WHERE o.id_user='".$data['operator']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

}