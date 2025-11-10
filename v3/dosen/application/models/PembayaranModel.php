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
		$sql = "INSERT INTO pembayaran VALUES ('','".$data['idBendahara']."','".$data['nip']."','".$data['tgl_bayar']."', '".$data['bulan']."','".$data['tahun']."', '".$data['sksr_gaji']."', '".$data['sksr_kinerja']."', '".$data['tarif_gaji']."','".$data['tarif_kinerja']."', '".$data['pph']."', '0')";
		$res = $this->db->query($sql);

		return $res;
	}
	public function updatePembayaran($data)
	{
		$sql = "UPDATE pembayaran SET id_bendahara = '".$data['idBendahara']."', tanggal_bayar = '".date("Y-m-d")."', bulan = '".$data['bulan']."', tahun='".$data['tahun']."', sksr_gaji='".$data['sksr_gaji']."', sksr_kinerja = '".$data['sksr_kinerja']."' , tarif_gaji = '".$data['tarif_gaji']."', tarif_kinerja = '".$data['tarif_kinerja']."' WHERE id_pembayaran = '".$data['idBayar']."'";
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