<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminModel extends CI_Model {

	public function getAdmin($data)
	{
		if($data['id_fakultas'] == 0)
		{
			$sql = "SELECT a.*, f.nama as nama_fakultas, f.singkatan, f.kode_fakultas FROM admin a join fakultas f ON a.id_fakultas = f.id_fakultas"	;
		}
		else
		{
			$sql = "SELECT a.*, f.nama as nama_fakultas, f.singkatan, f.kode_fakultas FROM admin a join fakultas f ON a.id_fakultas = f.id_fakultas WHERE a.id_fakultas = '".$data['id_fakultas']."'";
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataAdmin($data)
	{
		$sql = "SELECT a.*, f.nama as nama_fakultas, f.singkatan, f.kode_fakultas FROM admin a JOIN fakultas f ON a.id_fakultas = f.id_fakultas WHERE a.id_admin = '".$data['id_admin']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function entryDataAdmin($data)
	{
		
		$sql = "INSERT INTO admin VALUES ('".$data['id_user']."','".$data['id_user']."','".$data['id_fakultas']."','".$data['nama_admin']."','".$data['no_telepon']."','".$data['email']."','".$data['foto']."')";
		$res = $this->db->query($sql);
		$sql2 = "INSERT INTO user VALUES('".$data['id_user']."','2','".md5("123456")."')";
		$res2 = $this->db->query($sql2);
		return $res+$res2;
	}

	public function resetPassAdmin($data)
	{
		$sql = "UPDATE user SET password='".md5('123456')."' WHERE id_user = '".$data['id_user']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function updateDataAdminIndividu($data)
	{
		$sql = "UPDATE admin SET id_fakultas = '".$data['id_fakultas']."', nama = '".$data['nama_admin']."', telepon = '".$data['no_telepon']."', email  = '".$data['email']."', foto = '".$data['foto']."' WHERE id_admin = '".$data['id_admin']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function deleteDataAdminIndividu($data)
	{
		$sql = "DELETE FROM admin WHERE id_admin = '".$data['id_admin']."'";
		$res = $this->db->query($sql);
		$sql = "DELETE FROM user WHERE id_user='".$data['id_user']."'";
		$res = $this->db->query($sql);
		
		
		return $res;
	}
}