<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PendidikanModel extends CI_Model {

	public function getPendidikanByIDDosen($data)
	{
		$sql = "SELECT rp.*, jp.* FROM riwayat_pendidikan rp JOIN jenjang_pendidikan jp ON rp.id_jenjang_pendidikan = jp.id_jenjang_pendidikan WHERE rp.id_dosen = '".$data['id_dosen']."' ORDER BY rp.tmt desc";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getPendidikanByIDRiwayat($data)
	{
		$sql = "SELECT * FROM riwayat_pendidikan WHERE id_riwayat_pendidikan='".$data['idRiwayatPendidikan']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function addPendidikanIndividu($data)
	{
		$sql = "INSERT INTO riwayat_pendidikan VALUES ('','".$data['idDosen']."','".$data['jenjang']."','".$data['tmt']."','".$data['gelar']."','".$data['institusi']."')";
		$res = $this->db->query($sql);
		$res = $this->db->insert_id();
		return $res;
	}
	public function updatePendidikanIndividu($data)
	{
		$sql = "UPDATE riwayat_pendidikan SET id_jenjang_pendidikan='".$data['jenjang']."', tmt='".$data['tmt']."', gelar='".$data['gelar']."', institusi='".$data['institusi']."' WHERE id_riwayat_pendidikan='".$data['idpendidikan']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function deletePendidikanIndividu($data)
	{
		$sql = "DELETE FROM riwayat_pendidikan WHERE id_riwayat_pendidikan = '".$data['idpendidikan']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function getPendidikanByTMT($data)
	{
		$sql = "SELECT r.id_riwayat_pendidikan, p.singkatan , r.tmt FROM riwayat_pendidikan r JOIN jenjang_pendidikan p ON r.id_jenjang_pendidikan = p.id_jenjang_pendidikan WHERE r.id_dosen = '".$data['id_dosen']."' AND r.tmt < date('".$data['tahun']."-".$data['bulan']."-05') ORDER BY r.tmt DESC LIMIT 1";
		$res = $this->db->query($sql);

		return $res->result_array();
	}
}