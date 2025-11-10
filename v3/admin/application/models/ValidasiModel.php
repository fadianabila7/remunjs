<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ValidasiModel extends CI_Model {

	public function submitValidasiTriDharma($data)
	{
		$sql = "INSERT INTO validasi_tridharma VALUES ('','".$data['nip']."', '".$data['bulan']."', '".$data['tahun']."','".$data['sks_bid_1']."','".$data['sks_bid_2']."', '".$data['sks_bid_3']."', '".$data['sks_bid_4']."','".$data['beban_wajib']."', '".$data['kelebihan_maks']."', '".$data['deskripsi']."', '".$data['status']."')";
		$res = $this->db->query($sql);

		return $res;
	}
}