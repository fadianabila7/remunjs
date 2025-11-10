<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GolonganModel extends CI_Model {

	public function getGolonganByIDDosen($data)
	{
		$sql = "SELECT rg.*, g.* from riwayat_golongan rg JOIN golongan g ON rg.id_golongan = g.id_golongan WHERE rg.id_dosen= '".$data['nip']."' ORDER BY rg.tmt desc";

		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function getGolongan()
	{
		$sql = "SELECT * FROM golongan";
		$res = $this->db->query($sql);
		return $res->result_array();
	}	
	public function getGolonganByIDRiwayat($data)
	{
		$sql = "SELECT * FROM riwayat_golongan WHERE id_riwayat_golongan='".$data['idRiwayatGolongan']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	public function updateGolonganIndividu($data)
	{
		$sql = "UPDATE riwayat_golongan SET id_golongan='".$data['golongan']."', tmt='".$data['tmtgolongan']."' WHERE id_riwayat_golongan='".$data['idgolongan']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function addGolonganIndividu($data)
	{
		$sql = "INSERT INTO riwayat_golongan VALUES ('','".$data['idDosen']."','".$data['golongan']."','".$data['tmt']."')";
		$res = $this->db->query($sql);
		$res = $this->db->insert_id();
		return $res;
	}
	public function deleteGolonganIndividu($data)
	{
		$sql = "DELETE FROM riwayat_golongan WHERE id_riwayat_golongan = '".$data['idgolongan']."'";
		$res = $this->db->query($sql);
		return $res;
	}
	public function getGolonganByTMT($data)
	{
		$sql = "SELECT r.id_riwayat_golongan, g.nama, g.pph FROM riwayat_golongan r JOIN golongan g ON r.id_golongan = g.id_golongan WHERE r.tmt < date('".$data['tahun']."-".$data['bulan']."-05') AND r.id_dosen = '".$data['nip']."' order by r.tmt DESC LIMIT 1 ";
		$res = $this->db->query($sql);

		return $res->result_array();
	}
	
}