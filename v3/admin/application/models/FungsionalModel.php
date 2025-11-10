<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FungsionalModel extends CI_Model {

	public function getFungsionalByIDDosen($data)
	{
		$sql = "SELECT rf.*, jf.* FROM riwayat_jabatan_fungsional rf JOIN jabatan_fungsional jf ON rf.id_jabatan_fungsional = jf.id_jabatan_fungsional WHERE rf.id_dosen='".$data['nip']."' ORDER BY rf.tmt desc";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getFungsionalByIDRiwayat($data)
	{
		$sql = "SELECT * FROM riwayat_jabatan_fungsional WHERE id_riwayat_jabatan_fungsional='".$data['idRiwayatFungsional']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function addFungsionalIndividu($data)
	{
		$sql = "INSERT INTO riwayat_jabatan_fungsional VALUES ('','".$data['idDosen']."','".$data['fungsional']."','".$data['tmt']."')";
		$res = $this->db->query($sql);
		$res = $this->db->insert_id();
		return $res;
	}
	public function updateFungsionalIndividu($data)
	{
		$sql = "UPDATE riwayat_jabatan_fungsional SET id_jabatan_fungsional='".$data['fungsional']."', tmt='".$data['tmt']."' WHERE id_riwayat_jabatan_fungsional='".$data['idfungsional']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function deleteFungsionalIndividu($data)
	{
		$sql = "DELETE FROM riwayat_jabatan_fungsional WHERE id_riwayat_jabatan_fungsional = '".$data['idRiwayatFungsional']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function getFungsionalByTMT($data)
	{
		$sql = "SELECT r.id_riwayat_jabatan_fungsional, r.id_jabatan_fungsional , f.*, f.nama as namaf FROM riwayat_jabatan_fungsional r JOIN jabatan_fungsional f ON r.id_jabatan_fungsional = f.id_jabatan_fungsional WHERE r.id_dosen='".$data['nip']."' AND r.tmt < date('".$data['tahun']."-".$data['bulan']."-10') order by r.tmt DESC LIMIT 1";

		$res = $this->db->query($sql);

		return $res->result_array();
	}
}