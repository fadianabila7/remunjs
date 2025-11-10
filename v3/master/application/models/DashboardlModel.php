<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashboardlModel extends CI_Model {

	public function getFungsionalByTMT($data){
		$sql = "SELECT r.id_riwayat_jabatan_fungsional, r.id_jabatan_fungsional , f.grade, f.jobvalue, f.nama as namaf FROM riwayat_jabatan_fungsional r JOIN jabatan_fungsional f ON r.id_jabatan_fungsional = f.id_jabatan_fungsional WHERE r.id_dosen='".$data['nip']."' AND r.tmt < date('".$data['tahun']."-".$data['bulan']."-28') order by r.tmt DESC LIMIT 1";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getStrukturalByTMT($data){
		$sql = "SELECT r.id_riwayat_jabatan_struktural, r.deskripsi, j.* FROM riwayat_jabatan_struktural r JOIN jabatan_struktural j ON r.id_jabatan_struktural = j.id_jabatan_struktural WHERE r.tmt < date('".$data['tahun']."-".$data['bulan']."-28') AND r.id_dosen = '".$data['nip']."' order by r.tmt DESC, r.id_riwayat_jabatan_struktural DESC LIMIT 1 ";
		$res = $this->db->query($sql);

		return $res->result_array();
	}
}