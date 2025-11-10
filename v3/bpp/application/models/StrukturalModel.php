<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class StrukturalModel extends CI_Model {

	public function getStrukturalByIDDosen($data)
	{
		$sql = "SELECT rs.*, js.* FROM riwayat_jabatan_struktural rs JOIN jabatan_struktural js ON rs.id_jabatan_struktural = js.id_jabatan_struktural WHERE rs.id_dosen= '".$data['nip']."' ORDER BY rs.tmt desc, rs.id_riwayat_jabatan_struktural DESC";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getStrukturalByIDRiwayat($data)
	{
		$sql = "SELECT * FROM riwayat_jabatan_struktural WHERE id_riwayat_jabatan_struktural ='".$data['idRiwayatStruktural']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function addStrukturalIndividu($data)
	{
		$sql = "INSERT INTO riwayat_jabatan_struktural VALUES ('','".$data['idDosen']."','".$data['struktural']."','".$data['tmt']."','".$data['deskripsi']."')";
		$res = $this->db->query($sql);
		$res = $this->db->insert_id();
		return $res;
	}
	public function updateStrukturalIndividu($data)
	{
		$sql = "UPDATE riwayat_jabatan_struktural SET id_jabatan_struktural='".$data['struktural']."', tmt='".$data['tmt']."', deskripsi='".$data['deskripsi']."' WHERE id_riwayat_jabatan_struktural='".$data['idstruktural']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function deleteStrukturalIndividu($data)
	{
		$sql = "DELETE FROM riwayat_jabatan_struktural WHERE id_riwayat_jabatan_struktural = '".$data['idRiwayatStruktural']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function getStrukturalByTMT($data)
	{
		$sql = "SELECT r.id_riwayat_jabatan_struktural, r.deskripsi, j.* FROM riwayat_jabatan_struktural r JOIN jabatan_struktural j ON r.id_jabatan_struktural = j.id_jabatan_struktural WHERE r.tmt < date('".$data['tahun']."-".$data['bulan']."-05') AND r.id_dosen = '".$data['nip']."' order by r.tmt DESC, r.id_riwayat_jabatan_struktural DESC LIMIT 1 ";
		$res = $this->db->query($sql);

		return $res->result_array();
	}

}