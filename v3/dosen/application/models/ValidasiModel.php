<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ValidasiModel extends CI_Model {

	public function submitValidasiTriDharma($data){
		$sql = "INSERT INTO validasi_tridharma VALUES ('',
													   '".$data['nip']."', 
													   '".$data['bulan']."', 
													   '".$data['tahun']."',
													   '".$data['sks_bid_1']."',
													   '".$data['sks_bid_2']."', 
													   '".$data['sks_bid_3']."', 
													   '".$data['sks_bid_4']."',
													   '".$data['sks_bid_5']."',
													   '".$data['sksr_tugas_tambahan']."', 
													   '".$data['sksr_gaji']."', 
													   '".$data['sksr_kinerja']."', 
													   '".$data['sksr_sisa']."', 
													   '".$data['deskripsi']."', 
													   '".$data['status']."'
													   )";
		$res = $this->db->query($sql);
		return $res;
	}

	public function updateValidasiTriDharma($data){
		$sql = "UPDATE validasi_tridharma SET jumlah_sks_bid_1 = '".$data['sks_bid_1']."', 
											  jumlah_sks_bid_2 = '".$data['sks_bid_2']."', 
											  jumlah_sks_bid_3 = '".$data['sks_bid_3']."', 
											  jumlah_sks_bid_4 = '".$data['sks_bid_4']."', 
											  jumlah_sks_bid_5 = '".$data['sks_bid_5']."', 
											  sksr_tugas_tambahan = '".$data['sksr_tugas_tambahan']."', 
											  sksr_gaji = '".$data['sksr_gaji']."', 
											  sksr_kinerja = '".$data['sksr_kinerja']."', 
											  sksr_sisa = '".$data['sksr_sisa']."', 
											  deskripsi = '".$data['deskripsi']."', 
											  status = '".$data['status']."' 
											  
											  WHERE id_dosen = '".$data['nip']."' 
											  AND bulan = '".$data['bulan']."' 
											  AND tahun='".$data['tahun']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function getDataValidasiBulanTahunByIDDosen($data){
		$sql = "SELECT * FROM validasi_tridharma where bulan = '".$data['bulan']."' AND tahun = '".$data['tahun']."' AND id_dosen = '".$data['nip']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	
	public function getValidasiBulanTahun($data){
		$sql = "SELECT * FROM validasi_tridharma where bulan='".$data['bulan']."' AND tahun = '".$data['tahun']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function getValidasiBulanTahunStatus($data){
		$sql = "SELECT * FROM validasi_tridharma where bulan='".$data['bulan']."' AND tahun = '".$data['tahun']."' AND status = '".$data['status']."'";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function updateDeskripsiByIDRiwayat($data){
		$sql = "UPDATE validasi_tridharma SET deskripsi = '".$data['deskripsi']."' WHERE id_validasi_tridharma = '".$data['riwayat']."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function updateStatusByIDRiwayat($data){
		$sql = "UPDATE validasi_tridharma SET status = '".$data['status']."' WHERE id_validasi_tridharma = '".$data['riwayat']."'";
		$res = $this->db->query($sql);
		return $res;
	}
}