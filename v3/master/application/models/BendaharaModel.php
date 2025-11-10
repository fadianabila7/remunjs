<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BendaharaModel extends CI_Model {

	public function getBendahara($data)
	{
		if($data['id_fakultas'] == 0)
		{
			$sql = "SELECT a.*, f.nama as nama_fakultas, f.singkatan, f.kode_fakultas FROM bendahara a join fakultas f ON a.id_fakultas = f.id_fakultas"	;
		}
		else
		{
			$sql = "SELECT a.*, f.nama as nama_fakultas, f.singkatan, f.kode_fakultas FROM bendahara a join fakultas f ON a.id_fakultas = f.id_fakultas WHERE a.id_fakultas = '".$data['id_fakultas']."'";
		}
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getDataBendahara($data)
	{
		$sql = "SELECT a.*, f.nama as nama_fakultas, f.singkatan, f.kode_fakultas FROM bendahara a JOIN fakultas f ON a.id_fakultas = f.id_fakultas WHERE a.id_bendahara = '".$data['id_bendahara']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function entryDataBendahara($data)
	{
		
		$sql = "INSERT INTO bendahara VALUES ('".$data['id_user']."','".$data['id_user']."','".$data['id_fakultas']."','".$data['nama_bendahara']."','".$data['no_telepon']."','".$data['email']."','".$data['foto']."')";
		$res = $this->db->query($sql);
		$sql2 = "INSERT INTO user VALUES('".$data['id_user']."','4','".md5("123456")."')";
		$res2 = $this->db->query($sql2);
		return $res+$res2;
	}

	public function resetPassBendahara($data)
	{
		$sql = "UPDATE user SET password='".md5('123456')."' WHERE id_user = '".$data['id_user']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function updateDataBendaharaIndividu($data)
	{
		$sql = "UPDATE bendahara SET id_fakultas = '".$data['id_fakultas']."', nama = '".$data['nama_bendahara']."', telepon = '".$data['no_telepon']."', email  = '".$data['email']."', foto = '".$data['foto']."' WHERE id_bendahara = '".$data['id_bendahara']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function deleteDataBendaharaIndividu($data)
	{
		$sql = "DELETE FROM bendahara WHERE id_bendahara = '".$data['id_bendahara']."'";
		$res = $this->db->query($sql);
		$sql = "DELETE FROM user WHERE id_user='".$data['id_user']."'";
		$res = $this->db->query($sql);
		
		
		return $res;
	}
}