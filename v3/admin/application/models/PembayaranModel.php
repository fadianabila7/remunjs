<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PembayaranModel extends CI_Model {

public function getPembayaranPerBulanTahun($data)
	{
		$sql="SELECT * FROM `pembayaran` WHERE bulan='".$data['bulan']."' AND tahun='".$data['tahun']."' AND id_dosen='".$data['nip']."'";
		$res = $this->db->query($sql);

		return $res->result_array();
	}
	public function insertPembayaran($data)
	{
		$sql = "INSERT INTO pembayaran VALUES ('','".$data['idBendahara']."','".$data['nip']."','".date("Y-m-d")."', '".$data['bulan']."','".$data['tahun']."', '".$data['tarif']."', '".$data['sksbayar']."', '1')";
		$res = $this->db->query($sql);

		return $res;
	}
	public function updatePembayaran($data)
	{
		$sql = "UPDATE pembayaran SET id_bendahara = '".$data['idBendahara']."', tanggal_bayar = '".date("Y-m-d")."', bulan = '".$data['bulan']."', tahun='".$data['tahun']."', tarif='".$data['tarif']."', jumlah_sks_dibayar = '".$data['sksbayar']."' WHERE id_pembayaran = '".$data['idBayar']."'";

		$res = $this->db->query($sql);

		return $res;
	}
	public function updateStatusPembayaran($data)	
	{
		$sql = "UPDATE pembayaran SET status='2' WHERE id_pembayaran= '".$data['idBayar']."'";
		$res = $this->db->query($sql);

		return $res;
	}
}