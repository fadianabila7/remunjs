<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TambahanModel extends CI_Model {

	public function getDataFakultas()
	{
		$sql = "SELECT * from fakultas order by id_fakultas ASC";
		$res = $this->db->query($sql);
		return $res->result_array();
	}



	public function getProdiByFakultas($data)	
	{
		if($data['fakultas']==0){
			$sql = "SELECT f.nama as nama_fakultas,j.* from jurusan j join fakultas f on j.id_fakultas = f.id_fakultas order by id_fakultas";
		}else{
			$sql = "SELECT f.nama as nama_fakultas,j.* from jurusan j join fakultas f on j.id_fakultas = f.id_fakultas  WHERE f.id_fakultas = '".$data['fakultas']."' ORDER BY f.id_fakultas";
		}

		$res = $this->db->query($sql);
		return $res->result_array();
	}



	// belum digunakan
	public function getDataJurusan()
	{
		$sql = "SELECT f.nama as nama_fakultas,j.* from jurusan j join fakultas f on j.id_fakultas = f.id_fakultas order by id_fakultas";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function dosenFakultas($data){
		$sql = "SELECT dosen.id_dosen, dosen.nama, if(riwayat_jabatan_fungsional.id_jabatan_fungsional<202,'34.02','30') as kali FROM `program_studi` JOIN dosen ON dosen.id_program_studi = program_studi.id_program_studi join riwayat_jabatan_fungsional on riwayat_jabatan_fungsional.id_dosen = dosen.id_dosen WHERE program_studi.id_fakultas = ".$data['fakultas']." ORDER BY riwayat_jabatan_fungsional.id_riwayat_jabatan_fungsional DESC";
		$res = $this->db->query($sql);
		return $res->result();
	}

	public function sksr16($data){
		$sql = "SELECT id_dosen, sum(jumlah_sks_bid_1+jumlah_sks_bid_2+jumlah_sks_bid_3+jumlah_sks_bid_4+jumlah_sks_bid_5+sksr_tugas_tambahan) as jum FROM `validasi_tridharma` WHERE `id_dosen` LIKE '".$data->id_dosen."' AND `bulan` in (6,5,4,3,2,1) ORDER BY validasi_tridharma.bulan DESC";
		$res = $this->db->query($sql);
		return $res->result_array();
	}

	public function sksr1($data,$b){
		$sql = "SELECT sksr_sisa, sum(jumlah_sks_bid_1+jumlah_sks_bid_2+jumlah_sks_bid_3+jumlah_sks_bid_4+jumlah_sks_bid_5+sksr_tugas_tambahan) as jum FROM `validasi_tridharma` WHERE `id_dosen` LIKE '".$data->id_dosen."' AND `bulan` = '".$b."' ORDER BY validasi_tridharma.bulan DESC";
		$res = $this->db->query($sql);
		return $res->result_array();
	}
	
}